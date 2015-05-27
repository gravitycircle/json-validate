<?php
function cipher($key, $str)
{
	$encryption = unserialize($key);

	$rand = rand(0,15);
	if(($rand % 2) == 0)
	{
		$str = str_split($str, 1);
	}
	else
	{
		$str = str_split(strrev($str), 1);
	}
	
	$crypted = $encryption[dechex($rand)];
	foreach($str as $s)
	{
		if(!isset($encryption[strtolower($s)]))
		{
			$crypted .= 'fa31';
		}
		else
		{
			$crypted .= $encryption[strtolower($s)];
		}
	}

	$rem = 3 - (strlen($crypted) % 3);
	$r = '';
	for($i=0; $i<$rem; $i++)
	{
		$r .= dechex(rand(0,15));
	}
	return $crypted.$r;

}
function deCipher($key, $str)
{
	$decryption = array_flip(unserialize($key));
	$str = explode(' ', chunk_split($str, 4, ' '));
	$decrypted = '';
	foreach($str as $index => $s)
	{
		if($s == '' || strlen($s) < 4)
		{
			unset($str[$index]);
		}
		else
		{
			if($index > 0)
			{
				$decrypted .= $decryption[$s];
			}
		}
	}

	if((hexdec($decryption[$str[0]]) % 2) == 1)
	{
		return strrev($decrypted);
	}
	else
	{
		return $decrypted;
	}

}

function verifyKey($key)
{
	$key = unserialize($key);
	$str = 'abcdefghijklmnopqrstuvwxyz0123456789!@#$%&*-_+= ';
	$str = str_split($str, 1);

	foreach($str as $letter)
	{
		if(!isset($key[$letter]))
		{
			return false;
		}
		else
		{
			if(!ctype_xdigit($key[$letter]))
			{
				return false;
			}
		}
	}
	return true;
}

function validate($token, $type)
{
	if($type == 'post')
	{
		$str = deCipher(get_option('post-key'), $token);
		$str = explode('-', $str);

		$phrase = $str[0];
		$timestamp = $str[1];

		if($phrase == get_option('post-phrase'))
		{
			$timeout = $timestamp + get_option('post-expiry');

			if($timeout >= strtotime('now'))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	else if($type == 'get')
	{
		$str = deCipher(get_option('get-key'), $token);
		$str = explode('-', $str);

		$phrase = $str[0];
		$timestamp = $str[1];
	//	echo $phrase;
		if($phrase == get_option('get-phrase'))
		{

			$timeout = $timestamp + get_option('get-expiry');

			if($timeout >= strtotime('now'))
			{

				return true;
			}
			else
			{

				return false;
			}
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}
?>