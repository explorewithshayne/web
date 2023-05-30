<?php

namespace xmlSitemapGenerator;

class Helpers {

      // used for reading object properties with a default
      public static function safeRead2($object, $property, $default) {
		if (isset( $object->{$property} )) {return esc_attr($object->{$property});}
            return $default; 
	}

      // read object property without a default
	public static function safeRead($object,$property)	{
		return self::safeRead2($object,$property, "");
	}
	
	static function getRequestValue($field, $default) {
		if (isset( $_REQUEST[$field])) { return sanitize_text_field( $_REQUEST[$field]); } 
		return $default;
	}

      static function geServerValue($field, $default) {
		if (isset( $_SERVER[$field])) {return sanitize_text_field( $_SERVER[$field]); }
		return $default;
	}

      // used for reading post variables
	static function getFieldValue($field, $default) {
		if (isset( $_POST[$field])) {return sanitize_text_field( $_POST[$field]);}
		return $default;
	}
	
      // used for reading post variables (text area)
	static function getTextAreaValue($field, $default){
		if (isset( $_POST[$field])) {return sanitize_textarea_field($_POST[$field]);}
		return $default;
	}
      // used for reading post variables (text area)
	static function getEmailValue($field, $default){
		if (isset( $_POST[$field])) {return sanitize_email($_POST[$field]);}
		return $default;
	}
      
}	 


?>