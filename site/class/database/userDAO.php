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
	private $user;

	/* Methods */
	
	/**
	 * Define attributes necessaries for the DAO
	 * @param $host string with not null value and the host of database
	 * @param $user string with not null value and the user of database server 
	 * @param $passwoord string with not null value and the user password's
	 * @param $database string with not null value and the name of schema in database server
	 * @param $user userModel object type
	 */ 
	public function __construct($host, $user, $password, $database, $user)
 	{
		super($host, $user, $password, $database);
		setUser($user);
	}

	private function setUser($user)
	{
		$this->user = $user;
	}
}
?>
