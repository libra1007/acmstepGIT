<?php
    class CodeController extends Controller {
        function submit() {
            if(!isset($_SESSION['username'])) {
                $this->display('loginpage');
            }
            else {
                $pid = $_GET['pid'];
                $this->assign('pid', $pid);
                $this->assign('username', $_SESSION['username']);
                $this->display('submit');
            }
        }
        function submitCode() {

        }
        function status() {
            if(!isset($_SESSION['username'])) {
                $this->display('loginpage');
            }
            else {
                $pid = $_GET['pid'];
                $uid = $_SESSION['uid'];
                $username = $_SESSION['username'];
                $codeModel = M('Code');
                $result = $codeModel->getByUid($uid);
                var_dump($result);
                $result = $this->getPage($pid, $result);
                $this->assign('uid', $uid);
                $this->assign('username', $username);
                $this->assign('hasPre', $result['hasPre']);
                $this->assign('hasNext', $result['hasNext']);
                $this->assign('pid', $result['pid']);
                $this->assign('rows', $result['rows']);
                $this->display('status');
            }
        }
    }
?>
