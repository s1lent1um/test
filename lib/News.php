<?php
/**
 * Created by silentium
 * Date: 13.12.13
 * Time: 17:12
 */

/**
 * Class News
 * @property string $title
 * @property string $text
 * @property $date_created
 * @property $date_edited
 */
class News extends Model {

	protected $_fields = array(
		'title',
		'text',
		'date_created',
		'date_edited',
	);



	public function save() {
		!is_null($this->date_created) or $this->date_created = date(DATE_SQL);
		$this->date_edited = date(DATE_SQL);
		parent::save();
	}


} 