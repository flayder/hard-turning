$(document).ready(function(){
    $(document).on('change', '[name="MARK_FILTER"]', function(){
    	var $this = $(this);
    	var MODELS = $('[name="MODEL_FILTER"]');
    	var YEAR = $('[name="YEAR_FILTER"]');
    	$data = new FormData;
    	$data.append('MARKA', $this.val());
    	MODELS.empty().append('<option value="">Модель авто</option>');
    	YEAR.empty().append('<option value="">Год</option>');
    	$.ajax({
		    url: '/ajax/fill.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    success: function(resp){
		    	if(resp.hasOwnProperty('MODELS')) {
		    		MODELS.empty().append('<option value="">Модель авто</option>');
		    		MODELS.parents('.select:eq(0)').find('span.val').text('Модель авто');
		    		MODELS.parents('.select:eq(0)').find('ul').empty();

		    		YEAR.empty().append('<option value="">Год</option>');
		    		YEAR.parents('.select:eq(0)').find('span.val').text('Год');
		    		YEAR.parents('.select:eq(0)').find('ul').empty();
		    		for(var i in resp.MODELS) {
		    			if(typeof resp.MODELS[i].ID == 'undefined') continue;
		    			MODELS.append('<option value="'+resp.MODELS[i].ID+'">'+resp.MODELS[i].NAME+'</option>');
		    			MODELS.parents('.select:eq(0)').find('ul').append('<li data-value="'+resp.MODELS[i].ID+'">'+resp.MODELS[i].NAME+'</li>');
		    		}
		    	}
		    }
		});
    });
    $(document).on('change', '[name="MODEL_FILTER"]', function(){
    	var $this = $(this);
    	var YEAR = $('[name="YEAR_FILTER"]');
    	$data = new FormData;
    	$data.append('MODEL', $this.val());
    	YEAR.empty().append('<option value="">Год</option>');
    	YEAR.parents('.select:eq(0)').find('ul').empty().append('<li data-value="">Год</li>');
    	$.ajax({
		    url: '/ajax/fill.php',
		    data: $data,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    success: function(resp){
		    	if(resp.hasOwnProperty('YEARS')) {
		    		YEAR.empty().append('<option value="">Год</option>');
		    		YEAR.parents('.select:eq(0)').find('span.val').text('Год');
                    YEAR.parents('.select:eq(0)').find('ul').empty();
		    		for(var i in resp.YEARS) {
		    			if(typeof resp.YEARS[i].ID == 'undefined') continue;
		    			YEAR.append('<option value="'+resp.YEARS[i].ID+'">'+resp.YEARS[i].NAME+'</option>');
		    			YEAR.parents('.select:eq(0)').find('ul').append('<li data-value="'+resp.YEARS[i].ID+'">'+resp.YEARS[i].NAME+'</li>');
		    		}
		    	}
		    }
		});
    });
    $(document).on('change', '[name="YEAR_FILTER"]', function(){
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
    $(document).on('click', '#search_filter', function(){
    	var $this = $(this);
    	var $error = false;
    	var $MARK = $('[name="MARK_FILTER"]').val();
    	var $MODEL = $('[name="MODEL_FILTER"]').val();
    	var $YEAR = $('[name="YEAR_FILTER"]').val();
    	if($MARK == '') {
    		$error = true;
    		alert('Выберите марку машины');
    	}
    	if($MODEL == '') {
    		$error = true;
    		alert('Выберите модель машины');
    	}
    	if($YEAR == '') {
    		$error = true;
    		alert('Выберите год выпуска машины');
    	}

    	if(!$error) {
    		window.location.href=$this.data('url');
    	}

    });
});