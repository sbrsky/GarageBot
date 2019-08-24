<?php

/**
 * CONFIG FILE
 * PATHS
 * DB LOGIN (MySQL)
 *
 * for localhost
 *
 */
define ('BASEURL', 'http://localhost/');
define ('DIRSEP', DIRECTORY_SEPARATOR);

$site_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP)  . DIRSEP;
define ('SITE_PATH', $site_path);

$view_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP) . DIRSEP. 'view' . DIRSEP;
define ('VIEW_PATH', $view_path);

$image_path = realpath(dirname(__FILE__) . DIRSEP . '..' . DIRSEP) . DIRSEP. 'photos' . DIRSEP. 'action' . DIRSEP;
define ('IMAGE_PATH', $image_path);

 /*DATABASE LOGIN DETAILS*/
define ('DBHOST', '127.0.0.1');
define ('DBUSER', 'root');
define ('DBPASS', '');
define ('DBNAME', 'bot');
define ('CHARSET', 'utf8mb4');
define ('THUBN', 'th_');
