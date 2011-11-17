<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/connection.php');

class auth {

	var $logged = false;
	var $is_admin = 0;
	var $email = '';

	
	function auth() {
		session_start();
		if (isset($_SESSION['auth']['email'])) {
			$this->email = $_SESSION['auth']['email'];
			$this->logged = true;
		} else {
			if (isset($_COOKIE['auth']['email'])) {
				$email = $_COOKIE['auth']['email'];
				$passwd_sha1 = $_COOKIE['auth']['passwd'];

				if ($this->check_login($email, $passwd_sha1)) {
					$_SESSION['auth']['email'] = $email;
					$this->email = $email;
					$this->logged = true;
					$this->reset_visit();
				} else {
					$this->logged = false;
				}

			} else {
					$this->logged = false;
			}
		}
		$this->load_info();
	}


	function load_info() {
		if ($this->logged) {
			global $con;
			$sql = "select * from users where email = '". $this->email . "'";
			$result = mysql_query($sql, $con);
			$row = mysql_fetch_array($result);
			$this->is_admin = $row['is_admin'];
			$_SESSION['auth']['is_admin'] = $this->is_admin;
		}
	}


	function login($email, $password, $save = false) {
		$this->logout();
		
		$sha1_password =  sha1($password);

		if ($this->check_login($email, $sha1_password)) {

			$_SESSION['auth']['email'] = $email;
			$this->email = $email;
			$this->logged = true;

			$this->load_info();
			$this->reset_visit();

			if ($save) {
				$this->cookie('auth[email]' , $email);
				$this->cookie('auth[passwd]', $sha1_password);
			}
		}

		return $this->logged;
	}
 
	function logout() {
		if ($this->logged == false)
			return;

		$this->cookie('auth[email]' , '');
		$this->cookie('auth[passwd]', '');

		//$this->email = '';
		$this->is_admin = 0;
		$this->logged = false;
		session_destroy();
	}

	function check_login($email, $sha1_password) {
		global $con;
		$sql = "select * from users where email = '". mysql_real_escape_string($email) . "'";
		$result = mysql_query($sql, $con);
		$row = mysql_fetch_array($result);

		if (mysql_num_rows($result) == 0) {
			return false;
		}

		if ($sha1_password == $row['passwd']) {
			return true;
		}

		return false;
	}

	function reset_visit() {
		global $con;
		$sql = "update users set last_login = now() where email = '". $this->email . "'";
		mysql_query($sql, $con);
	}
	
	function cookie($name, $value) {
		$expire = time() + 60*60*24*30; //expire in 30 days
		return setcookie($name, $value, $expire, "/");
	}
}
	
	$auth = new auth;
?> 