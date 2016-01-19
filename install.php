<?php
ini_set('display_errors',111111);
error_reporting(E_ALL^E_NOTICE);
session_start();

//Changes as per qst_1278 Start :: 1

//Changes as per qst_1278 End   :: 1

$webroot = 'http://'.$_SERVER['HTTP_HOST'].'/'.dirname($_SERVER['SCRIPT_NAME']).'/';
$sysOS = stristr(PHP_OS, 'WIN') ? 'win' : 'linux';

$db_host     = 'localhost';
$db_user     = 'root';
$db_pass     = '';
mysql_connect($db_host,$db_user,$db_pass);

// Download URL array
$arrDwnLib['curl']['win'] 	= "<a href='http://curl.haxx.se/download.html' target='_blank' >Click here to Download or install library</a>";
$arrDwnLib['curl']['linux'] 	= '<a href="http://curl.haxx.se/download.html" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['gd']['win']		= '<a href="http://www.libgd.org/releases/" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['gd']['linux']	= '<a href="http://www.libgd.org/releases/" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['mbstring']['win']	= '<a href="http://www.php.net/manual/en/mbstring.installation.php" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['mbstring']['linux']	= '<a href="http://www.php.net/manual/en/mbstring.installation.php" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['mysql']['win'] 	= '<a href="http://dev.mysql.com/downloads/mysql/" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['mysql']['linux'] 	= '<a href="http://dev.mysql.com/downloads/mysql/" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['mysqli']['win'] 	= '<a href="http://php.net/manual/en/mysqli.installation.php" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['mysqli']['linux'] 	= '<a href="http://php.net/manual/en/mysqli.installation.php" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['zip']['win'] 	= '<a href="http://php.net/manual/en/zip.installation.php" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['zip']['linux'] 	= '<a href="http://php.net/manual/en/zip.installation.php" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['xsl']['win'] 	= '<a href="http://www.php.net/manual/en/xsl.installation.php" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['xsl']['linux'] 	= '<a href="http://www.php.net/manual/en/xsl.installation.php" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['apc']['win'] 	= '<a href="http://downloads.php.net/pierre/" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['apc']['linux'] 	= '<a href="http://pecl.php.net/package/APC/download/" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['openssl']['win'] 	= '<a href="http://www.openssl.org/related/binaries.html" target="_blank" >Click here to Download or install library</a>';
$arrDwnLib['openssl']['linux'] 	= '<a href="http://www.openssl.org/source/" target="_blank" >Click here to Download or install library</a>';





if($_GET['msg'] == 'success' && $_SESSION['step'] < 5)
{
    header('Location:install.php?step='.$_SESSION['step']);
}
elseif(empty($_SESSION))
{
    header('Location:install.php?step=1');
}

function write($filename,$content)
{
    /*$fp = fopen($filename,'w');
    fwrite($fp,$content);
    fclose($fp);*/
}

function disbale()
{
    global $flag;
    $flag   = 1;

    return 'disabled';
}

$step               = ($_GET['step'] > 1)?$_GET['step']:1;
$dberrmsg           = '';
$uploadfileerror    = '';

if($_SESSION['step'] < 1) { $_SESSION['step'] = 1; }

if($_SESSION['step'] < $step && empty($_POST))
{
    header('Location:install.php?step='.$_SESSION['step']);
}

if($step == 1)
{
    $phpversion     = phpversion();
    $mysqlversion   = mysql_get_server_info();
    $apacheversion  = apache_get_version();
}

