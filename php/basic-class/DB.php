<?php
/**
 * Created by PhpStorm.
 * User: Brocade
 * Date: 18.1.16
 * Time: 21:08
 * 事例代码：
 * $db = new DB("localhost","root","password"); 创建一个数据库实例
 * $db->setDB("mysql");  选择一个操作的数据库
 * $db->select("db")->query(); 返回mysql数据库中的db表数据
 * $db->select("db")->field(array("host","db"))->query(); 返回mysql数据库中的db表host与db两栏数据
 * $db->delete("db")-where(array("host"=>"localhost"))->query(); 删除mysql数据库db表中host为localhost的全部数据
 * $db->insert("db")->values(array(xxx,xxx,xxx,xxx,...))->query(); 插入数据到数据表db中
 * $db->insert("db")->field(array("localhost","db"))->values(array(xxx,xxx,xxx,xxx))->query(); 插入数据到数据表db的localhost与db列中
 * $db->update("db")->set(array("localhost"=>"localhost"))->where(array("localhost"=>"127.0.0.1"))->query(); 将数据表db中localhost为127.0.0.1的字段修改为localhost
 */
class DB{

	private $db;

	private $sql;

	private $table;

	private $field;

	private $set;

	private $values;

	private $where;

	private $order;

	private $group;

	/**
	 * @var 用于参数绑定的type值
	 * 当绑定的参数有增加的时候，更新type的值
	 */
	private $type;

	/**
	 * @var array 用于参数绑定的参数值
	 * 当绑定的参数有增加的时候，更新param 数组的值，值放在param数组的最后
	 */
	private $param = array();

	function __construct($host, $username, $password){
		$mysqli = new mysqli($host, $username, $password);
		if ($mysqli->connect_errno) {
			die('Connect error (' . $mysqli->connect_errno . ')' . $mysqli->connect_error);
		} else {
			$mysqli->set_charset("utf8");
			$this -> db = $mysqli;
		}
	}

	/**
	 * 用于销毁sql执行后所存储的全部私有变量
	 */
	function destroy(){
		$this -> sql = null;
		$this -> table = null;
		$this -> field = null;
		$this -> set = null;
		$this ->values = null;
		$this -> where = null;
		$this -> order = null;
		$this -> group = null;
		$this -> type = null;
		$this -> param = array();
	}

	/**
	 * @param both_array $array
	 *  可以传递一个关联数组或者索引数组
	 *  会根据传递的数组自动生成匹配stmt_bind_param的参数
	 *  生成的参数形式 string $types , mixed &$var1 [, mixed &$... ]
	 */
	function getParam($array){
		$refsParam = array();
		$param = $this -> param;
		$param[0] = null;
		$this->type .= array_reduce($array, function(&$string, $item) use (&$param) {
			$param[] = $item;
			if( is_integer($item) ) $string .= "i";
			elseif( is_float($item) ) $string .="d";
			elseif( is_string($item) ) $string .="s";
			else $string .= "b";
			return $string;
		}, "");
		$param[0] = $this->type;
		foreach ($param as $key => $val ) $refsParam[$key] = &$param[$key];
		$this->param = $refsParam;
	}

	/**
	 * @param string $DB
	 * @return $this
	 *  选择用户操作的数据库，返回当前实例
	 */
	function setDB($DB){
		$this -> db -> select_db($DB);
		return $this;
	}

	/**
	 * @param string $table
	 * @return $this
	 * select查询语句
	 * field()方法为可选方法
	 * 最后必须执行query()方法
	 */
	function select($table){
		$this->table = $table;
		$this -> sql = "select * from {$table}";
		return $this;
	}

	/**
	 * @param both_array $field
	 * @return $this
	 *  选择查询或者插入的字段
	 *  此方法在执行的时候为可选方法
	 *   对于select语句 执行此方法后 select * from table 中的*将被替换限定查询的字段
	 *   对于insert语句 执行此方法后 insert into table values (...) table部分将增加限定的插入字段
	 */
	function field($field= null){
		$this->field =$field;
		$table = $this->table;
		if( is_array($field) )
			if( preg_match('/select(.*?)from(.*?)/i', $this->sql) )
			$this->sql = (function() use ($table, $field) {
				$fields = join(', ', $field);
				return "select {$fields} from {$table}";
			})();
			else
				$this->sql .= implode("", array("(", implode(", ", $field), ")" ) );
		return $this;
	}

