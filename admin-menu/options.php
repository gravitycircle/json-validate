<?php
function nonce_settings()
{
	$get_set = array(
		'JSON GET Encryption Key' => array(
			'description' => 'This key is used to encrypt a GET request through a hardcoded algorithm.',
			'option-name' => 'get-key',
			'classes' => 'token-auto-generate',
			'type' => 'paragraph'
		),
		'Encryption Passphrase' => array(
			'description' => 'A passphrase to verify a website requesting access to your data.',
			'option-name' => 'get-phrase',
			'classes' => '',
			'type' => 'text'
		),
		'Timeout Value (Defaults to 5 Seconds)' => array(
			'description' => 'Sets the time limit for a request\'s validity',
			'option-name' => 'get-expiry',
			'classes' => '',
			'type' => 'text'
		)
	);

	$post_set = array(
		'JSON POST Encryption Key' => array(
			'description' => 'This key is used to encrypt a GET request through a hardcoded algorithm.',
			'option-name' => 'post-key',
			'classes' => 'token-auto-generate',
			'type' => 'paragraph'
		),
		'Encryption Passphrase' => array(
			'description' => 'A passphrase to verify a website requesting access to your data.',
			'option-name' => 'post-phrase',
			'classes' => '',
			'type' => 'text'
		),
		'Timeout Value (Defaults to 5 Seconds)' => array(
			'description' => 'Sets the time limit for a request\'s validity',
			'option-name' => 'post-expiry',
			'classes' => '',
			'type' => 'text'
		)
	);
	?>
	<div id="custom-nonce" class="wrap" data-location="<?=plugins_url()?>/custom-nonce/">
		<h2>JSON Security Options</h2>
		<form method="post" action="options.php"> 
		<?php
			settings_fields( 'get-settings' );
			do_settings_sections( 'get-settings' );
		?>
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<div id="post-body-content" style="position: relative;">
					<div id="introduction" class="postbox ">
						<div class="handlediv" title="Click to toggle">
							<br>
						</div>
						<h3 class="hndle ui-sortable-handle">
							<span>What are GET and POST requests?</span>
						</h3>
						<div class="inside">
							<p style="color: #999; font-style: italic;">
								Your wordpress installation features an external API which communicates to any front end application. There are two types of requests to make this possible.
							</p>
							<p style="color: #999;">
								<strong>$_GET</strong> or GET requests are API calls to retrieve data securely from your WordPress application.
							<br>
								<strong>$_POST</strong> or POST requests are API calls to save data into your WordPress application.
							</p>
							<p style="color: #999; font-style: italic;">
								To secure both requests from any kind of interception, the combination of a generated key, passphrase and timeout values will be used with an algorithm to encrypt the transmission of your data.
							</p>
						</div>
					</div>
					<?=generate_option_metabox('meta-get-options', 'JSON $_GET Parameters', $get_set)?>
					<?=generate_option_metabox('meta-post-options', 'JSON $_POST Parameters', $post_set)?>
				</div>
				<div id="postbox-container-1" class="postbox-container">
					<div id="submitdiv" class="postbox">
						<div class="handlediv" title="Click to toggle">
							<br>
						</div>
						<h3 class="hndle ui-sortable-handle">
							<span>Encryption Status</span>
						</h3>
						<div class="inside">
							<div class="submitbox">
								<div id="minor-publishing">
									<div class="misc-pub-section misc-pub-post-status">
										<?php
										if(verifyKey(get_option('get-key')) && get_option('get-phrase') != '')
										{
											echo '<span style="color: #158a1d">GET requests are secure.</span>';
										}
										else
										{
											echo '<span style="color: #8a1515">GET requests are insecure.</span>';	
										}
										?>
									</div>
									<div class="misc-pub-section misc-pub-post-status">
										<?php
										if(verifyKey(get_option('post-key')) && get_option('post-phrase') != '')
										{
											echo '<span style="color: #158a1d">POST requests are secure.</span>';
										}
										else
										{
											echo '<span style="color: #8a1515">POST requests are insecure.</span>';	
										}
										?>
									</div>
								</div>
								<div id="major-publishing-actions">
									<div id="delete-action">
										<a href="#" class="button json-test">Test Tokens</a>
									</div>
									<div id="publishing-action">
										<input id="submit" class="button button-primary" type="submit" value="Save Changes" name="submit">
									</div>
									<div class="clear"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="postbox-container-2" class="postbox-container">
					
				</div>
			</div>
		</div>
		</form>
	</div>
	<?php
}

function register_custom_nonce_settings()
{
	register_setting( 'get-settings', 'get-key' );
	register_setting( 'get-settings', 'get-phrase' );
	register_setting( 'get-settings', 'get-expiry', 'zero_default' );

	register_setting( 'get-settings', 'post-key' );
	register_setting( 'get-settings', 'post-phrase' );
	register_setting( 'get-settings', 'post-expiry', 'zero_default' );
}

function zero_default($x)
{
	if(is_numeric($x))
	{
		if($x < 0)
		{
			$x = $x * -1;
		}
		

		if($x > 60)
		{
			return 60;
		}
		else if($x < 5)
		{
			return 5;
		}
		else
		{
			return floor($x);		
		}
	}
	else if($x == '')
	{
		return 5;
	}
	else
	{
		return 5;
	}
}
?>