<?php
/**
 * file: database.daoTest.php
 */
 
class userDaoTest extends PHPUnit_Framework_TestCase
{
	private static $connection;
	private static $user;
	
	public function setUp()
	{
        self::$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
	}
	
	public function testOpenConnection()
	{
		self::$connection = new UserDAO(Globals::$HOST, Globals::$USER, Globals::$PASSWORD, Globals::$DATABASE,self::$user);
	}
}

