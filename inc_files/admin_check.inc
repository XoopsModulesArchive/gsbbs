<?php
//★入場制限処理
if(!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']))
{
header('WWW-authenticate: basic realm="BBS Admin Only"');
header('HTTP/1.0 401 Unauthorized');
echo 'You are not an Admin of this BBS !';
exit();
}
if($_SERVER['PHP_AUTH_USER'] != $admin_id || $_SERVER['PHP_AUTH_PW'] != $admin_pass || $_SERVER['PHP_AUTH_USER'] == '' || $_SERVER['PHP_AUTH_PW'] == '')
{
header('WWW-authenticate: basic realm="BBS Admin Only"');
header('HTTP/1.0 401 Unauthorized');
echo 'You are not an Admin of this BBS !';
exit();
}

