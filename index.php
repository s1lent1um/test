<?php
/**
 * Created by silentium
 * Date: 12.12.13
 * Time: 18:55
 */
include 'lib/core.php';

$config = array(
	'connectionString' => '',
	'dataSourceType' => 'FileDataSource',
	'initSql' => '',
	'tables' => array('news'),
);
$config = array_merge($config, include 'config.php');
Model::$dataSourceType = $config['dataSourceType'];
Model::$dataSourceParam = $config['connectionString'];
$dataSource = Model::getDataSource();
if (method_exists($dataSource, 'initialize')) {
	$dataSource->initialize($config['tables'], $config['initSql']);
}
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'index';

switch ($action) {
	case 'add':
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$news = new News($_POST);
			$news->save();
			header('Location: /');
			die;
		}
		die ('Something\'s wrong');

	case 'edit':
		if (!isset($_REQUEST['id'])) { // zero possible
			die ('id required');
		}
		$id = (int) $_REQUEST['id'];
		$news = News::loadById($id);
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST['delete'])) {
				$news->delete();
				header('Location: /');
			} else {
				empty($_POST['title']) or $news->title = $_POST['title'];
				empty($_POST['text']) or $news->text = $_POST['text'];
				$news->save();
				header('Location: /?action=edit&id=' . $id);
			}
			die;
		}
		include 'edit.php';
		break;

	case 'index':
	default:
		/* @var News[] $news */
		$news = News::load(10);
		include 'list.php';

}

