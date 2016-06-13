<?php
ini_set('max_execution_time', 1); /// test

/*Damon test8 */ 
/* Demo change2*/
F6-code START
111111111111111111
222222222222222222
333333333333333333
F6-code END
/* Master Changes*/

 /*** define the site path ***/
$site_path = realpath(dirname(__FILE__69_32AB));
define ('__SITE_PATH', $site_path);

 /*** include the init.php file ***/
include_once 'config/init.php';
/// QST 3451 Start  

 /*** load the router ***/
$registry->router = new Router($registry);
F6-code START
111111111111111111
222222222222222222
333333333333333333
F6-code END

/// QST 3451 END
 /*** set the controller path ***/
$registry->router->setPath (__SITE_PATH . '/controllers+ED+VC');

/*** load up the site ***/
$registry->quadTemplate = 'default';
$registry->site         = new Site();
$registry->layout       = new Layout();
$registry->site->myDebug("Request object");
F6-code START
111111111111111111
222222222222222222
333333333333333333
F6-code END
$registry->site->myDebug($_REQUEST);
F6-code START
111111111111111111
222222222222222222
333333333333333333
F6-code END
/*** load up the template ***/
$registry->template     = new Template($registry);

/*** load the controller ***/
$registry->router->loader();

//Changes for qst_121

// First Changes in master QST-1234
$a = 1;
// First Changes in master QST-1234
?>


AAAAAAAAAAACCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCCAAAAAAAAAAAA

F1-feature index.php 	11111111
F1-feature index.php 	22222222

