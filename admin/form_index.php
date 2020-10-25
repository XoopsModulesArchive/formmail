<?php

###############################################################################
##             Formulaire - Information submitting module for XOOPS          ##
##                    Copyright (c) 2005 NS Tai (aka tuff)                   ##
##                       <http://www.brandycoke.com>                        ##
###############################################################################
##                    XOOPS - PHP Content Management System                  ##
##                       Copyright (c) 2000 XOOPS.org                        ##
##                          <https://www.xoops.org>                          ##
###############################################################################
##  This program is free software; you can redistribute it and/or modify     ##
##  it under the terms of the GNU General Public License as published by     ##
##  the Free Software Foundation; either version 2 of the License, or        ##
##  (at your option) any later version.                                      ##
##                                                                           ##
##  You may not change or alter any portion of this comment or credits       ##
##  of supporting developers from this source code or any supporting         ##
##  source code which is considered copyrighted (c) material of the          ##
##  original comment or credit authors.                                      ##
##                                                                           ##
##  This program is distributed in the hope that it will be useful,          ##
##  but WITHOUT ANY WARRANTY; without even the implied warranty of           ##
##  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            ##
##  GNU General Public License for more details.                             ##
##                                                                           ##
##  You should have received a copy of the GNU General Public License        ##
##  along with this program; if not, write to the Free Software              ##
##  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA ##
###############################################################################
##  Author of this file: NS Tai (aka tuff)                                   ##
##  URL: http://www.brandycoke.com/                                          ##
##  Project: Formulaire                                                      ##
###############################################################################
/**
 * XOOPS module 'FormMail'  by Tom (Malaika System)
 **/
require_once 'admin_header.php';
require_once dirname(__DIR__, 3) . '/include/cp_header.php';

if (isset($_GET['op'])) {
    $op = $_GET['op'];
}
if (isset($_POST['op'])) {
    $op = $_POST['op'];
}
if (isset($_GET['id_form'])) {
    $id_form = $_GET['id_form'];
}
//if (isset($_POST['id_form'])) $id_form = $_POST['id_form'];

//include "../include/functions.php";
//require_once XOOPS_ROOT_PATH."/class/xoopstree.php";
//require_once XOOPS_ROOT_PATH."/class/xoopslists.php";
//require_once XOOPS_ROOT_PATH."/include/xoopscodes.php";
require_once XOOPS_ROOT_PATH . '/class/module.errorhandler.php';
$eh = new ErrorHandler();

xoops_cp_header();
function addform()
{
    global $xoopsDB, $_POST, $eh;

    $myts = MyTextSanitizer::getInstance();

    $title = $myts->addSlashes($_POST['desc_form']);

    $admin = $myts->addSlashes($_POST['admin']);

    $groupe = $myts->addSlashes($_POST['groupe']);

    $email = $myts->addSlashes($_POST['email']);

    $expe = $myts->addSlashes($_POST['expe']);

    $text_index = $myts->addSlashes($_POST['text_index']);

    $text_form = $myts->addSlashes($_POST['text_form']);

    $form_order = $myts->addSlashes($_POST['form_order']);

    $form_req = $myts->addSlashes($_POST['form_req']);

    if (empty($title)) {
        redirect_header('index.php', 2, _AM_FORM_ERRORTITLE);

        exit();
    }

    if ((!empty($email)) && (!eregi("^[^@]+@[^.]+\..+", $email))) {
        redirect_header('index.php', 2, _AM_FORM_ERROREMAIL);

        exit();
    }

    if (empty($email) && empty($admin) && '0' == $groupe && empty($expe)) {
        redirect_header('index.php', 2, _AM_FORM_ERRORMAIL);

        exit();
    }

    $title = stripslashes($title);

    $title = eregi_replace("'", '`', $title);

    $title = eregi_replace('"', '`', $title);

    $title = eregi_replace('&', '_', $title);

    $sql = sprintf(
        "INSERT INTO %s (desc_form, admin, groupe, email, expe, text_index, text_form, form_order, form_req) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s')",
        $xoopsDB->prefix('formmail_id'),
        $title,
        $admin,
        $groupe,
        $email,
        $expe,
        $text_index,
        $text_form,
        $form_order,
        $form_req
    );

    $xoopsDB->query($sql) or $eh::show('0013');

    $sql = sprintf('SELECT id_form FROM ' . $xoopsDB->prefix('formmail_id') . " WHERE desc_form='%s'", $title);

    $res = $xoopsDB->query($sql) || die('Erreur SQL !<br>' . $sql . '<br>' . $xoopsDB->error());

    while (false !== ($row = $xoopsDB->fetchArray($res))) {
        $id_form = $row['id_form'];
    }

    // save for mymenu

    if ('on' == $form_req) {
        $status = '1';
    } else {
        $status = '0';
    }

    $sql2 = sprintf("INSERT INTO %s (itemname, itemurl, status) VALUES ('%s', '%s', '%s')", $xoopsDB->prefix('formmail_menu'), $title, XOOPS_URL . '/modules/formmail/index.php?id_form=' . $id_form, $status);

    $xoopsDB->query($sql2) or $eh::show('0013');

    redirect_header("ele_index.php?id_form=$id_form", 0, _AM_FORM_NEWFORMADDED);

    exit();
}

