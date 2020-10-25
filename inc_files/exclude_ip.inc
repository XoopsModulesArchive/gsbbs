<?php
$write_allow = 'allow';
$excludes = file('./ip/exclude.ipd');
foreach($excludes as $exclude_ip)
{
if(eregi(rtrim($exclude_ip), $_SERVER['REMOTE_ADDR']))
{
$write_allow = 'exclude';
}
if(gethostbyaddr(rtrim($exclude_ip)) == gethostbyaddr($_SERVER['REMOTE_ADDR']))
{
$write_allow = 'exclude';
}
}
$allows = file('./ip/allow.ipd');
foreach($allows as $allow_ip)
{
if(eregi(rtrim($allow_ip), $_SERVER['REMOTE_ADDR']))
{
$write_allow = 'allow';
}
if(gethostbyaddr(rtrim($allow_ip)) == gethostbyaddr($_SERVER['REMOTE_ADDR']))
{
$write_allow = 'allow';
}
}
if($write_allow != 'allow' || $write_allow == 'exclude')
{
echo '<font color="#FF0000">あなたの利用しているリモートホストは管理者によって書き込みを制限されています。<BR>
あなたと同じリモートホストを利用する「悪質なユーザ」の巻き添えになっている可能性があります<BR>
この問題を解決するために下記の情報を提示して管理者に連絡をとってみて下さい。</font>';
echo '<p>';
echo 'IP ADDRESS = ' . $_SERVER['REMOTE_ADDR'] . '<BR>';
echo 'REMOTE HOST = ' . gethostbyaddr($_SERVER['REMOTE_ADDR']);
exit();
}

