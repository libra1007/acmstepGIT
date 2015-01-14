<?php
	class UserModel extends Model{
		function __construct() {
			parent::__construct();
			$this->_tableName = 'user';
			$this->_tablePk = 'user_id';
		}
	
		function getUserInfo($uid){

			$field = 'user_id';
		    $rows = $this->findBy($field, $uid);	
			return $rows;
		}

		function getUserByUsername($username){
			$field = 'username';
			return $this->findBy($field, $username);
		}

		function getAllUsers(){
				
			$sort = "user_id DESC";
			$rows = $this->findAll(NULL, $sort);
			return $rows;
		}

		function addUser($userInfo){

			if ( NULL == $userInfo['username'] || NULL == $userInfo['password'] ){
				return false;
			}

			$newUser = array();
			$newUser['username'] = $userInfo['username'];
			$newUser['password'] = $userInfo['password'];
			$newUser['register_time'] = $userInfo['register_time'];

			return $this->add($newUser);
		}

		function updateUserState($userId, $field, $value){

			$conditions = array();
			$conditions['user_id'] = $userId;
			return $this->updateField($conditions, $field, $value);	
		}

		function updateUserInfo($info){
				
			$conditions = array();
			$conditions['user_id'] = $info['user_id'];
			return $this->update($conditions, $info);
		}

		function delUser($uid){

			$conditions = array();
			$conditions['user_id'] = $uid;		
			return $this->del($conditions);
		}
		
	}

?>
