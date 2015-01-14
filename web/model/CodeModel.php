<?php
class CodeModel extends Model{
    function __construct(){
        parent::__construct();
        $this->_tableName = 'code';
        $this->_tablePk = 'code_id';
    }       

    public function getByProbledmId($problemId = NULL){

        $conditions = array();
        $conditions []= array('problem_id' => $problemId);
        $sort = "run_time, run_memory, code_length";
        $list = array();
        $list = $this->findAll($conditions, $sort);
        return $list; 
    }
    
    public function getByUid($uid = NULL) {
        $conditions = array();
        $conditions['user_id'] = $uid;
        //$conditions []= array('user_id' => $uid);
        $sort = "code_id DESC";
        $list = array();
        $list = $this->findAll($conditions, $sort); 
        return $list;
    }

    public function add(){

    }

}   
?>
