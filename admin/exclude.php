<?php

require dirname(__DIR__, 3) . '/include/cp_header.php';
include '../inc_files/share_vars.php'; //環境設定変数の読み込み
//include "../inc_files/admin_check.inc"; //管理者かどうかの認証
//リストからの削除処理
if (isset($_POST['del_ips'])) {
    //制限対象からの除外

    if ($_POST['delex']) {
        $new_excludes = '';

        $old_excludes = file('../ip/exclude.ipd');

        foreach ($old_excludes as $old_exclude_ip) {
            $old_exclude_ip = rtrim($old_exclude_ip);

            if (!in_array($old_exclude_ip, $_POST['delex'], true)) {
                $new_excludes .= $old_exclude_ip . "\r\n";
            }
        }

        $new_excludes = rtrim($new_excludes);

        $dexfp = fopen('../ip/exclude.ipd', 'wb');

        flock($dexfp, 2);

        fwrite($dexfp, $new_excludes);

        flock($dexfp, 3);

        fclose($dexfp);
    }

    //優先許可対象からの除外

    if ($_POST['delalw']) {
        $new_allows = '';

        $old_allows = file('../ip/allow.ipd');

        foreach ($old_allows as $old_allow_ip) {
            $old_allow_ip = rtrim($old_allow_ip);

            if (!in_array($old_allow_ip, $_POST['delalw'], true)) {
                $new_allows .= $old_allow_ip . "\r\n";
            }
        }

        $new_allows = rtrim($new_allows);

        $dalfp = fopen('../ip/allow.ipd', 'wb');

        flock($dalfp, 2);

        fwrite($dalfp, $new_allows);

        flock($dalfp, 3);

        fclose($dalfp);
    }
}
//リストへの追加処理
if ((isset($_POST['add_exip']) && '' != $_POST['excludeip']) || (isset($_POST['add_alip']) && '' != $_POST['allowip'])) {
    if ($_POST['add_exip']) {
        $target_file = '../ip/exclude.ipd';

        $additional_ip = $_POST['excludeip'];
    } elseif ($_POST['add_alip']) {
        $target_file = '../ip/allow.ipd';

        $additional_ip = $_POST['allowip'];
    }

    $addfp = fopen($target_file, 'rb');

    flock($addfp, 1);

    $old_ips_list = fread($addfp, filesize($target_file));

    clearstatcache();

    flock($addfp, 3);

    fclose($addfp);

    $new_ips_list = $additional_ip . "\r\n" . $old_ips_list;

    $addwfp = fopen($target_file, 'wb');

    flock($addwfp, 2);

    fwrite($addwfp, $new_ips_list);

    flock($addwfp, 3);

    fclose($addwfp);
}
//リストの読み込み
$excludes = file('../ip/exclude.ipd');
foreach ($excludes as $exclude_ip) {
    $ex_ips[] = rtrim($exclude_ip);
}
$allows = file('../ip/allow.ipd');
foreach ($allows as $allow_ip) {
    $alw_ips[] = rtrim($allow_ip);
}
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
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <br><br><span class="bs_title">書き込み制限設定</span>
        <p>
        <table border="0" cellspacing="0" cellpadding="4" bgcolor="#EFEFFF">
            <tr>
                <td align="left" valign="top">
                    ○制限対象に指定されているIP文字列がユーザのIPアドレスに含まれる場合に<br>
                    　書き込みが制限されます。<br>
                    ○優先許可に指定されているIP文字列がユーザのIPアドレスに含まれる場合、<br>
                    　それが制限対象となっていても書き込みは優先的に許可されます。<br>
                    ※HOSTはIPから判断されるものを参考として表示しているだけです。<br>
                    　書き込み制限/許可の判断はIPアドレスの文字列によってのみ行われます。
                </td>
            </tr>
        </table>
        <p>
        <table border="0" cellspacing="0" cellpadding="4" bgcolor="#EFEFFF">
            <tr>
                <td align="center" valign="top">
                    <table border="0" cellspacing="0" cellpadding="4" bgcolor="#EFEFFF">
                        <tr>
                            <td align="center" valign="top">
                                <table border="0" cellspacing="1" cellpadding="2" bgcolor="#999999">
                                    <tr>
                                        <td colspan="3" align="center" nowrap bgcolor="#ffccff">▼ 制限対象 ▼</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center" nowrap bgcolor="#FFFFCC"><input type="text" name="excludeip" value="<?= $_GET['exip'] ?>" size="20">　<input type="submit" name="add_exip" value="追加"></td>
                                    </tr>
                                    <tr>
                                        <td align="center" nowrap bgcolor="#ccffff">del</td>
                                        <td align="center" nowrap bgcolor="#ccffff">IP</td>
                                        <td align="center" nowrap bgcolor="#ccffff">HOST</td>
                                    </tr>
                                    <?php
                                    if (isset($ex_ips)) {
                                        sort($ex_ips);

                                        foreach ($ex_ips as $realex_ip) {
                                            $realex_host = gethostbyaddr($realex_ip); ?>
                                            <tr>
                                                <td align="center" nowrap bgcolor="white"><input type="checkbox" name="delex[]" value="<?= $realex_ip ?>"></td>
                                                <td nowrap bgcolor="white"><?= $realex_ip ?></td>
                                                <td nowrap bgcolor="white"><?= $realex_host ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td align="center" nowrap bgcolor="white">*</td>
                                            <td nowrap bgcolor="white">no data</td>
                                            <td nowrap bgcolor="white">no data</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </td>
                            <td align="center" valign="top">
                                <table border="0" cellspacing="1" cellpadding="2" bgcolor="#999999">
                                    <tr>
                                        <td colspan="3" align="center" nowrap bgcolor="#ccff99">▼ 優先許可 ▼</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" align="center" nowrap bgcolor="#FFFFCC"><input type="text" name="allowip" value="<?= $_GET['add_ip'] ?>" size="20">　<input type="submit" name="add_alip" value="追加"></td>
                                    </tr>
                                    <tr>
                                        <td align="center" nowrap bgcolor="#ccffff">del</td>
                                        <td align="center" nowrap bgcolor="#ccffff">IP</td>
                                        <td align="center" nowrap bgcolor="#ccffff">HOST</td>
                                    </tr>
                                    <?php
                                    if (isset($alw_ips)) {
                                        sort($alw_ips);

                                        foreach ($alw_ips as $realalw_ip) {
                                            $realalw_host = gethostbyaddr($realalw_ip); ?>
                                            <tr>
                                                <td align="center" nowrap bgcolor="white"><input type="checkbox" name="delalw[]" value="<?= $realalw_ip ?>"></td>
                                                <td nowrap bgcolor="white"><?= $realalw_ip ?></td>
                                                <td nowrap bgcolor="white"><?= $realalw_host ?></td>
                                            </tr>
                                            <?php
                                        }
                                    } else {
                                        ?>
                                        <tr>
                                            <td align="center" nowrap bgcolor="white">*</td>
                                            <td nowrap bgcolor="white">no data</td>
                                            <td nowrap bgcolor="white">no data</td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <p>チェックしたIPを <input type="submit" name="del_ips" value="削除">
    </form>
    <p>
</div>
<?php
xoops_cp_footer();
?>
