<?php
class Uploader
{
	public function upload_file($file,$dir,$ext)
	{
	    if(isset($dir))
	    {
	        if(!is_dir($dir))
	        {
	            die('Error : NOT FOUND SUCH FOLDER'.$dir);
	        }
	        //echo '12sd23f1d23s1';
	        //NEW FOLDER WILL CONTAIN THE UPLOADED FILE
	        //die(var_dump($this->FILE));
	        if(!is_uploaded_file($file['tmp_name']) )
	        {
	            echo("Error : UPLOADED FILE NOT FOUND ON THE SERVER<br>");
	        }
	        //die($file['tmp_name']['size']);
	        /*
	        if($file['tmp_name']['size'] > 2048)
	        {
	        	die('Max File Size');
	        }*/
	        



	        //EXT VERIFICATION
	        $TYPES = array('ALL','application/x-mobipocket-ebook','application/epub+zip','image/jpeg','image/bmp','image/png','image/gif','application/pdf','application/vnd.ms-excel','application/octet-stream','application/x-shockwave-flash','application/vnd.openxmlformats-officedocument.wordprocessingml.document');
//                die();
//                if(is_array($file['type']))
//                {
//                    
//                }else{
//                    
//                }
//                echo($file['type']);
//                die();
	        if(!(in_array($file['type'],$TYPES)))
	        {
	            echo 'FILE FORMAT ERROR : ';
                    var_dump($file['type']);
	        }
	        // FILE NAME VERIFICATION
	        if( preg_match('#[\x00-\x1F\x7F-\x9F/\\\\]#', $file['name']) )
	        {
	            echo('Error File name');
	        }
	        //die($this->FILE['type']);
			//echo $file['type'].'<br>';
	        switch ($file['type'])
	        {
	            case 'image/jpeg' : $ext = 'jpg' ;
	                break;
	            case 'image/bmp' : $ext = 'bmp' ;
	                break;
	            case 'image/png' : $ext = 'png' ;
	                break;
	            case 'image/gif' : $ext = 'gif' ;
	                break;
	            default :
	                $ext = 'png';
	        }
	        $filename = substr(microtime(),10).'.'.$ext;
	        $filename = str_replace(' ','',$filename);
	        //die($dir);
	        if(!move_uploaded_file($file['tmp_name'], $dir.'/'.$filename))
	        {
	            echo('Error : Can\' move uploaded file<br>');
	        }else{
	            return (str_replace('../','',$dir.'/'.$filename));
	        }
	    }else{
	        echo('DIR NOT FOUND ON THE SERVER<br>');
	    }
	}
}
?>
