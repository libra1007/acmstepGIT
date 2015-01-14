<?php
    class IndexController extends Controller {
        public function index() {
            if(isset($_SESSION['username'])) {
				$this->display('leisure');
            }
            else {
                $this->display('loginpage');
            }
        }
    }
?>
