


<?php
class Tables
{
    public $select;
    public $from;
    public $order;
    public $limit;
    public $where;
    public $ID;
    public $operations;
    public $IMGFolder;
    public $table;
    public $Module;
    public $DataHeader;
    public $DHFE;
    public $DHOUT;
    public $DH;
    public $UPLOADER;
    public $Seeker;
    public $SeekerKeys;
    public $DIR;
    public $PICFIELD;
    public $PICEXT;
    public $PICICON;
    public $PICLBL;
    public $DB;
    public $join;

    public function GET($Args)
    {

        $HEADERTABLE = $Args['THead'];
        $MODULE = $Args['Module'];

        $TBLHeader = '';
        foreach($HEADERTABLE as $DATATABLE_EL)
        {
            $TBLHeader .= '{"title":"'.$DATATABLE_EL.'"},';   
        }

         $HEADERTABLE = substr($TBLHeader,0,strlen($TBLHeader)-1);
         $MODULE = $MODULE[0];
         //,$FROM,$WHERE,$MODULE,$OPERATIONS,$UPLOADFIELDS;
    ?>
    <script>
    $(document).ready(function(){
        //$('a[rel=facebox]').facebox();
        var asInitVals = new Array();
        //plugin pur charger le tableau
        var UploadOperation = new Array();
        var DeleteOperation = new Array();
        var EditOperation = new Array();
        var Table = $(".datatables").dataTable({
            /*
            "sPaginationType": "full_numbers",
            "iDisplayLength": 25,
            "dom": '<"toolbar">frtip',
            "aLengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
            "oLanguage": {
            "sSearch": "",
            */
    
            "columns" : [<?php echo $HEADERTABLE; ?>],
            "data" : [<?php self::GET_DATA($Args); ?>],
            //}
            
            "fnDrawCallback":function(){
                $("div.dataTables_filter").append('<a href="<?php echo WebSite.$MODULE;?>/Add" class="btn btn-default" title="Add">Add</a>');
            }//fin fnDrowCallback*/
        });//fin plugin datatable
    });//fin instance jquery
    </script>
    <style>
    #tpanel{
        float:left;
        margin-top:20px;
        width:880px;
    }
    </style>
    <?php 
    if(isset($TITLE) || isset($ALink))
    {
    ?>
    <div id="tpanel">
        <h4><?php if(isset($TITLE)){echo $TITLE;}?></h4>   
    </div>
    <?php 
    }
    ?>
    <table cellpadding="0" cellspacing="0" border="0" id="" class="datatables table table-striped table-bordered"></table>


