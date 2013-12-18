<?php
/**
 * Created by silentium
 * Date: 12.12.13
 * Time: 19:19
 */

interface IDataSource {

	public function read($table, $limit, $offset = 0);

	public function getById($table, $id);

	public function add($table, $data);

	public function edit($table, $id, $data);

	public function delete($table, $id);

}