<?php

// ------------------------------------------------------------------------- //
//                XOOPS - PHP Content Management System                      //
//                       <https://www.xoops.org>                             //
// ------------------------------------------------------------------------- //
// Based on:                                                                 //
// myPHPNUKE Web Portal System - http://myphpnuke.com/                       //
// PHP-NUKE Web Portal System - http://phpnuke.org/                          //
// Thatware - http://thatware.org/                                           //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
// ------------------------------------------------------------------------- //
/**
 * XOOPS module 'FormMail'  by Tom (Malaika System)
 **/
require_once 'admin_header.php';

function MyMenuAdmin()
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    xoops_cp_header();

    // admin menu

    formmail_admin_menu();

    OpenTable();

    echo '<big><b>' . _AM_FORM_TITLE . '</big></b>';

    //*********** Menueintrag hinzuf?en ******************************************************

    echo "<h4 style='text-align:left;'>" . _AM_FORM_ADDMENUITEM . "</h4>
		<form action='menu_index.php' method='post'>
		<table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
		<tr>
		<td class='bg2'>
			<table width='100%' border='0' cellpadding='4' cellspacing='1'>
			<tr>
			<td class='bg3'><b>" . _AM_FORM_POS . "</b></td>
			<td class='bg1'><input type='text' name='xposition' size='4' maxlength='4'>&nbsp&nbsp&nbsp(0000-9999)</td>
			</tr>
			<tr>
			<td class='bg3'><b>" . _AM_FORM_ITEMNAME . "</b></td>
			<td class='bg1'><input type='text' name='itemname' size='50' maxlength='60'></td>
			</tr>
			<tr>
			<td class='bg3'><b>" . _AM_FORM_INDENT . "</b></td>
			<td class='bg1'><input type='text' name='indent' size='12' maxlength='12' value='0px'></td>
			</tr>
			<tr>
			<td class='bg3'><b>" . _AM_FORM_FONT . "</b></td>
			<td class='bg1'>
			<input type='radio' checked name='bold' value='0'>" . _AM_FORM_NORMAL . "
			<input type='radio'	name='bold' value='1'>" . _AM_FORM_BOLD . "
			</td>
			</tr>
			<tr>
			<td class='bg3'><b>" . _AM_FORM_ITEMURL . "</b></td>
			<td class='bg1'><input type='text' name='itemurl' size='50' maxlength='100'></td>
			</tr>
			<tr>
			<td class='bg3'><b>" . _AM_FORM_MARGINTOP . "</b></td>
			<td class='bg1'><input type='text' name='margintop' size='12' maxlength='12' value='0px'></td>
			</tr>
			<tr>
			<td class='bg3'><b>" . _AM_FORM_MARGINBOTTOM . "</b></td>
			<td class='bg1'><input type='text' name='marginbottom' size='12' maxlength='12' value='0px'></td>
			</tr>
			<tr>
			<td class='bg3'><b>" . _AM_FORM_MEMBERSONLY . "</b></td>
			<td class='bg1'>
			<input type='radio' checked name='membersonly' value='1'>" . _AM_FORM_MEMBERS . "
			<input type='radio'	name='membersonly' value='0'>" . _AM_FORM_ALL . "
			</td>
			</tr>
			<tr>
			<td class='bg3'><b>Menu-Style</b></td>
			<td class='bg1'>
			<input type='radio' checked name='mainmenu' value='1'>" . _AM_FORM_FORMULAIREMENUSTYLE . "
			<input type='radio'	name='mainmenu' value='0'>" . _AM_FORM_MAINMENUSTYLE . "
			</td>
			</tr>
			<tr>
			<td class='bg3'><b>" . _AM_FORM_STATUS . "</b></td>
			<td class='bg1'>
			<input type='radio' checked name='status' value='1'>" . _AM_FORM_ACTIVE . "
			<input type='radio'	name='status' value='0'>" . _AM_FORM_INACTIVE . "
			</td>
			</tr>
			<tr>
			<td class='bg3'>&nbsp;</td>
			<td class='bg1'><input type='hidden' name='fct' value='mymenu'><input type='hidden' name='op' value='MyMenuAdd'><input type='submit' value='" . _AM_FORM_ADD . "'></td>
			</tr>
			</table>
		</td>
		</tr>
		</table>
		</form>
		<br>";

    //*********** Menueintrag ?dern/l?chen ******************************************************

    echo "<h4 style='text-align:left;'>" . _AM_FORM_CHANGEMENUITEM . "</h4>
		<form action='menu_index.php' method='post'>
		<table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
		<tr>
		<td class='bg2'>
			<table width='100%' border='0' cellpadding='4' cellspacing='1'>
			<tr class='bg3'>
			<td><b>" . _AM_FORM_POS_SHORT . '</b></td>
			<td><b>' . _AM_FORM_ITEMNAME . '</b></td>
			<td><b>' . _AM_FORM_INDENT_SHORT . '</b></td>
			<td><b>' . _AM_FORM_MARGIN_TOPSHORT . '</b></td>
			<td><b>' . _AM_FORM_MARGIN_BOTTOMSHORT . '</b></td>
			<td><b>' . _AM_FORM_ITEMURL . '</b></td>
			<td><b>' . _AM_FORM_MEMBERSONLY_SHORT . '</b></td>
			<td><b>Style</b></td>
			<td><b>' . _AM_FORM_STATUS . '</b></td>
			<td><b>' . _AM_FORM_FUNCTION . '</b></td>';

    $result = $xoopsDB->query('SELECT menuid, position, itemname, indent, margintop, marginbottom, itemurl, bold, membersonly, mainmenu, status FROM ' . $xoopsDB->prefix('formmail_menu') . ' ORDER BY position');

    $myts = MyTextSanitizer::getInstance();

    while (list($menuid, $position, $itemname, $indent, $margintop, $marginbottom, $itemurl, $bold, $membersonly, $mainmenu, $status) = $xoopsDB->fetchRow($result)) {
        $itemname = htmlspecialchars($itemname, ENT_QUOTES | ENT_HTML5);

        $itemurl = htmlspecialchars($itemurl, ENT_QUOTES | ENT_HTML5);

        echo "<tr class='bg1'><td align='right'>$position</td>";

        if (1 == $bold) {
            echo "<td><b>$itemname</b></td>";
        } else {
            echo "<td>$itemname</td>";
        }

        echo "<td>$indent</td>";

        echo "<td>$margintop</td>";

        echo "<td>$marginbottom</td>";

        echo "<td>$itemurl</td>";

        if (1 == $membersonly) {
            echo '<td>' . _AM_FORM_YES . '</td>';
        } else {
            echo '<td> </td>';
        }

        if (1 == $mainmenu) {
            echo '<td>' . _AM_FORM_FORMULAIREMENUSTYLE . '</td>';
        } else {
            echo '<td>' . _AM_FORM_MAINMENUSTYLE . '</td>';
        }

        if (1 == $status) {
            echo '<td>' . _AM_FORM_ACTIVE . '</td>';
        } else {
            echo '<td>' . _AM_FORM_INACTIVE . '</td>';
        }

        echo "<td><a href='menu_index.php?op=MyMenuEdit&amp;menuid=$menuid'>" . _AM_FORM_EDIT . "</a> | <a href='menu_index.php?op=MyMenuDel&amp;menuid=$menuid&amp;ok=0'>" . _AM_FORM_DELETE . '</a></td>
			</tr>';
    }

    echo '</table>
		</td>
		</tr>
		</table>
		</form>';

    CloseTable();
}

