<?php
	class ProblemController extends Controller {
		public function showProblem() {

			if (!isset($_SESSION['username'])) {
				$this->display('loginpage');
			} else {
				$problemId = $_REQUEST['pid'];
				$problemModel = M('Problem');
				$problemInfo = $problemModel->getProblemInfo($problemId);
				if ($problemInfo === FLASE) {
					$this->printErrorLog(mysql_error());
					echo "show failed";
				}
				else {
					$this->assign('problemInfo', $problemInfo);
					$this->display('showproblem');
				}
			}
		}
	}
?>

