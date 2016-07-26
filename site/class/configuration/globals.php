<?php
class Globals{
	const HOST = '127.0.0.1';
	const USER = 'root';
	const PASSWORD = '';
	const DATABASE = 'vovoSite';
	
	
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
