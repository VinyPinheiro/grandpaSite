<?php
/**
 * file: userDAO.php
 * class to work in database the userModel data
 */

require_once(realpath('.') . '/class/database/dao.php');
require_once(realpath('.') . '/class/configuration/globals.php');

class UserDAO extends DAO
{
	/* Class attributes */
	private $user_model;
	
	/* Exceptions messengers */
	
	const NULL_EMAIL = "Email não pode ser vazio ou nulo.";
	const INVALID_MODEL = "user_model deve ser um objeto do tipo Usuário.";
	const USER_MODEL_ISNT_OBJECT = "user_model deve ser um objeto.";
	const EXISTENT_EMAIL = "Email já cadastrado.";
	const NOT_EXISTENT_EMAIL = "Email não cadastrado.";

	/* Help constants */
	
	const CLASS_EXCEPTION_CODE = 1;
	
	/* Methods */
	
	/**
	 * Define attributes necessaries for the DAO
	 * @param $host string with not null value and the host of database
	 * @param $user string with not null value and the user of database server 
	 * @param $passwoord string with not null value and the user password's
	 * @param $database string with not null value and the name of schema in database server
	 * @param $user_model userModel object type
	 */ 
	public function __construct($host, $user, $password, $database, $user_model)
 	{
		parent::__construct($host, $user, $password, $database);
		$this->setUserModel($user_model);
	}
	
	/**
	 * Method to find and locate an User By Email
	 * @param email not null value and contain a valid email
	 * @return returns null if not found User or returns a user with your data
	 */
	public function findByEmail($email)
	{
		if($email != NULL && $email != "")
		{
			//Set variable to return for null
			$user = NULL;
			//Try open connection
			parent::connection();
			
			//Save resultfor query
			$data_result = parent::query("SELECT name,email,password,birthdate,sex,type FROM USER WHERE email = '" . $email . "'");
			
			//Verify if found register
			if($data_result->num_rows != 0)
			{
				$data = $data_result->fetch_array();
				$user = new UserModel($data['name'], $data['email'], $data['password'], $data['birthdate'], $data['sex'], $data['type']);
			}
			else
			{
				$user = NULL;
			}
			
			parent::disconnect();
			return $user;
		}
		else
		{
			throw new DatabaseException(self::NULL_EMAIL, self::CLASS_EXCEPTION_CODE);
		}
	}
	
	/**
	 * Method to save this User in database
	 */
	public function register()
	{
		//Verify if register exists
		if($this->findByEmail($this->user_model->getEmail()) == NULL)
		{
			parent::query("INSERT INTO USER(name, email,sex,password,birthdate, type) VALUES(".
				"'{$this->user_model->getName()}','{$this->user_model->getEmail()}',".
				"'{$this->user_model->getSex()}','{$this->user_model->getPassword()}',".
				"'{$this->user_model->getBirthdate()}','{$this->user_model->getType()}')");
		}
		else
		{
			throw new DatabaseException(self::EXISTENT_EMAIL, self::CLASS_EXCEPTION_CODE);
		}
	}
		
	/**
	 * Method to remove this User for database
	 */
	public function delete()
	{
		//Verify if register exists
		if($this->findByEmail($this->user_model->getEmail()) != NULL)
		{
			parent::query("DELETE FROM USER WHERE email = '{$this->user_model->getEmail()}'");
		}
		else
		{
			throw new DatabaseException(self::NOT_EXISTENT_EMAIL, self::CLASS_EXCEPTION_CODE);
		}
	}
	
	
	
	
	/* Getter and Setter */

	private function setUserModel($user_model)
	{
		if(is_object($user_model))
		{
			if(get_class($user_model) == "UserModel")
			{
				$this->user_model = $user_model;
			}
			else
			{
				throw new DatabaseException(self::INVALID_MODEL, self::CLASS_EXCEPTION_CODE);
			}
		}
		else
		{
			throw new DatabaseException(self::USER_MODEL_ISNT_OBJECT, self::CLASS_EXCEPTION_CODE);
		}
	}
}
?>
