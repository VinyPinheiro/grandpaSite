<?php
/**
 * file: model.questionModelTest.php
 */
 
class QuestionModelTest extends PHPUnit_Framework_TestCase
{
	private static $user;
	private static $image_default_path;


    protected function setUp()
    {
        self::$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
		self::$image_default_path = realpath('.') . '/user_image/default.png';
    }
	
	public function testCreateValidQuestion()
	{
		$question = new QuestionModel(self::$user,"Enunciado1","a","b","c","d","e","E");
	}
	
	public function testCreateValidQuestionWithFilePath()
	{
		$question = new QuestionModel(self::$user,"Enunciado1","a","b","c","d","e","E",self::$image_default_path);
	}
	
	public function testCreateValidQuestionWithFilePathAndIdentifier()
	{
		$question = new QuestionModel(self::$user,"Enunciado1","a","b","c","d","e","E",self::$image_default_path,5);
		
		assert ($question->getOwner() == self::$user,"Expected equals owners");
		assert ($question->getEnunciate() == "Enunciado1","Expected equals enunciate");
		assert ($question->getAlternative_A() == "a","Expected equals Alternative A");
		assert ($question->getAlternative_B() == "b","Expected equals Alternative B");
		assert ($question->getAlternative_C() == "c","Expected equals Alternative C");
		assert ($question->getAlternative_D() == "d","Expected equals Alternative D");
		assert ($question->getAlternative_E() == "e","Expected equals Alternative E");
		assert ($question->getCorrectLetter() == "E","Expected equals Correct answer");
		assert ($question->getImagePath() == self::$image_default_path,"Expected equals image path");
		assert ($question->getIdentifier() == 5,"Expected equals identifier");
	}
	
	public function testCreateValidQuestionWithFilePathNULLAndIdentifier()
	{
		$question = new QuestionModel(self::$user,"Enunciado1","a","b","c","d","e","E",NULL,5);
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::INVALID_IDENTIFIER
	*/
	public function testWithInvalidIdentifier()
	{
		$question = new QuestionModel(self::$user,"Enunciado1","a","b","c","d","e","E",NULL,"qqq");
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::NULL_ENUNCIATE
	*/
	public function testWithEmptyEnunciate()
	{
		$question = new QuestionModel(self::$user,"","a","b","c","d","e","E",NULL,NULL);
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::NULL_ENUNCIATE
	*/
	public function testWithNullEnunciate()
	{
		$question = new QuestionModel(self::$user,NULL,"a","b","c","d","e","E",NULL,NULL);
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::INVALID_PATCH
	*/
	public function testWithWrongPath_especialCharacters()
	{
		$question = new QuestionModel(self::$user,"Enunciado","a","b","c","d","e","E","sdf#/asd/asd",NULL);
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::INVALID_CORRECT_ALTERNATIVE
	*/
	public function testWithInvalidCorrectAnswer()
	{
		$question = new QuestionModel(self::$user,"Enunciado","a","b","c","d","e","Q",self::$image_default_path,NULL);
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::INVALID_CORRECT_ALTERNATIVE
	*/
	public function testWithNULLCorrectAnswer()
	{
		$question = new QuestionModel(self::$user,"Enunciado","a","b","c","d","e",NULL,self::$image_default_path,NULL);
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::INVALID_CORRECT_ALTERNATIVE
	*/
	public function testWithEmptyCorrectAnswer()
	{
		$question = new QuestionModel(self::$user,"Enunciado","a","b","c","d","e","",self::$image_default_path,NULL);
	}
	
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::INVALID_OWNER
	*/
	public function testWithInvalidOwner()
	{
		$question1 = new QuestionModel(self::$user,"Enunciado1","a","b","c","d","e","E");
		$question = new QuestionModel($question1,"Enunciado","a","b","c","d","e","A",self::$image_default_path,NULL);
	}
		
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::OWNER_NO_HAVE_PRIVILEGES
	*/
	public function testWithNoPrivilegesOwner()
	{
		$user1 = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","STUDENT");
		$question = new QuestionModel($user1,"Enunciado","a","b","c","d","e","A",self::$image_default_path,NULL);
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::OWNER_ISNT_OBJECT
	*/
	public function testWithOwnerIsnTObject()
	{
		$question = new QuestionModel("owner","Enunciado","a","b","c","d","e","A",self::$image_default_path,NULL);
	}	
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::NULL_ALTERNATIVE
	*/
	public function testWithAlternativeAInvalid()
	{
		$question = new QuestionModel(self::$user,"Enunciado","","b","c","d","e","A",self::$image_default_path,NULL);
	}
		
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::NULL_ALTERNATIVE
	*/
	public function testWithAlternativeBInvalid()
	{
		$question = new QuestionModel(self::$user,"Enunciado","a","","c","d","e","A",self::$image_default_path,NULL);
	}
		
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::NULL_ALTERNATIVE
	*/
	public function testWithAlternativeCInvalid()
	{
		$question = new QuestionModel(self::$user,"Enunciado","a","b","","d","e","A",self::$image_default_path,NULL);
	}
		
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::NULL_ALTERNATIVE
	*/
	public function testWithAlternativeDInvalid()
	{
		$question = new QuestionModel(self::$user,"Enunciado","a","b","c","","e","A",self::$image_default_path,NULL);
	}
		
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage QuestionModel::NULL_ALTERNATIVE
	*/
	public function testWithAlternativeEInvalid()
	{
		$question = new QuestionModel(self::$user,"Enunciado","a","b","c","d","","A",self::$image_default_path,NULL);
	}
}

