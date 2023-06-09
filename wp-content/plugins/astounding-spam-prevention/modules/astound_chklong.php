<?php

if (!defined('ABSPATH')) exit;

class astound_chklong  extends astound_module { 
	public function process($ip,&$stats=array(),&$options=array(),&$post=array()) {
		$this->searchname='email/author/password too long';
		if (array_key_exists('email',$post)) {
			$email=$post['email'];
			if (!empty($email)) {
				if (strlen($email)>64) {
					return "email too long:$email";
				}
			}
		}
		if (array_key_exists('user_email',$post)) {
			$email=$post['user_email'];
			if (!empty($email)) {
				if (strlen($email)>64) {
					return "email too long:$email";
				}
			}
		}
		if (array_key_exists('author',$post)) {
			if (!empty($post['author'])) {
				$author=$post['author'];
				if (strlen($post['author'])>64) {
					return "author too long:$author";
				}
			}
		}
		if (array_key_exists('psw',$post)) {
			if (!empty($post['psw'])) {
				$psw=$post['psw'];
				if (strlen($post['psw'])>32) {
					return "Password too long: $psw";
				}
			}
		}
		return false;
	}
}
?>