	/**
	 * @param string $table
	 * @return $this
	 * update方法用于数据库字典的更新
	 * set() where() 以及query()是update所必须执行的方法
	 */
	function update($table){
		$this->table = $table;
		$this->sql = "update {$table}";
		return $this;
	}

	/**
	 * @param assoc_array $set
	 * @return $this
	 *  update的子方法，必须执行
	 */
	function set($set){
		$this->set=$set;
		$this->getParam($set);
		if (is_array($set) )
			$this-> sql =implode("", array($this->sql, " set ", implode(", ", (
			function () use ($set) {
				$sets = array();
				foreach ($set as $key => $val)
					$sets[] = implode(" = ", array($key, "?"));
				return $sets;
			}
			)())));
		return $this;
	}

	/**
	 * @param string $table
	 * @return $this
	 * delete用于删除数据库中的字段
	 * where() 以及 query()为必需执行方法
	 */
	function delete($table){
		$this->table = $table;
		$this->sql = "delete from {$table}";
		return $this;
	}

	/**
	 * @param  string $table
	 * @return $this
	 *insert用于插入字段到数据库中
	 * values()以及query()为必须指定的方法
	 */
	function insert($table){
		$this->table=$table;
		$this->sql = "insert into {$table}";
		return $this;
	}

	/**
	 * @param both_array $values
	 * @return $this
	 * insert的子方法，必须执行
	 */
	function values($values){
		$this->values = $values;
		if(count($values) == count($values, 1)) {
			$this->getParam($values);
			$this->sql .= implode("", array(" values ", "(", (
			function () use ($values) {
				if (count($values) > 0) $string = "?";
				else $string = null;
				for ($i = 1; $i < count($values); $i++)
					$string .= ", ?";
				return $string;
			}
			)(), ")"));
		} else {
			$value = array();
			foreach ($values as $array){
				$this->getParam($array);
				$value[] = implode("", array("(", (
				function () use ($array) {
					if (count($array) > 0) $string = "?";
					else $string = null;
					for ($i = 1; $i < count($array); $i++)
						$string .= ", ?";
					return $string;
				}
				)(), ")"));
			}
			$this->sql .=implode("", array(" values ", implode(",",$value)));
		}
		return $this;
	}

	/**
	 * @param assoc_array $where
	 * @return $this
	 * 用于数据库语句限定
	 */
	function where($where = null){
		$this -> where = $where;
		$this->getParam($where);
		$wheres = array();

		if( is_array($where) )
			foreach ($where as $key => $val)
				$wheres[] = implode(" = ", array($key, "?"));
		else
			return $this;

		$this->sql = implode(
			array(
				$this->sql,
				" where ",
				implode(" and ", $wheres)
			)
		);

		return $this;
	}

	/**
	 * @param string $keyWord
	 * @param string $type
	 * @return $this
	 * $keyword的值只应使用数据表的列名
	 * type参数只接受 asc 与desc
	 * 注意：order语句链接应放到最后执行
	 */
	function order($keyWord, $type = desc){
		$this->sql .=implode(" ", array(" order by", $keyWord, $type));
		return $this;
	}

	/**
	 * @param $keyWord
	 * @return $this
	 * 数据库语句限定
	 * 用于分组
	 */
	function group($keyWord){
		$this->sql .= implode(" ", array(" group by", $keyWord));
		return $this;
	}

	/**
	 * @param $limit
	 * @return $this
	 * 查询语句限定
	 * 用于限定查询结果的条数
	 */
	function limit($limit){
		$this->sql .= implode(" ", array(" limit", $limit ));
		return $this;
	}

	/**
	 * @return array
	 * 执行查询
	 * 如果是select将返回查询结果
	 * 其他查询将返回影响的行数
	 */
	function query(){
		$result = array();
		$stmt = $this -> db ->prepare($this->sql);
		if(count($this->param) > 0) call_user_func_array([$stmt, "bind_param"], $this->param);
		$stmt->execute();
		if( $queryResult =$stmt->get_result() )
			while( $rows = $queryResult->fetch_array(MYSQLI_ASSOC)) $result[] = $rows;
		else $result["affected_rows"] = $stmt->affected_rows;
		$stmt->close();
		$this->destroy();
		return $result;
	}

	/**
	 * 关闭数据库连接，由用户手动执行
	 */
	function close(){
		$this->db->close();
	}

}