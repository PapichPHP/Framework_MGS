<?php

/* @param array[] Принимает аргументом массив и отбржает
*  его в удобночитаемом виде 
*/
function debug($array)
{
	echo "<pre>".print_r($array,1)."</pre>";
}

