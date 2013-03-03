<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
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
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Model', 'Model');
App::uses('Behavior', 'Containable');
/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    /**
     * Inserts current course on save
     * @param array $data
     * @return array
     */
    public function addCourse($data, $user_id = null){
        if(!$user_id) {
            User::get('id');
        }
        
        $model= $this->name;
        if(!$this->Course){
            App::import('Model', 'Course');
            $this->Course = new Course();
        }
        $this->Course->recursive=-1;
        $course = $this->Course->findCurrent($user_id);
        if(isset($data[0])){
            foreach ($data as $id=>$datum){
                $datum[$id]['course_id'] = $course;
            }
        } else {
            $data[$model]['course_id'] = $course;
        }
        return $data;
    }

    /**
     * Inserts current user id on save
     * @param array $data
     * @return array
     */
    public function addUser($data, $user_id = null){
        if(!$user_id) {
            User::get('id');
        }
        if(!empty($data[0])){
            foreach ($data as $id=>$datum){
                $datum[$id]['user_id'] = $user_id;
            }
        }
        return $data;
    }

    /**
     * Model Default beforeFilter
     * @param array $queryData
     * @return array
     */
    public function beforeFind($queryData){
        parent::beforeFind($queryData);
        return $this->secureFind($queryData);
    }

    public function beforeSave($data){
        $data = $this->addUser($data);
        $data = $this->addCourse($data);
        return $data; //$this->checkAccess();
    }

    function rand_string($length) {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        return substr(str_shuffle($chars),0,$length);
    }

    /**
     * Secures all searches in the application
     * @param array queryData
     * @param bool checkVirtual check virtual fields too
     * @return array
     */
    public function secureFind($queryData, $checkVirtual = true){
        
        //does the object have a course_id?
        $model = $this->name; //set model name
        if(!$this->$model){
            App::import('Model', $model);
            $this->$model = new $model;
        }

        if($this->$model->hasField('course_id', $checkVirtual)){
            //does the user have courses & is he in the course?
            
                if(empty($queryData['conditions']['course_id'])){
                    $queryData['conditions']['course_id'] = 1;
                }
        } else { //no course field so we check for a user_id
            
            if( ($this->$model->hasField('user_id', $checkVirtual))
                    && !$this->Auth->user('admin')){
                 if(!($queryData['conditions']['user_id'])){
                    $queryData['conditions']['user_id'] = $this->Auth->user('id');
                }
            }
        }
        return $queryData;
    }
}
