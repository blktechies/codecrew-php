<?php
App::uses('QuestionTag', 'Model');

/**
 * QuestionTag Test Case
 *
 */
class QuestionTagTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.question_tag',
		'app.question',
		'app.user',
		'app.answer',
		'app.comment',
		'app.comments_questions',
		'app.vote',
		'app.course',
		'app.teacher',
		'app.enrollments',
		'app.course_user',
		'app.tag'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->QuestionTag = ClassRegistry::init('QuestionTag');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->QuestionTag);

		parent::tearDown();
	}

}