function delform($id_form)
{
    global $xoopsDB, $eh;

    if (1 == $_POST['ok']) {
        // delete form data

        $sql = sprintf("DELETE FROM %s WHERE id_form = '%s'", $xoopsDB->prefix('formmail_id'), $id_form);

        $xoopsDB->query($sql) or $eh::show('0013');

        $sql = sprintf("DELETE FROM %s WHERE id_form = '%u'", $xoopsDB->prefix('formmail'), $id_form);

        $xoopsDB->query($sql) or $eh::show('0013');

        // delete menu data

        $itemurl = XOOPS_URL . '/modules/formmail/index.php?id_form=' . $id_form;

        $sql = sprintf("DELETE FROM %s WHERE itemurl = '%s'", $xoopsDB->prefix('formmail_menu'), $itemurl);

        $xoopsDB->query($sql) or $eh::show('0013');

        redirect_header('index.php', 0, _AM_FORM_FORMDEL);

        exit();
    }

    echo '<h4>' . _AM_FORM_FORMDEL2 . '</h4>';

    xoops_confirm(['op' => 'delform', 'ok' => 1], 'form_index.php?id_form=' . $id_form, _AM_RUSUREDEL);
}

function update()
{
    global $xoopsDB, $_POST, $eh;

    foreach ($_POST as $k => $v) {
        $$k = $v;
    }

    $myts = MyTextSanitizer::getInstance();

    foreach ($id as $id_form) {
        $expe[$id_form] = $myts->addSlashes($expe[$id_form]);

        $form_order[$id_form] = $myts->addSlashes($form_order[$id_form]);

        $form_req[$id_form] = $myts->addSlashes($form_req[$id_form]);

        $sql = sprintf("UPDATE %s SET expe='%s', form_order='%s', form_req='%s' WHERE id_form='%s' ", $xoopsDB->prefix('formmail_id'), $expe[$id_form], $form_order[$id_form], $form_req[$id_form], $id_form);

        $xoopsDB->query($sql) or $eh::show('0013');

        // update mymenu

        $menu_url = XOOPS_URL . '/modules/formmail/index.php?id_form=' . $id_form;

        if ('on' == $form_req[$id_form]) {
            $sql2 = sprintf("UPDATE %s SET status='%s' WHERE itemurl='%s'", $xoopsDB->prefix('formmail_menu'), '1', $menu_url);

            $xoopsDB->query($sql2) or $eh::show('0013');
        } else {
            $sql2 = sprintf("UPDATE %s SET status='%s' WHERE itemurl='%s'", $xoopsDB->prefix('formmail_menu'), '0', $menu_url);

            $xoopsDB->query($sql2) or $eh::show('0013');
        }
    }

    redirect_header('index.php', 1, _AM_FORM_FORMCHARG);

    break;
}

switch ($op) {
    case 'addform':
        addform();
        break;
    case 'delform':
        delform($id_form);
        break;
    case 'update':
        update();
        break;
    default:
        redirect_header('index.php', 0);
        exit();
}

require __DIR__ . '/footer.php';
xoops_cp_footer();
