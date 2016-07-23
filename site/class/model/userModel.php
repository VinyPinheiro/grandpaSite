<?php
/**
 * file: userModel.php
 * class to create a user object
 */
 
require_once(realpath('.') . '/class/configuration/globals.php');
 
class UserModel
{
	/* Class atrributes */
	private $name; //Name of the user, not null and less than 200 characters
	private $email;
	private $password;
	private $birthdate;
	private $sex;
	private $type;
	
	/* Exceptions messengers */
	
	const NULL_NAME = "Nome não pode ser nulo.";
	const GREATER_THAN_200 = "Nome não pode ter mais que 200 caracteres.";
	const INVALID_EMAIL = "Email inválido.";
	const SMALLER_PASSWORD = "Senha menor que 8 caracteres.";
	const GREAT_PASSWORD = "Senha maior que 40 caracteres.";
	const DATE_FORMAT = "Formato da data inválido.";
	const INVALID_DATE = "Data invalida.";
	const NULL_DATE = "Data não pode ser nula.";
	const INVALID_SEX = "Sexo invalido.";
	const INVALID_TYPE = "Tipo de registro invalido.";
	
	/* Help constants */
	
	const MAX_CARACTERS = 200;
	const MIN_PASSWORD_LENGTH = 8;
	const MAX_PASSWORD_LENGTH = 40; // Using only 20% the size of the bank to prevent 
									//	the encrypted password is greater than 200 characters
	const MALE = "MAN";
	const FEMALE = "WOMAN";	
	const TYPE_STUDENT = "STUDENT";
	const TYPE_ADMINISTRATOR = "ADMINISTRATOR";
	
	/*Methods*/
	
	public function __construct($name, $email, $password, $birthdate, $sex, $type)
	{
		$this->setName($name);
		$this->setEmail($email);
		$this->setPassword($password);
		$this->setBirthdate($birthdate);
		$this->setSex($sex);
		$this->settype($type);
	}
	
	/**
	 * Method to verify if the receive password is equals to this user password
	 * @param password string non null contain the password to verify
	 * @return return a boolean contain true to equal password or return false
	 */ 
	public function verifyPassword($password)
	{
		return password_verify($password, $this->password);
	}
	
	/* Getters and setters */
	
	private function setName($name)
	{
		//Remove left and right spaces
		$name = trim($name);
		
		//Verify if name is valid
		if($name != NULL && $name != "" && strlen($name) <= self::MAX_CARACTERS)
		{
			$this->name = $name;
		}
		else 
		{
			if($name == NULL || $name == "")
			{
				throw new UserModelException(self::NULL_NAME);
			}
			else
			{
				throw new UserModelException(self::GREATER_THAN_200);
			}
		}
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	private function setEmail($email)
	{
		if(filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$this->email = $email;
		}
		else
		{
			throw new UserModelException(self::INVALID_EMAIL);
		}
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	private function setPassword($password)
	{
		//Remove left and right spaces
		$password = trim($password);
		
		//Verify if password is valid
		if(strlen($password) >= self::MIN_PASSWORD_LENGTH)
		{
			
			if(strlen($password) <= self::MAX_PASSWORD_LENGTH)
			{
				//Criptography password
				$encrypt_password = Globals::criptograph($password);
				$this->password = $encrypt_password;
			}
			else
			{
				throw new UserModelException(self::GREAT_PASSWORD);
			}
		}
		else
		{
			throw new UserModelException(self::SMALLER_PASSWORD);
		}
	}
	
	private function setBirthdate($birthdate)
	{	
		if($birthdate != NULL && $birthdate != "")
		{	
			//Verify if the format date respect yyyy-mm-dd
			if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$birthdate))
			{
				// Split date in {year, month, day}
				$date_parts = explode('-',$birthdate);
				
				//Verify if date is valid
				if(checkdate($date_parts[1], $date_parts[2] ,$date_parts[0]))
				{
					$this->birthdate = $birthdate;
				}
				else
				{
					throw new UserModelException(self::INVALID_DATE);
				}
			}
			else
			{
				throw new UserModelException(self::DATE_FORMAT);
			}
		} 
		else
		{
			throw new UserModelException(self::NULL_DATE);
		}
		
	}
	
	public function getBirthdate()
	{
		return $this->birthdate;
	}
	
	private function setSex($sex)
	{
		//Change string to upper case
		$sex = strtoupper($sex);
		
		//Verify if is valid value for sex
		if(strcmp($sex,self::MALE) == 0 || strcmp($sex,self::FEMALE) == 0 )
		{
			$this->sex = $sex;
		}
		else
		{
			throw new UserModelException(self::INVALID_SEX);
		}
	}
	
	public function getSex()
	{
		return $this->sex;
	}
	
	private function setType($type)
	{
		//Change string to upper case
		$type = strtoupper($type);
		
		//Verify if is valid value for type of register
		if(strcmp($type,self::TYPE_ADMINISTRATOR) == 0 || strcmp($type,self::TYPE_STUDENT) == 0 )
		{
			$this->type = $type;
		}
		else
		{
			throw new UserModelException(self::INVALID_TYPE);
		}
	}
	
	public function getType()
	{
		return $this->type;
	}
}


class UserModelException extends Exception{
	
	public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

