<?php

function gsbbs_search($queryarray, $andor, $limit, $offset, $userid)
{
    global $xoopsDB;

    $sql = 'SELECT ID,REID,NAME,TITLE,MESS,TIME FROM ' . $xoopsDB->prefix('gs_bbs') . ' WHERE TIME>0 AND TIME<=' . time() . '';

    // because count() returns 1 even if a supplied variable

    // is not an array, we must check if $querryarray is really an array

    if (is_array($queryarray) && $count = count($queryarray)) {
        $sql .= " AND ((NAME LIKE '%$queryarray[0]%' OR TITLE LIKE '%$queryarray[0]%' OR MESS LIKE '%$queryarray[0]%')";

        for ($i = 1; $i < $count; $i++) {
            $sql .= " $andor ";

            $sql .= "(NAME LIKE '%$queryarray[$i]%' OR TITLE LIKE '%$queryarray[$i]%' OR MESS LIKE '%$queryarray[$i]%')";
        }

        $sql .= ') ';
    }

    $sql .= 'ORDER BY TIME DESC';

    $result = $xoopsDB->query($sql, $limit, $offset);

    $ret = [];

    $i = 0;

    while (false !== ($myrow = $xoopsDB->fetchArray($result))) {
        $ret[$i]['image'] = 'images/post_data.gif';

        if ('0' == $myrow['REID']) {
            $ret[$i]['link'] = 'sread_view.php?page=&mode=fromlist&view_id=' . $myrow['ID'] . '#post' . $myrow['ID'];
        } else {
            $ret[$i]['link'] = 'sread_view.php?page=&mode=fromlist&view_id=' . $myrow['REID'] . '#post' . $myrow['ID'];
        }

        $ret[$i]['title'] = $myrow['TITLE'];

        $ret[$i]['time'] = $myrow['TIME'];

        // $ret[$i]['uid'] = $myrow['uid'];

        $i++;
    }

    return $ret;
}
