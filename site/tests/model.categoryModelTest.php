<?php
/**
 * file: model.questionModelTest.php
 */
 
class CategoryModelTest extends PHPUnit_Framework_TestCase
{
	private static $user;
	private static $videos;
	private static $categories;
	private static $questions;
	
	private static $video1;
	private static $video2;
	private static $video3;
	
	protected function setUp()
    {
		$image_default_path = realpath('.') . '/user_image/default.png';
        self::$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","ADMINISTRATOR");
        
        $subsub1 = new CategoryModel("Subsub1",self::$user,NULL,NULL,1);
        $subsub2 = new CategoryModel("Subsub2",self::$user,NULL,NULL,2);
        $sub1 = new CategoryModel("Sub1",self::$user,NULL, array($subsub1,$subsub2),3);
        $sub2 = new CategoryModel("Sub2",self::$user,NULL,NULL,4);
        $sub3 = new CategoryModel("Sub3",self::$user,NULL,NULL,5);
        self::$categories = array($sub1,$sub2,$sub3);
        
        $question1 = new QuestionModel(self::$user,"Enunciado1","a","b","c","d","e","E",$image_default_path,3);
		$question2 = new QuestionModel(self::$user,"Enunciado1","a","b","c","d","e","E",$image_default_path,4);
		$question3 = new QuestionModel(self::$user,"Enunciado1","a","b","c","d","e","E",$image_default_path,5);
		self::$questions = array($question1,$question2, $question3);
		
		self::$video1 = new VideoModel("IblBGfLhztk",2,1, self::$questions);
		self::$video2 = new VideoModel("IblBGfLhztk",3,2, self::$questions);
		self::$video3 = new VideoModel("IblBGfLhztk",1,3, self::$questions);
		self::$videos = array(self::$video1,self::$video2,self::$video3);
	}
	
	public function testCreateASimpleCategory()
	{
		$name = "Nome";
		$category = new CategoryModel($name,self::$user,NULL,NULL,1);
		
		assert(strcmp($category->getName(), $name) == 0, "Expected Same names");
		assert($category->getOwner() == self::$user, "Expected Same Owner");
		assert($category->getIdentifier() == 1, "Expected Same Identifier");
	}
	
	public function testCreateACategoryWithVideos()
	{
		$name = "Nome";
		$category = new CategoryModel($name,self::$user,self::$videos);
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
	
	public function testOrdenationVideos()
	{
		$category = new CategoryModel("nome",self::$user,self::$videos);
		
		assert($category->getVideos()[0] == self::$video3);
		assert($category->getVideos()[1] == self::$video1);
		assert($category->getVideos()[2] == self::$video2);
	}
	
	/**
	* @expectedException CategoryModelException
	* @expectedExceptionMessage CategoryModel::ALL_OBJECTS_MUST_BE_VIDEOMODEL
	*/
	public function testCreateAVideoWithNotObjectArrayInVideos()
	{
		$category = new CategoryModel("Nome",self::$user,array("video1","Videos2"),NULL);
	}
	
	/**
	* @expectedException CategoryModelException
	* @expectedExceptionMessage CategoryModel::ALL_OBJECTS_MUST_BE_VIDEOMODEL
	*/
	public function testCreateAVideoWithNotVideoModelArrayInVideos()
	{
		$category = new CategoryModel("Nome",self::$user,array(self::$user,self::$user,self::$user),NULL);
	}
	
	/**
	* @expectedException CategoryModelException
	* @expectedExceptionMessage CategoryModel::ALL_POSITIONS_ARE_NOT_UNIQUE_NOR_FAULT
	*/
	public function testCreateAVideoWithNotValidValuesInArray()
	{		
		$video1 = new VideoModel("IblBGfLhztk",2,1, self::$questions);
		$video2 = new VideoModel("IblBGfLhztk",5,2, self::$questions);
		$video3 = new VideoModel("IblBGfLhztk",1,3, self::$questions);
		$videos = array($video1,$video2,$video3);
		
		$category = new CategoryModel("Nome",self::$user,$videos,NULL);
	}
	
	/**
	* @expectedException CategoryModelException
	* @expectedExceptionMessage CategoryModel::VIDEOS_ISNT_ARRAY
	*/
	public function testCreateAVideoWithNotArrayInVideos()
	{
		$category = new CategoryModel("Nome",self::$user,"Meus Videos",NULL);
	}
	
	/**
	* @expectedException CategoryModelException
	* @expectedExceptionMessage CategoryModel::NOT_NULL_VIDEO_AND_SUBCATEGOIES
	*/
	public function testCreateACategoryWithSubCategoriesAndVideos()
	{
		$category = new CategoryModel("Nome",self::$user,self::$videos,self::$categories);
	}
}
