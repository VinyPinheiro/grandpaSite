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
	
	/**
	* @expectedException CategoryModelException
	* @expectedExceptionMessage CategoryModel::NULL_NAME
	*/
	public function testWithNullName()
	{
		new CategoryModel(NULL, self::$user);
	}
	
	/**
	* @expectedException CategoryModelException
	* @expectedExceptionMessage CategoryModel::INVALID_OWNER
	*/
	public function testWithInvalidOwner()
	{
		$question = new QuestionModel(self::$user,"Enunciado1","a","b","c","d","e","E");
		new CategoryModel("Nome",$question);
	}
		
	/**
	* @expectedException CategoryModelException
	* @expectedExceptionMessage CategoryModel::OWNER_NO_HAVE_PRIVILEGES
	*/
	public function testWithNoPrivilegesOwner()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","STUDENT");
		new CategoryModel("Nome",$user);
	}
	
	/**
	* @expectedException CategoryModelException
	* @expectedExceptionMessage CategoryModel::OWNER_ISNT_OBJECT
	*/
	public function testWithOwnerIsnTObject()
	{
		new CategoryModel("Nome","Joao da silva");
	}	
}
