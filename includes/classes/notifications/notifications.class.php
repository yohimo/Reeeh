<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Notifications
{
    public static function add($operation,$module,$id,$user)
    {
        $DB = Database::getInstance();
        $Security = new Security();
        $Users = new user();
        switch($operation)
        {
            case 'like' : 
            $Title = $Users->getUserFirstLastName($user);
            $title = "<a href=\"#\">$Title</a>";

            $details = $title."<span>apprécie votre article 'titre'.</span>";
            if($Security->check_numbers($user))
            {
                $sql = "insert into notifications (title, details, id_module, id_element, id_user, cdate) values ('$title','$details',$module,$id,$user,now())";
                try{
                    $sth = $DB->prepare($sql);
                    $sth->bindParam(':title', $title, PDO::PARAM_STR);
                    $sth->bindParam(':details', $details, PDO::PARAM_STR);
                    $sth->bindParam(':user', $user, PDO::PARAM_INT);
                    $sth->execute();
                }catch(Exception $e)
                {
                    echo $e->getMessage();
                }
            }
            break;
            
        }

    }
    public static function seen($id)
    {
        
    }
}
?>
