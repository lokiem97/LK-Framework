<?php
/*
* Class kết nối Database
*/
class DB{
	//Các thông số kết nối
	private static $host      =  "localhost";
	private static $user_name =  "admin_lokiem";
	private static $db_name   =  "admin_lokiem";
	private static $password  =  "Yv2wi3G523C";
	private static $charset   =  "utf8";



	private $table,$distinct,$select,$where,$joins,$groupBy,$having,$orderBy,$limit,$offset,$union,$pageCurrent;
	private $data=[];
	//Khởi tạo class & lưu tên table
	function __construct($table){
		$this->table = $table;
	}


	//Khởi tạo kết nối
	private function connect(){
    @$connect = mysqli_connect(self::$host,self::$user_name,self::$password,self::$db_name);
    if(mysqli_connect_errno()){
    die('<meta charset="utf-8"/><div style="color:red"><h1>Lỗi kết nối Database</h1>Hãy kiểm tra lại thông số trong: <b>'.__FILE__.'</b> <br/>'.mysqli_connect_error().'</div>');
    }
    mysqli_set_charset($connect, self::$charset);
    return $connect;
    }

	//Đóng kết nối
	private function close(){
        @mysqli_close(self::connect());
    }

	//câu lệnh query
	public static function query($sql=''){
		$query = mysqli_query(self::connect(), $sql);
		self::close();
	    return $query;
	}

	//Chuyển sang chuỗi an toàn
	public static function safe($str){
		$real_escape = mysqli_real_escape_string(self::connect(),$str);
		self::close();
		return $real_escape;
	}

	//Lọc cột
	public function columnFilter($column){
		return (preg_match("/^[a-z0-9-_]+$/i", $column)==1 ? "`$column`" : "$column");
	}
	//Lưu tên table
	public static function table($table){
		return new self($table);
	}








	// Select
	public function select($columns){
		$this->select=func_get_args();;
		return $this;
	}

	public function distinct(){
		$this->distinct=" DISTINCT";
		return $this;
	}

	// Join
	public function join($p1, $p2="", $p3="", $p4=""){
		if(is_array($p1)){ $this->joins=$p1; }else{ $this->joins[]=func_get_args(); }
		return $this;
	}

	// Where
	public function where($p1, $p2="", $p3="", $p4=""){
		if(is_array($p1)){ $this->where=$p1; }else{ $this->where[]=func_get_args(); }
		return $this;
	}

	//GroupBy
	public function groupBy($groupBy){
		$this->groupBy=$groupBy;
		return $this;
	}

	// Having
	public function having($p1, $p2="", $p3="", $p4=""){
		if(is_array($p1)){ $this->having=$p1; }else{ $this->having[]=func_get_args(); }
		return $this;
	}

	// OrderBy
	public function orderBy($column,$sort="ASC"){
		if(is_array($column)){ $this->orderBy=$column; }else{ $this->orderBy[]=func_get_args(); }
		return $this;
	}

	// Limit
	public function limit($limit){
		$this->limit=$limit;
		return $this;
	}

	// Offset
	public function offset($offset){
		$this->offset=$offset;
		return $this;
	}


	//Where và Having
	private function whereOrHaving($data,$having=false,$sql=""){
		foreach($data as $key=>$where){
				if($key==0){
					$bool     ="";
					$column   =$where[0];
					$operator =strtoupper($where[1]);
					$value    =$where[2];
				}else{
					$bool     =strtoupper($where[0]);
					$column   =$where[1];
					$operator =strtoupper($where[2]);
					$value    =$where[3];
				}
				switch($operator){

					//Lệnh IN,NOT IN
					case "IN":
					case "NOT IN":
					if(is_array($value)){
						$where="(";
						foreach ($value as $k=>$in) {
							$where.="".($k==0 ? "" : ",")."$in";
						}
						$where.=")";
					}else{$where=$value;}
					$sql.=" $bool ".$this->columnFilter($column)." $operator ".self::safe($where)."";
					break;

					//Lệnh BETWEEN,NOT BETWEEN
					case "BETWEEN":
					case "NOT BETWEEN":
					if(is_array($value)){
						$where="".(INT)$value[0]." AND ".(INT)$value[1]."";
					}else{$where=$value;}
					$sql.=" $bool (".$this->columnFilter($column)." $operator ".self::safe($where).")";
					break;

					//Các lệnh khác
					default:
					$sql.=" $bool ".$this->columnFilter($column)." $operator '".self::safe($value)."'";
				}
			}
			return $sql;
	}

