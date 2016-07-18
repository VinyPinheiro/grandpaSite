<?php
/**
 * file: html.pageTest.php
 */
 
class PageTest extends PHPUnit_Framework_TestCase
{
	
	public function testValidtitle()
	{
		Page::header("nova");
	}
	
	/**
	* @expectedException PageException
	*/
	public function testNulltitle()
	{
		Page::header(NULL);
	}
	
	/**
	* @expectedException PageException
	*/
	public function testEmptytitle()
	{
		Page::header("");
	}
	
}

