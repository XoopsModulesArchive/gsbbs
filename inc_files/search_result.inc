<?php
//キーワードを含む記事のIDを検索
$search_words = $_GET['keyword'];
$search_where = "NAME like '%".$search_words."%' or MAIL like '%".$search_words."%' or HP like '%".$search_words."%' or TITLE like '%".$search_words."%' or MESS like '%".$search_words."%'";
$query1 = "select ID, REID from $BBS_TABLE where $search_where";
$search1 = $GLOBALS['xoopsDB']->queryF($query1);
if($GLOBALS['xoopsDB']->getRowsNum($search1) == 0)
{
$searched_num = 0;
$GLOBALS['xoopsDB']->freeRecordSet($search1);
}
else
{
$searched_num = $GLOBALS['xoopsDB']->getRowsNum($search1);
$sread_array[] = 0;
while($srow1 = $GLOBALS['xoopsDB']->fetchBoth($search1,MYSQL_ASSOC))
{
if($srow1['REID'] == '0' && !in_array($srow1['ID'], $sread_array))
{
$sread_array[] = $srow1['ID'];
}
if($srow1['REID'] != '0' && !in_array($srow1['REID'], $sread_array))
{
$sread_array[] = $srow1['REID'];
}
$all_id_array[] = $srow1['ID'];
}
$GLOBALS['xoopsDB']->freeRecordSet($search1);
$search_where2 = '';
$i = 0;
foreach($sread_array as $sread_ids)
{
if($sread_ids != 0)
{
if($i == 0)
{
$i++;
}
else
{
$search_where2 .= ' or ';
}
$search_where2 .= "ID='".$sread_ids."'";
}
}
//全スレッド数を取得
$all_sread_result = $GLOBALS['xoopsDB']->queryF("select ID from $BBS_TABLE where $search_where2",$link);
$all_sread_num = $GLOBALS['xoopsDB']->getRowsNum($all_sread_result);
$GLOBALS['xoopsDB']->freeRecordSet($all_sread_result);
//親記事の抽出
$start_row = ($page - 1) * $list_pp;
$result = $GLOBALS['xoopsDB']->queryF("select ID, REID, ICON, NAME, MAIL, HP, TITLE, MESS, MSF_C, MRF_C, F_NAME, TIME from $BBS_TABLE where $search_where2 order by RETIME desc limit $start_row, $list_pp",$link);
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
$result_2 = $GLOBALS['xoopsDB']->queryF("select ID, REID, ICON, NAME, MAIL, HP, TITLE, MESS, MSF_C, MRF_C, F_NAME, TIME from $BBS_TABLE where $where_str order by TIME",$link);
$i = 0;
while($row_2 = $GLOBALS['xoopsDB']->fetchBoth($result_2,MYSQL_ASSOC))
{
$master_reid                            = $row_2['REID'];
    $data_array[(string)$master_reid][] = $row_2; //返信記事を配列に格納
}
$GLOBALS['xoopsDB']->freeRecordSet($result_2); //検索結果リソースの解放
$GLOBALS['xoopsDB']->close($link); //MySQLとの接続を解除(明示)
}

