# phpMyAdmin MySQL-Dump
# version 2.2.0
# http://phpwizard.net/phpMyAdmin/
# http://phpmyadmin.sourceforge.net/ (download page)
#
# ホスト: localhost
# Generation Time: May 22, 2003, 3:35 pm
# Server version: 3.23.43
# PHP Version: 4.1.2
# データベース: `gustav`
# --------------------------------------------------------
#
# テーブルの構造 `gs_bbs`
#
CREATE TABLE gs_bbs (
    ID      INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    REID    INT(10) UNSIGNED NOT NULL DEFAULT '0',
    ICON    VARCHAR(50)      NOT NULL DEFAULT '',
    NAME    VARCHAR(100)     NOT NULL DEFAULT '',
    MAIL    VARCHAR(100)     NOT NULL DEFAULT '',
    HP      VARCHAR(255)              DEFAULT NULL,
    TITLE   VARCHAR(255)              DEFAULT NULL,
    MESS    TEXT             NOT NULL,
    MSF_C   VARCHAR(20)      NOT NULL DEFAULT '000000',
    MRF_C   VARCHAR(20)      NOT NULL DEFAULT 'FFFF99',
    F_NAME  VARCHAR(50)               DEFAULT NULL,
    PASS    VARCHAR(10)               DEFAULT NULL,
    TIME    INT(14) UNSIGNED NOT NULL DEFAULT '0',
    RETIME  INT(14) UNSIGNED NOT NULL DEFAULT '0',
    CHKTIME INT(10) UNSIGNED NOT NULL DEFAULT '0',
    AGENT   VARCHAR(255)              DEFAULT NULL,
    IP      VARCHAR(50)               DEFAULT NULL,
    PRIMARY KEY (ID)
)
    ENGINE = ISAM;