    <?php
    }

    public function GET_DATA($Args)
    {
            $Security = new Security();
            //$DB = new Database();
            //extract select
            $this->select = $Args['Select'];
            //extract from
            $this->from = $Args['From'][0];
            $WHERE = $Args['Where'];
            //extract where
            if(!empty($WHERE))
            {
                    $this->where=" WHERE ";
                    $this->where.=$WHERE;
            }else{
                    $this->where='';
            }
            //join
            $Join = $Args['Join'];

            for($i=0;$i<=count($Join);$i++)
            {
                //echo $Join[$i];
            }


            if(!empty($Join))
            {
                $this->join = '';
               foreach($Join as $Join_e => $Join_k)
               {
                
                    //echo count($Join_k);
                    if(count($Join_k) == 4)
                    {
                        $this->join .= ' join '.$Join_k[0].' as '.$Join_k[3].' on ('.$Join_k[1].' = '.$Join_k[2].')';    
                    }else{
                        $this->join .= ' join '.$Join_k[0].' on ('.$Join_k[1].' = '.$Join_k[2].')';
                    }
    
               }
            }else{
                    $this->join = '';
            }
            //echo $this->join;
            //die();
    ///upload des images
            $this->UPLOADER = $Args['UPLOADFIELDS'];
    ///extract IMGFolder
            //$this->IMGFolder = $IMGFolder;
    ///extract operations
            $this->operations = $Args['Operations'];
    ///extract table
            $this->table = $Args['From'][0];
    ///extract module name
            $this->Module = $Args['Module'][0];


            /* Paging */
            $sLimit = "";
            if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
            {
                    $sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".mysql_real_escape_string( $_GET['iDisplayLength'] );
            }

            /* Ordering */
            $sOrder = "";
            if ( isset( $_GET['iSortCol_0'] ) )
            {
                    $sOrder = "";
                    $sOrder .= "ORDER BY  ";
                    for ( $i=0 ; $i<mysql_real_escape_string( $_GET['iSortingCols'] ) ; $i++ )
                    {
                            $sOrder .= fnColumnToField(mysql_real_escape_string( $_GET['iSortCol_'.$i] ))."
                                    ".mysql_real_escape_string( $_GET['iSortDir_'.$i] ) .", ";
                    }
                    $sOrder = substr_replace( $sOrder, "", -2 );
            }
            //$sOrder = 'ORDER BY id DESC';
            if(isset($this->select))
            {
                $this->SQL_select = '';
                foreach($this->select as $Select_e=>$Select_k)
                {

                    $this->SQL_select .= ','.$Select_k.' as `'.$Select_e.'`';
                }
                $this->SQL_select = substr($this->SQL_select, 1);
                //die($this->SQL_select);
                $sQuery = "SELECT $this->SQL_select FROM $this->from $this->join $this->where $sOrder $sLimit";
            }else{
                $sQuery = "$this->SQL_select FROM $this->from $this->join $this->where $sOrder $sLimit";
            }

            //die($sQuery);
            $DB = Database::getInstance();
            if(!($rResult = $DB->Query($sQuery)))
            {
                    echo $sQuery;
                    die('Request Error');
            }
            $sQuery = "SELECT FOUND_ROWS()";
            $rResultFilterTotal = $DB->Query( $sQuery);
            $aResultFilterTotal = $rResultFilterTotal->fetch();

            $iFilteredTotal = $aResultFilterTotal[0];

            $sQuery = "SELECT COUNT(*) FROM $this->table";
            $rResultTotal = $DB->Query( $sQuery);
            $aResultTotal = $rResultTotal->fetch();
            $iTotal = $aResultTotal[0];


            if(empty($_GET['sEcho']))
            {
                    $sEcho=1;
            }else{
                    $sEcho=$_GET['sEcho'];
            }
            $sOutput = '';

            //$sa=split(" ,",$this->SQL_select);
            /*
            if(!empty($this->operations))
            {
                    $this->operations=split(',',$this->operations);
            }else{
                    $this->operations=0;
            }
            */
        $count =0;
        $aRows = $rResult->fetchAll();
        $i = 0;
        //var_dump($aRows);
        foreach($aRows as $aRow)
        {               
            $count++;
            $sOutput .= "[";
            foreach($this->select as $Select_e=>$Select_k)
            {

                if($i == 0)
                {
                    $this->ID = $Select_e;
                    $this->IDV= $aRow[$Select_e];
                    $this->FID = $Select_e;
                }
                $i++;

                    
                $f = $Select_e;
                //check this please         
                if($f == 'content' || $f == 'short_text' /*|| strstr($f,'description')*/)
                {//

                }
                /*
                elseif($f == 'tech_file' || $f == 'website' || $f =='link'){
                    if($Security->check_HTTP($aRow["$f"])){
                        if(substr($aRow[$f],0,4) == 'http')
                        {
                            $sOutput .= '"<a href=\"'.$aRow[$f].'\" TARGET=\"_blank\" style=\"text-decoration:none;color:#0CF\" title=\"'.$aRow[$f].'\"><img src=\"images/link.png\" class=\"links\"></a>",';
                        }else{
                            $sOutput .= '"<a href=\"http://'.$aRow[$f].'\" TARGET=\"_blank\" style=\"text-decoration:none;color:#0CF\" title=\"'.$aRow[$f].'\"><img src=\"images/link.png\" class=\"links\"></a>",';
                        }
                        
                    }else{
                        $sOutput .= '"Error link",';
                    }
                    

                }
*/
                elseif(strstr($f,'active')){
                    $this->FIELD = $f;                                                                                          
                    if(preg_match('/\./',$f))
                    {
                        $f= split('[\.]',$f);
                        $f = $f[1];
                        $f=$aRow["$f"];
                    }else{
                        $f=$aRow["$f"];
                    }   
                    if($f ==1){
                        $sOutput .= '"<img src=\"images/hp.png\" name=\"'.$this->FIELD.'_'.$this->FID.'\" class=\"'.$this->table.'\" title=\"'.str_replace('(select ','',$this->ID).'\" value=\"1\" >",';   
                    }else{
                        $sOutput .= '"<img src=\"images/no_hp.png\" name=\"'.$this->FIELD.'_'.$this->FID.'\" class=\"'.$this->table.'\" title=\"'.str_replace('(select ','',$this->ID).'\" value=\"0\" >",';
                    }

                }elseif($f == 'img_src' ){
                      $url = $aRow["$f"];              
                      //$handle = @fopen($url,'r');            
                      //if($handle !== false){             
                        $sOutput .= '"<img src=\"'.$aRow["$f"].'\" style=\"width:25px;height:25px\" class=\"link\">",';                               
                }elseif($f == 'hexa' ){  
                    $sOutput .= '"<font style=\"color:#'.$aRow["$f"].'\">'.$aRow["$f"].'</font>",';                               
                }elseif(strstr($f ,'picture') || strstr($f ,'file')){
                                    if(file_exists($aRow[$f]))
                                    {
                                        //echo substr($aRow[$f],-4);
                                        switch (substr($aRow[$f],-4))
                                        {
                                            case '.pdf' : $sOutput .= '"<a href=\"'.$aRow[$f].'\" target=\"_blank\" title=\"Fichier de format pdf\"><img class=\"link\" src=\"images/pdf32.png\"></a>",';
                                                break;
                                            case '.jpg' : $sOutput .= '"<a href=\"'.$aRow[$f].'\" target=\"_blank\" title=\"Fichier de format jpg\"><img class=\"link\" src=\"images/jpg32.png\"></a>",';
                                                break;
                                            case 'jpeg' : $sOutput .= '"<a href=\"'.$aRow[$f].'\" target=\"_blank\" title=\"Fichier de format jpg\"><img class=\"link\" src=\"images/jpg32.png\"></a>",';
                                                break;
                                            case '.png' : $sOutput .= '"<a href=\"'.$aRow[$f].'\" target=\"_blank\" title=\"Fichier de format jpg\"><img class=\"link\" src=\"images/jpg32.png\"></a>",';
                                                break;
                                            default : $sOutput .= '"<a href=\"'.$aRow[$f].'\" target=\"_blank\" title=\"Telecharger le fichier">Telecharger</a>",';
                                        }
                                    }else{
                                        $sOutput .= '"<img class=\"link\" src=\"images/fileerror.png\" title=\"Fichier introuvable\">",';
                                    }
                                    
                }elseif($f == 'order'){
                    if($count == 1){
                        $sOutput .='"<img name=\"'.$aRow["order"].'\" id=\"'.$this->FID.'\" src=\"images/order_bottom.png\" title=\"Deplacer en bas\" class=\"Displace '.$this->table.'\">",';                                  
                    }else if($count == $iTotal){
                        $sOutput .= '"<img name=\"'.$aRow["order"].'\" id=\"'.$this->FID.'\" src=\"images/order_top.png\" title=\"Deplacer en haut\" class=\"Displace '.$this->table.'\">",';                           
                    }else{
                        $sOutput .= '"<img name=\"'.$aRow["order"].'\" id=\"'.$this->FID.'\" src=\"images/order_bottom.png\" title=\"Deplacer en bas\" class=\"Displace '.$this->table.'\">&nbsp&nbsp'.
                                    '<img name=\"'.$aRow["order"].'\" id=\"'.$this->FID.'\" src=\"images/order_top.png\" title=\"Deplacer en haut\" class=\"Displace '.$this->table.'\">",';                            
                    }                 

                }else{
                    $sOutput .= '"'.addslashes(trim(preg_replace( "/\r|\n/", " ",$aRow[$f]))).'",';
                } 
            }
            if(count($this->operations) != 0)
            {
                $sOutput .= '"';
                if(in_array('edit',$this->operations))
                {
                    $sOutput .= '<a rel=\"facebox\" href=\"'.$this->Module.'/Edit/'.$aRow[$this->FID].'\" class=\"btn btn-default btn-xs\" title=\"Editer\">Edit</a>';
                }
                if(in_array('delete',$this->operations) || in_array('DELETE',$this->operations))
                {
                    $sOutput .= '<a href=\"'.$this->Module.'/Delete/'.$aRow[$this->FID].'\" class=\"btn btn-default btn-xs DELETE\" onclick=\"DeleteElement(\''.WS.WSDIR.$this->Module.'\','.$aRow[$this->FID].')\" title=\"Delete\">Delete</a>';
                }
                $sOutput .= '"],';
            }else{
                $sOutput = substr_replace( $sOutput, "", -1 );
                $sOutput .= '],';
            }   
        }
        $sOutput = substr_replace( $sOutput, "", -1 );
        echo $sOutput;
    }
   
}
?>

