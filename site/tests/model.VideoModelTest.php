<?php
/**
 * file: model.videoModelTest.php
 */
 
class VideoModelTest extends PHPUnit_Framework_TestCase
{
	public function testCreateValidVideo()
	{
		$video = new VideoModel("IblBGfLhztk",1,1);
	}
	public function testCreateValidVideoWithoutIdentifier()
	{
		$video = new VideoModel("IblBGfLhztk",1);
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

