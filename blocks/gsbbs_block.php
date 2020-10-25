<?php

function b_gsbbs_new($options)
{
    $db = XoopsDatabaseFactory::getDatabaseConnection();

    $block = [];

    $block['content'] = '<ul>';

    $query = 'SELECT ID, REID, NAME, TITLE, TIME FROM ' . $db->prefix('gs_bbs') . ' WHERE id > 0 ORDER BY TIME DESC LIMIT ' . $options[0];

    $result = $db->query($query) || die("Query failed rank109 $query");

    while (false !== ($Slog = $GLOBALS['xoopsDB']->fetchArray($result))) {
        $now_time = time();

        if (($now_time - $Slog['TIME']) <= $options[1] * 60 * 60) {
            $now_str = '&nbsp;<font color="#FF0000">new</font>';
        } else {
            $now_str = '';
        }

        if ('0' == $Slog['REID']) {
            $jump_url = XOOPS_URL . '/modules/gsbbs/sread_view.php?page=&mode=fromlist&view_id=' . $Slog['ID'] . '#post' . $Slog['ID'];
        } else {
            $jump_url = XOOPS_URL . '/modules/gsbbs/sread_view.php?page=&mode=fromlist&view_id=' . $Slog['REID'] . '#post' . $Slog['ID'];
        }

        $block['content'] .= '<li><a href="' . $jump_url . '">' . $Slog['TITLE'] . '</a>' . $now_str . '&nbsp;' . $Slog['NAME'] . '<small>&nbsp;' . date('y-m-d H:i', $Slog['TIME']) . '</small></li>';
    }

    $block['content'] .= '</ul>';

    return $block;
}

function b_gsbbs_ranking($options)
{
    $db = XoopsDatabaseFactory::getDatabaseConnection();

    $block = [];

    $ranking_max = $options[0]; #表示する件数
    $calc_start = time() - $options[1] * 60 * 60 * 24; #集計期間（日
    $block['content'] = '<table border= 0 cellspacing= 1 cellpadding= 0 bgcolor="#a9a9a9"><tr><td class="head" align= center>' . _MB_GSBBS_RANK2 . '</td><td class="head" align= center>' . _MB_GSBBS_NAME2 . '</td><td class="head" align= center>' . _MB_GSBBS_POSTNUM2 . '</td></tr>';

    $query = 'SELECT NAME, max(TIME) as MAXTIME, count(ID) as POSTNUM FROM ' . $db->prefix('gs_bbs') . " WHERE RETIME > $calc_start GROUP BY NAME ORDER BY POSTNUM DESC, MAXTIME DESC LIMIT 0, $ranking_max ";

    $result = $db->query($query) || die("Query failed rank109 $query");

    $data_max = 0;

    $i = 1;

    while (false !== ($row = $GLOBALS['xoopsDB']->fetchArray($result))) {
        $block['content'] .= '<tr><td class="odd" align= center>' . $i . '</td><td class="odd" align= center>' . $row['NAME'] . '</td><td class="odd" align= center>' . $row['POSTNUM'] . '</td></tr>';

        $i++;
    }

    $block['content'] .= '</table>';

    return $block;
}

function b_gsbbs_new2($options)
{
    $db = XoopsDatabaseFactory::getDatabaseConnection();

    $block = [];

    $block['content'] = '<table border= 0 cellspacing= 1 cellpadding= 0 bgcolor="#a9a9a9"><tr><td class="head" align= center>' . _MB_GSBBS_TITLE3 . '</td><td class="head" align= center>' . _MB_GSBBS_NAME3 . '</td><td class="head" align= center>' . _MB_GSBBS_DATE3 . '</td></tr>';

    $query = 'SELECT ID, REID, NAME, TITLE, TIME FROM ' . $db->prefix('gs_bbs') . ' WHERE id > 0 ORDER BY TIME DESC LIMIT ' . $options[0];

    $result = $db->query($query) || die("Query failed rank109 $query");

    while (false !== ($Slog = $GLOBALS['xoopsDB']->fetchArray($result))) {
        $now_time = time();

        if (($now_time - $Slog['TIME']) <= $options[1] * 60 * 60) {
            $now_str = '&nbsp;<font color="#FF0000">new</font>';
        } else {
            $now_str = '';
        }

        if ('0' == $Slog['REID']) {
            $jump_url = XOOPS_URL . '/modules/gsbbs/sread_view.php?page=&mode=fromlist&view_id=' . $Slog['ID'] . '#post' . $Slog['ID'];
        } else {
            $jump_url = XOOPS_URL . '/modules/gsbbs/sread_view.php?page=&mode=fromlist&view_id=' . $Slog['REID'] . '#post' . $Slog['ID'];
        }

        $block['content'] .= '<tr><td class="odd"><a href="' . $jump_url . '">' . $Slog['TITLE'] . '</a>' . $now_str . '</td><td class="odd" align= center>' . $Slog['NAME'] . '</td><td class="odd" align= center>' . date('y-m-d H:i', $Slog['TIME']) . '</td></tr>';
    }

    $block['content'] .= '</table>';

    return $block;
}

function b_gsbbs_sreadnamelist($options)
{
    $db = XoopsDatabaseFactory::getDatabaseConnection();

    $block = [];

    $block['content'] = '<table border= 0 cellspacing= 1 cellpadding= 0 bgcolor="#a9a9a9"><tr><td class="odd">';

    $query = 'SELECT ID, TITLE FROM ' . $db->prefix('gs_bbs') . ' WHERE REID=0 ORDER BY RETIME DESC LIMIT 0, ' . $options[0];

    $result = $db->query($query) || die("Query failed rank109 $query");

    $srn = 1;

    while (false !== ($Slog = $GLOBALS['xoopsDB']->fetchArray($result))) {
        $jump_url = XOOPS_URL . '/modules/gsbbs/sread_view.php?view_id=' . $Slog['ID'] . '&page=&mode=fromlist';

        $block['content'] .= '●<a href="' . $jump_url . '">' . $srn . ': ' . $Slog['TITLE'] . '</a>';

        $srn++;
    }

    $block['content'] .= '</td></tr></table>';

    return $block;
}

function b_gsbbs_new_edit($options)
{
    $form = '' . _MB_GSBBS_NUM1 . '&nbsp;';

    $form .= "<input type='text' name='options[]' value='" . $options[0] . "'><br>";

    $form .= '' . _MB_GSBBS_PER1 . '&nbsp;';

    $form .= "<input type='text' name='options[]' value='" . $options[1] . "'>";

    return $form;
}

function b_gsbbs_ranking_edit($options)
{
    $form = '' . _MB_GSBBS_NUM2 . '&nbsp;';

    $form .= "<input type='text' name='options[]' value='" . $options[0] . "'><br>";

    $form .= '' . _MB_GSBBS_PER2 . '&nbsp;';

    $form .= "<input type='text' name='options[]' value='" . $options[1] . "'>";

    return $form;
}

function b_gsbbs_new2_edit($options)
{
    $form = '' . _MB_GSBBS_NUM3 . '&nbsp;';

    $form .= "<input type='text' name='options[]' value='" . $options[0] . "'><br>";

    $form .= '' . _MB_GSBBS_PER3 . '&nbsp;';

    $form .= "<input type='text' name='options[]' value='" . $options[1] . "'>";

    return $form;
}

function b_gsbbs_sreadnamelist_edit($options)
{
    $form = '' . _MB_GSBBS_NUM4 . '&nbsp;';

    $form .= "<input type='text' name='options[]' value='" . $options[0] . "'>";

    return $form;
}
