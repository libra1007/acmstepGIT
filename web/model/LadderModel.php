<?php
	class LadderModel extends Model{
		function __construct(){
			parent::__construct();
			$this->_tableName = 'ladder';
			$this->_talbePk = 'ladder_id';
		}

		function addLadder($ladderInfo){
			$problemId = $ladderInfo['problem_id'];
			if ( $problemId < 1 || $problemId > 999 ){
				return false;
			}
			return $this->add($ladderInfo);
		}
	
		function getLadderList(){
			$fields = 'ladder_id';
			return $this->findAll(NULL,NULL,$fields);	
		}

		function getLadderInfo($lid){
			$conditions = array();
			$conditions['lid'] = $lid;
			return $this->find($condtions);
		}

		function getLadderInfoByPid($pid){
			$conditions = array();
			$conditions['problem_id'] = $pid;
			return $this->find($condtions);
		}

		function updateProblemId($lid,$pid){
			$conditions = array();
			$conditions['ladder_id'] = $lid;
			$field = 'problem_id';
			return $this->updateField($conditions, $field, $pid);	
		}

		function delLadder($lid){
			$conditions = array();
			$conditions['ladder_id'] = $lid;
			return $this->del($conditions);
		}

	}
?>
