<?php
function auto_link($uri){
$uri = ereg_replace("(^|[^=\"'])(https?|ftp|news)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)","\\1<a href=\"\\2\\3\" target=\"_blank\">\\2\\3</a>",$uri);
return $uri;
}
function auto_link2($uri2){
require __DIR__ . '/share_vars.php';
$uri2 = ereg_replace("(^|[^=\"'])(https?|ftp|news)(://[[:alnum:]\+\$\;\?\.%,!#~*/:@&=_-]+)","\\1<a href=\"\\2\\3\" target=\"_blank\">".$link_moji . '</a>', $uri2);
return $uri2;
}