function MyMenuEdit($menuid)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    xoops_cp_header();

    // admin menu

    formmail_admin_menu();

    $result = $xoopsDB->query('SELECT position, itemname, indent, margintop, marginbottom, itemurl, bold, membersonly, mainmenu, status FROM ' . $xoopsDB->prefix('formmail_menu') . " WHERE menuid=$menuid");

    [$xposition, $itemname, $indent, $margintop, $marginbottom, $itemurl, $bold, $membersonly, $mainmenu, $status] = $xoopsDB->fetchRow($result);

    $myts = MyTextSanitizer::getInstance();

    $itemname = htmlspecialchars($itemname, ENT_QUOTES | ENT_HTML5);

    $itemurl = htmlspecialchars($itemurl, ENT_QUOTES | ENT_HTML5);

    OpenTable();

    echo '<big><b>' . _AM_FORM_TITLE . "</big></b>
		<h4 style='text-align:left;'>" . _AM_FORM_EDITMENUITEM . "</h4>
		<form action='menu_index.php' method='post'>
		<input type='hidden' name='menuid' value='$menuid'>
		<table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
		<tr>
		<td class='bg2'>
			<table width='100%' border='0' cellpadding='4' cellspacing='1'>
			<tr>
			<td class='bg3'><b>" . _AM_FORM_POS . "</b></td>
			<td class='bg1'><input type='text' name='xposition' size='4' maxlength='4' value='$xposition'>&nbsp&nbsp&nbsp(0000-9999)</td>
			</tr>
			<tr>
			<td class='bg3'><b>" . _AM_FORM_ITEMNAME . "</b></td>
			<td class='bg1'><input type='text' name='itemname' size='50' maxlength='60' value='$itemname'></td>
			</tr>
			<tr>
				<td class='bg3'><b>" . _AM_FORM_INDENT . "</b></td>
			<td class='bg1'><input type='text' name='indent' size='12' maxlength='12' value='$indent'></td>
			</tr>
			<tr>
			<td class='bg3'><b>" . _AM_FORM_FONT . "</b></td>
			<td class='bg1'>";

    if (1 == $bold) {
        $checked_bold = 'checked';

        $checked_normal = '';
    } else {
        $checked_normal = 'checked';

        $checked_bold = '';
    }

    echo "<input type='radio' $checked_normal name='bold' value='0'>" . _AM_FORM_NORMAL . "
		<input type='radio' $checked_bold   name='bold' value='1'>" . _AM_FORM_BOLD . "
		</td>
		</tr>
		<tr>
		<td class='bg3'><b>Menu-Style</b></td>
		<td class='bg1'>";

    if (1 == $mainmenu) {
        $checked_mymenustyle = 'checked';

        $checked_mainmenustyle = '';
    } else {
        $checked_mainmenustyle = 'checked';

        $checked_mymenustyle = '';
    }

    echo "<input type='radio' $checked_mymenustyle name='mainmenu' value='1'>" . _AM_FORM_FORMULAIREMENUSTYLE . "
		<input type='radio' $checked_mainmenustyle name='mainmenu' value='0'>" . _AM_FORM_MAINMENUSTYLE . "
		</td>
		</tr>
		<tr>
		<td class='bg3'><b>" . _AM_FORM_ITEMURL . "</b></td>
		<td class='bg1'><input type='text' name='itemurl' size='50' maxlength='100' value='$itemurl'></td>
		</tr>
		<tr>
		<td class='bg3'><b>" . _AM_FORM_MARGINTOP . "</b></td>
		<td class='bg1'><input type='text' name='margintop' size='12' maxlength='12' value='$margintop'></td>
		</tr>
		<tr>
		<td class='bg3'><b>" . _AM_FORM_MARGINBOTTOM . "</b></td>
		<td class='bg1'><input type='text' name='marginbottom' size='12' maxlength='12' value='$marginbottom'></td>
		</tr>
		<tr>
		<td class='bg3'><b>" . _AM_FORM_MEMBERSONLY . "</b></td>
		<td class='bg1'>";

    if (1 == $membersonly) {
        $checked_members = 'checked';

        $checked_allusers = '';
    } else {
        $checked_allusers = 'checked';

        $checked_members = '';
    }

    echo "<input type='radio' $checked_members  name='membersonly' value='1'>" . _AM_FORM_MEMBERS . "
		<input type='radio' $checked_allusers name='membersonly' value='0'>" . _AM_FORM_ALL . "
		</td>
		</tr>
		<tr>
		<td class='bg3'><b>" . _AM_FORM_STATUS . "</b></td>
		<td class='bg1'>";

    if (1 == $status) {
        $checked_active = 'checked';

        $checked_inactive = '';
    } else {
        $checked_inactive = 'checked';

        $checked_active = '';
    }

    echo "<input type='radio' $checked_active   name='status' value='1'>" . _AM_FORM_ACTIVE . "
		<input type='radio' $checked_inactive name='status' value='0'>" . _AM_FORM_INACTIVE . "
		</td>
		</tr>
		<tr>
		<td class='bg3'>&nbsp;</td>
		<td class='bg1'><input type='hidden' name='fct' value='mymenu'><input type='hidden' name='op' value='MyMenuSave'><input type='submit' value='" . _AM_FORM_SAVECHANG . "'></td>
		</tr>
		</table>
		</td>
		</tr>
		</table>
		</form>";

    CloseTable();
}

