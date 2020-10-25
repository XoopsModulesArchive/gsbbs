<?php
if(get_magic_quotes_gpc()) {
$_POST=array_map('stripslashes', $_POST);
}
$config_file = fopen('../inc_files/share_vars.php', 'w+');
$bbs_title_data = '$bbs_title = "' . $_POST['conf_bbs_title'] . "\";\n";
$home_url_data = '$home_url = "' . $_POST['conf_home_url'] . "\";\n";
$bbs_url_data = '$bbs_url = "' . $_POST['conf_bbs_url'] . "\";\n";
$bbs_i_url_data = '$bbs_i_url = "' . $_POST['conf_bbs_i_url'] . "\";\n";
$sread_pp_data = '$sread_pp = "' . $_POST['conf_sread_pp'] . "\";\n";
$list_pp_data = '$list_pp = "' . $_POST['conf_list_pp'] . "\";\n";
$sread_list_data = '$sread_list = "' . $_POST['conf_sread_list'] . "\";\n";
$sread_list_num_data = '$sread_list_num = "' . $_POST['conf_sread_list_num'] . "\";\n";
$top_post_form_data = '$top_post_form = "' . $_POST['conf_top_post_form'] . "\";\n";
$tags_valid_data = '$tags_valid = "' . $_POST['conf_tags_valid'] . "\";\n";
$auto_link_data = '$auto_link = "' . $_POST['conf_auto_link'] . "\";\n";
$link_moji_data = '$link_moji = "' . $_POST['conf_link_moji'] . "\";\n";
$ip_exclude_data = '$ip_exclude = "' . $_POST['conf_ip_exclude'] . "\";\n";
$mailto_bbsmaster_data = '$mailto_bbsmaster = "' . $_POST['conf_mailto_bbsmaster'] . "\";\n";
$mailto_bbsmaster2_data = '$mailto_bbsmaster2 = "' . $_POST['conf_mailto_bbsmaster2'] . "\";\n";
$admin_address_data = '$admin_address = "' . $_POST['conf_admin_address'] . "\";\n";
$file_post_sw_data = '$file_post_sw = "' . $_POST['conf_file_post_sw'] . "\";\n";
$make_thums_data = '$make_thums = "' . $_POST['conf_make_thums'] . "\";\n";
$thums_wsize_data = '$thums_wsize = "' . $_POST['conf_thums_wsize'] . "\";\n";
$ranking_max_data = '$ranking_max = "' . $_POST['conf_ranking_max'] . "\";\n";
$ranking_since_data = '$ranking_since = "' . $_POST['conf_ranking_since'] . "\";\n";
$new_mark_data = '$new_mark = "' . $_POST['conf_new_mark'] . "\";\n";
$footer_data = "\$footer = \"<a href=\\\"http://www.bluish.jp/\\\" target=\\\"_blank\\\">G's BBS [XOOPS] 1.1.2</a><BR>G's BBS v4, Copyright(C) 2003, <a href=\\\"http://www.waf.jp/\\\" target=\\\"_blank\\\">Web Application Factory</a> All Rights Reserved.\";\n"; //著作権表示(変更不可)
$config_data = "<?php\n".$bbs_title_data . ''
               . $home_url_data . ''
               . $bbs_url_data . ''
               . $bbs_i_url_data . ''
               . $sread_pp_data . ''
               . $list_pp_data . ''
               . $sread_list_data . ''
               . $sread_list_num_data . ''
               . $top_post_form_data . ''
               . $tags_valid_data . ''
               . $auto_link_data . ''
               . $link_moji_data . ''
               . $ip_exclude_data . ''
               . $mailto_bbsmaster_data . ''
               . $mailto_bbsmaster2_data . ''
               . $admin_address_data . ''
               . $file_post_sw_data . ''
               . $make_thums_data . ''
               . $thums_wsize_data . ''
               . $ranking_max_data . ''
               . $ranking_since_data . ''
               . $new_mark_data . ''
               . $footer_data . '?>';
fwrite($config_file, $config_data);
fclose($config_file);

