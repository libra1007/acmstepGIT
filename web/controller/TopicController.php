<?php
    class LeisureController extends Controller{

        public function showLeisureList(){

			if (!isset($_SESSION['username'])){
				$this->display('loginpage');
			}
			else{

				$leisureModel = M('Leisure');
				
				$topicList = $leisureModel->getTopicList();
				
				$pid = $_GET['pid'];
				$uid = $_SESSION['uid'];
				$newTopicList = $this->getPage($pid, 20, $topicList);

				$this->assign('uid', $uid);
				$this->assign('pid', $pid);
				$this->assign('hasPre', $newTopicList['hasPre']);
				$this->assign('hasNext', $newTopicList['hasNext']);
				$this->assign('rows', $newTopicList['rows']);
				$this->display('leisure');
			}
        }

		public function showProblemList(){
				
			if (!isset($_SESSION['username'])){
				$this->display('loginpage');
			}
			else{
				$lid = $_GET['lid'];
				$pid = $_GET['pid'];

				$leisureModel = M('Leisure');
				$topicInfo = $leisureModel->getTopicInfo($lid);
				
				$problemIds = 	

				$problemModel = M('Problem');
			
				$problemList = $leisureModel->findAll();
				$pid = $_GET['pid'];
				$uid = $_SESSION['uid'];
				 		
			}
		}

    } 
?>
