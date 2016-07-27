<?php
/**
 * file: database.questionDaoTest.php
 */
 
class QuestionDaoTest extends PHPUnit_Framework_TestCase
{
	
	private $question_dao;
	private $user_dao;
	private static $user;
	private static $question;
	private static $image_default_path;
	
	protected function setUp()
	{
		self::$image_default_path = realpath('.') . '/user_image/default.png';
		
        self::$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@abcd.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
        $this->user_dao = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
        $this->user_dao->register(); 
        
        self::$question = new QuestionModel(self::$user,"Enunciado1","a","b","c","d","e","E",self::$image_default_path,1);
        $this->question_dao = new QuestionDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$question);

	}
	
	protected function tearDown()
	{
		try
		{        
			$this->question_dao->delete();
		}
		catch(Exception $messenge)
		{
			// Nothing to do.
		}
		
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
	 * @expectedExceptionMessenger QuestionDAO::USER_MODEL_ISNT_OBJECT	
	 */
	public function testCreateQuestionDaoWithNonObjectQuestionModel()
	{
		$question_dao = new QuestionDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,"Vinicius");
	}

	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger QuestionDAO::INVALID_MODEL	
	 */
	public function testCreateQuestionDaoWithInvalidObject()
	{
		$question_dao = new QuestionDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,new mysqli());
	}



	public function testFindQuestionByIdentified()
	{
		assert(QuestionDAO::findByIdentifier(1) == NULL, "Expected Null by return");
	}

	public function testFindQuestionByNullIdentified()
	{
		assert(QuestionDAO::findByIdentifier(NULL) == NULL, "Expected Null by return");
	}
	
	public function testRegisterQuestion()
	{
		assert(QuestionDAO::findByIdentifier($this->question_dao->register()) != NULL, "Register not encounter");
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessenger QuestionDAO::EXISTENT_IDENTIFIER
	 */
	public function testRegisterSameQuestionIdentifier()
	{
		$this->question_dao->register();
		$this->question_dao->register();
	}
}

?>
