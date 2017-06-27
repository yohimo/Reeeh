<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Comments{
    function count($Mod,$ID)
    {
        $DB = Database::getInstance();
        $Security = new Security();
        $Modules = new Modules();
        
        if($Security->check_noSpecialCaracters($Mod) && $Security->check_numbers($ID))
        {
            $ModID = $Modules->getID($Mod);
            if($ModID)
            {
                $sql = "select id from comments where id_module = $ModID and id_comments = $ID";
//                echo $sql;
                $query3=$DB->query($sql);
                $query3->execute();
                return $query3->rowCount();
            }else{
                return 0;
                return 'error class comments : '.__LINE__;
            }
        }else{
            return 'error';
        }
    }
    public static function get($Mod,$ID){
        $DB = Database::getInstance();
        $Security = new Security();
        $Modules = new Modules();
        $Users = new user();
        if($Security->check_noSpecialCaracters($Mod) && $Security->check_numbers($ID))
        {
            $ModID = $Modules->getID($Mod);
            if($ModID)
            {
                $Comments = array();
                $sql = "select id_user,text,cdate from comments where id_module = $ModID and id_comments = $ID and deleted = 0 order by id desc";
//                echo $sql;
                $query3=$DB->query($sql);
                $query3->execute();
                //die($sql);
                if($query3->rowCount() > 0)
                {
                    while ($result = $query3->fetch(PDO::FETCH_ASSOC)) {
                        $user = $Users->getUserFirstLastName($result['id_user']);
                        $userPP = $Users->getDefaultPicture($result['id_user']);
                        
                        $comment = $result['text'];//don't forget to remove html or sql injection or ...
                        $date = $result['cdate'];
                        array_push($Comments,array('user'=>$user,'picture'=>$userPP,'comment'=>$comment,'date'=>$date));
                    }
                    return json_encode($Comments);
                }else{
                    return null;
                }
            }else{
                return null;
            }
        }else{
            return 'error';
        }
    }
    public static function add($Mod,$ID){
        
    }
    public static function delete($Mod,$ID){
        
    }
    public static function update($Mod,$ID){
        
    }
}
?>
