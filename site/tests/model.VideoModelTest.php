<?php
/**
 * file: model.videoModelTest.php
 */
 
class VideoModelTest extends PHPUnit_Framework_TestCase
{
	private static $questions;

	protected function setUp()
	{
		$image_default_path = realpath('.') . '/user_image/default.png';
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
		$question1 = new QuestionModel($user,"Enunciado1","a","b","c","d","e","E",$image_default_path,3);
		$question2 = new QuestionModel($user,"Enunciado1","a","b","c","d","e","E",$image_default_path,4);
		$question3 = new QuestionModel($user,"Enunciado1","a","b","c","d","e","E",$image_default_path,5);
		self::$questions = array($question1,$question2, $question3);
	}

	public function testCreateValidVideo()
	{
		$video = new VideoModel("IblBGfLhztk",1,1, self::$questions);
	}
	
	/**
	* @expectedException VideoModelException
	* @expectedExceptionMessage VideoModel::INVALID_IDENTIFIER
	*/
	public function testWithInvalidIdentifier()
	{
		$video = new VideoModel("IblBGfLhztk",1,"as");
	}
}

