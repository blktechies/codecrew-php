<?php
/**
 * QuestionTagFixture
 *
 */
class QuestionTagFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'question_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'tag_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'modified' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 45, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'modifiedby' => array('type' => 'integer', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'question_id' => 1,
			'tag_id' => 1,
			'created' => 'Lorem ipsum dolor sit amet',
			'modified' => 'Lorem ipsum dolor sit amet',
			'modifiedby' => 1
		),
	);

}
