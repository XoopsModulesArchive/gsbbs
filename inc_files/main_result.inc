<?php
//初期アクセス時にページ番号を1に設定
if(!isset($_GET['page']) || $_GET['page'] == '')
{
$page = 1;
}
else
{
$page = $_GET['page'];
}
//ビュータイプを定義
if(isset($_POST['set_list_view']))
{
$sread_pp = $list_pp;
$now_view = 'list';
}
elseif(isset($_POST['set_normal_view']) || $_COOKIE['view_type'] == 'normal')
{
$now_view = 'normal';
}
elseif($_COOKIE['view_type'] == 'list')
{
$sread_pp = $list_pp;
$now_view = 'list';
}
else
{
$now_view = 'normal';
}
//全スレッド数を取得
$all_sread_result = $GLOBALS['xoopsDB']->queryF("select ID from $BBS_TABLE where REID=0",$link);
$all_sread_num = $GLOBALS['xoopsDB']->getRowsNum($all_sread_result);
$GLOBALS['xoopsDB']->freeRecordSet($all_sread_result);
//親記事の抽出
$start_row = ($page - 1) * $sread_pp;
$result = $GLOBALS['xoopsDB']->queryF("select ID, REID, ICON, NAME, MAIL, HP, TITLE, MESS, MSF_C, MRF_C, F_NAME, TIME from $BBS_TABLE where REID=0 order by RETIME desc limit $start_row, $sread_pp",$link);
$where_str = '';
$i = 0;
while($row = $GLOBALS['xoopsDB']->fetchBoth($result,MYSQL_ASSOC))
{
$sread_num                            = $row['ID'];
    $data_array[(string)$sread_num][] = $row; //親記事を配列に格納
if($i > 0)
{
$where_str .= ' or';
}
$where_str .= " REID='".$sread_num."'";
$i++;
}
$GLOBALS['xoopsDB']->freeRecordSet($result); //検索結果リソースの解放
//返信記事の抽出
if($where_str != '')
{
$result_2 = $GLOBALS['xoopsDB']->queryF("select ID, REID, ICON, NAME, MAIL, HP, TITLE, MESS, MSF_C, MRF_C, F_NAME, TIME from $BBS_TABLE where $where_str order by TIME",$link);
$i = 0;
while($row_2 = $GLOBALS['xoopsDB']->fetchBoth($result_2,MYSQL_ASSOC))
{
$master_reid                            = $row_2['REID'];
    $data_array[(string)$master_reid][] = $row_2; //返信記事を配列に格納
}
$GLOBALS['xoopsDB']->freeRecordSet($result_2); //検索結果リソースの解放
}
//$GLOBALS['xoopsDB']->close($link); //MySQLとの接続を解除(明示)

