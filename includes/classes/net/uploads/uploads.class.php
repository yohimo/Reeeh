<?php
/*********************************************/
//Note : if you want to modify this file please contact Brahim Moulblad
//CREATED BY Brahim Moulblad
//Created 07-05-2010
//Updated 07-05-2010
//docx = application/vnd.openxmlformats-officedocument.wordprocessingml.document
//doc = application/msword
//xlsx = application/vnd.openxmlformats-officedocument.spreadsheetml.sheet
//csv = application/vnd.ms-excel
//*********************************************/
class UPLOAD
{
	public $DIR;
	public $NDIR;
	public $FILE;
	public $EXT;
	public $MOD;
	public $TABLE;
	public $FIELD;
	public $ID;
	public $SI;
	public $FNMAE;
	public $SQL;
	public $DB;
	public $CNF;
	public $AllowedExtFiles = array('application/msword','application/vnd.ms-excel','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/pdf');
        public $AllowedExtImages = array('image/jpeg','image/png','image/bmp');
	public function UFORM($DIR,$MOD,$TABLE,$FIELD,$ID,$EXT,$SID)
	{
            if(empty($TABLE))
            {
                die("Erreur dans les variables d'upload");
            }
		$this->DIR = $DIR;
		$this->MOD = $MOD;
		$this->TABLE = $TABLE;
		$this->FIELD = $FIELD;
		$this->ID = $ID;
		$this->SID = $SID;
		$this->EXT = $EXT;
?>
		<script language="javascript">
		$().ready(function(){
			var D = $("#D").val();
			var T = $("#T").val();
			var F = $("#F").val();
			var I = $("#I").val();
			var E = $("#E").val();
			var SI = $("#SI").val();
			new AjaxUpload('UFile', {
				action: 'functions/OPERATIONS/Upload.php',
				name: 'file',
				data: {
				    D : D,
				    T : T,
				    F : F,
				    I : I,
				    E : E,
				    SI : SI
				},
				autoSubmit: true,
				responseType: false,
				onSubmit : function(file,ext){
			        if (! (ext && /^(<?php echo str_replace(',','|',$this->EXT); ?>)$/i.test(ext))){
			                // extension is not allowed
			                alert('Erreur : format de fichier est invalide');
			                // cancel upload
			                return false;
			        }
		        },
				onComplete : function(file,response){
					if(response == 'OK')
					{
						location.reload();
					}else{
						alert(response);
					}
				}	
			});
		});
		</script>
		<div id="UPLOADER">
			<input type="hidden" id="D" value="<?php echo $this->DIR; ?>">
			<input type="hidden" id="T" value="<?php echo $this->TABLE; ?>">
			<input type="hidden" id="F" value="<?php echo $this->FIELD; ?>">
			<input type="hidden" id="I" value="<?php echo $this->ID; ?>">
			<input type="hidden" id="E" value="<?php echo $this->EXT; ?>">
			<input type="hidden" id="SI" value="<?php echo $this->SID; ?>">
			<input type="file" id="UFile" value="T&eacute;l&eacute;charger">
		</div>
<?php	
	}
	
