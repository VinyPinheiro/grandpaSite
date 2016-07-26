<?php
/**
 * file: userDAO.php
 * class to work in database the userModel data
 */

require_once(realpath('.') . '/class/database/dao.php');
require_once(realpath('.') . '/class/configuration/globals.php');

class UserDAO extends DAO
{
	/* Class attributes */
	private $user_model;

	/* Methods */
	
	/**
	 * Define attributes necessaries for the DAO
	 * @param $host string with not null value and the host of database
	 * @param $user string with not null value and the user of database server 
	 * @param $passwoord string with not null value and the user password's
	 * @param $database string with not null value and the name of schema in database server
	 * @param $user_model userModel object type
	 */ 
	public function __construct($host, $user, $password, $database, $user_model)
 	{
		parent::__construct($host, $user, $password, $database);
		setUserModel($user_model);
	}

	private function setUserModel($user_model)
	{
		$this->user_model = $user_model;
	}
}
?>
