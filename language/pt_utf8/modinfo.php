<?php

// Module Info
// The name of this module
define('_MI_FORM_NAME', 'Form');
// A brief description of this module
define('_MI_FORM_DESC', 'For sending messages to the webmaster & Displays an individually configurable menu in a block');
// admin/menu.php
define('_MI_FORM_ADMENU0', 'Form management');
define('_MI_FORM_ADMENU1', 'MyMenu');
// preferences
define('_MI_FORM_TEXT_WIDTH', 'Default width of text boxes');
define('_MI_FORM_TEXT_MAX', 'Default maximum length of text boxes');
define('_MI_FORM_TAREA_ROWS', 'Default rows of text areas');
define('_MI_FORM_TAREA_COLS', 'Default columns of text areas');
define('_MI_FORM_DELIMETER', 'Delimeter for check boxes and radio buttons');
define('_MI_FORM_DELIMETER_SPACE', 'White space');
define('_MI_FORM_DELIMETER_BR', 'Line break');
define('_MI_FORM_SEND_METHOD', 'Send method');
define('_MI_FORM_SEND_METHOD_DESC', 'Note: Form submitted by anonymous users cannot be sent by using private message.');
define('_MI_FORM_SEND_METHOD_MAIL', 'Email');
define('_MI_FORM_SEND_METHOD_PM', 'Private message');
define('_MI_FORM_SEND_GROUP', 'Send to group');
define('_MI_FORM_SEND_ADMIN', 'Send to site admin only');
define('_MI_FORM_SEND_ADMIN_DESC', 'Settings of "Send to group" will be ignored');
define('_MI_FORM_SEND_GUESTEXPE', '¥²¥¹¥È¤Ë¥á¡¼¥ë¤Î¹µ¤¨¤òÁ÷¿®¤¹¤ë');
define('_MI_FORM_SEND_GUESTEXPE_DESC', '¤³¤ÎÀßÄê¤ÏÁ´¤Æ¤Î¥Õ¥©¡¼¥à¤ËÅ¬ÍÑ¤µ¤ì¤Þ¤¹¡£¹µ¤¨¥á¡¼¥ë¤ÎÁ÷¿®¤ÎÍ­Ìµ¤Ï¡¢¥Õ¥©¡¼¥àËè¤ËÀßÄê¤·¤Æ¤¯¤À¤µ¤¤');
define('_MI_FORM_SEND_USERNAME', '¡Ö¤ªÌ¾Á°¡×Íó¤Ë¼«Æ°ÁÞÆþ¤¹¤ëÌ¾Á°¤Î»ØÄê');
define('_MI_FORM_SEND_USERNAME_DESC', 'ÅÐÏ¿¥æ¡¼¥¶¡¼¤Î¾ì¹ç¡¢¥Õ¥©¡¼¥à¤Î¡Ö¤ªÌ¾Á°¡×Íó¤Ë¼«Æ°¤ÇÁÞÆþ¤µ¤ì¤ëÌ¾Á°¤ò»ØÄê¤·¤Þ¤¹¡£');
define('_MI_FORM_SEND_USERNAME_UNAME', '¥í¥°¥¤¥óÌ¾¤òÁÞÆþ');
define('_MI_FORM_SEND_USERNAME_NAME', 'ËÜÌ¾¤òÁÞÆþ');
define('_MI_FORM_SEND_MAILTITLE', '¥á¡¼¥ë¥¿¥¤¥È¥ë¤Ë¥µ¥¤¥ÈÌ¾¤òÉ½¼¨');
define('_MI_FORM_SEND_MAILTITLE_DESC', '¡Ö¤Ï¤¤¡×¤È¤¹¤ë¤È¡¢¥á¡¼¥ë¥¿¥¤¥È¥ë¤ÎÀèÆ¬¤Ë¡¢[' . $xoopsConfig['sitename'] . '] ¤ÈÉ½¼¨¤µ¤ì¤Þ¤¹');
define('_MI_FORM_SEND_MAILTITLE2', '¥á¡¼¥ë¥µ¥Ö¥¿¥¤¥È¥ë');
define('_MI_FORM_SEND_MAILTITLE_DESC2', "¥á¡¼¥ë¥¿¥¤¥È¥ë¤Î'¥µ¥¤¥ÈÌ¾'¤È'¥Õ¥©¡¼¥àÌ¾'¤Î´Ö¤Ë¡¢¤³¤³¤ÇÀßÄê¤·¤¿Ê¸»ú¤òÁÞÆþ¤·¤Þ¤¹¡£É¬Í×Ìµ¤¤»þ¤Ï¡¢¶õÍó¤Ë¤·¤Æ¤¯¤À¤µ¤¤¡£");
// The name of this module
//define("_MI_FORM_MENU_NAME","MyMenu");
// A brief description of this module
//define("_MI_FORM_MENU_DESC","Displays an individually configurable menu in a block");
// Names of blocks for this module (Not all module has blocks)
define('_MI_FORM_MENU_BNAME', 'FormMail');
