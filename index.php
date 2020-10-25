<?php

require __DIR__ . '/header.php';
require XOOPS_ROOT_PATH . '/header.php';
//ビュータイプを変更した時にクッキーに登録
if (isset($_POST['set_list_view'])) {
    setcookie('view_type', 'list', time() + 60 * 60 * 24 * 180);
}
if (isset($_POST['set_normal_view'])) {
    setcookie('view_type', 'normal', time() + 60 * 60 * 24 * 180);
}
//▼既読ＯＫボタンを押した時にクッキーへ時刻を登録
if (isset($_POST['set_look_time'])) {
    setcookie('looked', time(), time() + 60 * 60 * 24 * 180);
}
include './inc_files/share_vars.php'; //環境設定変数の読み込み
include './inc_files/sjisconvert.inc'; //SJISへの変換関数読み込み
include './inc_files/auto_link.inc'; //自動リンク変換関数読み込み
//▼MySQLとの接続
include './inc_files/connect_db.php';
//▼記事が投稿された時の処理
if (isset($_POST['post_message'])) {
    include './inc_files/input_to_db.inc';
}
//▼記事の修正がポストされた時の処理
if (isset($_POST['mod_message'])) {
    include './inc_files/mod_at_db.inc';
}
//▼ファイルの添付が指定された場合の処理
if (isset($_POST['post_add_file'])) {
    include './inc_files/add_file_process.inc';
}
//▼記事の読み出し
include './inc_files/main_result.inc';
?>
<style type="text/css" media="screen">
    <?php include 'inc_files/share.css'; ?>
</style>
<a name="top"></a>
<div align="center">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td valign="top">
                <p>
                <table width="100%" border="0" cellspacing="0" cellpadding="5" bgcolor="#ffffff">
                    <tr class="bs_title">
                        <td align="left" valign="middle" width="50%">
                            <b><?= sjisconvert($bbs_title) ?></b>　<?php include './counter/counter.inc'; ?>
                        </td>
                        <td align="right" valign="middle" width="50%">
                            <a href="reference.php"><img src="images/help.gif" align="absmiddle" border="0"></a>　<a href="mp/index.php" target="_blank"><img src="images/imode.gif" align="absmiddle" border="0"></a>　
                        </td>
                    </tr>
                </table>
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
                } elseif (is_file('./inc_files/infomation.txt')) {
                    ?>
                    <p>
                    <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td style="font-size: 10pt">
                                <?php
                                include './inc_files/infomation.txt'; ?>
                            </td>
                        </tr>
                    </table>
                    <?php
                }
                clearstatcache();
                //---------------------------２ch風スレッドタイトル表示--------------------------------------------------
                if ('on' == $sread_list) {
                    include './inc_files/sread_name_list.inc';
                }
                //------------------------------------------------------------------------------------------------------------------
                ?>
                <p>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" nowrap>
                            <a href="ranking_view.php"><img src="images/ranking.gif" alt="ランキング表示" align="middle" border="0"></a>
                        </td>
                        <td align="center" valign="middle" nowrap><img src="images/spacer.gif" width="15" height="15" align="middle" border="0"></td>
                        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                            <td align="center" valign="middle" nowrap>
                                <?php
                                if ('list' == $now_view) {
                                    ?>
                                    <input type="image" src="images/basemode.gif" name="submit" alt="list" align="middle" border="0">
                                    <input type="hidden" name="set_normal_view" value="normal">
                                    <?php
                                } else {
                                    ?>
                                    <input type="image" src="images/listview.gif" name="submit" alt="list" align="middle" border="0">
                                    <input type="hidden" name="set_list_view" value="list">
                                    <?php
                                }
                                ?>
                            </td>
                        </form>
                        <td align="center" valign="middle" nowrap><img src="images/spacer.gif" width="15" height="15" align="middle" border="0"></td>
                        <?php
                        if ('list' == $now_view) {
                            ?>
                            <form action="<?= $_SERVER['PHP_SELF'] ?>?page=<?= $page ?>" method="post">
                                <td>
                                    <input type="image" src="images/timeset.gif" name="submit" alt="looked" align="middle" border="0">
                                    <input type="hidden" name="set_look_time" value="looked">
                                </td>
                            </form>
                            <td align="center" valign="middle" nowrap><img src="images/spacer.gif" width="15" height="15" align="middle" border="0"></td>
                            <?php
                        }
                        ?>
                        <form action="search_view.php" method="get">
                            <td align="center" valign="middle" nowrap>
                                記事検索 <input type="text" name="keyword" size="20" border="0">
                                <input type="submit" name="search" value="検索">
                            </td>
                        </form>
                    </tr>
                </table>
                <p>
                    <?php
                    if ('on' == $top_post_form) {
                        include './inc_files/top_post_form.inc';
                    } else {
                        ?>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" nowrap>
                            <a href="post_form.php?page=<?= $page ?>&mode=new"><img src="images/newwrite.gif" alt="新規記事を書く" align="middle" border="0"></a>
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
                            include './inc_files/page_mov.inc';
                            ?>
                        </td>
                    </tr>
                </table>
                <p>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="top">
                            <?php
                            if (isset($_POST['set_list_view'])) {
                                include './inc_files/list_loop.inc';
                            } elseif (isset($_POST['set_normal_view'])) {
                                include './inc_files/mess_loop.inc';
                            } elseif ('list' == $_COOKIE['view_type']) {
                                include './inc_files/list_loop.inc';
                            } elseif ('normal' == $_COOKIE['view_type']) {
                                include './inc_files/mess_loop.inc';
                            } else {
                                include './inc_files/mess_loop.inc';
                            }
                            ?>
                        </td>
                    </tr>
                </table>
                <p>
                <table border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td align="center" valign="middle" nowrap>
                            <?php
                            include './inc_files/page_mov.inc';
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
        </tr>
    </table>
</div>
<?php
require XOOPS_ROOT_PATH . '/footer.php';
?>