	public function EASYUPLOAD($DIR,$FILE)
	{
            $this->DIR = $DIR;
            /*
            if(isset($FILE))
            {*/
            	$this->FILE = $FILE;
            	/*
            }else{
            	die('File not found');
            }
            */
            if(isset($this->DIR))
            {
                if(!is_dir($this->DIR))
                {
                    die('Error : NOT FOUND SUCH FOLDER'.$this->DIR);
                }
                //echo '12sd23f1d23s1';
                //NEW FOLDER WILL CONTAIN THE UPLOADED FILE
                //die(var_dump($this->FILE));
                if(!is_uploaded_file($this->FILE['tmp_name']) )
                {
                    die("Error : UPLOADED FILE NOT FOUND ON THE SERVER");
                }
                //EXT VERIFICATION
                $TYPES = array('ALL','image/jpeg','image/bmp','image/png','image/gif','application/pdf','application/vnd.ms-excel','application/octet-stream','application/x-shockwave-flash','application/vnd.openxmlformats-officedocument.wordprocessingml.document');
                if(!(in_array($this->FILE['type'],$TYPES)))
                {
                    die('FILE FORMAT ERROR : '.$this->FILE['type']);
                }
                // FILE NAME VERIFICATION
                if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $this->FILE['name']) )
                {
                    die('Error File name');
                }
                //die($this->FILE['type']);
                switch ($this->FILE['type'])
                {
                    case 'image/jpeg' : $this->Extention = 'jpg' ;
                        break;
                    case 'application/pdf' : $this->Extention = 'pdf' ;
                        break;
                    case 'application/vnd.ms-excel' : $this->Extention = 'csv' ;
                        break;
                    case 'application/octet-stream' : $this->Extention = 'csv' ;
                        break;
                    case 'application/x-shockwave-flash' : $this->Extention = 'swf' ;
                        break;
                    case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' : $this->Extention = 'docx' ;
                        break;
                    case 'image/bmp' : $this->Extention = 'bmp' ;
                        break;
                    case 'image/png' : $this->Extention = 'png' ;
                        break;
                    case 'image/gif' : $this->Extention = 'gif' ;
                        break;
                    default :
                        $this->Extention = 'RAR';
                }
                $this->FNMAE = substr(microtime(),10).'.'.$this->Extention;
                $this->FNMAE = str_replace(' ','',$this->FNMAE);
                if(!move_uploaded_file($this->FILE['tmp_name'], $this->DIR.$this->FNMAE))
                {
                        die('Error : Can\' move uploaded file');
                }else{
                        return $this->DIR.$this->FNMAE;
                }
            }else{
                    die('DIR NOT FOUND ON THE SERVER');
            }
	}	
	
	public function UFile($DIR,$FILE,$EXT,$TABLE,$FIELD,$ID,$SI)
	{
            $this->DIR = $DIR;
            $this->FILE = $FILE;
            $this->EXT = $EXT;
            $this->TABLE = $TABLE;
            $this->FIELD = $FIELD;
            $this->ID = $ID;
            $this->SI = $SI;
            if(strstr($this->TABLE,' ')){
                $this->TABLE = preg_split('[\ ]',$this->TABLE);
                $this->TABLE = $this->TABLE[0];
            }
		
		if(isset($this->DIR)){
                        $this->DIR = '../../'.$this->DIR;
			if(!is_dir($this->DIR))
			{
                            die('NOT FOUND SUCH FOLDER : '.$this->DIR);
			}
			$this->NDIR = $this->DIR.'/'; //NEW FOLDER WILL CONTAIN THE UPLOADED FILE					
			if(!is_uploaded_file($this->FILE['tmp_name']) )
			{
				exit("UPLOADED FILE NOT FOUND ON THE SERVER");
			}
			//EXT VERIFICATION
			$TYPES = array('ALL','image/jpeg','image/bmp','image/png','image/gif', 'application/pdf','application/vnd.ms-excel','application/octet-stream');
			if(!(in_array($this->FILE['type'],$TYPES)))
			{
				
			    die('FILE FORMAT ERROR : '.$this->FILE['type']);
			}
                        //die($this->FILE['type']);
			// FILE NAME VERIFICATION
			if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $this->FILE['name']) )
			{
			    die('Error File name');
			}
                        switch ($this->FILE['type'])
                        {
                            case 'image/jpeg' : $this->Extention = 'jpg' ;
                                break;
                            case 'application/pdf' : $this->Extention = 'pdf' ;
                                break;
                            case 'image/bmp' : $this->Extention = 'bmp' ;
                                break;
                            case 'image/png' : $this->Extention = 'png' ;
                                break;
                            case 'image/gif' : $this->Extention = 'gif' ;
                                break;
                            case 'application/vnd.ms-excel' : $this->Extention = 'xls' ;
                                break;
                            case 'application/octet-stream' : $this->Extention = 'csv' ;
                                break;
                            default : $this->Extention = 'err' ;
                        }
                        
                        //$this->Extention =
			$this->FNMAE = substr(microtime(),10).'.'.$this->Extention;
			if(!move_uploaded_file($this->FILE['tmp_name'], $this->NDIR.str_replace(' ','',$this->FNMAE)) )
			{
				die('ERROR : Can\' move uploaded file');
			}else{
				if(!file_exists('../../includes/Classes/DB/DB.class.php'))
				{
					die('DBFILE NOT FOUND');	
				}
				require_once('../../includes/Classes/DB/DB.class.php');
				require_once('../../includes/Classes/Config/Config.class.php');
				$session = new Session();
                                $this->DB = new Database();

                                $this->FNMAE = str_replace(' ','',$this->FNMAE);
                                $this->DIR = str_replace('../../','',$this->DIR);
				$this->SQL = 'UPDATE '.$this->TABLE.' set '.$this->FIELD.'=\''.$this->DIR.'/'.$this->FNMAE.'\' WHERE '.$this->SI.'='.$this->ID;
                                //die($this->SQL);
				$this->DB->Query($this->SQL);
				//die($this->SQL);
				die('OK');
			}
		}else{
			die('DIR NOT FOUND ON THE SERVER');
		}
	}
	
	//upload simple file
	
	public function USimpleFile($DIR,$EXT,$FILE,$Table,$Field,$Operation,$Value)
	{
		$this->DIR = $DIR;
		$this->FILE = $FILE;
		$this->EXT = $EXT;
		$this->TABLE = $Table;
		$this->FIELD = $Field;
		$this->Operation = $Operation;
		$this->Value = $Value;
		$this->AllowedExtFiles = array('ALL','image/jpeg','image/bmp','image/png','image/gif','application/vnd.ms-excel','application/octet-stream');
		if(isset($this->DIR)){
			if(is_dir('../../../files/') || is_dir('../../../../files/'))
			{
				if(is_dir('../../../files/'))
				{
					if(!is_dir('../../../files/'.$this->DIR.'/'))
					{
						mkdir('../../../files/'.$this->DIR.'/', 0700);
					}
					if(!is_dir('../../../files/'.$this->DIR.'/'))
					{
						die('Error creating directory');	
					}
					$this->NDIR = '../../../files/'.$this->DIR.'/'; //NEW FOLDER WILL CONTAIN THE UPLOADED FILE					
					if(!is_uploaded_file($this->FILE['tmp_name']) )
					{
					 	exit("Error : UPLOADED FILE ( ".$this->FILE['tmp_name']." ) NOT FOUND ON THE SERVER");
					}
				}else{
					if(!is_dir('../../../../files/'.$this->DIR.'/'))
					{
						mkdir('../../../../files/'.$this->DIR.'/', 0700);
					}
					if(!is_dir('../../../../files/'.$this->DIR.'/'))
					{
						die('Error creating directory');	
					}
					$this->NDIR = '../../../../files/'.$this->DIR.'/'; //NEW FOLDER WILL CONTAIN THE UPLOADED FILE

                                        
					if(!is_uploaded_file($this->FILE['tmp_name']) )
					{
					 	exit("Error : UPLOADED FILE ( ".$this->FILE['tmp_name']." ) NOT FOUND ON THE SERVER");
					}
				}
			}else{
				die('Directory of files not found at "../../../files/'.$this->DIR.'"');	
			}

			//EXT VERIFICATION
			

			if(!(in_array($this->FILE['type'],$this->AllowedExtFiles)))
			{
				echo $this->FILE['type'] ;
			    die('FILE FORMAT ERROR');
			}
			// FILE NAME VERIFICATION
			if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $this->FILE['name']) )
			{
			    die('Error File name');
			}
                        switch ($this->FILE['type'])
                        {
                            case 'image/jpeg' : $this->Extention = 'jpg' ;
                                break;
                            case 'application/pdf' : $this->Extention = 'pdf' ;
                                break;
                        }
			$this->FNMAE = substr(microtime(),10).'.'.$this->Extention;
                        $this->FNMAE = str_replace(' ','',$this->FNMAE);
			if(!move_uploaded_file($this->FILE['tmp_name'], $this->NDIR.$this->FNMAE) )
			{
				die('ERROR : Can\' move uploaded file');
			}
			
			
			///ajoute dane la table
			if(file_exists('../../../includes/Classes/DB/DB.class.php'))
			{
				require_once('../../../includes/Classes/DB/DB.class.php');
				require_once('../../../includes/Classes/Config/Config.class.php');	
			}else{
				require_once('../../../../includes/Classes/DB/DB.class.php');
				require_once('../../../../includes/Classes/Config/Config.class.php');
				
			}
                        
			
			$this->CNF = new Config();
			$session = new Session();
                        $DB = new Database();
			$this->SQL = 'INSERT INTO '.$this->TABLE.' ('.$this->FIELD.',cdate,cby) VALUES (\''.$this->FNMAE.'\',now(),'.$session->getSession('EMPLOYEE').');';
                        //die($this->SQL);
			$this->DB->Query($this->SQL);
			echo 'OK';
		}else{
			die('DIR NOT FOUND ON THE SERVER');
		}
	}
	//upload simple file
	
	public function UCustomFile($DIR,$EXT,$FILE,$Table,$Field,$Value,$SFields,$SValue,$USQL)
	{
		$this->DIR = $DIR;
		$this->FILE = $FILE;
		$this->EXT = $EXT;
		$this->TABLE = $Table;
		$this->FIELD = $Field;
		$this->Value = $Value;
		$this->SFields = $SFields;
		$this->SValue = $SValue;
		$this->uSQL = $USQL;
		$this->AllowedExtFiles = array('ALL','image/jpeg','image/bmp','image/png','image/gif','application/pdf','application/octet-stream');
		if(isset($this->DIR)){
			if(is_dir('../../../files/') || is_dir('../../../../files/') || is_dir('files/'))
			{
				if(is_dir('../../../files/'))
				{
					if(!is_dir('../../../files/'.$this->DIR.'/'))
					{
						mkdir('../../../files/'.$this->DIR.'/', 0700);
					}
					if(!is_dir('../../../files/'.$this->DIR.'/'))
					{
						die('Error creating directory "'.'files/'.$this->DIR.'/'.'" Line : '.__line__);
					}
					$this->NDIR = '../../../files/'.$this->DIR.'/'; //NEW FOLDER WILL CONTAIN THE UPLOADED FILE					
					if(!is_uploaded_file($this->FILE['tmp_name']) )
					{
					 	exit("Error : UPLOADED FILE ( ".$this->FILE['tmp_name']." ) NOT FOUND ON THE SERVER");
					}
				}elseif(is_dir('../../../files/')){
					if(!is_dir('../../../../files/'.$this->DIR.'/'))
					{
                                            mkdir('../../../../files/'.$this->DIR.'/', 0700);
					}
					if(!is_dir('../../../../files/'.$this->DIR.'/'))
					{
						die('Error creating directory');	
					}
					$this->NDIR = '../../../../files/'.$this->DIR.'/'; //NEW FOLDER WILL CONTAIN THE UPLOADED FILE					
					if(!is_uploaded_file($this->FILE['tmp_name']) )
					{
					 	exit("Error : UPLOADED FILE ( ".$this->FILE['tmp_name']." ) NOT FOUND ON THE SERVER");
					}
				}elseif(is_dir('files/')){
					if(!is_dir('files/'.$this->DIR.'/'))
					{
						mkdir('files/'.$this->DIR.'/', 0700);
					}
					if(!is_dir('files/'.$this->DIR.'/'))
					{
                                            die('No directorywith this name "'.'files/'.$this->DIR.'/'.'" Line : '.__line__);
					}
					$this->NDIR = 'files/'.$this->DIR.'/'; //NEW FOLDER WILL CONTAIN THE UPLOADED FILE					
					if(!is_uploaded_file($this->FILE['tmp_name']) )
					{
					 	exit("Error : UPLOADED FILE ( ".$this->FILE['tmp_name']." ) NOT FOUND ON THE SERVER");
					}
				}
			}else{
                            die('Directory of files not found at "../../../files/'.$this->DIR.'"');
			}

			//EXT VERIFICATION
			

			if(!(in_array($this->FILE['type'],$this->AllowedExtFiles)))
			{
				echo $this->FILE['type'] ;
			    die('FILE FORMAT ERROR');
			}
			// FILE NAME VERIFICATION
			if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $this->FILE['name']) )
			{
			    die('Error File name');
			}
			if($this->EXT == 'ALL')
			{
                            switch($this->FILE['type'])
                            {
                                case 'image/jpeg' : $this->EXT = 'jpg';
                                break;
                                case 'image/bmp' : $this->EXT = 'bmp';
                                break;
                                case 'image/png' : $this->EXT = 'png';
                                break;
                                case 'image/gif' : $this->EXT = 'gif';
                                break;
                                case 'application/pdf' : $this->EXT = 'pdf';
                                break;
                            }
			}
			$this->FNMAE = substr(microtime(),10).'.'.$this->EXT;
			if(!move_uploaded_file($this->FILE['tmp_name'], $this->NDIR.str_replace(' ','',$this->FNMAE)) )
			{
				die('ERROR : Can\' move uploaded file');
			}
			///ajoute dane la table
			if(file_exists('../../../includes/Classes/DB/DB.class.php'))
			{
				require_once('../../../includes/Classes/DB/DB.class.php');
				require_once('../../../includes/Classes/Config/Config.class.php');	
			}elseif(file_exists('../../../../includes/Classes/DB/DB.class.php')){
				require_once('../../../../includes/Classes/DB/DB.class.php');
				require_once('../../../../includes/Classes/Config/Config.class.php');
			}elseif(file_exists('includes/Classes/DB/DB.class.php'))
			{
				require_once('includes/Classes/DB/DB.class.php');
				require_once('includes/Classes/Config/Config.class.php');
			}else{
				die('Config File not found Upload : '.__line__);	
			}
			
			$this->CNF = new Config();
			$session = new Session();
                        $this->DB = new Database();
			$this->FileName = str_replace(' ','',$this->NDIR.$this->FNMAE);
			$this->FileName = str_replace('../','',$this->FileName);
			//echo $this->FileName;
			$this->SQL = 'INSERT INTO '.$this->TABLE.' ('.$this->FIELD.','.$this->SFields.',cdate,cby) VALUES (\''.$this->FileName.'\','.$this->SValue.',now(),'.$session->getSession('EMPLOYEE').');';
			//die($this->SQL);
			$this->DB->Query($this->SQL);
			return 'OK';
		}else{
			die('DIR NOT FOUND ON THE SERVER');
		}
	}
}				   									
?>