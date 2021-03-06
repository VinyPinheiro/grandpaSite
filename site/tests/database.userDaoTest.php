<?php
/**
 * file: database.userDaoTest.php
 */
 
class userDaoTest extends PHPUnit_Framework_TestCase
{
	private $user_dao;
	private $user_dao2;
	private static $user;
	private static $user2;
	
	protected function setUp()
	{
        self::$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@abcd.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
        $this->user_dao = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
        
        self::$user2 = new UserModel("Vinicius Pinheiro","viny-pinheiro@abcdef.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
        $this->user_dao2 = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user2);
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
		try
		{
			$this->user_dao2->delete();
		}
		catch(Exception $messenge)
		{
			// Nothing to do.
		}
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage DAO::INVALID_HOST
	 */
	public function testOpenuser_daoWithInvalidHost()
	{
		$this->user_dao = new UserDAO("127.0.0.256", Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage DAO::NULL_HOST
	 */
	public function testOpenuser_daoWithNullHost()
	{
		$this->user_dao = new UserDAO(NULL, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage DAO::NULL_HOST
	 */
	public function testOpenuser_daoWithEmptyHost()
	{
		$this->user_dao = new UserDAO("", Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage DAO::NULL_USER
	 */
	public function testOpenuser_daoWithEmptyUser()
	{
		$this->user_dao = new UserDAO(Globals::HOST, "", Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage DAO::NULL_USER
	 */
	public function testOpenuser_daoWithNullUser()
	{
		$this->user_dao = new UserDAO(Globals::HOST, NULL, Globals::PASSWORD, Globals::DATABASE,self::$user);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage DAO::NULL_DATABASE
	 */
	public function testOpenuser_daoWithNullDatabase()
	{
		$this->user_dao = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, NULL,self::$user);
	}
	
	/**
	 * Force SQL error
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage DAO::WRONG_QUERY
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
			UserDAO::findByEmail("viny-pinheiro@abc.com'jhg");
		}
		catch(DatabaseException $message)
		{
			assert (strcmp("DatabaseException: [0]: " . DAO::WRONG_QUERY, $message) == 0);
		}
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage UserDAO::USER_MODEL_ISNT_OBJECT	
	 */
	public function testCreateUserDaoWithNonObjectUserModel()
	{
		$this->user_dao = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,"Vinicius");
	}

	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage UserDAO::INVALID_MODEL	
	 */
	public function testCreateUserDaoWithInvalidObject()
	{
		$this->user_dao = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,new mysqli());
	}

	public function testFindUserByEmail()
	{
		UserDAO::findByEmail("viny-pinheiro@abc.com");
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage UserDAO::NULL_EMAIL
	 */
	public function testFindUserByNullEmail()
	{
		UserDAO::findByEmail(NULL);
	}
	
	public function testRegisterUser()
	{
		$this->user_dao->register();
		assert($this->user_dao->findByEmail(self::$user->getEmail()), "Expected two equals emails");
		$this->user_dao->delete();
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage UserDAO::EXISTENT_EMAIL
	 */
	public function testRegisterDuplicatedUser()
	{
		$this->user_dao->register();
		$this->user_dao->register();
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage UserDAO::NOT_EXISTENT_EMAIL
	 */
	public function testDeleteNonExistentUser()
	{
		$this->user_dao->delete();
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage UserDAO::NOT_EXISTENT_EMAIL
	 */
	public function testUpdateUserWithoutChangeEmailButEmailNotInDatabases()
	{		
        $user = new UserModel("Vinicius Pinheiro da Silva","viny-pinheiro@abcd.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
		$this->user_dao->update($user);
	}
	
	public function testUpdateUserWithoutChangeEmail()
	{
		$this->user_dao->register(); 
		$user = new UserModel("Vinicius Pinheiro da Silva","viny-pinheiro@abcd.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
		$this->user_dao->update($user);
	}
	
	public function testUpdateUserWithChangedEmail()
	{
		$this->user_dao->register();
		$this->user_dao->update(self::$user2);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage UserDAO::NOT_EXISTENT_EMAIL
	 */
	public function testUpdateUserWithChangeEmailButOldEmailNotInDatabases()
	{
		$this->user_dao->update(self::$user2);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage UserDAO::EXISTENT_EMAIL
	 */
	public function testUpdateUserWithChangeEmailButNewEmailInDatabases()
	{
		$this->user_dao->register();
		$this->user_dao2->register();
		
		$this->user_dao->update(self::$user2);
		
		
	}
}