function MyMenuSave($menuid, $xposition, $itemname, $indent, $margintop, $marginbottom, $itemurl, $bold, $membersonly, $mainmenu, $status)
{
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $itemname = $myts->addSlashes(trim($itemname));

    $itemurl = $myts->addSlashes(trim($itemurl));

    $xoopsDB->query(
        'UPDATE ' . $xoopsDB->prefix('formmail_menu') . " SET position=$xposition, itemname='$itemname', indent='$indent', margintop='$margintop', marginbottom='$marginbottom', itemurl='$itemurl', bold=$bold, membersonly=$membersonly, mainmenu=$mainmenu, status=$status WHERE menuid=$menuid"
    );

    redirect_header('menu_index.php?op=MyMenuAdmin', 1, _AM_FORM_DBUPDATED);

    exit();
}

function MyMenuAdd($xposition, $itemname, $indent, $margintop, $marginbottom, $itemurl, $bold, $membersonly, $mainmenu, $status)
{
    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $itemname = $myts->addSlashes(trim($itemname));

    $itemurl = $myts->addSlashes(trim($itemurl));

    //	$newid = $xoopsDB->genId($xoopsDB->prefix("formmail_menu")."_menuid_seq");

    //	$xoopsDB->query("INSERT INTO ".$xoopsDB->prefix("formmail_menu")." (menuid, position, itemname, indent, margintop, marginbottom, itemurl, bold, membersonly, mainmenu, status) VALUES ($newid, $xposition, '$itemname', '$indent', '$margintop', '$marginbottom', '$itemurl', $bold, $membersonly, $mainmenu, $status)");

    $sql = sprintf(
        'INSERT INTO ' . $xoopsDB->prefix('formmail_menu') . " ( position, indent, itemname, margintop, marginbottom, itemurl, bold, mainmenu, membersonly, status) VALUES ('$xposition', '$indent', '$itemname', '$margintop', '$marginbottom', '$itemurl', $bold, $mainmenu, $membersonly, $status)"
    );

    $xoopsDB->query($sql);

    redirect_header('menu_index.php?op=MyMenuAdmin', 1, _AM_FORM_DBUPDATED);

    exit();
}

