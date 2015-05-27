<?php
function gen_key()
{
	$str = 'abcdefghijklmnopqrstuvwxyz0123456789!@#$%&*-_+= ';
	$arr = array();
	foreach(str_split($str, 1) as $s)
	{
		$g = '';
		for($i=0; $i<4;$i++)
		{
			$g .= dechex(rand(0,15));
		}
		$arr[$s] = $g;
	}

	if(count(array_unique($arr))<count($arr))
	{
	    gen_key();
	}
	else
	{
		return $arr;
	}
}

echo serialize(gen_key());
?>