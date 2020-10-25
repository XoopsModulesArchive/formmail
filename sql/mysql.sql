#
# DROP TABLE IF EXISTS `formmail_id`;
CREATE TABLE formmail_id (
    id_form    SMALLINT(5) NOT NULL AUTO_INCREMENT,
    desc_form  VARCHAR(60) NOT NULL DEFAULT '',
    admin      VARCHAR(5)           DEFAULT NULL,
    groupe     VARCHAR(255)         DEFAULT NULL,
    email      VARCHAR(255)         DEFAULT NULL,
    expe       VARCHAR(5)           DEFAULT NULL,
    text_index TEXT        NOT NULL,
    text_form  TEXT        NOT NULL,
    form_order SMALLINT(2) NOT NULL DEFAULT '0',
    form_req   VARCHAR(5)  NOT NULL DEFAULT '0',
    PRIMARY KEY (`id_form`),
    UNIQUE KEY `` (`desc_form`)
)
    ENGINE = ISAM;
# DROP TABLE IF EXISTS `formmail`;
CREATE TABLE formmail (
    id_form     INT(5)               NOT NULL DEFAULT '0',
    ele_id      SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
    ele_type    VARCHAR(10)          NOT NULL DEFAULT '',
    ele_caption VARCHAR(255)         NOT NULL DEFAULT '',
    ele_order   SMALLINT(2)          NOT NULL DEFAULT '0',
    ele_req     TINYINT(1)           NOT NULL DEFAULT '1',
    ele_value   TEXT                 NOT NULL,
    ele_display TINYINT(1)           NOT NULL DEFAULT '1',
    PRIMARY KEY (`ele_id`),
    KEY `ele_display` (`ele_display`),
    KEY `ele_order` (`ele_order`)
)
    ENGINE = ISAM;
# DROP TABLE IF EXISTS `formmail_menu`;
CREATE TABLE formmail_menu (
    menuid       INT(4) UNSIGNED NOT NULL AUTO_INCREMENT,
    position     INT(4) UNSIGNED NOT NULL,
    indent       INT(2) UNSIGNED NOT NULL DEFAULT '0',
    itemname     VARCHAR(60)     NOT NULL DEFAULT '',
    margintop    VARCHAR(12)     NOT NULL DEFAULT '0px',
    marginbottom VARCHAR(12)     NOT NULL DEFAULT '0px',
    itemurl      VARCHAR(100)    NOT NULL DEFAULT '',
    bold         TINYINT(1)      NOT NULL DEFAULT '0',
    mainmenu     TINYINT(1)      NOT NULL DEFAULT '0',
    membersonly  TINYINT(1)      NOT NULL DEFAULT '1',
    status       TINYINT(1)      NOT NULL DEFAULT '1',
    PRIMARY KEY (menuid),
    KEY idxmymenustatus (status)
)
    ENGINE = ISAM;