function MyMenuDel($menuid, $ok = 0)
{
    global $xoopsDB, $xoopsConfig, $xoopsModule;

    if (1 == $ok) {
        $xoopsDB->query('DELETE FROM ' . $xoopsDB->prefix('formmail_menu') . " WHERE menuid=$menuid");

        redirect_header('menu_index.php?op=MyMenuAdmin', 1, _AM_FORM_DBUPDATED);

        exit();
    }

    xoops_cp_header();

    OpenTable();

    $result = $xoopsDB->query('SELECT position, itemname, indent, margintop, marginbottom, itemurl, bold, membersonly, mainmenu, status FROM ' . $xoopsDB->prefix('formmail_menu') . " WHERE menuid=$menuid");

    [$position, $itemname, $indent, $margintop, $marginbottom, $itemurl, $bold, $membersonly, $mainmenu, $status] = $xoopsDB->fetchRow($result);

    echo '<big><b>' . _AM_FORM_TITLE . '</big></b>';

    echo "<h4 style='text-align:left;'>" . _AM_FORM_DELETEMENUITEM . "</h4>
			<form action='menu_index.php' method='post'>
			<input type='hidden' name='menuid' value='$menuid'>
			<table border='0' cellpadding='0' cellspacing='0' valign='top' width='100%'>
			<tr>
			<td class='bg2'>
				<table width='100%' valign='top' border='0' cellpadding='4' cellspacing='1'>
				<tr>
				<td class='bg3' width='30%'><b>" . _AM_FORM_POS . "</b></td>
				<td class='bg1'>" . $position . "</td>
				</tr>
				<tr>
				<td class='bg3'><b>" . _AM_FORM_ITEMNAME . "</b></td>
				<td class='bg1'>" . $itemname . "</td>
				</tr>
				<tr>
				<td class='bg3'><b>" . _AM_FORM_ITEMURL . "</b></td>
				<td class='bg1'>" . $itemurl . '</td>
				</tr>
				</table>
			</td>
			</tr>
			</table>
			</form>';

    echo "<table valign='top'><tr>";

    echo "<td width='30%'valign='top'><span style='color:#ff0000;'><b>" . _AM_FORM_WANTDEL . '</b></span></td>';

    echo "<td width='3%'>\n";

    echo myTextForm("menu_index.php?op=MyMenuDel&menuid=$menuid&ok=1", _AM_FORM_YES);

    echo "</td><td>\n";

    echo myTextForm('menu_index.php?op=MyMenuAdmin', _AM_FORM_NO);

    echo "</td></tr></table>\n";

    CloseTable();
}

/*
foreach ($_POST as $k => $v) {
    ${$k} = $v;
}
if(!isset($_POST['op']) && isset($_GET['op']) ) {
    $op = $_GET['op'] ;
}
if(!isset($_POST['ok']) && isset($_GET['ok']) ) {
    $ok = $_GET['ok'] ;
}
if(!isset($_POST['menuid']) && isset($_GET['menuid']) ) {
    $menuid = $_GET['menuid'] ;
}
*/
extract($_GET);
extract($_POST);

switch ($op) {
    case 'MyMenuDel':
        MyMenuDel($menuid, $ok);
        break;
    case 'MyMenuAdd':
        MyMenuAdd($xposition, $itemname, $indent, $margintop, $marginbottom, $itemurl, $bold, $membersonly, $mainmenu, $status);
        break;
    case 'MyMenuSave':
        MyMenuSave($menuid, $xposition, $itemname, $indent, $margintop, $marginbottom, $itemurl, $bold, $membersonly, $mainmenu, $status);
        break;
    case 'MyMenuAdmin':
        MyMenuAdmin();
        break;
    case 'MyMenuEdit':
        MyMenuEdit($menuid);
        break;
    default:
        MyMenuAdmin();
        break;
}
xoops_cp_footer();