if($step == 2)
{
    $flag       = 0;
    $extensions = get_loaded_extensions();

    $curl       = !in_array('curl',$extensions)?disbale():'enabled';
    $gd         = !in_array('gd',$extensions)?disbale():'enabled';
    $mbstring   = !in_array('mbstring',$extensions)?disbale():'enabled';
    $mysql      = !in_array('mysql',$extensions)?disbale():'enabled';
    $mysqli     = !in_array('mysqli',$extensions)?disbale():'enabled';
    $xsl        = !in_array('xsl',$extensions)?disbale():'enabled';
    $zip        = !in_array('zip',$extensions)?disbale():'enabled';
    $apc        = !in_array('apc',$extensions)?disbale():'enabled';
    $openssl    = !in_array('openssl',$extensions)?disbale():'enabled';

    $apache_modules = apache_get_modules();

    $rewrite    = !in_array('mod_rewrite',$apache_modules)?disbale():'enabled';
    $deflate    = !in_array('mod_deflate',$apache_modules)?disbale():'enabled';
    $dir        = !in_array('mod_dir',$apache_modules)?disbale():'enabled';
    $env        = !in_array('mod_env',$apache_modules)?disbale():'enabled';
    $expires    = !in_array('mod_expires',$apache_modules)?disbale():'enabled';
    $headers    = !in_array('mod_headers',$apache_modules)?disbale():'enabled';
    //$isapi      = !in_array('mod_isapi',$apache_modules)?disbale():'enabled';
    $php5       = !in_array('mod_php5',$apache_modules)?disbale():'enabled';

    $_SESSION['step']   = 2;
}

if($step == 4)
{
    $dbhost     = $_POST['dbhost'];
    $dbuser     = $_POST['dbuser'];
    $dbpass     = $_POST['dbpass'];
    $quaddb     = $_POST['dbquad'];
    $quadplusdb = $_POST['dbquadplus'];
    $console    = $_POST['console'];
    $piwik      = $_POST['piwik'];
    $debug      = $_POST['debug'];
    $exectime   = $_POST['exectime'];
    $cache      = $_POST['cache'];

    mysql_connect($dbhost,$dbuser,$dbpass);
    if(mysql_error() != '')
    {
        $dberrmsg = 'Unable to connect to database with given specifications';
    }

    mysql_select_db($quaddb);
    if(mysql_error() != '' && $dberrmsg == '')
    {
        $dberrmsg = 'Unable to select Quad database';
    }

//    mysql_select_db($quadplusdb);
//    if(mysql_error() != '' && $dberrmsg == '')
//    {
//        $dberrmsg = 'Unable to select Quad Plus database';
//    }

    if(mysql_get_server_info() < 5.0 && $dberrmsg == '')
    {
        $dberrmsg = 'Mysql Version should be greater than or equal to 5.0';
    }

    if($dberrmsg == '')
    {
        $base_dir   = dirname($_SERVER['SCRIPT_NAME']).'/';

        $content    = file_get_contents('.htaccesssample');
        $content    = str_replace('#DIRPATH#',$base_dir,$content);

        write('.htaccess',$content);

        $os         = (strstr(PHP_OS,'WIN')?'WIN':PHP_OS);

        $search     = array('#PROJECT#','#QUADPLUSDB#','#QUADDB#','#DBUSER#','#DBPASS#','#DBHOST#','#OS#',"'#CONSOLE#'","'#PIWIK#'","'#DEBUG#'","'#EXECUTETIME#'","'#CACHE#'");
        $replace    = array(trim($base_dir,'/'),$quadplusdb,$quaddb,$dbuser,$dbpass,$dbhost,$os,$console,$piwik,$debug,$exectime,$cache);

        $content    = file_get_contents('config/setup/samplesite.php');
        $content    = str_replace($search,$replace,$content);

        write('config/setup/site.php',$content);

        $content    = file_get_contents('webservice/.samplehtaccess');
        $content    = str_replace('#DIRPATH#',$base_dir.'webservice/',$content);

        write('webservice/.htaccess',$content);

        $search     = array('#PROJECT#','#QUADPLUSDB#','#QUADDB#','#DBUSER#','#DBPASS#','#DBHOST#');
        $replace    = array(trim($base_dir,'/'),$quadplusdb,$quaddb,$dbuser,$dbpass,$dbhost);

        $content    = file_get_contents('webservice/config/sampleconfig.php');
        $content    = str_replace($search,$replace,$content);

        write('webservice/config/config.php',$content);

        $search     = array('#PROJECT#');
        $replace    = array(trim($base_dir,'/'));

        $content    = file_get_contents('plugins/socialapps/sampleconfig.php');
        $content    = str_replace($search,$replace,$content);

        write('plugins/socialapps/config.php',$content);

        $_SESSION['step']   = 4;
        
       // header('Location:install.php?msg=success');
    }
}

