<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html lang="ja">
<head>
    <title>ICON LIST</title>
    <meta http-equiv="content-type" content="text/html;charset=EUC-JP">
    <style type="text/css" media="screen">
        <!--
        td {
            font-size: 10pt
        }

        -->
    </style>
</head>
<body bgcolor="#FFFFFF" text="#333333" background="images/bg.gif">
<div align="center">
    <?php
    //★タイトルを表示
    echo '<h2><font color="#FF00FF">ICON LIST</font></h2>';
    ?>
    <p>
    <table cellpadding="2" bgcolor="#CCCCCC">
        <?php
        $dir = opendir('images/icon');
        while ($ifile_names = readdir($dir)) {
            if (!preg_match("^\.", $ifile_names) && !eregi('iconspace', $ifile_names) && !eregi('admin', $ifile_names)) {
                $iconname_array[] = $ifile_names;
            }
        }
        closedir($dir);
        sort($iconname_array);
        $i = 1;
        while (list($ikey, $iconname) = each($iconname_array)) {
            if (1 == $i) {
                echo '<tr>';
            }

            echo '<td nowrap bgcolor="#FFFFFF" align="center" valign="middle">';

            echo "<img src=\"images/icon/${iconname}\">";

            echo '<br>' . str_replace('.gif', '', $iconname) . '</td>';

            if (6 == $i) {
                echo '</tr>';
            }

            $i += 1;

            if (7 == $i) {
                $i = 1;
            }
        }
        if ($i > 1) {
            while ($i <= 6) {
                echo '<td bgcolor="#FFFFFF" align="center" valign="middle">＊</td>';

                $i++;
            }
        }
        ?>
    </table>
    <p>
    <form><input type="button" value="閉じる" onClick="window.close();"</form>
</div>
</body>
</html>
