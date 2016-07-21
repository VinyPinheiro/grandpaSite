<?php
class Globals{
	public static $HOST = '127.0.0.1';
	public static $USER = 'root';
	public static $PASSWORD = '';
	public static $DATABASE = 'vovoSite';
	
	
	/**
	 * Method to generate a criptography to values
	 * @param value string with the text to criptography, not null values
	 * @return encrypted string
	 */
	public static function criptograph($value)
	{
		$options = ['cost' => 10]; // Define coast for cryptography
		
		return password_hash($value, PASSWORD_BCRYPT, $options);
	}
}
?>
