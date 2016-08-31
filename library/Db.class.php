<?php 
/**
* 数据库基类
*/
class Db
{
	protected $_dbHandle;
	protected $_result;

	public function connect($host,$user,$pass,$dbname)
	{
		try {
			//pdo连接方式
			$dsn = sprintf("mysql:host=%s;dbname=%s;charset=utf8",$host,$dbname);
			$this->_dbHandle = new PDO($dsn,$user,$pass,array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
		} catch (PDOException $e) {
			exit('错误:'.$e->getMessage());
		}
	}

	/**
	 * 查询所有的数据
	 * @return assoc 列索引列表
	 */
	public function selectAll()
	{
		$sql = sprintf("select * from `%s` ",$this->_table);
        echo $sql;
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute();

		return $sth->fetchAll();
	}

	/**
	 * 根据id查询一条数据
	 * @param  int $id 主键
	 * @return assoc     
	 */
	public function select($id)
	{
		$sql = sprintf("select * from `%s` where `id` = '%s' ",$this->_table,$id);
		$sth = $this->_dbHandle->prepare($sql);
		$sth->execute();

		return $sth->fetch();
	}

	/**
	 * 根据id删除纪律
	 * @param  int $id 主键
	 * @return assco     
	 */
	public function delete($id)
    {
        $sql = sprintf("delete from `%s` where `id` = '%s'", $this->_table, $id);
        $sth = $this->_dbHandle->prepare($sql);
        $sth->execute();

        return $sth->rowCount();
    }

    /**
     * 自定义查询sql
     * @param  string $sql 自定义sql
     * @return int         影响条数
     */
    public function query($sql)
    {
        $sth = $this->_dbHandle->prepare($sql);
        $sth->execute();

        return $sth->rowCount();
    }

    /**
     * 添加数据
     * @param array $data 对象
     */
    public function add($data)
    {
        $sql = sprintf("insert into `%s` %s", $this->_table, $this->formatInsert($data));

        return $this->query($sql);
    }

    /**
     * 修改数据
     * @param  int $id   主键
     * @param  array $data 数组
     * @return [type]       [description]
     */
    public function update($id, $data)
    {
        $sql = sprintf("update `%s` set %s where `id` = '%s'", $this->_table, $this->formatUpdate($data), $id);

        return $this->query($sql);
    }

    /**
     * 数组转化插入数据的sql形式
     * @param  arrary $data string
     * @return string       string
     */
    private function formatInsert($data)
    {
        $fields = array();
        $values = array();
        foreach ($data as $key => $value) {
            $fields[] = sprintf("`%s`", $key);
            $values[] = sprintf("'%s'", $value);
        }

        $field = implode(',', $fields);
        $value = implode(',', $values);

        return sprintf("(%s) values (%s)", $field, $value);
    }

    /**
     * 将数组转化成更新数据的sql形式
     * @param  array $data array
     * @return sql       sql
     */
    private function formatUpdate($data)
    {
        $fields = array();
        foreach ($data as $key => $value) {
            $fields[] = sprintf("`%s` = '%s'", $key, $value);
        }

        return implode(',', $fields);
    }

}