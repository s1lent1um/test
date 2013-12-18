<?php
/**
 * Created by silentium
 * Date: 12.12.13
 * Time: 19:20
 */

class FileDataSource implements IDataSource {

	const DELIMITER = "\n-------\n";

	public function getById($table, $id) {
		$records = file_get_contents($table . '.txt');
		$records = explode(static::DELIMITER, $records);
		return isset($records[$id]) ? unserialize(trim($records[$id])) : false;
	}


	public function read($table, $limit, $offset=0) {
		$records = file_get_contents($table . '.txt');
		$records = explode(static::DELIMITER, $records);
		$records = array_slice($records, -$offset - $limit, $limit);
		$records = array_map(function ($v) {
			return unserialize(trim($v));
		}, $records);
		return array_reverse($records);
	}


	public function add($table, $data) {
		$filename = $table . '.txt';
		$data = serialize($data);
		!file_exists($filename) or $data = static::DELIMITER . $data;
		file_put_contents($filename, $data, FILE_APPEND);
	}

	public function edit($table, $id, $data) {
		$filename = $table . '.txt';
		$records = file_get_contents($filename);
		$records = explode(static::DELIMITER, $records);
		$records[$id] = serialize($data);
		file_put_contents($filename, implode(static::DELIMITER, $records));
	}

	public function delete($table, $id) {
		$filename = $table . '.txt';
		$records = file_get_contents($filename);
		$records = explode(static::DELIMITER, $records);
		if (isset($records[$id])) {
			unset($records[$id]);
		}
		file_put_contents($filename, implode(static::DELIMITER, $records));
	}


}