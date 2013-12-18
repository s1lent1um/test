<?php
/**
 * Created by silentium
 * Date: 16.12.13
 * Time: 2:58
 */

class SqlDataSource implements IDataSource {
	/**
	 * @var PDO
	 */
	protected $_pdo;


	public function connect($connectionString) {
		$this->_pdo = new PDO($connectionString);
		$this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function __construct($connectionString = null) {
		$this->connect($connectionString);
	}

	public function initialize($tables, $initSQL) {
		if (empty($tables) || empty($initSQL)) {
			return;
		}
		$sql = "SELECT * FROM information_schema.tables WHERE table_name IN (" . implode(',', array_map([$this->_pdo, 'quote'], $tables)) . ")";
		if ($this->_pdo->query($sql)->rowCount() !== count($tables)) {
			$this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0);
			$this->_pdo->exec($initSQL);
		}
	}


	public function add($table, $data) {
		$keys = array_keys($data);
		$params = array_map(function ($v) { return ':' . $v; }, $keys);
		$data = array_combine($params, array_values($data));
		$keys = implode(', ', $keys);
		$params = implode(', ', $params);
		$sql = "INSERT INTO \"$table\" ($keys) VALUES ($params)";
		$this->_pdo->prepare($sql)->execute($data);
	}

	public function read($table, $limit, $offset = 0) {
		$limit += 0; // shorter than $limit = (int)$limit;
		$offset += 0;
		$sql = "SELECT * FROM \"$table\" ORDER BY id DESC LIMIT $limit OFFSET $offset";
		return $this->_pdo->query($sql)->fetchAll();
	}

	public function getById($table, $id) {
		$data = array(':id' => (int)$id);
		$sql = "SELECT * FROM \"$table\" WHERE id=" . $id;
		return $this->_pdo->prepare($sql)->execute($data)->fetch();
	}

	public function edit($table, $id, $data) {
		$id += 0;
		$keys = array_keys($data);
		$params = array_map(function ($v) { return ':' . $v; }, $keys);
		$set = array_map(function($k, $p) { return $k . '=' . $p; }, $keys, $params);
		$data = array_combine($params, array_values($data));
		$data[':id'] = $id;
		$set = implode(', ', $set);
		$sql = "UPDATE \"$table\" SET $set WHERE id=:id";
		$this->_pdo->prepare($sql)->execute($data);
	}

	public function delete($table, $id) {
		$data = array(':id' => (int)$id);
		$sql = "DELETE FROM \"$table\" WHERE id=:id";
		$this->_pdo->prepare($sql)->execute($data);
	}


} 