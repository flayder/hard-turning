new WOW().init();

jQuery.validator.addMethod("usPhoneFormat", function(value, element) {
return this.optional(element) || /\d{1} [\(]\d{3}[\)] \d{3}[\-]\d{2}[\-]\d{2}/.test(value);
}, "Enter a valid phone number.");

$(window).load(function() {
    $('[data-img]').each(function(){
            var src = $(this).attr('data-img')
            if($(this).hasClass('lazyBG')){
                $(this).css('background-image','url('+src+')')
            }else {
                $(this).attr('src',src)
            }
        })
    setTimeout(function(){
            
            var cord = [0,0]
            if($(window).outerWidth() > 768){
                cord = [56.129007, 40.391016]
            }else {
                cord = [56.130607, 40.393016]
            }
            ymaps.ready(init);
    function init() {
        var myMap = new ymaps.Map('map', {
            center: cord,
            zoom: 17,
            controls: ['smallMapDefaultSet']
        });
        var myPlacemark = new ymaps.Placemark(
            [56.129007, 40.393016], {}, {
                iconImageHref: 'img/metka.png',
                iconImageSize: [114, 134], 
                iconImageOffset: [-57, -134] 
            });
        myMap.geoObjects.add(myPlacemark);
    }
        
    },2000)
    
    
    
})
$(document).ready(function() {
$('.intro_flex_area [data-img]').each(function(){
            var src = $(this).attr('data-img')
            if($(this).hasClass('lazyBG')){
                $(this).css('background-image','url('+src+')')
            }else {
                $(this).attr('src',src)
            }
        })
$("input[name='phone']").mask("+0 (000) 000-00-00");
$("input[name='phone']").click(function(){
	if($(this).val() == ''){
		$(this).val('+7')
	}
})
$('a[href^="#"]').click(function( event ) {
    event.preventDefault();
    $("html, body").animate({ scrollTop: $($(this).attr("href")).offset().top }, 500);
});
function youtube_parser(url){
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
    var match = url.match(regExp);
    return (match&&match[7].length==11)? match[7] : false;
}
$('.rev_video').each(function(){
    var url =$(this).attr('href')
    var id = youtube_parser(url)
    $(this).css('background-image','url(https://img.youtube.com/vi/'+id+'/hqdefault.jpg)')
})
    
$('.rev_sldier').owlCarousel({
    loop:true,
    margin:30,
    nav:true,
    navText:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
    $('.cases_slider_wrp').owlCarousel({
    loop:true,
    margin:30,
    nav:true,
    navText:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
    
    
$('.carousel_center').owlCarousel({
    loop:true,
    margin:30,
    nav:false,
    dots:false,
    animateOut: 'fadeOut',
    touchDrag:false,
     mouseDrag:false,
    navText:false,
    responsive:{
        0:{
            items:1,
            touchDrag:true,
     mouseDrag:true,
            nav:true,
            autoHeight:true
        },
        767:{
            items:1,
            touchDrag:false,
     mouseDrag:false,
            autoHeight:false,
            nav:false
        },
        1000:{
            items:1
        }
    }
})
    
$('.carousel_sht').owlCarousel({
    loop:true,
    margin:30,
    nav:false,
    animateOut: 'fadeOut',
    dots:false,
    navText:false,
    touchDrag:false,
     mouseDrag:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
$('.carousel_3d').owlCarousel({
    loop:true,
    margin:30,
    nav:false,
    dots:false,
    navText:false,
    animateOut: 'fadeOut',
    touchDrag:false,
     mouseDrag:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
$('.go_nt').click(function(){
    $('.carousel_3d, .carousel_sht, .carousel_center').trigger('next.owl.carousel')
})
$('.go_pr').click(function(){
    $('.carousel_3d, .carousel_sht, .carousel_center').trigger('prev.owl.carousel')
})
$('.open_nav').click(function(){
    $('.main_section').slideToggle(300)
})
$(document).mouseup(function(e) 
{
    var container = $(".open_nav,.main_section");

    if (!container.is(e.target) && container.has(e.target).length === 0) {
        if($(window).outerWidth() < 768){
            $('.main_section').slideUp(300)
        }
    }
});
    function scrollbarWidth() {
    var block = $('<div>').css({'height':'50px','width':'50px'}),
        indicator = $('<div>').css({'height':'200px'});

    $('body').append(block.append(indicator));
    var w1 = $('div', block).innerWidth();    
    block.css('overflow-y', 'scroll');
    var w2 = $('div', block).innerWidth();
    $(block).remove();
    return (w1 - w2);
}
    $('.modal').on('shown.bs.modal', function (e) {
  $('body').css('padding-right',''+scrollbarWidth()+'px')
    $('header').css('width','calc(100% - '+scrollbarWidth()+'px)')
})
$('[data-toggle="modal"]').click(function(){
	$('header').css('width','calc(100% - '+scrollbarWidth()+'px)')
})
$('.modal').on('hidden.bs.modal', function (e) {
  $('body').css('padding-right','0px')
    $('header').css('width','100%')
})
$('form').each(function(){
    var forma = $(this)
    $(forma).validate({
			rules: {
                phone: {
          required: true,
                    usPhoneFormat: true,
        }
      },
			submitHandler: function(form) {
			$.ajax({
			type: "POST", 
			url: "mail.php", 
			data: $(forma).serialize(), 
			success: function(html)
			{		
				$('.modal').modal('hide');
                setTimeout(function(){
                    $('#thanks').modal('toggle')
                },500)
			} 
			}); 
			return false;
		}
	}); 
})
//$('#consult').modal('toggle')
    
$('.mat_slider').owlCarousel({
    loop:false,
    margin:10,
    nav:true,
    lazyLoad:true,
    navText:false,
    dots:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
$('[data-target="#recall"]').click(function(){
    var tt = $(this).html()
    if(!$(this).hasClass('noset')){
    $('#recall .head_but').html(tt)
    }
})
$('.kletka_slider_main').owlCarousel({
    loop:false,
    margin:10,
    nav:true,
    navText:false,
    rewind:true,
    startPosition: 1,
    touchDrag: true,
    lazyLoad:true,
    mouseDrag: false,
    dots:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
})  
$('.small_slider').owlCarousel({
    loop:false,
    margin:10,
    rewind:true,
    nav:false,
    navText:false,
    touchDrag: false,
    lazyLoad:true,
    animateOut: 'fadeOut',
    mouseDrag: false,
    dots:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
}) 
$('.small_slider2').owlCarousel({
    loop:false,
    margin:10,
    rewind:true,
    lazyLoad:true,
    nav:false,
    navText:false,
    touchDrag: false,
    animateOut: 'fadeOut',
    startPosition: 2,
    mouseDrag: false,
    dots:false,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:1
        },
        1000:{
            items:1
        }
    }
}) 
$('.kletka_next, .small_slider2').click(function(){
    $(this).closest('section').find('.owl-carousel').not('.mat_slider').trigger('next.owl.carousel')
})
$('.kletka_prev, .small_slider').click(function(){
    $(this).closest('section').find('.owl-carousel').not('.mat_slider').trigger('prev.owl.carousel')
})
$('.buttons_kletki [data-target="#recall"]').click(function(){
    var butt = $(this).attr('data-buttle')
    $('#recall .head_but').html(butt)
})

});