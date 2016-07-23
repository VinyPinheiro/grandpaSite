<?php
/**
 * file: model.questionModelTest.php
 */
 
class QuestionModelTest extends PHPUnit_Framework_TestCase
{
	public function testCreateValidQuestion()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
		$question = new QuestionModel($user,"Enunciado1","a","b","c","d","e","E");
	}
}

