/* Контекстное меню */



jQuery(document).ready(function($) {
	
	$('.commentlist li').each(function(i) {
		
		$(this).find('div.commentNumber').text('#' + (i + 1));
		
	});
	
	$('#commentform').on('click','#submit',function(e) {


		e.preventDefault();
		
		let comParent = $(this);

		$('.wrap_result').
					css('color','green').
					text('Сохранение комментария').
					fadeIn(500,function() {
						
						let data = $('#commentform').serializeArray();
						
						$.ajax({
							
							url:$('#commentform').attr('action'),
							data:data,
							headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
							type:'POST',
							datatype:'JSON',
							success: function(html) {
								if(html.error) {
									$('.wrap_result').css('color','red').append('<br /><strond>Ошибка: </strong>' + html.error.join('<br />'));
									$('.wrap_result').delay(2000).fadeOut(500);
								}
								else if(html.success) {
									$('.wrap_result')
										.append('<br /><strong>Сохранено!</strong>')
										.delay(2000)
										.fadeOut(500,function() {

											if(html.data.parent_id > 0) {
												comParent.parents('div#respond').prev().after('<ul class="children">' + html.comment + '</ul>');
												document.getElementById('commentform').reset();
											}
											else {
												if($.contains('#comments','ol.commentlist')) {
													$('ol.commentlist').append(html.comment);
													document.getElementById('commentform').reset();
												}
												else {

													$('#respond').before('<ol class="commentlist group">' + html.comment + '</ol>');
													document.getElementById('commentform').reset();
												}
											}




											$('#cancel-comment-reply-link').click();
										})

								}

							},
							error:function() {
								$('.wrap_result').css('color','red').append('<br /><strond>Ошибка: </strong>');
								$('.wrap_result').delay(2000).fadeOut(500, function() {
									$('#cancel-comment-reply-link').click();
								});

							}
							
						});
					});
		
	});


/*
	$('#delete-confirm').on('click', function (event) {
		event.preventDefault();

		const url = $('#delete-form').attr('action');

		swal({
			title: 'Вы уверенны?',
			text: 'Эта запись и ее детали будут навсегда удалены!',
			icon: 'warning',
			buttons: ["Отмена", "Да!"],
		}).then(function(value) {
			if (value) {
				let id = $(this).data('id');
				$.ajax({
					type: "POST",
					url: url,
					data: {id:id},
					headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					success: function (data) {

					}
				});
			}
		});
	});
*/


// Stop carousel
	$('.carousel').carousel({
		interval: false
	});

});

