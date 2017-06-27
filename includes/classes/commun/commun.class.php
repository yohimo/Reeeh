<?php
class Cummon{

	public function UList($table,$fields,$limit,$order,$where,$join){
		$DB = Database::getInstance();
		/*
		params of this function
		$table = name of table
		$fields : array , format : $fields = array('*'), format : $fields = array('field1','field1','field1',..)
		$limit = array($start,$end) ex : select * from $table limit $limit[0],$limit[0]
		
		$where : array = format $where = array('where1'=>array('fieldname','value'),'where2'=>array('fieldname','value'),xxx) ex  
		$order = filed name
		$join  : array(array(table,field1,field2),array(table,field1,field2),x) 
		*/

		//var_dump($where);
		if(!empty($where))
		{
			foreach($where as $where_el)
			{
				echo 1;
				echo $where_el;
				$this->where = $where_el;
			}
		}else{
			$this->where = '';
		}

		$this->table = $table;
		$this->limit = $limit;
		$this->order = $order[0];
		$this->fields = $fields;

		foreach($fields as $field)
		{
			$this->sql_fields .= ",$field";
		}

		foreach($join as $join_e => $join_k)
		{
			//var_dump($join_k);
			$this->sql_join = "$join_k[0] join $join_k[1] on ($join_k[2] = $join_k[1].$join_k[3]) ";
		}
		$this->sql_fields = substr($this->sql_fields, 1 );

		//$this->join = $join;
		
		$sql = 'select '.$this->sql_fields.' from '.$this->table.' '.$this->sql_join.' where 1=1 '.$this->where.' order by '.$this->order.' limit '.$this->limit[0].','.$this->limit[1];
		//var_dump($sql);
		return $DB->query($sql)->fetchAll();
	}
	public function update()
	{
		
	}
}
?>