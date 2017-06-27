<?php 


	//you need to create file called defines and put this defined values in it
	define('APP','Reeeh');
	define('DS','/');
	define('WS','http://localhost');
	define('WSDIR','reeeh');
	define('HOME',$_SERVER["DOCUMENT_ROOT"].WS.WSDIR);
	define('Plugins',$_SERVER["DOCUMENT_ROOT"].'/includes/plugins/');
	define('WebSite','http://'.$_SERVER['HTTP_HOST'].DS.WSDIR.DS);
	#Database
	define('DBserver', 'localhost');
	define('DBuser', 'root');
	define('DBpwd', '');
	define('DB', 'reeeh');

	
	//define("DEF_DIR", "");
	require 'classes/db/db.class.php';
    //class de cummon
	require 'classes/commun/commun.class.php';
    //class de cummon
	require 'classes/forms/forms.class.php';
    //class de cummon
	require 'classes/tables/tables.class.php';

	require 'functions/functions.php';
	//class browser for all browsers
	require 'classes/browser/Browser.php';
	// include all CLASSES //
        //passwords class
	require 'classes/users/passwords.class.php';
        //passwords class
	require 'classes/users/users.class.php';
        //class de securite
	require 'classes/security/security.class.php';
        //class de securite
	require 'classes/net/uploads/uploads.class.php';
    //our controller
    require 'controller.php';
        
?>