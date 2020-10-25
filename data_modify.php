<?php

$post_pass = $_POST['POST_PASS'];
$target_id = $_POST['modid'];
$mode = $_POST['mod_mode'];
$page = $_POST['page'];
if ('' == $target_id) {
    echo 'modify ID post error !';

    exit();
}
require dirname(__DIR__, 2) . '/mainfile.php';
include './inc_files/share_vars.php'; //環境設定変数の読み込み
include './inc_files/connect_db.php'; //MySQLとの接続
include './inc_files/sjisconvert.inc'; //SJISへの変換関数読み込み
//パスワードのチェック
$result = $GLOBALS['xoopsDB']->queryF("select * from $BBS_TABLE where ID='$target_id'");
$row = $GLOBALS['xoopsDB']->fetchBoth($result, MYSQL_ASSOC);
$GLOBALS['xoopsDB']->freeRecordSet($result);
if ('' == $post_pass || $post_pass != $row['PASS']) {
    $header_str = 'Location: ./pass_check.php?modid=' . $target_id . '&passcheck=bad';

    header($header_str);

    exit();
}
$result_stat = '';
//記事の削除処理
if ('del' == $mode) {
    $del_record = $GLOBALS['xoopsDB']->queryF("delete from $BBS_TABLE where ID='$target_id'");

    if (!$del_record) {
        $result_stat .= '<font color="#FF0000">エラー！' . $target_id . '番の記事レコードの削除に失敗しました。</font><br>';
    } else {
        $result_stat .= '<font color="#0000FF">' . $target_id . '番の記事レコードを削除しました。</font><br>';
    }
}
//添付ファイルの削除処理
if ('file_del' == $mode || 'del' == $mode) {
    if ('' != $row['F_NAME']) {
        //添付ファイルの削除

        $target_file = './upfiles/' . $target_id . '_' . $row['F_NAME'];

        $del_file = @unlink($target_file);

        if (!$del_file) {
            $result_stat .= '<font color="#FF0000">エラー！添付ファイルの削除に失敗しました。</font><br>';
        } else {
            $result_stat .= '<font color="#0000FF">添付ファイルを削除しました。</font><br>';
        }

        //サムネイルファイルの削除

        $target_thumb = './thums/' . $target_id . 'tn_' . $row['F_NAME'];

        if (is_file($target_thumb)) {
            $del_thumb = @unlink($target_thumb);

            if (!$del_thumb) {
                $result_stat .= '<font color="#FF0000">エラー！サムネイルファイルの削除に失敗しました。</font><br>';
            } else {
                $result_stat .= '<font color="#0000FF">サムネイルファイルを削除しました。</font><br>';
            }
        }

        clearstatcache();

        $data_fcmod = $GLOBALS['xoopsDB']->queryF("update $BBS_TABLE set F_NAME='' where ID='$target_id'");

        if (!$data_fcmod) {
            $result_stat .= '<font color="#FF0000">エラー！データレコードのファイル名変更に失敗しました。</font><br>';
        } else {
            $result_stat .= '<font color="#0000FF">データレコードのファイル名を変更しました。</font><br>';
        }
    }
}
//処理結果表示
if ('' != $result_stat) {
    include './inc_files/mod_stat.inc';

    exit();
}
//ファイルの添付処理
if ('file_add' == $mode) {
    include './inc_files/add_file_form.inc';

    exit();
}
//記事の編集処理
if ('mod' == $mode) {
    include './inc_files/mod_form.inc';

    exit();
}
