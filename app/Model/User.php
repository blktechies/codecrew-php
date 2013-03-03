<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property Answer $Answer
 * @property Comment $Comment
 * @property Question $Question
 * @property Vote $Vote
 */
class User extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'first' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'last' => array(
			'alphanumeric' => array(
				'rule' => array('alphanumeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'password' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'dob' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'lastlogin' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'created' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'modified' => array(
			'datetime' => array(
				'rule' => array('datetime'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'modifiedby' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Answer' => array(
			'className' => 'Answer',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'Comment' => array(
			'className' => 'Comment',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'Question' => array(
			'className' => 'Question',
			'foreignKey' => 'user_id',
			'dependent' => false,
		),
		'Vote' => array(
			'className' => 'Vote',
			'foreignKey' => 'user_id',
			'dependent' => false,
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Courses' => array(
			'className' => 'CoursesUser',
			'joinTable' => 'courses_users',
			'foreignKey' => 'users.id',
			'associationForeignKey' => 'courses.id',
			'unique' => 'keepExisting',
			'conditions' => '',
		),
            	'CurrentCourse' => array(
			'className' => 'CoursesUser',
			'joinTable' => 'courses_users',
			'foreignKey' => 'users.id',
			'associationForeignKey' => 'courses.id',
			'unique' => 'keepExisting',
			'conditions' => '',
		),

	);

/** Methods for getting Current User in Model Functions **/


    private function &getInstance($user=null) {
      static $instance = array();

      if ($user) {
        $instance[0] =& $user;
      }

      if (!$instance) {
        trigger_error(__("User not set.", true), E_USER_WARNING);
        return false;
      }

      return $instance[0];
    }

    public function store($user) {
      if (empty($user)) {
        return false;
      }

      User::getInstance($user);
    }

    public function get($path) {
      $_user =& User::getInstance();
      
      $path = str_replace('.', '/', $path);
      if (strpos($path, 'User') !== 0) {
        $path = sprintf('User/%s', $path);
      }

      if (strpos($path, '/') !== 0) {
        $path = sprintf('/%s', $path);
      }


      $value = Set::extract($path, $_user);

      if (!$value) {
        return false;
      }
      
      return $value[0];
    }

/** Model Callbacks **/

    public function beforeSave($options = array()) {
        // Use bcrypt
        if (isset($this->data['User']['password'])) {
            $hash = Security::hash($this->data['User']['password'], 'blowfish');
            $this->data['User']['password'] = $hash;
        }
        return true;
    }

/** Functions **/

}
