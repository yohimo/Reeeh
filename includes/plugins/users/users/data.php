


<?php
//Countries
function Add()
{
        $user=new FORMS();

        $form = array(   
                    array('users'),
                    array('HIDDEN','module','50','module','module','Users'),
                    array('HIDDEN','redirect','50','redirect','redirect','users'),
                    array('HIDDEN','mdir','50','mdir','mdir','users'),
                    array('DIVSTART','','form-horizontal'),


                        array('DIVSTART','','form-group'),
                            array('LABEL','First name :'/*Text*/,'col-sm-2 control-label'/*class*/,''/*ID*/),
                            array('DIVSTART','','col-sm-8'),
                                array('TEXT','first_name','form-control','form-control','first_name','value','','first_name'),
                            array('DIVEND'),
                        array('DIVEND'),

                        array('DIVSTART','','form-group'),
                            array('LABEL','Last name :'/*Text*/,'col-sm-2 control-label'/*class*/,''/*ID*/),
                            array('DIVSTART','','col-sm-8'),
                                array('TEXT','last_name','form-control','form-control','last_name','value','','last_name'),
                            array('DIVEND'),
                        array('DIVEND'),

                        array('DIVSTART','','form-group'),
                            array('LABEL','Password :'/*Text*/,'col-sm-2 control-label'/*class*/,''/*ID*/),
                            array('DIVSTART','','col-sm-8'),
                                array('PASSWORD','password','form-control','form-control','password','value','','password'),
                            array('DIVEND'),
                        array('DIVEND'),

                        array('DIVSTART','','form-group'),
                            array('LABEL','Email :'/*Text*/,'col-sm-2 control-label'/*class*/,''/*ID*/),
                            array('DIVSTART','','col-sm-8'),
                                array('TEXT','email','form-control','form-control','email','value','','email'),
                            array('DIVEND'),
                        array('DIVEND'),

                        array('DIVSTART','','form-group'),
                            array('LABEL','Phone :'/*Text*/,'col-sm-2 control-label'/*class*/,''/*ID*/),
                            array('DIVSTART','','col-sm-8'),
                                array('TEXT','phone','form-control','form-control','phone','value','','phone'),
                            array('DIVEND'),
                        array('DIVEND'),




                        array('DIVSTART','','form-group'),
                            array('LABEL','Description :'/*Text*/,'col-sm-2 control-label'/*class*/,''/*ID*/),
                            array('DIVSTART','','col-sm-8'),
                                array('TEXTAREA','description','4','form-control','description',''),
                            array('DIVEND'),
                        array('DIVEND'),






      

                        array('DIVSTART','','form-group'),
                            array('DIVSTART','','col-sm-offset-2 col-sm-5'),
                                array('BUTTON','Ajouter','send','btn btn-default','send'),
                                array('CBUTTON','Fermer','close',"btn btn-default","close","$('#facebox').fadeOut();$('#overlay').fadeOut();"),
                            array('DIVEND'),
                            
                        array('DIVEND'),
                        
                    array('DIVEND'),



            
        );
    $user->Draw($form);
}


    function PADD()
    {

      $Post = array(
                array('users'),
                array('first_name','first_name','text','45','text'),
                array('last_name','last_name','text','45','text'),
                array('password','password','password','45','password'),
                array('email','email','email','','email'),
                array('phone','phone','number','20','number'),
                array('description','description','text','250','text')

            );

        return $Post;
    }




function EDIT($ID)
{				

    $tags = new FORMS();
    $form=array(
    array('users'/*table*/,'id'/*id table*/,$ID),
	array('HIDDEN','test','test',50,'module','module','users'),
	array('HIDDEN','test','test',50,'mdir','mdir','users'),
   
    array('DIVSTART'/*first div*/,''/*class*/,'form-horizontal'/*id*/),
    //name
        //name
    array('DIVSTART','','form-group'),
        array('LABEL',' Last name :'/*Text*/,'col-sm-2 control-label'/*class*/,''/*ID*/),
        array('DIVSTART','','col-sm-8'),

            array('TEXT','first_name'/*name field*/,'first_name'/*name post*/,'40'/*size post*/,'form-control'/*class*/,'first_name'/*id*/),
        array('DIVEND'),
    array('DIVEND'),

    array('DIVSTART','','form-group'),
        array('LABEL',' First name :'/*Text*/,'col-sm-2 control-label'/*class*/,''/*ID*/),
        array('DIVSTART','','col-sm-8'),

            array('TEXT','last_name'/*name field*/,'last_name'/*name post*/,'40'/*size post*/,'form-control'/*class*/,'last_name'/*id*/),
        array('DIVEND'),
    array('DIVEND'),

    array('DIVSTART','','form-group'),
        array('LABEL',' User email :'/*Text*/,'col-sm-2 control-label'/*class*/,''/*ID*/),
        array('DIVSTART','','col-sm-8'),

            array('TEXT','email'/*name field*/,'email'/*name post*/,'40'/*size post*/,'form-control'/*class*/,'email'/*id*/),
        array('DIVEND'),
    array('DIVEND'),




    array('DIVSTART','','form-group'),
        array('LABEL',' User phone :'/*Text*/,'col-sm-2 control-label'/*class*/,''/*ID*/),
        array('DIVSTART','','col-sm-8'),

            array('TEXT','phone'/*name field*/,'phone'/*name post*/,'40'/*size post*/,'form-control'/*class*/,'phone'/*id*/),
        array('DIVEND'),
    array('DIVEND'),



    array('DIVSTART','','form-group'),
        array('LABEL','Description :'/*Text*/,'col-sm-2 control-label'/*class*/,''/*ID*/),
            array('DIVSTART','','col-sm-8'),
                array('TEXTAREA','description','description','4','form-control','description',''),
            array('DIVEND'),
    array('DIVEND'),


    //Bottons*/

        array('DIVSTART','','form-group'),
            array('DIVSTART','','col-sm-offset-2 col-sm-5'),
                array('BUTTON','Modifier','send','btn btn-default','send'),
                array('CBUTTON','Fermer','close',"btn btn-default","close","$('#facebox').fadeOut();$('#overlay').fadeOut();"),
            array('DIVEND'),
                        
        array('DIVEND'),

    //fin de div
    array('DIVEND')

		);
	$tags->EDraw($form);

    //$MyForm->Create_Form_Edit($Form);
}


function PEDIT()
{
    $Post = array();
    array_push($Post,array('users'/*table*/));
    //hidden
    array_push($Post,array('W'/*where*/,'id'/*field id*/,'ID'/*property id*/));
    array_push($Post,array('email'/*name field*/,'email'/*name post*/,'text'/*type verification*/,'45'/*size post*/));
    array_push($Post,array('first_name'/*name field*/,'first_name'/*name post*/,'text'/*type verification*/,'45'/*size post*/));
    array_push($Post,array('last_name'/*name field*/,'last_name'/*name post*/,'text'/*type verification*/,'45'/*size post*/));
    array_push($Post,array('phone'/*name field*/,'phone'/*name post*/,'text'/*type verification*/,'45'/*size post*/));
    array_push($Post,array('description'/*name field*/,'description'/*name post*/,'text'/*type verification*/,'250'/*size post*/));
    return $Post;
}
?>

