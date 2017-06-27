<?php
$Args = array(
	'Select' => array('id'=>'users.id','email'=>'email','first_name'=>'first_name','last_name'=>'last_name','phone'=>'users.phone'),
	'From' => array('users order by id desc'),
	'Where' => array(),
	'Join' => array(),
	'Module'=> array('Users','Gestion des utilisateurs'),
	'Operations' => array('edit','delete'),
	'THead' => array('ID', 'Email', 'Nom', 'Prénom', 'Téléphone', 'Operations'),
	'Files' => array(),
	'Butons' =>	array(
					array('Ajouter countries','?Module=Countries&Action=Add','add_nw','add button','Ajouter countries','facebox','iconAdd')
				),
	'UPLOADFIELDS' => array()
	);
$Tables = new Tables();
$DATATABLE = $Tables->GET($Args);
?>


