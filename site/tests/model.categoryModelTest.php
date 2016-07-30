<?php
/**
 * file: model.questionModelTest.php
 */
 
class CategoryModelTest extends PHPUnit_Framework_TestCase
{
	private static $user;
	private static $videos;
	private static $categories;
	
	protected function setUp()
    {
        self::$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
        $subsub1 = new CategoryModel("Subsub1",self::$user,NULL,NULL,1);
        $subsub2 = new CategoryModel("Subsub2",self::$user,NULL,NULL,2);
        $sub1 = new CategoryModel("Sub1",self::$user,NULL, array($subsub1,$subsub2),3);
        $sub2 = new CategoryModel("Sub2",self::$user,NULL,NULL,4);
        $sub3 = new CategoryModel("Sub3",self::$user,NULL,NULL,5);
        
        self::$categories = array($sub1,$sub2,$sub3);
	}
	
	public function testCreateASimpleCategory()
	{
		$name = "Nome";
		$category = new CategoryModel($name,self::$user);
		
		assert(strcmp($category->getName(), $name) == 0, "Expected Same names");
		assert($category->getOwner() == self::$user, "Expected Same Owner");
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
	
	public function testCreateACategoryWithValidSons()
	{
		$category = new CategoryModel("Nome",self::$user,NULL,self::$categories);
		assert ($category->getSons() == self::$categories, "Expected same categories");
	}
	
	/**
	* @expectedException CategoryModelException
	* @expectedExceptionMessage CategoryModel::ALL_OBJECTS_MUST_BE_CATEGORYMODEL
	*/
	public function testCreateACategoryWithEmptySonsArray()
	{
		$category = new CategoryModel("Nome",self::$user,NULL,array(self::$user,self::$user,self::$user));
	}
	
	/**
	* @expectedException CategoryModelException
	* @expectedExceptionMessage CategoryModel::SON_CATEGORY_ISNT_ARRAY
	*/
	public function testCreateACategoryWithNotArraySons()
	{
		$category = new CategoryModel("Nome",self::$user,NULL,"AA");
	}

	/**
	* @expectedException CategoryModelException
	* @expectedExceptionMessage CategoryModel::ALL_OBJECTS_MUST_BE_CATEGORYMODEL
	*/
	public function testCreateACategoryWithNotCategoryArraySons()
	{
		$category = new CategoryModel("Nome",self::$user,NULL,array(25,24,25));
	}
}