if($step == 5)
{
   /* if($_FILES['fileupload']['size'] != 1112064)
    {
        $uploadfileerror    = 'Please upload valid dot file';
        $step = 4;
    }
    else*/
    {
        //move_uploaded_file($_FILES['fileupload']['tmp_name'], 'WAT_QUAD_03_v5.dot');
         $_SESSION['step']   = 5;
        header('Location:install.php?msg=success');
    }
}
?>
<html>
<head>
    <style>
        body{font-family:verdana,tahoma,arial;}
        .active{background:#c0c0c0;}
        .done{background:#EBF9D2;}
        a{text-decoration: none;}
        table{margin-top:10px;}
        th.border, td.border{border:1px solid #cccccc;font-size:12px;padding:5px;}
        td.instructions ul {margin:15px;padding:0px;}
        div.failure{background-color:#FFB3B5;font-size:15px;height:20px;padding:5px;margin-top:10px;}
        div.success{background-color:#EBF9D2;font-size:15px;height:20px;padding:5px;margin-top:10px;}
        .note{color:#ff0000;font-size:12px;}
        .instructions{font-size:12px;}
        .install_label{text-align:left;font-size:20px;margin-top:10px;}
        .button {background-color:#3399CC;border:1px solid #3399CC;color:#FFFFFF;font-family:Tahoma,Helvetica;font-size:12px;font-weight:bold;margin-left:3px;padding:2px;width:auto;}
    </style>
    <!--script type="text/javascript" src="http://java.com/js/deployJava.js"></script>-->
        

</head>
<body>
    <table cellpadding='0' cellspacing='0' border='0' align='center' width="990">
        <tr>
            <td align="left"><div class='install_label'>
    <img class="pngfixicon" id="institutelogoimage" src="<?php echo $webroot; ?>assets/renditions/html/templates/welcome/images/Quad_64.png" alt="">
    Quad Installation</div></td>
        </tr>
    </table>

    <?php if($_GET['msg'] == 'success') { session_destroy(); ?>
    <table cellpadding='0' cellspacing='0' border='0' align='center' width="990">
    <tr>
        <td width='200' class='border done'>Step 1: Version Check</td>
        <td width='200' class='border done'>Step 2: Extension Check</td>
        <td width='200' class='border done'>Step 3: QuAD Configuration</td>
        <td width='200' class='border done'>Step 4: Word Template</td>
        <td width='190' class='border active'>Step 5:Summary</td>
    </tr>
</table>
    <table cellpadding='0' cellspacing='0' border='0' align='center' width="990">
    <tr>
        <td><div class='success' style='height:50px;'>Your installation has been successfully completed.
            <br/> <br/> <a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/quad">Click Here to go to QuAD</a></div></td>
    </tr>
</table>
<?php } elseif($dberrmsg != '') { $_SESSION['step'] = 3;?>
    <div class='failure'><?php echo $dberrmsg; ?></div>
    <div style='margin-top:5px;'><a href='install.php?step=3'><input type='button' name='back' value='Back'></a></div>
<?php } elseif($step == 1) { ?>
<form name='step1' action='?step=2' method='post'>
<table cellpadding='0' cellspacing='0' border='0' align='center' width="990">
    <tr>
        <td width='200' class='border active'>Step 1: Version Check</td>
        <td width='200' class='border'>Step 2: Extension Check</td>
        <td width='200' class='border'>Step 3: QuAD Configuration</td>
        <td width='200' class='border'>Step 4: Word Template</td>
        <td width='190' class='border'>Step 5:Summary</td>
    </tr>
</table>    
<table cellpadding='0' cellspacing='0' border='0' align='center' width="990">
    <tr>
        <?php if($phpversion < '5.2.0') { ?>
        <td class='border'>PHP Version should be greater than or equal to 5.2 </td>
        <?php } else { ?>
        <td width='200' class='border'>PHP Version</td>
        <td width='250' class='border'><?php echo $phpversion; ?>&nbsp;&nbsp;<a href="http://<?php echo $_SERVER['HTTP_HOST']; ?>/phpinfo.php">[phpinfo]</a></td>
        <?php } ?>
    </tr>
    <tr>
        <?php if($mysqlversion < '5') { ?>
        <td class='border'>Mysql Version should be greater than or equal to 5 </td>
        <?php } else { ?>
        <td width='200' class='border'>Mysql Version</td>
        <td width='250' class='border'><?php echo $mysqlversion; ?></td>
        <?php } ?>
    </tr>
    <tr>       
        <td width='200' class='border'>Apache Version</td>
        <td width='250' class='border'><?php echo $apacheversion; ?></td>
    </tr>
    <tr>
        <td width='200' class='border'>Java</td>
        <td width='250' class='border'><span id="java"></span><div id="java_dwn" style="display:none"><a href="http://www.java.com/en/download/manual.jsp" target="_blank" >Click here to Download</a></div></td>
    </tr>
    <?php if((!stristr(PHP_OS, 'WIN'))) { ?>
    <tr>
        <td width='200' class='border'>Ffmpeg</td>
        <td width='250' class='border'>enabled</td>
    </tr>
    <?php } ?>
    <?php if($phpversion >= '5.2.0' && $mysqlversion >= '5') { ?>
    <tr><td colspan='2' height='5'>&nbsp;</td></tr>
    <tr>
        <td colspan='2' align='right'><input type='submit' name='next'  id='first_next' value='Next'></td>
    </tr>
    <?php } ?>
</table>
</form>
<?php } elseif($step == 2) { ?>
<form name='step2' action='?step=3' method='post'>
    <table cellpadding='0' cellspacing='0' border='0' align='center' width="990">
    <tr>
        <td width='200' class='border done'>Step 1: Version Check</td>
        <td width='200' class='border active'>Step 2: Extension Check</td>
        <td width='200' class='border'>Step 3: QuAD Configuration</td>
        <td width='200' class='border'>Step 4: Word Template</td>
        <td width='190' class='border'>Step 5:Summary</td>
    </tr>
</table>
<?php
$extLibCount = 1;
$apacheExtCount = 1;
?>
<table cellpadding='0' cellspacing='0' border='0' align='center' width='990'>
    <tr>
        <td align='left' colspan='6' class='note'>* Please make sure that all the below mentioned php extensions and apache modules are enabled.</td>
    </tr>
    <tr><td colspan='6' height='5'>&nbsp;</td></tr>
    <tr>
        <th align='left' colspan='6'>PHP Extensions</th>
    </tr>
    <tr><td colspan='6' height='5'>&nbsp;</td></tr>
    <tr>
        <th width="40" class="border" style="text-align: left; padding-bottom:5px;">Sr. No.</th>
        <th width='100' class='border' style="text-align: left; padding-bottom:5px;">Extension</th>
        <th width='150' class='border' style="text-align: left; padding-bottom:5px;">Extension Name</th>
        <th width='150' class='border' style="text-align: left; padding-bottom:5px;">Recommended</th>
        <th width='150' class='border' style="text-align: left; padding-bottom:5px;">Current</th>
        <th width='400' class='border' style="text-align: left; padding-bottom:5px;">Reference</th>
    </tr>
    <tr>
        <td width="40" class='border'><?php echo $extLibCount++; ?></td>
        <td width='100' class='border'>Curl</td>
        <td width='150' class='border'><?php echo (!stristr(PHP_OS, 'WIN'))?'php_curl.so':'php_curl.dll'; ?></td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $curl; ?></td>
        <td width='400' class='border'><?php echo ($curl == 'disabled') ? $arrDwnLib['curl'][$sysOS] : '&nbsp;'; ?></td>
    </tr>
    <tr>
        <td width="40" class='border'><?php echo $extLibCount++; ?></td>
        <td width='100' class='border'>GD</td>
        <td width='150' class='border'><?php echo (!stristr(PHP_OS, 'WIN'))?'php_gd2.so':'php_gd2.dll'; ?></td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $gd; ?></td>
        <td width='400' class='border'><?php echo ($gd == 'disabled') ? $arrDwnLib['gd'][$sysOS] : '&nbsp;'; ?></td>
    </tr>
    <tr>
        <td width="40" class='border'><?php echo $extLibCount++; ?></td>
        <td width='100' class='border'>MbString</td>
        <td width='150' class='border'><?php echo (!stristr(PHP_OS, 'WIN'))?'php_mbstring.so':'php_mbstring.dll'; ?></td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $mbstring; ?></td>
        <td width='400' class='border'><?php echo ($mbstring == 'disabled') ? $arrDwnLib['mbstring'][$sysOS] : '&nbsp;'; ?></td>
    </tr>
    <tr>
        <td width="40" class='border'><?php echo $extLibCount++; ?></td>
        <td width='100' class='border'>Mysql</td>
        <td width='150' class='border'><?php echo (!stristr(PHP_OS, 'WIN'))?'php_mysql.so':'php_mysql.dll'; ?></td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $mysql; ?></td>
        <td width='400' class='border'><?php echo ($mysql == 'disabled') ? $arrDwnLib['mysql'][$sysOS] : '&nbsp;'; ?></td>
    </tr>
    <tr>
        <td width="40" class='border'><?php echo $extLibCount++; ?></td>
        <td width='100' class='border'>Mysqli</td>
        <td width='150' class='border'><?php echo (!stristr(PHP_OS, 'WIN'))?'php_mysqli.so':'php_mysqli.dll'; ?></td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $mysqli; ?></td>
        <td width='400' class='border'><?php echo ($mysqli == 'disabled') ? $arrDwnLib['mysqli'][$sysOS] : '&nbsp;'; ?></td>
    </tr>
    <tr>
        <td width="40" class='border'><?php echo $extLibCount++; ?></td>
        <td width='100' class='border'>XSL</td>
        <td width='150' class='border'><?php echo (!stristr(PHP_OS, 'WIN'))?'xsl.so':'php_xsl.dll'; ?></td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $xsl; ?></td>
        <td width='400' class='border'><?php echo ($xsl == 'disabled') ? $arrDwnLib['xsl'][$sysOS] : '&nbsp;'; ?></td>
    </tr>
    <tr>
        <td width="40" class='border'><?php echo $extLibCount++; ?></td>
        <td width='100' class='border'>ZIP</td>
        <td width='150' class='border'><?php echo (!stristr(PHP_OS, 'WIN'))?'zip.so':'php_zip.dll'; ?></td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $zip; ?></td>
        <td width='400' class='border'><?php echo ($zip == 'disabled') ? $arrDwnLib['zip'][$sysOS] : '&nbsp;'; ?></td>
    </tr>
     <tr>
        <td width="40" class='border'><?php echo $extLibCount++; ?></td>
        <td width='100' class='border'>APC</td>
        <td width='150' class='border'><?php echo (!stristr(PHP_OS, 'WIN'))?'apc.so':'php_apc.dll'; ?></td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $apc; ?></td>
        <td width='400' class='border'><?php echo ($apc == 'disabled') ? $arrDwnLib['apc'][$sysOS] : '&nbsp;'; ?></td>
    </tr>
     <tr>
        <td width="40" class='border'><?php echo $extLibCount++; ?></td>
        <td width='100' class='border'>OpenSSL</td>
        <td width='150' class='border'><?php echo (!stristr(PHP_OS, 'WIN'))?'openssl.so':'php_openssl.dll'; ?></td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $openssl; ?></td>
        <td width='400' class='border'><?php echo ($openssl == 'disabled') ? $arrDwnLib['openssl'][$sysOS] : '&nbsp;'; ?></td>
    </tr>
    <tr><td colspan='6' height='5'>&nbsp;</td></tr>
    <tr><td colspan='6' height='5'>&nbsp;</td></tr>
    <tr>
        <th align='left' colspan='6'>Apache Modules</th>
    </tr>
    <tr><td colspan='6' height='5'>&nbsp;</td></tr>
    <tr>
        <th width="40" class="border" style="text-align: left; padding-bottom:5px;">Sr. No.</th>
        <th width='100' class='border' style="text-align: left; padding-bottom:5px;">Module</th>
        <th width='150' class='border' style="text-align: left; padding-bottom:5px;">Module Name</th>
        <th width='150' class='border' style="text-align: left; padding-bottom:5px;">Recommended</th>
        <th width='150' class='border' style="text-align: left; padding-bottom:5px;">Current</th>
        <th width='400' class='border' style="text-align: left; padding-bottom:5px;">Reference</th>
    </tr>
    <tr>
        <td width="40" class='border'><?php echo $apacheExtCount++; ?></td>
        <td width='100' class='border'>Rewrite</td>
        <td width='150' class='border'>mod_rewrite.so</td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $rewrite; ?></td>
        <td width='400' class='border'>&nbsp;</td>
    </tr>
    <tr>
        <td width="40" class='border'><?php echo $apacheExtCount++; ?></td>
        <td width='100' class='border'>Deflate</td>
        <td width='150' class='border'>mod_deflate.so</td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $deflate; ?></td>
        <td width='400' class='border'>&nbsp;</td>
    </tr>
    <tr>
        <td width="40" class='border'><?php echo $apacheExtCount++; ?></td>
        <td width='100' class='border'>Dir</td>
        <td width='150' class='border'>mod_dir.so</td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $dir; ?></td>
        <td width='400' class='border'>&nbsp;</td>
    </tr>
    <tr>
        <td width="40" class='border'><?php echo $apacheExtCount++; ?></td>
        <td width='100' class='border'>Env</td>
        <td width='150' class='border'>mod_env.so</td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $env; ?></td>
        <td width='400' class='border'>&nbsp;</td>
    </tr>
    <tr>
        <td width="40" class='border'><?php echo $apacheExtCount++; ?></td>
        <td width='100' class='border'>Expires</td>
        <td width='150' class='border'>mod_expires.so</td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $expires; ?></td>
        <td width='400' class='border'>&nbsp;</td>
    </tr>
    <tr>
        <td width="40" class='border'><?php echo $apacheExtCount++; ?></td>
        <td width='100' class='border'>Headers</td>
        <td width='150' class='border'>mod_headers.so</td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $headers; ?></td>
        <td width='400' class='border'>&nbsp;</td>
    </tr>
    <!--<tr>
        <td width='200' class='border'>Isapi</td>
        <td width='250' class='border'><?php echo $isapi; ?></td>
    </tr>-->
    <tr>
        <td width="40" class='border'><?php echo $apacheExtCount++; ?></td>
        <td width='100' class='border' >Php5</td>
        <td width='150' class='border'>php5_module</td>
        <td width='150' class='border'>enabled</td>
        <td width='150' class='border'><?php echo $php5; ?></td>
        <td width='400' class='border'>&nbsp;</td>
    </tr>
    <?php if($flag == 0) { ?>
    <tr><td colspan='6' height='5'>&nbsp;</td></tr>
    <tr>
        <td align='left' colspan="5"><a href='install.php?step=1'><input type='button' name='back' value='Back'></a></td>
        <td align='right'><input type='submit' name='next' value='Next'></td>
    </tr>
    <?php } ?>
</table>
</form>
<?php } elseif($step == 3) { ?>
<form name='step3' action='?step=4' method='post'>
    <table cellpadding='0' cellspacing='0' border='0' align='center' width="990">
    <tr>
        <td width='200' class='border done'>Step 1: Version Check</td>
        <td width='200' class='border done'>Step 2: Extension Check</td>
        <td width='200' class='border active'>Step 3: QuAD Configuration</td>
        <td width='200' class='border'>Step 4: Word Template</td>
        <td width='190' class='border'>Step 5:Summary</td>
    </tr>
</table>
<table cellpadding='0' cellspacing='0' border='0' align='center' width="990">
    <tr>
        <th align='left' colspan='2'>Database Details</th>
    </tr>
    <tr><td colspan='2' height='5'>&nbsp;</td></tr>
    <tr>
        <td width='200' class='border'>Host Name</td>
        <td width='250' class='border'><input type='text' name='dbhost' id='dbhost' value=''></td>
    </tr>
    <tr>
        <td width='200' class='border'>User Name</td>
        <td width='250' class='border'><input type='text' name='dbuser' id='dbuser' value=''></td>
    </tr>
    <tr>
        <td width='200' class='border'>Password</td>
        <td width='250' class='border'><input type='password' name='dbpass' id='dbpass' value=''></td>
    </tr>
    <tr>
        <td width='200' class='border'>Quad DB Name</td>
        <td width='250' class='border'><input type='text' name='dbquad' id='dbquad' value=''></td>
    </tr>
    <tr><td colspan='2' height='2'>&nbsp;</td></tr>
    <tr>
        <td colspan="2"><input type="button" value="Test Connection" /></td>
    </tr>
    <!--<tr>
        <td width='200' class='border'>Quad Plus DB Name</td>
        <td width='250' class='border'><input type='text' name='dbquadplus' id='dbquadplus' value=''></td>
    </tr>-->
    <tr><td colspan='2' height='5'>&nbsp;</td></tr>
    <tr>
        <th align='left' colspan='2'>Settings</th>
    </tr>
    <tr><td colspan='2' height='5'>&nbsp;</td></tr>
    <tr>
        <td width='200' class='border'>Firebug Console</td>
        <td width='250' class='border'><input type='radio' name='console' value='true' checked>&nbsp;enable&nbsp;<input type='radio' name='console' value='false'>&nbsp;disable</td>
    </tr>
    <!--<tr>
        <td width='200' class='border'>Piwik</td>
        <td width='250' class='border'><input type='radio' name='piwik' value='true'>&nbsp;enable&nbsp;<input type='radio' name='piwik' value='false' checked>&nbsp;disable</td>
    </tr>-->
    <tr>
        <td width='200' class='border'>Application Debug</td>
        <td width='250' class='border'><input type='radio' name='debug' value='true' checked>&nbsp;enable&nbsp;<input type='radio' name='debug' value='false'>&nbsp;disable</td>
    </tr>
    <!--<tr>
        <td width='200' class='border'>Show Execution Time</td>
        <td width='250' class='border'><input type='radio' name='exectime' value='true'>&nbsp;enable&nbsp;<input type='radio' name='exectime' value='false' checked>&nbsp;disable</td>
    </tr>-->
    <tr>
        <td width='200' class='border'>Cache</td>
        <td width='250' class='border'><input type='radio' name='cache' value='true' checked>&nbsp;enable&nbsp;<input type='radio' name='cache' value='false'>&nbsp;disable</td>
    </tr>
    <tr>
        <td width='200' class='border'>Navigation Log</td>
        <td width='250' class='border'><input type='radio' name='navigationLog' value='true' checked>&nbsp;enable&nbsp;<input type='radio' name='navigationLog' value='false'>&nbsp;disable</td>
    </tr>
    <tr>
        <td width='200' class='border'>DB Query Time (Normal Slow)</td>
        <td width='250' class='border'><input type="text" name="normalSlow" value="0.2">&nbsp;seconds</td>
    </tr>
    <tr>
        <td width='200' class='border'>DB Query Time (Medium Slow)</td>
        <td width='250' class='border'><input type="text" name="mediumSlow" value="1">&nbsp;seconds</td>
    </tr>
    <tr>
        <td width='200' class='border'>DB Query Time (Extreme Slow)</td>
        <td width='250' class='border'><input type="text" name="extremeSlow" value="2">&nbsp;seconds</td>
    </tr>
    <tr><td colspan='2' height='5'>&nbsp;</td></tr>
    <tr>
        <td align='left'><a href='install.php?step=2'><input type='button' name='back' value='Back'></a></td>
        <td align='right'><input type='submit' name='next' value='Next'></td>
    </tr>
</table>
</form>
<?php } elseif($step == 4) { ?>
<?php if($uploadfileerror != '') { ?>
<div class='failure'><?php echo $uploadfileerror; ?></div>
<?php } ?>
<table cellpadding='0' cellspacing='0' border='0' align='center' width="990">
    <tr>
        <td width='200' class='border done'>Step 1: Version Check</td>
        <td width='200' class='border done'>Step 2: Extension Check</td>
        <td width='200' class='border done'>Step 3: QuAD Configuration</td>
        <td width='200' class='border active'>Step 4: Word Template</td>
        <td width='190' class='border'>Step 5:Summary</td>
    </tr>
</table>
<table cellpadding='0' cellspacing='0' border='0' align='center' width="990">
    <tr>
        <th align='left' colspan='2'>Offline Template</th>
    </tr>
    <tr><td colspan='2' height='5'>&nbsp;</td></tr>
    <tr>
        <td align='left' colspan='2' class='instructions'>
        * Please download the offline template. After downloading, follow below procedure.
        <ul>
            <li>Right click on it</li>
            <li>Click on properties</li>
            <li>Click on Custom Tab</li>
            <li>Click on Location</li>
            <li>Put <i><u><?php echo $webroot.'authoring/';?></u></i> in Value field textbox</li>
            <li>Click on OK</li>
            <li>Upload same file after doing all these changes</li>
        </ul>
        </td>
    </tr>
    <tr><td colspan='2' height='5'>&nbsp;</td></tr>
    <tr>
        <td width='100' colspan='2'><div id='download'><a href="<?php echo $webroot; ?>WAT_QUAD_03_v5_sample.dot">Download</a></div></td>
    </tr>
    <tr><td colspan='2' height='5'>&nbsp;</td></tr>
    <tr>
        <td colspan='2'>
            <div id='upload'>
                Upload
            </div>
            <div id='showupload'>
                <form name='step4' action='?step=5' method='post' enctype='multipart/form-data' onsubmit='return validateUploadFile()'>
                    <input type='file' name='fileupload' id='fileupload' value=''>
                    <input type='submit' name='upload' value='Upload'>
                </form>
            </div>
        </td>
    </tr>
    <tr>
        <td align='left' colspan='2'><a href='install.php?step=3'><input type='button' name='back' value='Back'></a></td>
    </tr>
</table>

<?php } ?>
<?php 

//Changes as per qst_1278 Start :: 2

//Changes as per qst_1278 End :: 2
?>
</body>
<script type='text/javascript'>
function validateUploadFile()
{
    var str = document.getElementById('fileupload').value;
    var ext = str.substr(str.lastIndexOf('.')+1,str.length);

    if(ext != 'dot')
    {
        alert('Please upload sample dot file only.');
        return false;
    }
    else
    {
        return true;
    }
}

if( navigator.javaEnabled() == true)
{
    if(document.getElementById('java') != null)
    {
        document.getElementById('java').innerHTML = 'enabled';
    }
}
else
{
    if(document.getElementById('java') != null)
    {
        document.getElementById('java').innerHTML = 'disabled';
        document.getElementById('first_next').style.display = 'none';
        //document.getElementById('java_dwn').style.display = 'block';
    }
}
</script>
</html>
<?php


?>