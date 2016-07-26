<?php
/**
 * file: database.daoTest.php
 */
 
class userDaoTest extends PHPUnit_Framework_TestCase
{
	private $connection;
	private static $user;
	
	public function setUp()
	{
        self::$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
	}
	
	public function testOpenConnection()
	{
		$this->connection = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::INVALID_HOST
	 */
	public function testOpenConnectionWithInvalidHost()
	{
		$this->connection = new UserDAO("127.0.0.256", Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::NULL_HOST
	 */
	public function testOpenConnectionWithNullHost()
	{
		$this->connection = new UserDAO(NULL, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::NULL_HOST
	 */
	public function testOpenConnectionWithEmptyHost()
	{
		$this->connection = new UserDAO("", Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::NULL_USER
	 */
	public function testOpenConnectionWithEmptyUser()
	{
		$this->connection = new UserDAO(Globals::HOST, "", Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::NULL_USER
	 */
	public function testOpenConnectionWithNullUser()
	{
		$this->connection = new UserDAO(Globals::HOST, NULL, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::NULL_USER
	 */
	public function testOpenConnectionWithNullDatabase()
	{
		$this->connection = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, NULL,self::$user);
	}
	
	/**
	 * Force SQL error
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::WRONG_QUERY
	 */
	public function testFindUserByEmailForceWrongQuery()
	{
		$this->connection = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
		$this->connection->findByEmail("viny-pinheiro@abc.com'jhg");
	}
	
	/**
	 * Force SQL error
	 */
	public function testVerifyMessageError()
	{
		$this->connection = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
		try
		{
			$this->connection->findByEmail("viny-pinheiro@abc.com'jhg");
		}
		catch(DatabaseException $message)
		{
			assert (strcmp("DatabaseException: [0]: " . DAO::WRONG_QUERY, $message) == 0);
		}
	}
	
	
	
	/**
	 * Locate data by email
	 */
	public function testFindUserByEmail()
	{
		$this->connection = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
		$this->connection->findByEmail("viny-pinheiro@abc.com");
	}
	
	
	
}

