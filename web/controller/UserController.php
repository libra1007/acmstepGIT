<?php
	class UserController extends Controller {

		function checkSqlError($con) {
			if ($con === FALSE) {
				$this->printfErrorLog(mysql_error());
				return;
			}
		}
		function login() {
			if (empty($_POST['username'])) {
				$this->assign('login_error', 'username is error');
				$this->display('loginpage');
				return;
			}
			else {
				unset($login_error);
				$userModel = M('User');
				$userInfo = $userModel->getUserByUsername($_POST['username']);
				if (empty($userInfo) || $userInfo['password'] != $_POST['password']) {
					$this->assign('login_error', 'username or password is error!');
					$this->display('loginpage');
					return;
				}
				else {
					$_SESSION['username'] = $_POST['username'];
					$_SESSION['uid'] = $userInfo['uid'];
					$this->display('leisure');
				}
			}
		}

		function logout() {
			session_destroy();
			$this->display('loginpage');
		}

		function assignUserInfo() {
			$this->assign('register_error', 'username is exist');	
			$this->assign('username', $_REQUEST['username']);
			$this->assign('motto', $_REQUEST['motto']);
			$this->assign('sex', $_REQUEST['sex']);
			$this->assign('email', $_REQUEST['email']);
			$this->assign('nickname', $_REQUEST['nickname']);
			$this->assign('realname', $_REQUEST['realname']);
			$this->assign('age', $_REQUEST['age']);
			$this->assign('school', $_REQUEST['school']);	
			$this->assign('class', $_REQUEST['class']);
			$this->assign('qq', $_REQUEST['qq']);
			$this->assign('major', $_REQUEST['major']);
			$this->display('register');	
		}

		function register() {

			if (isset($_SESSION['username'])) {
				$this->error('you need logout first',U('User','login'));
			}
			$userModel = M('User');
			$arr = $userModel->getUserByUsername($_POST['username']);
			if (!empty($arr)) {
				$this->error('用户已存在');
			}

			$con['username'] = $_POST['username'];
			$con['password'] = $_POST['password'];
			$con['register_time'] = getTime(); 

			if ( $userModel->addUser($con) ){
				$this->success('注册成功！');
			}
			else{
				$this->error('register failed for some reasons -o-!');
			}
			
		}

		function getUserInfo() {
			if (!isset($_SESSION['username'])) {
				$this->display('loginpage');
				return;
			}
			$uid = $_GET['uid'];
			$userModel = M('User');
			$userInfo = $userModel->getUserInfo($uid);
			checkSqlError($userInfo);
			if (!empty($userInfo)) {
				$this->assign('userInfo', $userInfo);
				dump($userInfo);
			}
			else echo 'no such User';
		}

		function updateUserInfo() {
			if (!isset($_SESSION['username'])) {
				$this->display('loginpage');
				return;
			}
			$userModel = M('User');
			$result = $userModel->upadateUserInfo($_POST);
			checkSqlError($result);
		}	
	}	

?>
