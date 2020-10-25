<?php

require dirname(__DIR__, 3) . '/include/cp_header.php';
include '../inc_files/share_vars.php'; //環境設定変数の読み込み
//include "../inc_files/admin_check.inc"; //管理者かどうかの認証
include '../inc_files/sjisconvert.inc'; //SJISへの変換関数読み込み
//▼MySQLとの接続
include '../inc_files/connect_db.php';
//▼記事の削除
if (isset($_POST['posts_del'])) {
    $stat_str = '';

    if (!isset($_POST['del_target']) || '' == $_POST['del_target']) {
        $stat_str .= '<font color="#FF0000">削除対象のレコードが指定されていません！</font><br>';
    } else {
        $target_array = $_POST['del_target'];

        sort($target_array);

        $where_in_query = '';

        $id_list = '';

        $i = 0;

        foreach ($target_array as $delete_id) {
            if ($i > 0) {
                $where_in_query .= ' or ';

                $id_list .= ', ';
            }

            $where_in_query .= "ID='" . $delete_id . "'";

            $id_list .= $delete_id;

            $i++;
        }

        $select_query = "select ID, F_NAME from $BBS_TABLE where " . $where_in_query;

        $delete_query = "delete from $BBS_TABLE where " . $where_in_query;

        $fsort_result = $GLOBALS['xoopsDB']->queryF($select_query);

        while (false !== ($f_row = $GLOBALS['xoopsDB']->fetchBoth($fsort_result, MYSQL_ASSOC))) {
            if ('' != $f_row['F_NAME'] && 'none' != $f_row['F_NAME']) {
                $dfname = $f_row['ID'] . '_' . $f_row['F_NAME'];

                if (is_file("../upfiles/$dfname")) {
                    $derete_file_result = @unlink("../upfiles/$dfname");

                    if (!$derete_file_result) {
                        $stat_str .= $id_list . ' <font color="#FF0000">番の記事の添付ファイル削除に失敗しました！</font><br>';
                    } else {
                        $stat_str .= $id_list . ' <font color="#0000FF">番の記事の添付ファイルを削除しました</font><br>';
                    }
                }

                clearstatcache();

                $dtnname = $f_row['ID'] . 'tn_' . $f_row['F_NAME'];

                if (is_file("../thums/$dtnname")) {
                    $derete_tnfile_result = @unlink("../thums/$dtnname");

                    if (!$derete_tnfile_result) {
                        $stat_str .= $id_list . ' <font color="#FF0000">番の記事のサムネイル削除に失敗しました！</font><br>';
                    } else {
                        $stat_str .= $id_list . ' <font color="#0000FF">番の記事のサムネイルを削除しました</font><br>';
                    }
                }

                clearstatcache();
            }
        }

        $GLOBALS['xoopsDB']->freeRecordSet($fsort_result);

        $del_result = $GLOBALS['xoopsDB']->queryF($delete_query);

        if (!$del_result) {
            $stat_str .= $id_list . ' <font color="#FF0000">番の記事レコード削除に失敗しました！</font><br>';
        } else {
            $del_num = count($_POST['del_target']);

            $id_list = '( ' . $id_list . ' )';

            $stat_str .= '<font color="#0000FF">以下の合計 ' . $del_num . ' の記事レコードを削除しました。<br>' . $id_list . '</font><br>';
        }
    }
}
//▼記事の修正がポストされた時の処理
if (isset($_POST['mod_message'])) {
    include './inc_files/admin_mod_at_db.inc';
}
//▼ファイルの添付が指定された場合の処理
if (isset($_POST['post_add_file'])) {
    include './inc_files/admin_add_file_process.inc';
}
//▼記事の読み出し
include '../inc_files/admin_result.inc';
xoops_cp_header();
?>
<style type="text/css" media="screen">
    <?php include '../inc_files/share.css'; ?>
</style>
<div align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="white">
        <tr>
            <td align="left">[<a href="../index.php">掲示板に戻る</a>]</td>
            <td align="right">[<a href="admin.php">記事管理</a>] - [<a href="config.php">基本設定</a>] - [<a href="css_conf.php">その他設定</a>] - [<a href="exclude.php">IP制限</a>]</td>
        </tr>
    </table>
    <br><br><span class="bs_title">記事管理画面</span>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <?php
        if (isset($stat_str) && '' != $stat_str) {
            ?>
            <p>
            <table border="0" cellspacing="2" cellpadding="5" bgcolor="#ccccff">
                <tr>
                    <td align="center" bgcolor="#ffccff">■ 処理結果 ■</td>
                </tr>
                <tr>
                    <td bgcolor="#ffffff">
                        <?= $stat_str ?>
                    </td>
                </tr>
            </table>
            <?php
        }
        ?>
        <p>
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" valign="middle" nowrap>
                    <?php
                    include '../inc_files/page_mov_admin.inc';
                    ?>
                </td>
            </tr>
        </table>
        <p>
            チェックした記事を <input type="submit" name="posts_del" value="削除">　<font color="#FF00FF">※ 確認せず削除されます</font>
            <?php
            if (isset($bad_post)) {
                include '../inc_files/bad_rows_loop.inc';
            }
            ?>
        <p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" valign="top">
                    <?php
                    include '../inc_files/admin_loop.inc';
                    ?>
                </td>
            </tr>
        </table>
        <p>
            チェックした記事を <input type="submit" name="posts_del" value="削除">　<font color="#FF00FF">※ 確認せず削除されます</font>
        <p>
        <table border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" valign="middle" nowrap>
                    <?php
                    include '../inc_files/page_mov_admin.inc';
                    ?>
                </td>
            </tr>
        </table>
        <p>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" valign="middle">
                    <hr size="1"><?= $footer ?>
                    <hr size="1">
                </td>
            </tr>
        </table>
        </td>
    </form>
    </tr>
    </table>
</div>
<?php
xoops_cp_footer();
?>
