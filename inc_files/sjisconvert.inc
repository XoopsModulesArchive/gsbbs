<?php
function sjisconvert($str)
{
$code_check = mb_detect_encoding($str);
if(!eregi('euc', $code_check) && $code_check != '')
{
$str = mb_convert_encoding($str, 'EUC-JP', (string)$code_check);
}
return $str;
}

