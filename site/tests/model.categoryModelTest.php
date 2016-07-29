<?php
/**
 * file: model.questionModelTest.php
 */
 
class CategoryModelTest extends PHPUnit_Framework_TestCase
{
	private static $user;
	private static $videos;
	private static $categories;
	private static $category;
	
	protected function setUp()
    {
        self::$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
	}
	
	public function testCreateASimpleCategory()
	{
		new CategoryModel("Nome",self::$user);
	}
	
	/**
	* @expectedException CategoryModelException
	* @expectedExceptionMessage CategoryModel::INVALID_IDENTIFIER
	*/
	public function testWithInvalidIdentifier()
	{
		new CategoryModel("Nome", self::$user, NULL, NULL, "A");
	}
}
