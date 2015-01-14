<?php
	$CONFIGURE = array(
	      'db' => array(
		  'host' => '192.168.1.3', // 数据库地址
          'port' => '3306',        // 端口
		  'database' => 'acmstep',  //数据库名称
		  'user' => 'root',     // 用户名
		  'password' => 'vj123456',      // 密码
		)
	);
	$con = mysql_connect($CONFIGURE['db']['host'], $CONFIGURE['db']['user'], $CONFIGURE['db']['password']);
	if (!$con) {
		die('Could not connect: ' . mysql_error());
	} else {
		echo "Success";
		mysql_close($con);
	}
?>
