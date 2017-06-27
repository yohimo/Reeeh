<?php
//
if(isset($_GET['Module']))
{  
    $Module = $_GET['Module'];
}else{
    $Module = '';
}

$Users = new user();
function getFile($filename)
{
    if(file_exists($filename))
    {
        require_once($filename);
    }
    else{
        echo '<br>Fichier introuvable : '.$filename;
    }
}



//home page
//var_dump($Module);

$Allowed_modules = array('Subscribe','Logout','Contact','Privacy','Login','Connect','CGV','FPWD','FPWDS');
if(isset($Module) && in_array($Module,$Allowed_modules))
{
    //require_once 'header.php';
    switch($Module)
    {
        case 'Login' :
            getFile('includes/plugins/login.php');
        break;
        case 'Logout' :
            $Users->logout();
        break;
        case 'Subscribe' :
            getFile('includes/plugins/users/subscribe/subscribe.php');
        break;
    }
    die();
}







if(isset($_GET['Module']) && $_GET['Module'] != 'Ajax')
{
    require_once 'public/header/header.php';
    require_once 'public/menu/menu.php';
}else{
    $DIR = $_POST['Dir'];
    $FILE = $_FILES['File'];
    if(!(is_dir($DIR)))
    {
        mkdir($DIR, 0777 , true);
        fopen($DIR.'/index.php', 'w');
    }
    $UPLOAD = new UPLOAD();
    $File = $UPLOAD->EASYUPLOAD($DIR,$FILE);
    echo trim(str_replace('../','',$File));
    die();
}






if(isset($Module) && $Module != '')
{
    $module = strtolower($Module);
    $modules_parrents = array(
        'products'=>array('tags','categories','compatibility','scategories','status','documentation','products','options_group','options'),
        'general'=>array('countries','home','cities','menu','app','languages','colors','menu_position','menu_type','page_category','pages'),
        'users'=>array('collections','deposit','users'),
    );
    foreach($modules_parrents as $mp=>$mpk)
    {
        if(in_array($module,$mpk))
        {
            $parent_folder = $mp;
            break;
        }
    }
    if(isset($_GET['ID']) && $_GET['ID'] != '')
    {
        $Action = $_GET['ID'];
        
        if(!isset($_GET['ID2']))
        {
            getFile('includes/plugins/'.$parent_folder.'/'.strtolower($module).'/data.php');
            Add();
        }
        if(isset($_GET['ID2']))
        {
            $Value = $_GET['ID2'];
            getFile('includes/plugins/'.$parent_folder.'/'.strtolower($module).'/data.php');
            switch($_GET['ID'])
            {
                case 'Edit' : 
                    EDIT($Value);
                    break;
            }
        }
    }else{
        getFile('includes/plugins/'.$parent_folder.'/'.strtolower($module).'/list.php');
    }
}
else{
        getFile('includes/plugins/general/home/list.php');
}

?>