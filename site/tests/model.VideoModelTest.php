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

	public function testCreateValidVideoWithoutQuestions()
	{
		$video = new VideoModel("IblBGfLhztk",1,1);
	}

	public function testCreateValidVideoWithoutIdentifierAndQuestions()
	{
		$video = new VideoModel("IblBGfLhztk",1);
	}

	public function testCreateValidVideoWithoutIdentifier()
	{
		$video = new VideoModel("IblBGfLhztk",1,NULL, self::$questions);
	}
	
	/**
	* @expectedException VideoModelException
	* @expectedExceptionMessage VideoModel::INVALID_IDENTIFIER
	*/
	public function testWithInvalidIdentifier()
	{
		$video = new VideoModel("IblBGfLhztk",1,"as");
	}

	
	/**
	* @expectedException VideoModelException
	* @expectedExceptionMessage VideoModel::NULL_LINK
	*/
	public function testWithEmptyLink()
	{
		$video = new VideoModel("",1,1, self::$questions);
	}

	/**
	* @expectedException VideoModelException
	* @expectedExceptionMessage VideoModel::NULL_LINK
	*/
	public function testWithNULLLink()
	{
		$video = new VideoModel(NULL,1,1, self::$questions);
	}

	/**
	* @expectedException VideoModelException
	* @expectedExceptionMessage VideoModel::LINK_GREAT_THAN_200
	*/
	public function testWithLinkGreatThan200()
	{
		$video = new VideoModel("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa",1,1, self::$questions);
	}
	
	/**
	* @expectedException VideoModelException
	* @expectedExceptionMessage VideoModel::ONLY_UNSIGNED_VALUE
	*/
	public function testSignedPosition()
	{
		$video = new VideoModel("IblBGfLhztk",-1,1, self::$questions);
	}
	
	/**
	* @expectedException VideoModelException
	* @expectedExceptionMessage VideoModel::ONLY_NUMERIC_NUMBER
	*/
	public function testNonNumericPosition()
	{
		$video = new VideoModel("IblBGfLhztk","AA",1, self::$questions);
	}
	
	public function testStringNumericPosition()
	{
		$video = new VideoModel("IblBGfLhztk","1",1, self::$questions);
	}

}

