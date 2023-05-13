$(document).ready(function(){
	$(document).on('submit', '#REGISTER_FORM', function(e){
    	var $this = $(this);
    	$data = new FormData($this[0]);
    	$.ajax({
		    url: '/ajax/register_user.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    success: function(resp){
		    	$('.alert-danger, .alert-success').empty().hide();
		    	var $err = false;
		    	if(resp.DONE == 'N') {
		    		for(var i in resp.ERRORS) {
		    			$('.alert-danger').append('<p>'+resp.ERRORS[i]+'</p>');
		    			$err = true;
		    		}
		    		if($err) $('.alert-danger').show();
		    	} else if(resp.DONE == 'Y') {
		    		$('.alert-success').show().append('<p>Вы успешно зарегистрировались</p>');
		    		setTimeout(function(){
		    			window.location.href = '/';
		    		}, 5000);
		    	}
		    }
		});
    	return false;
    });
    $(document).on('change', '[name="MARK"]', function(){
    	var $this = $(this);
    	var MODELS = $('[name="MODEL"]');
    	var YEAR = $('[name="YEAR"]');
    	$data = new FormData;
    	$data.append('MARKA', $this.val());
    	MODELS.empty().append('<option value="">Выберите модель авто</option>');
    	YEAR.empty().append('<option value="">Выберите год авто</option>');
    	$.ajax({
		    url: '/ajax/fill.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    success: function(resp){
		    	if(resp.hasOwnProperty('MODELS')) {
		    		MODELS.empty().append('<option value="">Выберите модель авто</option>');
		    		MODELS.parents('.select:eq(0)').find('span.val').text('Выберите модель авто');
		    		MODELS.parents('.select:eq(0)').find('ul').empty().append('<li data-value="">Выберите модель авто</li>');

		    		YEAR.empty().append('<option value="">Выберите год авто</option>');
		    		YEAR.parents('.select:eq(0)').find('span.val').text('Выберите год авто');
		    		YEAR.parents('.select:eq(0)').find('ul').empty().append('<li data-value="">Выберите год авто</li>');
		    		for(var i in resp.MODELS) {
		    			if(typeof resp.MODELS[i].ID == 'undefined') continue;
		    			MODELS.append('<option value="'+resp.MODELS[i].ID+'">'+resp.MODELS[i].NAME+'</option>');
		    			MODELS.parents('.select:eq(0)').find('ul').append('<li data-value="'+resp.MODELS[i].ID+'">'+resp.MODELS[i].NAME+'</li>');
		    		}
		    	}
		    }
		});
    });
    $(document).on('change', '[name="MODEL"]', function(){
    	var $this = $(this);
    	var YEAR = $('[name="YEAR"]');
    	$data = new FormData;
    	$data.append('MODEL', $this.val());
    	YEAR.empty().append('<option value="">Выберите год авто</option>');
    	YEAR.parents('.select:eq(0)').find('ul').empty().append('<li data-value="">Выберите год авто</li>');
    	$.ajax({
		    url: '/ajax/fill.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    success: function(resp){
		    	if(resp.hasOwnProperty('YEARS')) {
		    		YEAR.empty().append('<option value="">Выберите модель авто</option>');
		    		YEAR.parents('.select:eq(0)').find('span.val').text('Выберите год авто');
		    		for(var i in resp.YEARS) {
		    			if(typeof resp.YEARS[i].ID == 'undefined') continue;
		    			YEAR.append('<option value="'+resp.YEARS[i].ID+'">'+resp.YEARS[i].NAME+'</option>');
		    			YEAR.parents('.select:eq(0)').find('ul').append('<li data-value="'+resp.YEARS[i].ID+'">'+resp.YEARS[i].NAME+'</li>');
		    		}
		    	}
		    }
		});
    });
    $(document).on('change', '[name="YEAR"]', function(){
    	var $this = $(this);
    	$data = new FormData;
    	$data.append('YEAR', $this.val());
    	$.ajax({
		    url: '/ajax/fill.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    success: function(resp){
		    }
		});
    });
});