<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    var $uses = array('Courses', 'User');


    public $components = array(
        'Session',
        'Auth' => array(
            'authenticate' => array(
                'Blowfish' => array(
                    'fields' => array('username' => 'email'),
                    //'scope' => array('User.is_active' => true)
                ),
            ),
        ),
    );
    
    public function beforeFilter(){
        parent::beforeFilter();
        App::import('Model', 'User');
        User::store($this->Auth->user());
    }

    public function beforeSave(){
        parent::beforeSave();
        return $this->setUserAndCourse($data);
    }
    
    private function setUserAndCourse($data){
        $data['user_id'] = User::get('id');
        $this->Course->recursive = -1;
        $data['course_id'] = $this->Course->findCurrent($data['user_id']);
        return $data;
    }
}
