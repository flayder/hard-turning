keyboard='';
function TheaterJS(options) {
    var self = this,
        defaults = {
            autoplay: true,
            erase: true
        };
    self.events = {};
    self.scene = -1;
    self.scenario = [];
    self.options = self.utils.merge(defaults, options || {});
    self.casting = {};
    self.current = {};
    self.state = "ready";
    self.lineVisible = false;
}
TheaterJS.prototype = {
    constructor: TheaterJS,
    set: function(value, args) {
        var self = this;
        self.current.model = value;
        var setDataPlaceholder = false;
        switch (self.current.type) {
            case "function":
                self.current.voice.apply(self, args);
                break;
            default:
                if (self.lineVisible != true && value != args[3]) {
                    value += '|';
                    self.lineVisible = true;
                    setDataPlaceholder = true;
                } else {
                    self.lineVisible = false;
                }
                if (self.current.voice.tagName == 'INPUT') {
                    if (setDataPlaceholder) {
                        self.current.voice.setAttribute('data-cur-placeholder-string', args[3]);
                    }
                    self.current.voice.placeholder = value;
                } else {
                    self.current.voice.innerHTML = value;
                }
                break;
        }
        return self;
    },
    getSayingSpeed: function(filter, constant) {
        if (typeof filter !== "number") {
            constant = filter;
            filter = 0;
        }
        var self = this,
            experience = self.current.experience + filter,
            skill = constant ? experience : self.utils.randomFloat(experience, 1);
        return self.utils.getPercentageBetween(1000, 50, skill);
    },
    getInvincibility: function() {
        var self = this;
        return self.current.experience * 10;
    },
    isMistaking: function() {
        var self = this;
        return self.current.experience < self.utils.randomFloat(0, 1.4);
    },
    utils: {
        merge: function(dest, origin) {
            for (var key in origin)
                if (origin.hasOwnProperty(key)) dest[key] = origin[key];
            return dest;
        },
        getPercentageBetween: function(min, max, perc) {
            return (min - (min * perc)) + (max * perc);
        },
        randomCharNear: function(ch) {
            var utils = this,
                threshold = 1,
                nearbyChars = [],
                uppercase = !!ch.match(/[A-Z]/);
            ch = ch.toLowerCase();
            var charPosition = keyboard[ch] || [],
                c, p;
            for (c in keyboard) {
                if (!keyboardocument.hasOwnProperty(c) || c === ch) continue;
                p = keyboard[c];
                if (Math.abs(charPosition[0] - p[0]) <= threshold && Math.abs(charPosition[1] - p[1]) <= threshold) {
                    nearbyChars.push(c);
                }
            }
            var randomChar = nearbyChars.length > 0 ? nearbyChars[utils.randomNumber(0, nearbyChars.length - 1)] : utils.randomChar();
            return uppercase ? randomChar.toUpperCase() : randomChar;
        },
        randomChar: function() {
            var utils = this,
                chars = 'abcdefghijklmnopqrstuvwxyz';
            return chars.charAt(utils.randomNumber(0, chars.length - 1));
        },
        randomNumber: function(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        },
        randomFloat: function(min, max) {
            return Math.round((Math.random() * (max - min) + min) * 10) / 10;
        },
        hasClass: function(el, className) {
            if (el.classList) return el.classList.contains(className);
            else return new RegExp('(^| )' + className + '( |$)', 'gi').test(el.className);
        },
        addClass: function(el, className) {
            if (el.classList) el.classList.add(className);
            else el.className += ' ' + className;
        },
        removeClass: function(el, className) {
            if (el.classList) el.classList.remove(className);
            else el.className = el.className.replace(new RegExp('(^|\\b)' + className.split(' ').join('|') + '(\\b|$)', 'gi'), ' ');
        }
    },
    train: function(actor) {
        var self = this,
            defaults = {
                experience: .6,
                voice: function(newValue, newChar, prevChar, str) {
                    console.log(newValue);
                },
                type: "function",
                model: ""
            };
        return self.utils.merge(defaults, actor);
    },
    describe: function(name, experience, voice) {
        if (typeof name !== "string") throw ("actor's name has wrong type: " + typeof name);
        var self = this,
            actor = {
                name: name
            };
        if (experience !== void 0) actor.experience = experience;
        if (voice !== void 0) {
            actor.type = typeof voice === "function" ? "function" : "DOM";
            if (actor.type === "DOM") actor.voice = typeof voice === "string" ? document.querySelector(voice) : voice;
            else actor.voice = voice;
        }
        self.casting[name] = self.train(actor);
        return self;
    },
    write: function() {
        var self = this,
            scenes = Array.prototype.splice.apply(arguments, [0]),
            scene;
        for (var i = 0, l = scenes.length; i < l; i++) {
            scene = scenes[i];
            if (typeof scene === "string") {
                var params = scene.split(":"),
                    hasActor = params.length > 1,
                    actor = hasActor ? params[0].trim() : null,
                    speech = hasActor ? params[1] : params[0];
                if (hasActor) self.write({
                    name: "actor",
                    args: [actor]
                });
                if (self.options.erase && hasActor) self.write({
                    name: "erase"
                });
                self.write({
                    name: "say",
                    args: [speech, !hasActor]
                });
            } else if (typeof scene === "number") {
                if (scene < 0) self.write({
                    name: "erase",
                    args: [scene]
                });
                else self.write({
                    name: "wait",
                    args: [scene]
                });
            } else if (typeof scene === "function") {
                self.write({
                    name: "call",
                    args: [scene]
                });
            } else if (scene instanceof Object) {
                self.scenario.push(scene);
            }
        }
        if (self.options.autoplay) self.play();
        return self;
    },
    play: function(restart) {
        var self = this;
        if (restart === true) self.scene = -1;
        if (self.state === "ready") self.next();
        return self;
    },
    on: function(events, fn) {
        var self = this;
        events = events.split(",");
        for (var i = 0, l = events.length, event; i < l; i++) {
            event = events[i] = events[i].trim();
            (self.events[event] || (self.events[event] = [])).push(fn);
        }
        return self;
    },
    emit: function(scope, event, args) {
        if (typeof scope !== "string") throw ("emit: scope missing");
        if (typeof event !== "string") event = void 0;
        else if (event !== void 0 && args === void 0) args = event;
        var self = this,
            eventName = scope + (event ? ":" + event : "");
        self.trigger(eventName, args).trigger("*", [eventName].concat(args));
        return self;
    },
    trigger: function(eventName, args) {
        var self = this,
            events = self.events[eventName] || [];
        (args instanceof Array || (args = [args]));
        for (var i = 0, l = events.length; i < l; i++) events[i].apply(self, [eventName].concat(args));
        return self;
    },
    call: function(fn, async) {
        var self = this;
        fn.apply(self);
        return !async ?self.next(): self;
    },
    next: function() {
        var self = this,
            prevScene = self.scenario[self.scene];
        if (prevScene) self.emit(prevScene.name, "end", [prevScene.name].concat(prevScene.args));
        if (self.scene + 1 >= self.scenario.length) {
            self.state = "ready";
        } else {
            self.state = "playing";
            var nextScene = self.scenario[++self.scene];
            self.emit(nextScene.name, "start", [nextScene.name].concat(nextScene.args));
            self[nextScene.name].apply(self, nextScene.args);
        }
        return self;
    },
    actor: function(actor) {
        var self = this;
        self.current = self.casting[actor];
        return self.next();
    },
    say: function(speech, append) {
        var self = this,
            mistaken = false,
            invincible = self.getInvincibility(),
            cursor, model;
        if (append) {
            model = self.current.model;
            cursor = self.current.model.length - 1;
            speech = model + speech;
        } else {
            model = self.current.model = "";
            cursor = -1;
        }
        var timeout = setTimeout(function nextChar() {
            var prevChar = model.charAt(cursor),
                newChar, newValue;
            if (mistaken) {
                invincible = self.getInvincibility();
                mistaken = false;
                newChar = null;
                newValue = model = model.substr(0, cursor);
                cursor--;
            } else {
                cursor++;
                newChar = speech.charAt(cursor);
                if (--invincible < 0 && (prevChar !== newChar || self.current.experience <= .3) && self.isMistaking()) {
                    newChar = self.utils.randomCharNear(newChar);
                }
                if (newChar !== speech.charAt(cursor)) mistaken = true;
                newValue = model += newChar;
            }
            self.set(newValue, [newValue, newChar, prevChar, speech]);
            if (mistaken || cursor < speech.length) timeout = setTimeout(nextChar, self.getSayingSpeed());
            else self.next();
        }, self.getSayingSpeed());
        return self;
    },
    erase: function(n) {
        var self = this,
            cursor = typeof self.current.model === "string" ? self.current.model.length : -1,
            min = typeof n === "number" && n < 0 ? cursor + 1 + n : 0;
        if (cursor < 0) return self.next();
        var timeout = setTimeout(function eraseChar() {
            var prevChar = self.current.model.charAt(cursor),
                newValue = self.current.model.substr(0, --cursor);
            self.set(newValue, [newValue, null, prevChar, newValue]);
            if (cursor >= min) setTimeout(eraseChar, self.getSayingSpeed(.2, true));
            else self.next();
        }, self.getSayingSpeed(.2, true));
        return self;
    },
    wait: function(delay) {
        var self = this;
        setTimeout(function() {
            self.next();
        }, delay);
        return self;
    }
};
window.TheaterJS = TheaterJS;