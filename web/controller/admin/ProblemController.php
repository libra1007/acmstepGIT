<?php
	class ProblemController extends Controller {
		public function addProblemPage() {
			$this->checkAdmin();
			$this->display('addproblempage');
		}

		public function addProblem() {
			$this->checkAdmin();
			$problemModel = M('Problem');
			$problemInfo = $_POST;
			$problemInfo['solve_times'] = 0;
			$problemInfo['submit_times'] = 0;
			$pid = $problemModel->addProblem($problemInfo);
			if($pid === FALSE) {
				$this->error('add problem failed', U('Problem', 'showProblemList').'&pid=1');
			}
			else {
				$this->success('add problem success', U('Problem', 'showProblemList').'&pid=1'); 
			}
		}

		public function delProblem() {
			$this->checkAdmin();
			$problemModel = M('Problem');
			$pid = $_GET['pid'];;
			$status = $problemModel->delProblem($pid);
			if($status === FALSE) {
				$this->error('del problem failed', U('Problem', 'showProblemList').'&pid=1');
			}
			else {
				$this->success('del problem success', U('Problem', 'showProblemList').'&pid=1'); 
			}
		}

		public function updateProblem() {
			$this->checkAdmin();
			$problemModel = M('Problem');
			$problemInfo = $_POST;
			$status = $problemModel->updateProblem($problemInfo);
			if($status === FALSE) {
				$this->error('update problem failed', U('Problem', 'showProblem')."&pid={$problemInfo['problem_id']}");
			}
			else {
				$this->success('update problem success', U('Problem', 'showProblem')."&pid={$problemInfo['problem_id']}"); 
			}
		}

		public function showProblem() {
			$this->checkAdmin();
			$pid = $_GET['pid'];;
			$problemModel = M('Problem');
			$problemInfo = $problemModel->getProblemInfo($pid);
			if($problemInfo === FALSE) {
				$this->error('show problem failed', U('Problem', 'showProblemList').'&pid=1');
			}
			else {
				$this->assign('problemInfo', $problemInfo);
				$this->display('editproblem');
			}
		}

		public function showProblemList() {
			$this->checkAdmin();
			$pid = $_GET['pid'];;
			$problemModel = M('Problem');
			$problemRows = $problemModel->getProblemList();
			$problemRows = $this->getPage($pid, 20, $problemRows); 
			if($problemRows === FALSE) {
				$this->error('show problem list failed', U('Problem', 'showProblemList').'&pid=1');
			}
			else {
				$this->assign('problemList', $problemRows['rows']);
				$this->display('showproblemlist');
			}
		}
	}
?>
