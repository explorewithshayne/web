<?php

if (!defined('ABSPATH')) exit;

class astound_chkperiods  extends astound_module { 
	public function process($ip,&$stats=array(),&$options=array(),&$post=array()) {
		if (array_key_exists('email',$post)) {
			$email=$post['email'];
			if (!empty($email)) {
				$email=substr($email,0,strpos($email,'@'));
				if (substr_count($email, ".")>1) {
					return "too many periods in: $email";
				}
			}
		}
		if (array_key_exists('user_email',$post)) {
			$email=$post['user_email'];
			if (!empty($email)) {
				$email=substr($email,0,strpos($email,'@'));
				if (substr_count($email, ".")>1) {
					return "too many periods in: $email";
				}
			}
		}
		return false;
	}
}
?>