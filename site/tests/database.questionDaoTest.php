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
	private static $question2;
	private static $image_default_path;
	
	const DEFAULT_IDENTIFIER = 12678;
	
	protected function setUp()
	{
		self::$image_default_path = realpath('.') . '/user_image/default.png';
		
        self::$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@abcd.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
        $this->user_dao = new UserDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,self::$user);
        $this->user_dao->register(); 
        
        self::$question = new QuestionModel(self::$user,"Enunciado1","a","b","c","d","e","E",self::$image_default_path,self::DEFAULT_IDENTIFIER);
        self::$question2 = new QuestionModel(self::$user,"Enunciado2","a","b","c","d","e","E",self::$image_default_path,3);
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
	 * @expectedExceptionMessage QuestionDAO::QUESTION_MODEL_ISNT_OBJECT	
	 */
	public function testCreateQuestionDaoWithNonObjectQuestionModel()
	{
		$question_dao = new QuestionDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,"Vinicius");
	}

	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage QuestionDAO::INVALID_MODEL	
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
	 * @expectedExceptionMessage QuestionDAO::EXISTENT_IDENTIFIER
	 */
	public function testRegisterSameQuestionIdentifier()
	{
		$this->question_dao->register();
		$this->question_dao->register();
	}
	
	public function testUpdateQuestionWithoutChangeIdentifier()
	{
		$this->question_dao->register();
		
		$question2 = new QuestionModel(self::$user,"Enunciado2","a","b","c","d","e","E",self::$image_default_path,self::DEFAULT_IDENTIFIER);
		$this->question_dao->update($question2);
		
		assert(strcmp($question2->getEnunciate(), QuestionDAO::findByIdentifier(self::DEFAULT_IDENTIFIER)->getEnunciate()) == 0, "Not changed enunciate.");
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage QuestionDAO::NOT_EXISTENT_IDENTIFIER
	 */
	public function testUpdateQuestionWithoutChangeIdentifierButInitialIdentifierNotExists()
	{		
		$question2 = new QuestionModel(self::$user,"Enunciado2","a","b","c","d","e","E",self::$image_default_path,self::DEFAULT_IDENTIFIER);
		$this->question_dao->update($question2);
	}
	
	public function testUpdateQuestionWithChangedIdentifier()
	{
		$this->question_dao->register();
		
		$this->question_dao->update(self::$question2);
		
		assert(strcmp(self::$question2->getEnunciate(), QuestionDAO::findByIdentifier(self::$question2->getIdentifier())->getEnunciate()) == 0, "Not changed enunciate.");
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage QuestionDAO::INVALID_IDENTIFIER
	 */
	public function testUpdateQuestionWithoutChangeIdentifierButInitialIdentifierIsInvalid()
	{	
		$this->question_dao->register();
		$question2 = new QuestionModel(self::$user,"Enunciado2","a","b","c","d","e","E",self::$image_default_path,NULL);
		$this->question_dao->update($question2);
	}
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage QuestionDAO::NOT_EXISTENT_IDENTIFIER
	 */
	public function testUpdateQuestionWithoutChangeIdentifierButInitialIdentifierIsntExists()
	{	
		$question2 = new QuestionModel(self::$user,"Enunciado2","a","b","c","d","e","E",self::$image_default_path,NULL);
		$this->question_dao->update($question2);
	}
}

?>
