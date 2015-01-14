<?php
	class UserController extends Controller {
        function login() {
			if(isset($_SESSION['username']) && $_SESSION['user_type'] == 1) {
				$this->display('admin');
			}
			else {
				$UserModel = M('User');
				$UserInfo = $UserModel->getUserByUsername($_POST['username']);
				if(empty($UserInfo) || $UserInfo['password'] != $_POST['password']) {
					$this->error('password is wrong');
				}
				if($UserInfo['user_type'] != 1) {
					$this->error('user_type is wrong');
				}
				$_SESSION['username'] = $UserInfo['username'];
				$_SESSION['uid'] = $UserInfo['user_id'];
				$_SESSION['user_type'] = $UserInfo['user_type'];
				$this->success('log success', U('User', 'login'));
			}
        }

		function logout() {
			$this->checkAdmin();
			session_destroy();
			$this->success('logout success', U('Index', 'index'));
		}

		

		function delUser() {
			$this->checkAdmin();
			$uid = $_GET['uid'];
			$userModel = M('User');
			$userInfo = $userModel->getUserInfo($uid);
			if(!empty($userInfo)) {
				$userModel->delUser($uid);
			}
		}

		function editUserInfo() {
			$this->checkAdmin();
			$userModel = M('User');
			$userInfo = $_POST;
			if(!empty($userInfo)) {
				$status = $userModel->updateUserInfo($userInfo);
				if($status !== false) {
					$this->success('update success', U('User', 'getUserList')."&uid={$_POST['uid']}");
				}
				else {
					$this->error('updata failed', U('User', 'getUserList')."&uid={$_POST['uid']}");
				}
			}
		}

		function editUser() {
			$this->checkAdmin();
			dump($_POST);
			$uid = $_GET['uid'];
			$userModel = M('User');
			$userInfo = $userModel->getUserInfo($uid);
			$this->assign('userInfo', $userInfo);
			$this->display('edituserinfo');
		}

		function getUserList() {
			$this->checkAdmin();
			$pid = isset($_GET['pid']) ? $_GET['pid'] : 1;
			$userModel = M('User');
			$userRows = $userModel->getALLUsers();
			$userRows = $this->getPage($pid, 20, $userRows); 
			$this->assign('userRows', $userRows);
			$this->display('userlist');
		}
	}
?>
