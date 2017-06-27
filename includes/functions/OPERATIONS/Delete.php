<?php
class DRFT//delete Row from table
{
	function Kill($Table,$ID,$IDV)
	{
		$this->Table = $Table;
		$this->IDV = $ID;
		$this->ID = $IDV;
		if(!(preg_match('/^[a-zA-Z, 0-9\-\_\.\ \r\n]+$/',$this->Table)))
		{
                    echo '<center>Erreur Table</center><br>';
		}	
		if(!(preg_match('/^[a-zA-Z, 0-9\-\_\.\ \r\n]+$/',$this->ID)))
		{
                    echo '<center>Erreur ID</center><br>';
		}
		if(!(preg_match('/^[0-9]+$/i',$this->IDV)))
		{
                    echo '<center>Erreur IDV</center><br>';
		}
		if(file_exists('functions/Cryptography.fn.php')){
                    require_once 'functions/Cryptography.fn.php';
		}else{
                    echo('EF Cryptography');
		}
		if(file_exists('includes/Classes/DB/DB.class.php')){
                    require_once 'includes/Classes/DB/DB.class.php';
		}else{
                    echo('EF DB');
		}
		if(file_exists('includes/Classes/Security/RegX.class.php')){
                    require_once 'includes/Classes/Security/RegX.class.php';
		}else{
                    echo('EF RegX.class');
		}
		if(file_exists('includes/Classes/Config/Config.class.php')){
                    require_once 'includes/Classes/Config/Config.class.php';
		}else{
                    echo('EF Config.class');
		}			
		$session = new Session();			
		$RegX = new RegX;
		if($RegX->check_noSpecialCaracters($this->Table))
		{
                    if($RegX->check_noSpecialCaracters($this->ID))
                    {
                        if($RegX->check_numbers($this->IDV))
                        {
                            $DB = new Database();
                            if($DB->Show_tables($this->Table))
                            {
                                //$this->SQL = 'DELETE FROM '.$this->Table.' where '.$this->ID.'='.$this->IDV;
                                $this->SQL = 'update '.$this->Table.' set deleted = 1 where '.$this->ID.'='.$this->IDV;
                                //die($this->SQL);
                                if($DB->Query($this->SQL))
                                {
                                    return 'OK';
                                }else{
                                    return 'UE';//Unknown Error
                                }
                            }else{
                                echo 'Probleme de nom de table : '.$this->Table;//table problem
                            }
                        }else{
                            echo 'Error Table Field Value';
                        }
                    }else{
                        echo '<center>Erreur : Nom de champs est incorrect<center><br>';
                    }
		}else{
                    echo 'Error Table Name';
		}
	}
}
?>
