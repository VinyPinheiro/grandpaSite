<?php
/**
 * file: model.questionModelTest.php
 */
 
class QuestionModelTest extends PHPUnit_Framework_TestCase
{
	private $user;
	private $image_default_path;
	
	public function setUp()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
		$image_default_path = realpath('.') . '/user_image/default.png';
	}
	
	public function testCreateValidQuestion()
	{
		$question = new QuestionModel($this->user,"Enunciado1","a","b","c","d","e","E");
	}
	
	public function testCreateValidQuestionWithFilePath()
	{
		$question = new QuestionModel($this->user,"Enunciado1","a","b","c","d","e","E",$this->image_default_path);
	}
	
	public function testCreateValidQuestionWithFilePathAndIdentifier()
	{
		$question = new QuestionModel($this->user,"Enunciado1","a","b","c","d","e","E",$this->image_default_path,5);
	}
	
	public function testCreateValidQuestionWithFilePathNULLAndIdentifier()
	{
		$question = new QuestionModel($this->user,"Enunciado1","a","b","c","d","e","E",NULL,5);
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage Identificador da questão invalido.
	*/
	public function testWithInvalidIdentifier()
	{
		$question = new QuestionModel($this->user,"Enunciado1","a","b","c","d","e","E",NULL,"qqq");
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage O enunciado não pode ser nulo ou vazio.
	*/
	public function testWithEmptyEnunciate()
	{
		$question = new QuestionModel($this->user,"","a","b","c","d","e","E",NULL,NULL);
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage O enunciado não pode ser nulo ou vazio.
	*/
	public function testWithNullEnunciate()
	{
		$question = new QuestionModel($this->user,NULL,"a","b","c","d","e","E",NULL,NULL);
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage Imagem não encontrada.
	*/
	public function testWithWrongPath_especialCharacters()
	{
		$question = new QuestionModel($this->user,"Enunciado","a","b","c","d","e","E","sdf#/asd/asd",NULL);
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage Alternativa Correta invalida.
	*/
	public function testWithInvalidCorrectAnswer()
	{
		$question = new QuestionModel($this->user,"Enunciado","a","b","c","d","e","Q",$this->image_default_path,NULL);
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage Alternativa Correta invalida.
	*/
	public function testWithNULLCorrectAnswer()
	{
		$question = new QuestionModel($this->user,"Enunciado","a","b","c","d","e",NULL,$this->image_default_path,NULL);
	}
	
	/**
	* @expectedException QuestionModelException
	* @expectedExceptionMessage Alternativa Correta invalida.
	*/
	public function testWithEmptyCorrectAnswer()
	{
		$question = new QuestionModel($this->user,"Enunciado","a","b","c","d","e","",$this->image_default_path,NULL);
	}
}

