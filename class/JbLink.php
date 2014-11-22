<?
class mysqlilink
{
	var $link;
	var $result;
	var $sql;
	var $debug = false;
	
	function JbLink($host, $user, $password, $database="")
	{
		$this->link = mysqli_connect($host, $user, $password, $database);
	}
	
	function close()
	{
		mysqli_close($this->link);
	}
	
	function query($sql)
	{
		$this->sql = $sql;
		$this->result = mysqli_query($this->link,$sql);

		if ($this->debug && $this->result===false)
			echo '<div style="color:red">'.$this->sql.'</div>';
		return $this->result;
	}
	
	function insert($table, $col_value_array)
	{
		$cols = "";
		$values = "";
		foreach ($col_value_array as $key => $value)
		{
			$cols .= "`$key`,";
			$values .= "'$value',";
		}
		$cols = rtrim($cols, ",");
		$values = rtrim($values, ",");
		
		$this->sql = "insert into `$table` ($cols) values ($values)";
		$this->result = mysqli_query($this->sql, $this->link);
		if ($this->debug && $this->result===false)
			echo '<div style="color:red">'.$this->sql.'</div>';
		return $this->result;
	}
	
	function update($table, $col_value_array, $condition)
	{
		$this->sql = "";
		foreach ($col_value_array as $key => $value)
			$this->sql .= "`$key`='$value',";
		$this->sql = rtrim($this->sql, ",");	
		
		$this->sql = "update `$table` set ".$this->sql." where $condition";
		$this->result = mysqli_query($this->sql, $this->link);
		if ($this->debug && $this->result===false)
			echo '<div style="color:red">'.$this->sql.'</div>';
		return $this->result;
	}
	
	function fetch()
	{
		return mysqli_fetch_array($this->result);
	}	
	
	function num_rows()
	{
		return mysqli_num_rows($this->result);
	}
	
	function data_seek($i)
	{
		mysqli_data_seek($this->result, $i);
	}
	
	function error()
	{
		return mysqli_error($this->link);
	}
	
	function fetch_field()
	{
		return mysqli_fetch_field($this->result);
	}
}
?>
