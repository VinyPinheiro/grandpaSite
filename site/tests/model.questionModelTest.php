<?php
/**
 * file: model.questionModelTest.php
 */
 
class QuestionModelTest extends PHPUnit_Framework_TestCase
{
	private $user;
	
	public function setUp()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
	}
	
	public function testCreateValidQuestion()
	{
		$question = new QuestionModel($this->user,"Enunciado1","a","b","c","d","e","E");
	}
	
	public function testCreateValidQuestionWithFilePath()
	{
		$question = new QuestionModel($this->user,"Enunciado1","a","b","c","d","e","E","imagens/imagem1.jpg");
	}
	
	public function testCreateValidQuestionWithFilePathAndIdentifier()
	{
		$question = new QuestionModel($this->user,"Enunciado1","a","b","c","d","e","E","imagens/imagem1.jpg",5);
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
}

