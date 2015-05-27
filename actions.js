if (!Date.now) {
    Date.now = function() { return new Date().getTime(); }
}
(function ($){
	$(document).ready(function(){
		$('.token-auto-generate').find('textarea').before('<div class="autogen"><a href="#" class="rand-key button">Generate Random Key</a></div>');

		$('.rand-key').click(function(e){
			e.preventDefault();
			var val = $(this);
			var confirm = true;
			if($($(val).parent().siblings('.cn_input')).val() != '')
			{
				confirm = window.confirm('Do you want to replace your current key with a generated one?');
			}
			
			$.ajax({
				type: 'GET',
				url: $('#custom-nonce').data('location')+'actions/auto-generate.php',
				data: 'do=1',
				complete: function(info){
					$($(val).parent().siblings('.cn_input')).val(info.responseText);
				}
			});
		});

		$('.json-test').on('click', function(e){
			e.preventDefault();
			var tokens = {
				'get': '',
				'post' : ''
			};

			var validation = ['GET not validated.', 'POST not validated.'];

			$.ajax({
				type: 'GET',
				url: $('#custom-nonce').data('location')+'ajax/request-token.php',
				data: 'get&ts='+Date.now(),
				complete: function(info){
					tokens.get = info.responseText;

					$.ajax({
						type: 'GET',
						url: $('#custom-nonce').data('location')+'ajax/request-token.php',
						data: 'post&ts='+Date.now(),
						complete: function(info1){
							tokens.post = info1.responseText;

							$.ajax({
								type: 'POST',
								url: $('#custom-nonce').data('location')+'ajax/validate.php',
								data: 'check-token='+tokens.post,
								complete: function(info2){
									if(info2.responseText == 'Validated.')
									{
										validation[1] = 'POST validated.';
										$.ajax({
											type: 'GET',
											url: $('#custom-nonce').data('location')+'ajax/validate.php',
											data: 'check-token='+tokens.get,
											complete: function(info3){
												if(info3.responseText == 'Validated.')
												{
													validation[0] = 'GET validated.';
													alert('All tokens are valid and active.');
												}
											}
										});
									}
									else
									{
										alert(validation[0]+" | "+validation[1]);
									}
								}
							});
						}
					});
				}
			});
		});
	});
})(jQuery);