<?php

$modversion['name'] = _MI_GSBBS_NAME;
$modversion['version'] = '1.1.2';
$modversion['description'] = _MI_GSBBS_DESC;
$modversion['credits'] = "<a href=\"http://www.bluish.jp/\" target=\"_blank\">G's BBS [XOOPS] 1.1.2</a><br>G's BBS v4, Copyright(C) 2005, <a href=\"http://www.waf.jp/\" target=\"_blank\">Web Application Factory</a> All Rights Reserved.";
$modversion['author'] = 'Sting_Band <a href="http://www.bluish.jp/">http://www.bluish.jp/</a>';
$modversion['help'] = '';
$modversion['license'] = '';
$modversion['official'] = 0;
$modversion['image'] = 'images/gsbbs.png';
$modversion['dirname'] = 'gsbbs';
// Sql file (must contain sql generated by phpMyAdmin or phpPgAdmin)
// All tables should not have any prefix!
$modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
// Tables created by sql file (without prefix!)
$modversion['tables'][0] = 'gs_bbs';
// Admin
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/admin.php';
$modversion['adminmenu'] = 'admin/menu.php';
// Menu
$modversion['hasMain'] = 1;
// Search
$modversion['hasSearch'] = 1;
$modversion['search']['file'] = 'xoops_search.inc.php';
$modversion['search']['func'] = 'gsbbs_search';
// Blocks
$modversion['blocks'][1]['file'] = 'gsbbs_block.php';
$modversion['blocks'][1]['name'] = _MI_GSBBS_BNAME1;
$modversion['blocks'][1]['description'] = 'Gs BBS NEW POST';
$modversion['blocks'][1]['show_func'] = 'b_gsbbs_new';
$modversion['blocks'][1]['edit_func'] = 'b_gsbbs_new_edit';
$modversion['blocks'][1]['options'] = '10|24';
$modversion['blocks'][2]['file'] = 'gsbbs_block.php';
$modversion['blocks'][2]['name'] = _MI_GSBBS_BNAME2;
$modversion['blocks'][2]['description'] = 'Gs BBS RANKING';
$modversion['blocks'][2]['show_func'] = 'b_gsbbs_ranking';
$modversion['blocks'][2]['edit_func'] = 'b_gsbbs_ranking_edit';
$modversion['blocks'][2]['options'] = '20|365';
$modversion['blocks'][3]['file'] = 'gsbbs_block.php';
$modversion['blocks'][3]['name'] = _MI_GSBBS_BNAME3;
$modversion['blocks'][3]['description'] = 'Gs BBS NEW POST2';
$modversion['blocks'][3]['show_func'] = 'b_gsbbs_new2';
$modversion['blocks'][3]['edit_func'] = 'b_gsbbs_new2_edit';
$modversion['blocks'][3]['options'] = '10|24';
$modversion['blocks'][4]['file'] = 'gsbbs_block.php';
$modversion['blocks'][4]['name'] = _MI_GSBBS_BNAME4;
$modversion['blocks'][4]['description'] = 'Gs BBS sread name list';
$modversion['blocks'][4]['show_func'] = 'b_gsbbs_sreadnamelist';
$modversion['blocks'][4]['edit_func'] = 'b_gsbbs_sreadnamelist_edit';
$modversion['blocks'][4]['options'] = '50';
