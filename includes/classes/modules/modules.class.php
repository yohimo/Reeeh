<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class Modules{
    public static function getID($Mod)
    {
        $Security = new Security();
        if($Security->check_noSpecialCaracters($Mod))
        {
            $DB = Database::getInstance();
            $sql = "select id from modules where title = '$Mod' and deleted = 0";
            $query=$DB->query($sql);
            $query->execute();
            if($query->rowCount() > 0)
            {
                    $result = $query->fetch(PDO::FETCH_ASSOC);
                return $result['id'];
            }else{
                return 0;
            }
        }else{
            return 'error';
        }
        
    }
}
?>
