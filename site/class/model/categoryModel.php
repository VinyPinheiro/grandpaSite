<?php
/**
 * file: CategoryDAO.php
 * class to persist data in database tfrom questionModel
 */

require_once(realpath('.') . '/class/model/videoModel.php');

class CategoryModel
{
	/* Class Attributes */
	
	private $name; // String Not null with the name of the category 
	private $identifier; // Integer with the code of category or not null if the category is a new
	private $owner; // UserModel object with the creator of this category
	private $son_category; // Array with Categories daughters of this category, value is null if attribute videos have values
	private $videos; // Array with Videos belonging to this category, value is null if attribute son_category have values
	
	/* Exceptions messengers */
	
	const INVALID_IDENTIFIER = "Identificador da categoria invalido.";
	const NULL_NAME = "O nome não pode ser nulo ou vazio.";
	const OWNER_NO_HAVE_PRIVILEGES = "Usuário não tem privilégios suficientes";
	const INVALID_OWNER = "Dono deve ser um objeto do tipo Usuário.";
	const OWNER_ISNT_OBJECT = "Dono deve ser um objeto.";

	/* Method */
	
	/**
	 * @param name String Not null with the name of the category 
	 * @param owner UserModel object with the creator of this category
	 * @param videos Array with Videos belonging to this category, value is null if attribute son_category have values
	 * @param son_category Array with Categories daughters of this category, value is null if attribute videos have values
	 * @param identifier Integer with the code of category or not null if the category is a new
	 */
	public function __construct($name, $owner, $videos = NULL, $son_category = NULL, $identifier = NULL)
	{
		$this->setIdentifier($identifier);
		$this->setName($name);
		$this->setOwner($owner);
	}


	/* Getters and Setters */
	
	private function setIdentifier($identifier)
	{
		if(is_null($identifier) || is_numeric($identifier))
		{
			$this->identifier = $identifier;			
		}
		else
		{
			throw new CategoryModelException(self::INVALID_IDENTIFIER);
		}
	}
	
	private function setName($name)
	{
		//Remove Spaces
		$name = trim($name);
		
		if($name != NULL && $name != "")
		{
			$this->name = $name;
		}
		else
		{
			throw new CategoryModelException(self::NULL_NAME);
		}
	}
	
	private function setOwner($owner)
	{
		if(is_object($owner))
		{
			if(get_class($owner) == "UserModel")
			{
				if($owner->getType() == "ADMINISTRATOR")
				{
					$this->owner = $owner;
				}
				else
				{
					throw new CategoryModelException(self::OWNER_NO_HAVE_PRIVILEGES);
				}
			}
			else
			{
				throw new CategoryModelException(self::INVALID_OWNER);
			}
		}
		else
		{
			throw new CategoryModelException(self::OWNER_ISNT_OBJECT);
		}
	}
}

/**
 * @codeCoverageIgnore
 */
class CategoryModelException extends Exception{
	
	public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}


?>
