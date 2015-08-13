<?php
ini_set('max_execution_time', 1);

/*Damon test8 */ 
/* Demo change2*/
/* Master Changes*/

 /*** define the site path ***/
$site_path = realpath(dirname(__FILE__));
define ('__SITE_PATH', $site_path);

 /*** include the init.php file ***/
include_once 'config/init.php';


 /*** load the router ***/
$registry->router = new Router($registry);

 /*** set the controller path ***/
$registry->router->setPath (__SITE_PATH . '/controllers');

/*** load up the site ***/
$registry->quadTemplate = 'default';
$registry->site         = new Site();
$registry->layout       = new Layout();
$registry->site->myDebug("Request object");
$registry->site->myDebug($_REQUEST);
/*** load up the template ***/
$registry->template     = new Template($registry);

/*** load the controller ***/
$registry->router->loader();
?>
