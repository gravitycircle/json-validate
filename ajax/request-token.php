<?php
require_once('../../../../wp-load.php');
if((!isset($_GET['get']) && !isset($_GET['post'])) || (isset($_GET['get']) && isset($_GET['post'])) || !isset($_GET['ts']))
{
	echo 'Request Failed.';
}
else
{
	if(isset($_GET['get']))
	{
		echo cipher(get_option('get-key'), get_option('get-phrase').'-'.strtotime('now'));
	}
	else if(isset($_GET['post']))
	{
		echo cipher(get_option('post-key'), get_option('post-phrase').'-'.strtotime('now'));
	}
}
?>