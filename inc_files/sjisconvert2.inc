<?php
function sjisconvert($str)
{
$code_check = mb_detect_encoding($str);
if(!eregi('sjis', $code_check) && $code_check != '')
{
$str = mb_convert_encoding($str, 'SJIS', (string)$code_check);
}
return $str;
}

