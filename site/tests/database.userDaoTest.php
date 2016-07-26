<?php
/**
 * file: database.daoTest.php
 */
 
class userDaoTest extends PHPUnit_Framework_TestCase
{
	private $user_dao;
	private static $user;
	
	protected function setUp()
	{
        self::$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@abcd.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
        $this->user_dao = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	protected function tearDown()
	{
		try
		{
			$this->user_dao->delete();
		}
		catch(Exception $messenge)
		{
			// Nothing to do.
		}
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::INVALID_HOST
	 */
	public function testOpenuser_daoWithInvalidHost()
	{
		$this->user_dao = new UserDAO("127.0.0.256", Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::NULL_HOST
	 */
	public function testOpenuser_daoWithNullHost()
	{
		$this->user_dao = new UserDAO(NULL, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::NULL_HOST
	 */
	public function testOpenuser_daoWithEmptyHost()
	{
		$this->user_dao = new UserDAO("", Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::NULL_USER
	 */
	public function testOpenuser_daoWithEmptyUser()
	{
		$this->user_dao = new UserDAO(Globals::HOST, "", Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::NULL_USER
	 */
	public function testOpenuser_daoWithNullUser()
	{
		$this->user_dao = new UserDAO(Globals::HOST, NULL, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::NULL_USER
	 */
	public function testOpenuser_daoWithNullDatabase()
	{
		$this->user_dao = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, NULL,self::$user);
	}
	
	/**
	 * Force SQL error
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger DAO::WRONG_QUERY
	 */
	public function testFindUserByEmailForceWrongQuery()
	{
		$this->user_dao = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
		$this->user_dao->findByEmail("viny-pinheiro@abc.com'jhg");
	}
	
	/**
	 * Force SQL error
	 */
	public function testVerifyMessageError()
	{
		try
		{
			$this->user_dao->findByEmail("viny-pinheiro@abc.com'jhg");
		}
		catch(DatabaseException $message)
		{
			assert (strcmp("DatabaseException: [0]: " . DAO::WRONG_QUERY, $message) == 0);
		}
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger UserDAO::USER_MODEL_ISNT_OBJECT	
	 */
	public function testCreateUserDaoWithNonObjectUserModel()
	{
		$this->user_dao = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,"Vinicius");
	}

	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger UserDAO::INVALID_MODEL	
	 */
	public function testCreateUserDaoWithInvalidObject()
	{
		$this->user_dao = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,new mysqli());
	}

	public function testFindUserByEmail()
	{
		$this->user_dao->findByEmail("viny-pinheiro@abc.com");
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger UserDAO::NULL_EMAIL
	 */
	public function testFindUserByNullEmail()
	{
		$this->user_dao->findByEmail(NULL);
	}
	
	public function testRegisterUser()
	{
		$this->user_dao->register();
		assert($this->user_dao->findByEmail(self::$user->getEmail()), "Expected two equals emails");
		$this->user_dao->delete();
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger UserDAO::EXISTENT_EMAIL
	 */
	public function testRegisterDuplicatedUser()
	{
		$this->user_dao->register();
		$this->user_dao->register();
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger UserDAO::NOT_EXISTENT_EMAIL
	 */
	public function testDeleteNonExistentUser()
	{
		$this->user_dao->delete();
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger UserDAO::NOT_EXISTENT_EMAIL
	 */
	public function testUpdateUserWithoutChangeEmailButEmailNotInDatabases()
	{
		$this->user_dao->update(new UserModel("Vinicius Pinheiro da Silva","viny-pinheiro@abcd.com","123456789","1995-02-14","MAN","ADMINISTRATOR"));
	}
	
	public function testUpdateUserWithoutChangeEmail()
	{
		$this->user_dao->register();
		$this->user_dao->update(new UserModel("Vinicius Pinheiro da Silva","viny-pinheiro@abcd.com","123456789","1995-02-14","MAN","ADMINISTRATOR"));
	}
}

