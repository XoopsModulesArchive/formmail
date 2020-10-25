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
require __DIR__ . '/header.php';

// view index
if (!isset($_GET['id_form'])) {
    // count form

    $result = $xoopsDB->query('SELECT id_form FROM ' . $xoopsDB->prefix('formmail_id') . " WHERE form_req='on'");

    $num_form = $xoopsDB->getRowsNum($result);

    // form == one : go to form

    if (1 == $num_form) {
        [$id_form] = $xoopsDB->fetchRow($result);

        redirect_header(XOOPS_URL . '/modules/formmail/index.php?id_form=' . $id_form, 0, _MD_FORM_MSG_CHARG);

        exit();

        // form >1ea : view menu
    }

    $GLOBALS['xoopsOption']['template_main'] = 'formmail_index.html';

    require_once XOOPS_ROOT_PATH . '/header.php';

    global $xoopsDB;

    $myts = MyTextSanitizer::getInstance();

    $i = 1;

    $result2 = $xoopsDB->query('SELECT id_form, desc_form, text_index FROM ' . $xoopsDB->prefix('formmail_id') . " WHERE form_req='on' ORDER BY form_order");

    while (false !== ($row = $xoopsDB->fetchArray($result2))) {
        $form_list['id_form'] = htmlspecialchars($row['id_form'], ENT_QUOTES | ENT_HTML5);

        $form_list['title'] = htmlspecialchars($row['desc_form'], ENT_QUOTES | ENT_HTML5);

        $form_list['text'] = $myts->displayTarea($row['text_index']);

        $xoopsTpl->append('form_list', $form_list);

        $i++;
    }

    $xoopsTpl->assign('form_title', _MD_FORM_SITENAME);

    $xoopsTpl->assign('form_subject', _MD_FORM_SUBJECT);

    $xoopsTpl->assign('formmail_credits', credits());

    require_once XOOPS_ROOT_PATH . '/footer.php';

// mail form
} else {
    $id_form = $_GET['id_form'];

    $myts = MyTextSanitizer::getInstance();

    // check id_form

    $sql = 'SELECT desc_form, admin, groupe, email, expe, text_index, text_form, form_req FROM ' . $xoopsDB->prefix('formmail_id') . ' WHERE id_form=' . $id_form . '';

    $result = $xoopsDB->query($sql) || die('Erreur SQL !<br>' . $sql . '<br>' . $xoopsDB->error());

    if ($result) {
        while (false !== ($row = $xoopsDB->fetchArray($result))) {
            $title = htmlspecialchars($row['desc_form'], ENT_QUOTES | ENT_HTML5);

            $admin = htmlspecialchars($row['admin'], ENT_QUOTES | ENT_HTML5);

            $groupe = htmlspecialchars($row['groupe'], ENT_QUOTES | ENT_HTML5);

            $email = htmlspecialchars($row['email'], ENT_QUOTES | ENT_HTML5);

            $expe = htmlspecialchars($row['expe'], ENT_QUOTES | ENT_HTML5);

            $text_index = $myts->displayTarea($row['text_index']);

            $text_form = $myts->displayTarea($row['text_form']);

            $form_req = htmlspecialchars($row['form_req'], ENT_QUOTES | ENT_HTML5);
        }
    }

    // no title & $form_req==off : return to index.php

    if (!empty($xoopsUser)) {
        $isAdmin = $xoopsUser->isAdmin($xoopsModule->mid());

        if (!isset($title) || ('on' !== $form_req && !$isAdmin)) {
            redirect_header(XOOPS_URL . '/', 1, _MD_FORM_MSG_ERROR);

            exit();
        }
    } else {
        if (!isset($title) || ('on' !== $form_req)) {
            redirect_header(XOOPS_URL . '/', 1, _MD_FORM_MSG_ERROR);

            exit();
        }
    }

    // view form

    if (empty($_POST['submit'])) {
        $GLOBALS['xoopsOption']['template_main'] = 'formmail_form.html';

        require_once XOOPS_ROOT_PATH . '/header.php';

        $xoopsTpl->assign('text_index', $text_index);

        $xoopsTpl->assign('text_form', $text_form);

        $xoopsTpl->assign('formmail_credits', credits());

        $criteria = new Criteria('ele_display', 1);

        $criteria->setSort('ele_order');

        $criteria->setOrder('ASC');

        $elements = &$formmail_mgr->getObjects2($criteria, $id_form);

        $form = new XoopsThemeForm(_MD_FORM_LANG_FORMTITLE . $title, 'formmail', XOOPS_URL . '/modules/formmail/index.php?id_form=' . $id_form . '');

        // fix-form : name & email

        if (!empty($xoopsUser)) {
            $h_name = $xoopsUser->getVar('name', 'E');

            if ('name' == $xoopsModuleConfig['username_sel'] && !empty($h_name)) {
                $name_v = $h_name;
            } else {
                $name_v = $xoopsUser->getVar('uname', 'E');
            }
        } else {
            $name_v = '';
        }

        $email_v = !empty($xoopsUser) ? $xoopsUser->getVar('email', 'E') : '';

        $name_text = new XoopsFormText(_MD_FORM_LANG_NAME, 'usersName', $xoopsModuleConfig['t_width'], $xoopsModuleConfig['t_max'], $name_v);

        $email_text = new XoopsFormText(_MD_FORM_LANG_EMAIL, 'usersEmail', $xoopsModuleConfig['t_width'], $xoopsModuleConfig['t_max'], $email_v);

        $form->addElement($name_text, true);

        $form->addElement($email_text, true);

        $count = 0;

        foreach ($elements as $i) {
            $renderer = new FormmailElementRenderer($i);

            $form_ele = $renderer->constructElement('ele_' . $i->getVar('ele_id'));

            $req = (int)$i->getVar('ele_req');

            $form->addElement($form_ele, $req);

            $count++;

            unset($hidden);
        }

        $form->addElement(new XoopsFormButton('', 'submit', _SUBMIT, 'submit'));

        $form->assign($xoopsTpl);

        require_once XOOPS_ROOT_PATH . '/footer.php';

    // send mail
    } else {
        //		$myts = MyTextSanitizer::getInstance();

        $msg = '';

        unset($_POST['submit']);

        foreach ($_POST as $k => $v) {
            if (false !== strpos($k, "ele_")) {
                $n = explode('_', $k);

                $ele[$n[1]] = $v;

                $id[$n[1]] = $n[1];
            }
        }

        foreach ($id as $i) {
            $element = $formmail_mgr->get($i);

            if (!empty($ele[$i])) {
                $ele_type = $element->getVar('ele_type');

                $ele_value = $element->getVar('ele_value');

                $ele_caption = $element->getVar('ele_caption');

                $ele_caption = stripslashes($ele_caption);

                $ele_caption = eregi_replace('&#039;', '`', $ele_caption);

                $ele_caption = eregi_replace('&quot;', '`', $ele_caption);

                $msg .= "\n" . $ele_caption . "\n";

                switch ($ele_type) {
                    case 'text':
                        $msg .= $myts->stripSlashesGPC($ele[$i]) . "\n";
                        break;
                    case 'textarea':
                        $msg .= $myts->stripSlashesGPC($ele[$i]) . "\n";
                        break;
                    case 'radio':
                        $opt_count = 1;
                        while ($v = each($ele_value)) {
                            if ($opt_count == $ele[$i]) {
                                $msg .= $myts->stripSlashesGPC($v['key']) . "\n";
                            }

                            $opt_count++;
                        }
                        break;
                    case 'yn':
                        $v = (2 == $ele[$i]) ? _NO : _YES;
                        $msg .= $myts->stripSlashesGPC($v) . "\n";
                        break;
                    case 'checkbox':
                        $opt_count = 1;
                        while ($v = each($ele_value)) {
                            if (is_array($ele[$i])) {
                                if (in_array($opt_count, $ele[$i], true)) {
                                    $msg .= $myts->stripSlashesGPC($v['key']) . "\n";
                                }

                                $opt_count++;
                            } else {
                                if (!empty($ele[$i])) {
                                    $msg .= $myts->stripSlashesGPC($v['key']) . "\n";
                                }
                            }
                        }
                        break;
                    case 'select':
                        $opt_count = 1;
                        if (is_array($ele[$i])) {
                            while ($v = each($ele_value[2])) {
                                if (in_array($opt_count, $ele[$i], true)) {
                                    $msg .= $myts->stripSlashesGPC($v['key']) . "\n";
                                }

                                $opt_count++;
                            }
                        } else {
                            while ($j = each($ele_value[2])) {
                                if ($opt_count == $ele[$i]) {
                                    $msg .= $myts->stripSlashesGPC($j['key']) . "\n";
                                }

                                $opt_count++;
                            }
                        }
                        break;
                    default:
                        break;
                }
            }
        }

        // 	echo nl2br($msg);

        if (is_dir(FORMMAIL_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/mail_template')) {
            $template_dir = FORMMAIL_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/mail_template';
        } else {
            $template_dir = FORMMAIL_ROOT_PATH . '/language/english/mail_template';
        }

        $xoopsMailer = getMailer();

        $xoopsMailer->setTemplateDir($template_dir);

        $xoopsMailer->setTemplate('formmail.tpl');

        // mail title

        $sendmail_title = '';

        if ('1' == $xoopsModuleConfig['mail_title']) {
            $sendmail_title .= '[' . $xoopsConfig['sitename'] . '] ';
        }

        if (!empty($xoopsModuleConfig['mail_title2'])) {
            $sendmail_title .= $xoopsModuleConfig['mail_title2'] . ' ';
        }

        $sendmail_title .= $title;

        $xoopsMailer->setSubject($sendmail_title);

        $usersEmail = $myts->stripSlashesGPC($_POST['usersEmail']);

        $usersName = $myts->stripSlashesGPC($_POST['usersName']);

        if (is_object($xoopsUser)) {
            $xoopsMailer->assign('UNAME', '"' . $usersName . '" <' . $usersEmail . '> : ' . $xoopsUser->getVar('uname'));

            $xoopsMailer->assign('UID', $xoopsUser->getVar('uid'));
        } else {
            $xoopsMailer->assign('UNAME', '"' . $usersName . '" <' . $usersEmail . '> : ' . $xoopsConfig['anonymous']);

            $xoopsMailer->assign('UID', '-');
        }

        $xoopsMailer->assign('IP', xoops_getenv('REMOTE_ADDR'));

        $xoopsMailer->assign('AGENT', xoops_getenv('HTTP_USER_AGENT'));

        $xoopsMailer->assign('MSG', $msg);

        $xoopsMailer->assign('TITLE', $title);

        // send PM && xoopsuser

        if ('pm' == $xoopsModuleConfig['method'] && is_object($xoopsUser)) {
            $xoopsMailer->usePM();

            $sqlstr = "SELECT $xoopsDB->prefix" . "_users.uname AS UserName, $xoopsDB->prefix" . "_users.email AS UserEmail, $xoopsDB->prefix" . '_users.uid AS UserID FROM 
				 ' . $xoopsDB->prefix('groups') . ', ' . $xoopsDB->prefix('groups_users_link') . ', ' . $xoopsDB->prefix('users') . " WHERE $xoopsDB->prefix" . "_users.uid = $xoopsDB->prefix" . "_groups_users_link.uid 
				 AND $xoopsDB->prefix" . "_groups_users_link.groupid = $xoopsDB->prefix" . "_groups.groupid AND $xoopsDB->prefix" . "_groups.groupid = $groupe";

            $res = $xoopsDB->query($sqlstr);

            while (list($UserName, $UserEmail, $UserID) = $xoopsDB->fetchRow($res)) {
                $xoopsMailer->setToEmails($UserEmail);

                //	mail($UserEmail,$subject,$msg,"From: $sender\nReply-To: $replyto\nX-Mailer: PHP/");
            }

            // send E-mail
        } else {
            $xoopsMailer->useMail();

            if ('on' == $expe) {
                if (!empty($xoopsUser)) {
                    $email_expe = $xoopsUser->getVar('email');

                    $xoopsMailer->setToEmails($email_expe);

                    $xoopsMailer->assign('EMAIL_EXPE', $email_expe);
                } elseif ($xoopsModuleConfig['guest_expe']) {
                    $email_expe = $usersEmail;

                    $xoopsMailer->setToEmails($email_expe);

                    $xoopsMailer->assign('EMAIL_EXPE', $email_expe);
                } else {
                    $xoopsMailer->assign('EMAIL_EXPE', ' -- ');
                }
            } else {
                $xoopsMailer->assign('EMAIL_EXPE', ' -- ');
            }

            if ('on' == $admin) {
                $xoopsMailer->setToEmails($xoopsConfig['adminmail']);

                $xoopsMailer->assign('ADMINEMAIL', $xoopsConfig['adminmail']);

                $xoopsMailer->assign('EMAIL', ' -- ');

                $xoopsMailer->assign('GROUPE', ' -- ');
            } else {
                $xoopsMailer->assign('ADMINEMAIL', ' -- ');

                $xoopsMailer->setToEmails($email);

                $xoopsMailer->assign('EMAIL', $email);

                if (!empty($groupe) && ('0' != $groupe)) {
                    $sql = sprintf('SELECT name FROM ' . $xoopsDB->prefix('groups') . " WHERE groupid='%s'", $groupe);

                    $res = $xoopsDB->query($sql) || die('Erreur SQL !<br>' . $sql . '<br>' . $xoopsDB->error());

                    if ($res) {
                        while (false !== ($row = $xoopsDB->fetchRow($res))) {
                            $gr = $row[0];
                        }
                    }

                    $xoopsMailer->assign('GROUPE', $gr);
                } else {
                    $xoopsMailer->assign('GROUPE', ' -- ');
                }

                $sqlstr = "SELECT $xoopsDB->prefix" . "_users.uname AS UserName, $xoopsDB->prefix" . "_users.email AS UserEmail, $xoopsDB->prefix" . '_users.uid AS UserID FROM
		            ' . $xoopsDB->prefix('groups') . ', ' . $xoopsDB->prefix('groups_users_link') . ', ' . $xoopsDB->prefix('users') . " WHERE $xoopsDB->prefix" . "_users.uid = $xoopsDB->prefix" . "_groups_users_link.uid
		            AND $xoopsDB->prefix" . "_groups_users_link.groupid = $xoopsDB->prefix" . "_groups.groupid AND $xoopsDB->prefix" . "_groups.groupid = $groupe";

                $res = $xoopsDB->query($sqlstr);

                while (list($UserName, $UserEmail, $UserID) = $xoopsDB->fetchRow($res)) {
                    $xoopsMailer->setToEmails($UserEmail);

                    //	mail($UserEmail,$subject,$msg,"From: $sender\nReply-To: $replyto\nX-Mailer: PHP/");
                }
            }
        }

        $xoopsMailer->send();

        $sent = sprintf(_MD_FORM_MSG_SENT, $xoopsConfig['sitename']) . _MD_FORM_MSG_THANK;

        redirect_header(XOOPS_URL . '/', 2, $sent);

        exit();

        // 	if( !$xoopsMailer->send(true) ){
        // 		echo $xoopsMailer->getErrors();
        // 	}else{
        // 		echo $xoopsMailer->getSuccess();
        // 	}
    }
}

function credits()
{
    $credits = "<div style='text-align: right; font-size: x-small; font-style: italic;'>
	Turbinado pelo FormMail  v 1.0beta by Tom ( <a href='http://malaika.s31.xrea.com/' target='_blank'>Malaika System</a> )<br>
	Based on : <a href='http://www.xoops-themes.com/' target='_blank'>Formulaire 1.0 : xoops-themes&middot;com</a><br>
	/ <a href='http://www.brandycoke.com/' target='_blank'>Liaise 1.0b5 by NS Tai (aka tuff)</a> 
	/ MyMenu by Marcel Widmer</div>";

    return $credits;
}
