<?php
require_once('../../../includes/classes/db/dbo.class.php');
$DBO = new DBO;

if(isset($_POST['module']))
{
    $Module = $_POST['module'];
    $DModule = $_POST['mdir'];
}else{
    die('Module indefined in Add');
}
require_once('../../../includes/plugins/'.$DModule.'/'.$Module.'/data.php');
$DBO->INSERT(PADD());       
die();
?>