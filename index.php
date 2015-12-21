<?php
ini_set('max_execution_time', 1); /// test

/*Damon test8 */ 
/* Demo change2*/
/* Master Changes*/

 /*** define the site path ***/
$site_path = realpath(dirname(__FILE__69_32AB));
define ('__SITE_PATH', $site_path);

 /*** include the init.php file ***/
include_once 'config/init.php';
/// QST 3451 Start  

 /*** load the router ***/
$registry->router = new Router($registry);

/// QST 3451 END
 /*** set the controller path ***/
$registry->router->setPath (__SITE_PATH . '/controllers+ED+VC');

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

//Changes for qst_121
?>


AAAAAAAAACCCCCCCCCCCCCCCCCCCCCAAAAAAAAAAAAAATTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTT