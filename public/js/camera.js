Webcam.set({
	image_format:'png'
});

Webcam.attach('#camera');

Webcam.on( 'live', function(){
	$('#take_picture, #print_back, ' + picture).removeClass('hidden');

	$('#take_picture').click(function(){
		Webcam.freeze();	
		$(this).hide();
		$('#retake_picture, #save_picture').show();
	});

	$('#retake_picture').click(function(){
		Webcam.unfreeze();
		$('#retake_picture, #save_picture').hide();
		$('#take_picture').show();
	});

	$('#save_picture').click(function(){
		Webcam.snap(function(data_uri){
			$.ajax({
				headers : {
					'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
				},
				url	: '/health_certificate/' + id + '/picture',
				method: 'POST',
				data : {'webcam' : data_uri.replace(/^data\:image\/\w+\;base64\,/, '')},
				success : function(data){
					console.log('success');
					$('#picture').attr('src', data.url);
				},
				error : function(){
					console.log('error');
					window.alert('An error has occured');
				},
				complete : function(){
					console.log('complete');
					$('#save_picture, #retake_picture').hide();
					$('#take_picture, #print_front').show();
				}
			});
		});
	});

	$('.print').click(function(){
		if($(this).attr('id') == 'print_front')
		{
			$('#front_preview').removeClass('no-print');
			$('#back_preview').addClass('no-print');
		}

		else if($(this).attr('id') == 'print_back')
		{
			$('#back_preview').removeClass('no-print');
			$('#front_preview').addClass('no-print');
		}
		
		window.print();
	});
});

Webcam.on( 'error', function(err){
	window.alert('There is an error in your camera. Please plug it and enable access to your web browser.');
	console.log(err);
});