<?php

//データベース接続のパスワード等を設定します。
//MySQLホスト名
$SQL_HOST = XOOPS_DB_HOST;
//MySQLユーザー名
$SQL_U_NAME = XOOPS_DB_USER;
//MySQLバスワード
$SQL_PASS = XOOPS_DB_PASS;
//MySQLデータベース名
$SQL_DB = XOOPS_DB_NAME;
/*
掲示板で使用するMySQLのテーブル名を設定します。
掲示板を複数設置する場合など必要に応じて変更して下さい。
*/
$BBS_TABLE = XOOPS_DB_PREFIX;
$BBS_TABLE .= '_gs_bbs'; //記事を格納するテーブル名。よく解らないときは変更しないこと。
//▼データベースとの接続
$link = mysql_connect($SQL_HOST, $SQL_U_NAME, $SQL_PASS);
if (!$link) {
    echo 'MySQLとの接続に失敗しました。ユーザー名、パスワード等を確認してください。';

    exit();
}
//▼$SQL_DBをアクティブなデータベースにする
$active_db = mysqli_select_db($GLOBALS['xoopsDB']->conn, $SQL_DB, $link);
if (!$active_db) {
    echo '指定されたDBをアクティブにすることができませんでした。DB名等を確認してください。';

    exit();
}
