<?php
/**
 * file: categoryDAO.php
 * class to persist data in database from categoryModel and Video Model
 */

require_once(realpath('.') . '/class/database/dao.php');
require_once(realpath('.') . '/class/database/userDAO.php');
require_once(realpath('.') . '/class/configuration/globals.php');

class CategoryDAO extends DAO
{
	
	/* Class attributes */
	private $category;
	
	/* Exceptions messengers */
	
	const INVALID_MODEL = "category deve ser um objeto do tipo CategoryModel.";
	const CATEGORY_ISNT_OBJECT = "category deve ser um objeto.";

	/* Help constants */
	
	const CLASS_EXCEPTION_CODE = 3;
		
	/* Methods */

	/**
	 * Define attributes necessaries for the DAO
	 * @param $host string with not null value and the host of database
	 * @param $user string with not null value and the user of database server 
	 * @param $passwoord string with not null value and the user password's
	 * @param $database string with not null value and the name of schema in database server
	 * @param $category CategoryModel object type
	 */ 
	public function __construct($host, $user, $password, $database, $category)
 	{
		parent::__construct($host, $user, $password, $database);
		$this->setCategoryModel($category);
	}
	
	
	/* Getter and Setter */

	private function setCategoryModel($category)
	{
		if(is_object($category))
		{
			if(get_class($category) == "CategoryModel")
			{
				$this->category = $category;
			}
			else
			{
				throw new DatabaseException(self::INVALID_MODEL, self::CLASS_EXCEPTION_CODE);
			}
		}
		else
		{
			throw new DatabaseException(self::CATEGORY_ISNT_OBJECT, self::CLASS_EXCEPTION_CODE);
		}
	}
	
	public function getCategoryModel()
	{
		return $this->category;
	}
	
	
}
