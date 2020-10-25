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
$sread_pp = $list_pp;
$now_view = 'list';
//全スレッド数を取得
$all_sread_result = $GLOBALS['xoopsDB']->queryF("select ID from $BBS_TABLE where REID=0",$link);
$all_sread_num = $GLOBALS['xoopsDB']->getRowsNum($all_sread_result);
//実際にある親記事のIDを配列に格納
while($sread_check = $GLOBALS['xoopsDB']->fetchBoth($all_sread_result,MYSQL_ASSOC))
{
$there_sread_id[] = $sread_check['ID'];
}
$GLOBALS['xoopsDB']->freeRecordSet($all_sread_result);
//返信記事から「存在すべき」親記事のIDを検索
$sread_id_result = $GLOBALS['xoopsDB']->queryF("select REID from $BBS_TABLE where REID > 0 group by REID",$link);
while($sread_id_row = $GLOBALS['xoopsDB']->fetchBoth($sread_id_result,MYSQL_ASSOC))
{
if(!in_array($sread_id_row['REID'], $there_sread_id))
{
$bad_reid[] = $sread_id_row['REID'];
}
}
$GLOBALS['xoopsDB']->freeRecordSet($sread_id_result);
if(isset($bad_reid))
{
$where_reid = '';
$loop_max = count($bad_reid);
$i = 1;
foreach($bad_reid as $bad_id)
{
$where_reid .= "REID='".$bad_id."'";
if($i < $loop_max)
{
$where_reid .= ' or ';
}
$i++;
}
$bad_result = $GLOBALS['xoopsDB']->queryF("select ID, REID, ICON, NAME, MAIL, HP, TITLE, MESS, MSF_C, MRF_C, F_NAME, TIME from $BBS_TABLE where $where_reid order by REID, ID ",$link);
while($bad_row = $GLOBALS['xoopsDB']->fetchBoth($bad_result,MYSQL_ASSOC))
{
$bad_post[] = $bad_row; //親記事のない返信記事を配列に格納
}
$GLOBALS['xoopsDB']->freeRecordSet($bad_result); //検索結果リソースの解放
}
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
$result_2 = $GLOBALS['xoopsDB']->queryF("select ID, REID, ICON, NAME, MAIL, HP, TITLE, MESS, MSF_C, MRF_C, F_NAME, TIME from $BBS_TABLE where $where_str order by TIME",$link);
$i = 0;
while($row_2 = @$GLOBALS['xoopsDB']->fetchBoth($result_2,MYSQL_ASSOC))
{
$master_reid                            = $row_2['REID'];
    $data_array[(string)$master_reid][] = $row_2; //返信記事を配列に格納
}
@$GLOBALS['xoopsDB']->freeRecordSet($result_2); //検索結果リソースの解放
@$GLOBALS['xoopsDB']->close($link); //MySQLとの接続を解除(明示)

