<?php

require __DIR__ . '/header.php';
require XOOPS_ROOT_PATH . '/header.php';
include './inc_files/share_vars.php'; //環境設定変数の読み込み
include './inc_files/sjisconvert.inc';
include './inc_files/connect_db.php';
$calc_start = time() - $ranking_since;
$result = $GLOBALS['xoopsDB']->queryF(" select NAME, max(TIME) as MAXTIME, count(ID) as POSTNUM from $BBS_TABLE where RETIME > $calc_start group by NAME order by POSTNUM desc, MAXTIME desc limit 0, $ranking_max ");
$data_max = 0;
while (false !== ($row = $GLOBALS['xoopsDB']->fetchBoth($result, MYSQL_ASSOC))) {
    $rank_array[] = $row;

    $postnum_array[] = $row['POSTNUM'];

    if ($row['POSTNUM'] > $data_max) {
        $data_max = $row['POSTNUM'];
    }
}
$GLOBALS['xoopsDB']->freeRecordSet($result);
$GLOBALS['xoopsDB']->close($link); //MySQLとの接続を解除(明示)
?>
<style type="text/css" media="screen">
    <?php include 'inc_files/share.css'; ?>
</style>
<div align="center">
    <p>発言ランキング
    <p>集計対象発言数：<?= @array_sum($postnum_array) ?>
    <p>
    <table border="0" cellspacing="1" cellpadding="0" bgcolor="#a9a9a9">
        <tr>
            <td align="center" bgcolor="#ccccff" nowrap>順位</td>
            <td align="center" bgcolor="#ccccff" nowrap>なまえ</td>
            <td align="center" bgcolor="#ccccff" nowrap>発言数</td>
            <td align="center" bgcolor="#ccccff" nowrap>最終発言日</td>
            <td align="center" bgcolor="#ccccff" nowrap>発言率</td>
        </tr>
        <?php
        $i = 1;
        $bc = 0;
        if (isset($rank_array)) {
            foreach ($rank_array as $value) {
                if (2 == $bc) {
                    $bc = 0;
                }

                if (0 == $bc) {
                    $tdbg = 'ffffff';
                }

                if (1 == $bc) {
                    $tdbg = 'e0e0ff';
                }

                $post_rate = round((($value['POSTNUM'] / array_sum($postnum_array)) * 100), 1);

                $bar_width = round((200 * ($value['POSTNUM'] / $data_max)), 0); ?>
                <tr>
                    <td align="center" bgcolor="<?= $tdbg ?>"><?= $i ?></td>
                    <td bgcolor="<?= $tdbg ?>"><?= sjisconvert($value['NAME']) ?></td>
                    <td align="center" bgcolor="<?= $tdbg ?>"><?= $value['POSTNUM'] ?></td>
                    <td align="center" bgcolor="<?= $tdbg ?>"><?= date('Y-m-d H:i', $value['MAXTIME']) ?></td>
                    <td bgcolor="<?= $tdbg ?>" valign="middle"><img src="images/graph.gif" width="<?= $bar_width ?>" height="10" align="middle" border="0"> <?= $post_rate ?>%</td>
                </tr>
                <?php
                $i++;

                $bc++;
            }
        }
        ?>
    </table>
    <p>[ <a href="index.php">戻る</a> ]</p>
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td align="center" valign="middle">
            <hr size="1"><?= $footer ?>
            <hr size="1">
        </td>
    </tr>
</table>
<?php
require XOOPS_ROOT_PATH . '/footer.php';
?>
