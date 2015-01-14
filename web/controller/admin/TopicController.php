<?php
class TopicController extends Controller{
	function addTopicPage(){
		$this->checkAdmin();
		$this->display('addtopicpage');
	}

	function addTopic(){
		$this->checkAdmin();
		$topicModel = M('Topic');	
		$TopicInfo = $_POST;
		$tid = $topicModel->addTopic($TopicInfo);
		if ( $tid == false ){
			$this->error('add topic failed',U('Topic','showTopicList').'&pid=1');
		}
		else{
			$this->success('add topic success',U('Topic','showTopicList').'&pid=1');
		}
	}

	function delTopic(){
		$this->checkAdmin();
		$topicModel = M('Topic');
		$tid = $_GET['tid'];
		$res = $topicModel->delTopic($tid);
		if ( $res == false ){
			$this->error('del topic failed', U('Topic','showTopicList').'&pid=1');
		}
		else{
			$this->success('del topic success',U('Topic','showTopicList').'&pid=1');
		}
	}

	function showTopicList(){
		$this->checkAdmin();
		$pid = $_GET['pid'];	
		$topicModel = M('Topic');
		$topicRows = $topicModel->getTopicList();
		$topicRows = $this->getPage($pid, 20, $topicRows);
		if ( $topicRows == false ){
			$this->error('get topiclist failed',U('Index','index'));
		}
		else{
			$this->assign('topicList',$topicRows);	
			$this->display('topiclist');
		}
	}

	function editTopic(){
		$this->checkAdmin();
		$tid = $_GET['tid'];			
		$topicModel = M('Topic');
		$topicInfo = $topicModel->getTopicInfo($tid);				
		if (empty($topicInfo)){
			$this->error('get topicinfo failed',U('Topic','showTopicList').'$pid=1');
		}
		else{
			if (!empty($topicInfo['problem_ids'])){
				$problemList = explode(',',$topicInfo['problem_ids']);			
				$problemModel = M('Problem');

				foreach ($problemList as $pid){
					$problemName = $problemModel->getProblemNameById($pid);
					if ($problemName != NULL){
						$topicInfo['problemlist'][$pid] = $problemName;
					}
				}
			}
			else{
				$topicInfo['problemlist'] = array();
			}
			$this->assign('topicinfo',$topicInfo);
			$this->display('edittopic');
		}			
	}

	function addTopicProblem(){
		$this->checkAdmin();
		$tid = $_POST['tid'];
		$pid = $_POST['problem_id'];
		$topicModel = M('Topic');	
		$problemModel = M('Problem');
		$topicInfo = $topicModel->getTopicInfo($tid);
		$problemName = $problemModel->getProblemNameById($pid);
		if (NULL == $problemName){
			$this->error('add Problem failed, problem not existed!'); 
		}
		else{
			$problemIds = $topicInfo['problem_ids'];
			if (strchr($problemIds,$pid) == true){
				$this->error('add Problem failed, problem has existed!');
			}
			if (NULL == $problemIds){
				$problemIds = $pid;		
			}
			else{
				$problemIds = $problemIds.",".$pid;
			}
			if ($topicModel->updateTopicField($tid, 'problem_ids', $problemIds) == true){
				$this->success('Add Problem Success!',U('Topic','editTopic')."&tid=".$tid);
			}
			else{
				$this->error('add Problem failed!'); 
			}
		}
	}

	function delTopicProblem(){
		$this->checkAdmin();
		$tid = $_GET['tid'];
		$pid = $_GET['pid'];		
		$topicModel = M('Topic');	
		$topicInfo = $topicModel->getTopicInfo($tid);
		if (!empty($topicInfo['problem_ids'])){
			$problemList = explode(',',$topicInfo['problem_ids']);			
			$newProblemList = array();
			foreach ($problemList as $id){
				if ( $id != $pid ){
					$newProblemList [] = $id;
				}
			}
			$problemIds = implode(',',$newProblemList);
			if ($topicModel->updateTopicField($tid, 'problem_ids', $problemIds)){
				$this->success('del Problem success!');
			}
			else{
				$this->error('del Problem failed!');
			}
		}
		$this->error('del Problem failed!');
	}
} 
?>
