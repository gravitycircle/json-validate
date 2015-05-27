<?php
require_once('../../../../wp-load.php');

if(isset($_POST['check-token']) && isset($_GET['check-token']))
{
	echo 'Validation Failed.';
}
else
{

	if(isset($_POST['check-token']))
	{
		if(validate($_POST['check-token'], 'post'))
		{
			echo 'Validated.';
		}
		else
		{
			echo 'Validation Failed.'
		}
	}
	else if(isset($_GET['check-token']))
	{
		if(validate($_GET['check-token'], 'get'))
		{
			echo 'Validated.';
		}
		else
		{
			echo 'Validation Failed.'
		}
	}
	else
	{
		echo 'Validation Failed.';
	}
}
?>