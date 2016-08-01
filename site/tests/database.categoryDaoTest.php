<?php
/**
 * file: database.categoryDaoTest.php
 */
 
class CategoryDaoTest extends PHPUnit_Framework_TestCase
{
	private static $category_dao;
	private static $user;
	private static $videos;
	private static $categories;
	private static $category;
	private static $questions;
	
	const DEFAULT_IDENTIFIER = 12678;
	
	protected function setUp()
	{
		$image_default_path = realpath('.') . '/user_image/default.png';
        self::$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","ADMINISTRATOR");

		$this->category = new CategoryModel("Nome",self::$user,NULL,NULL);
		
		$this->category_dao = new CategoryDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,$this->category);

	}
	
	protected function tearDown()
	{
		
	}
	
	
	public function testCreateCategoryDao()
	{
		assert($this->category_dao->getCategoryModel() == $this->category);
	}
		
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage CategoryDAO::CATEGORY_ISNT_OBJECT	
	 */
	public function testCreateCategoryDaoWithNonObjectCategoryModel()
	{
		$category_dao = new CategoryDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,"Vinicius");
	}

	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage CategoryDAO::INVALID_MODEL	
	 */
	public function testCreateCategoryDaoWithInvalidObject()
	{
		$category_dao = new CategoryDAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE,new mysqli());
	}

}

?>
