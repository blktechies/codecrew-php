<?php
App::uses('AppModel', 'Model');
/**
 * Course Model
 *
 * @property Teacher $Teacher
 * @property Question $Question
 * @property enrollments $enrollments
 */
class Course extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'maxlength' => array(
				'rule' => array('maxlength', 45),
				//'message' => 'Your custom message here',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'start' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'end' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				'allowEmpty' => false,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'details' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please include details about the course.',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
    );

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Teacher' => array(
			'className' => 'User',
			'foreignKey' => 'teacher_id',
                        'table'=> 'users',
			'conditions' => ' Teacher.admin = true',
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Question' => array(
			'className' => 'Question',
			'foreignKey' => 'course_id',
			'dependent' => false,
		)
	);


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Users' => array(
			'className' => 'CoursesUser',
			'joinTable' => 'courses_users',
			'foreignKey' => 'user_id',
			'associationForeignKey' => 'course_id',
			'unique' => 'keepExisting',
		)
	);

        /*** Call Backs ***/
        public function beforeSave(){
            $this->data = parent::beforeSave($this->data);
            //set registration code for inserts.
            if(!$this->id){
                $this->data['Course']['regcode'] = $this->rand_string(8);
            }
            App::import('Model', 'User');
            $this->User = new User();
            $this->data['Course']['modifiedby'] = $this->User->get('id');
            debug( User::get('id') );
            die();
            return $this->data;
        }

        public function beforeFind($queryData){
            parent::beforeFind($queryData);
        }

        public function findCurrent($user_id){
            return true;
        }

        public function getStudentCurrentCourse($user_id){

            $conditions = array(
                0=> 'Course.start > current_date()',
                1=> 'Course.end < current_date()',
                'CouresUser.user_id'=>$user_id,
            );

            $this->Behaviors->load('Containable');
            $this->contain(array('User','CoursesUser'));
            $this->CourseStudents->recursive = 1;
            return $this->CourseStudents->find('first', $conditions);
        }
}
