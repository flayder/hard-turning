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
    	var YEAR = $this.val();
    	$data = new FormData;
    	$data.append('YEAR', YEAR);
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
    $(document).on('click', '[data-add-garage]', function(){
    	var $this = $(this);
    	var MARKA = $('[name="MARK"]').val();
    	var MODEL = $('[name="MODEL"]').val();
    	var YEAR = $('[name="YEAR"]').val();
    	if(MARKA == "") {
    		alert('Вы не выбрали марку авто');
    		return;
    	}
    	else if (MODEL == "") {
    		alert('Вы не выбрали модель авто');
    		return;
    	}
    	else if (YEAR == "") {
    		alert('Вы не выбрали год авто');
    		return;
    	}
    	$data = new FormData;
    	$data.append('ADD_GARAGE', "Y");
    	$data.append('MARKA', MARKA);
    	$data.append('MODEL', MODEL);
    	$data.append('YEAR', YEAR);
    	$.ajax({
		    url: '/ajax/garage.php',
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
		    		$('.alert-success').show().append('<p>Изменения успешно сохранены</p>');
		    		setTimeout(function(){
		    			window.location.reload();
		    		}, 5000);
		    	}
		    }
		});
    });
    $(document).on('click', '[data-remove-garage]', function(){
    	var $this = $(this);
    	var id = $this.data('remove-garage');
    	$data = new FormData;
    	$data.append('REMOVE_GARAGE', "Y");
    	$data.append('ID', id);
    	$.ajax({
		    url: '/ajax/garage.php',
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
		    	} else if(resp.DONE > 0) {
		    		$('.alert-success').show().append('<p>Изменения успешно сохранены</p>');
		    		$('#garage-'+resp.DONE).fadeOut(function(){
		    			$(this).remove();
		    		});
		    	}
		    }
		});
    });

    $(document).on('click', '[data-default]', function(){
    	var $this = $(this);
    	var ID = $this.data('default');
    	$data = new FormData;
    	$data.append('DEFAULT_GARAGE', "Y");
    	$data.append('ID', ID);
    	$.ajax({
		    url: '/ajax/garage.php',
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
		    		$('.alert-success').show().append('<p>Изменения успешно сохранены</p>');
		    		setTimeout(() => {
		    			$('.alert-danger, .alert-success').empty().hide();
		    		}, 3000)
		    	}
		    }
		});
    });

    $(document).on('click', '[data-win]', function(){
    	var $this = $(this);
    	var ID = $this.data('win');
    	var val = $this.parents('.input.add-b:eq(0)').find('input').val();
    	$data = new FormData;
    	$data.append('WIN_GARAGE', "Y");
    	$data.append('ID', ID);
    	$data.append('WIN_VAL', val);
    	$.ajax({
		    url: '/ajax/garage.php',
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
		    		$('.alert-success').show().append('<p>Изменения успешно сохранены</p>');
		    	}
		    }
		});
    });
});