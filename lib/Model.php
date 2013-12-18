<?php
/**
 * Created by silentium
 * Date: 13.12.13
 * Time: 17:13
 */

class Model {

	/**
	 * @var string
	 */
	public static $dataSourceType;
	public static $dataSourceParam;
	/**
	 * @var IDataSource
	 */
	protected static $_dataSource;


	public static $table = 'news';

	protected $_fields = array();

	protected $_data;


	protected static $initSQL;

	public $id;

	public function __construct(array $data = array()) {
		$this->_data = array_fill_keys($this->_fields, null);
		$this->_data = array_intersect_key(array_merge($this->_data, $data), $this->_data);
	}

	public function __get($key) {
		if (array_key_exists($key, $this->_data)) {
			return $this->_data[$key];
		}
		return null;
	}

	public function __set($key, $value) {
		if (!array_key_exists($key, $this->_data)) {
			throw new Exception(sprintf("Attribute '%s' is not defined in model %s", $key, get_class($this)));
		}
		$this->_data[$key] = $value;
	}

	public static function load($limit, $offset=0) {
		$res = static::getDataSource()->read(static::$table, $limit, $offset);
		array_walk($res, create_function('&$val, $key','$id=isset($val[\'id\'])?$val[\'id\']:$key;$val=new ' . get_called_class() . '($val);$val->id=$id;'));
		return $res;
	}

	public static function loadById($id) {
		if ($res = static::getDataSource()->getById(static::$table, $id)) {
			$res = new static($res);
			$res->id = $id;
		}
		return $res;
	}

	public function save() {
		if (is_null($this->id)) {
			$this->getDataSource()->add(static::$table, $this->_data);
		} else {
			$this->getDataSource()->edit(static::$table, $this->id, $this->_data);
		}
	}

	public function delete() {
		if (is_null($this->id)) {
			return;
		}

		$this->getDataSource()->delete(static::$table, $this->id);
	}


	/**
	 * @return IDataSource
	 */
	public static function getParentDataSource() {
		if (is_null(self::$_dataSource)) {
			self::$_dataSource = new self::$dataSourceType(self::$dataSourceParam);
		}
		return self::$_dataSource;
	}

	/**
	 * @return IDataSource
	 */
	public final static function getDataSource() {
		if (is_null(static::$_dataSource)) {
			if (static::$dataSourceType === self::$dataSourceType) {
				static::$_dataSource = static::getParentDataSource();
			} else {
				static::$_dataSource = new static::$dataSourceType(static::$dataSourceParam);
			}
		}
		return static::$_dataSource;
	}

} 