	// Nối các câu lệnh SQL
	public function sqlMerge($count=false){
		$sql="";
		//Select
		if(!empty($this->select)){
				$select="";
			foreach ($this->select as $id=>$sl) {
				$select.="".($id>0 ? "," : "")." ".$this->columnFilter($sl)." ";
			}
			$sql.="SELECT ".($count ? "COUNT(*) " : "".$this->distinct." $select")." FROM `{$this->table}`";
		}

		//Join
		if(!empty($this->joins)){
			foreach($this->joins as $key=>$join){
				$type   =strtoupper($join[0]);
				$table  =$join[1];
				$first  =$join[2];
				$second =$join[3];
				$sql.=" $type `$table` ON $first=$second";
			}
		}

		//Where
		if(!empty($this->where)){
			$sql.=" WHERE";
			$sql.=$this->whereOrHaving($this->where);
		}

		//GroupBy
		if(!empty($this->groupBy)){
			$sql.=" GROUP BY ".$this->columnFilter($this->groupBy)."";
		}

		//Having
		if(!empty($this->having)){
			$sql.=" HAVING";
			$sql.=$this->whereOrHaving($this->having,true);
		}

		//OrderBy
		if(!empty($this->orderBy)){
			$sql.=" ORDER BY";
			foreach($this->orderBy as $key=>$order){
				$sql.="".($key==0 ? "" : ",")." {$this->columnFilter($order[0])} {$order[1]}";
			}
		}

		//Limit
		if(!empty($this->limit) && !$count){
			$sql.=" LIMIT ".(INT)$this->limit."";
		}

		//Offset
		if(!empty($this->offset) && !$count){
			$sql.=" OFFSET ".(INT)$this->offset."";
		}

		//Union
		if(!empty($this->union)){
			foreach ($this->union as $type) {
				$sql.=" {$type["type"]} {$type["query"]} ";
			}
		}

		return $sql;
	}


	//Union
	public function union($query="",$type="UNION"){
		if(empty($query)){
			return ["type"=>$type, "query"=>$this->sqlMerge()];
		}else{
			if(isset($query["type"])){ $this->union[]=$query;  }else{ $this->union=$query; }
			return $this;
		}
	}

	//Union All
	public function unionAll($query="",$type="UNION ALL"){
		return $this->union($query,$type);
	}



	//Get dữ liệu
	public function get($only=false){
		//echo '<br/>'.$this->sqlMerge().'<br/>';
		if(empty($this->data)){
			if( $gData=self::query($this->sqlMerge()) ){
				$data=[];
				while($obData=mysqli_fetch_object($gData)){
					$data[]=$obData;
				}
				$this->data=$data;
			}
		}
		return $only ? $this->data[0] ?? NULL : $this->data;
	}



	//Phân trang
	public function pagination($limit=10){
		$this->limit=$limit;
		$pageCurrent = isset($_GET["page"]) ? (INT)$_GET["page"] : 1;
		if($pageCurrent<1){$pageCurrent=1;}
		$this->pageCurrent=$pageCurrent;
		$this->offset = ($pageCurrent-1)*$limit;
		return $this;
	}


	//Link phân trang
	public function links($op){
		return paginationLinks($op, $this->pageCurrent, $this->limit, $this->total());
	}


	//Insert
	public function insert($data=''){
		$k=$v='';
        foreach($data as $key => $value) {
            $k.=',`'.$key.'`';
            $v.=',"'.$this->safe($value).'"';
        }
        return $this->query('INSERT INTO `'.$this->table.'` ('.ltrim($k,',').') VALUES ('.ltrim($v,',').')');
    }



    //Update
    public function update($data='', $insert=false){
        $new = '';
        foreach($data as $key => $value) {
            $new.= ',`'. $key . '`="'.$this->safe($value).'"';
			$insrt[$key]=$value;
        }
        //Where
		if(!empty($this->where)){
			$where=$this->whereOrHaving($this->where);
		}
		if(DB::table($this->table)->select("*")->where($this->where)->exists()){
		$sql = self::query('UPDATE `'.$this->table.'` SET '.ltrim($new,',').' WHERE '.$where.'');
		}else{
		if($insert){ $sql = $this->insert($insrt); }else{ $sql = ''; }
		}
    return $sql;
    }


    //Insert dữ liệu nếu chưa có
    public function create($data=[]){
		if(!DB::table($this->table)->select("*")->where($this->where)->exists()){
			return $this->insert($data);
		}
    }



    //Delete
    public function delete(){
		if(!empty($this->where)){
			$where=$this->whereOrHaving($this->where);
			return self::query('DELETE FROM `'.$this->table.'` WHERE '.$where.'');
		}
    }


    //Đếm số dòng
    public function count(){
		$data  = $this->get();
		$count = is_array($data) ? count($data) : 0;
    	return $count;
    }


    //Đếm toàn bộ
    public function total(){
		if( $result = self::query($this->sqlMerge(true)) ){
			$count  = mysqli_fetch_row($result)[0];
		}
    	return $count ?? 0;
    }

    //Kiểm tra dữ liệu tồn tại
    public function exists(){
    	return $this->count() > 0 ? TRUE : FALSE;
    }


}//</Class>