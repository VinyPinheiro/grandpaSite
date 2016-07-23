<?php
/**
 * file: questionModel.php
 * class to create a question object
 */
 
require_once('class/model/userModel.php');

class QuestionModel
{
	/* Class attributes */
	
	private $identifier; //Number with the identifier code for the question. If is a new question, this value is null.
	private $alternative_A; // Not Null values and no greater than 200 caracters
	private $alternative_B; // Not Null values and no greater than 200 caracters
	private $alternative_C; // Not Null values and no greater than 200 caracters
	private $alternative_D; // Not Null values and no greater than 200 caracters
	private $alternative_E; // Not Null values and no greater than 200 caracters
	private $enunciate; //Enunciate for the question
	private $image_path; // Optional, path with the loaded image
	private $correct_letter; //Only A,B,C,D or E, contain the correct answer
	private $owner; //User who created the question 	
	
	/* Exceptions messengers */
	
	const INVALID_IDENTIFIER = "Identificador da questão invalido.";
	const NULL_ENUNCIATE = "O enunciado não pode ser nulo ou vazio.";
	const INVALID_PATCH = "Imagem não encontrada.";
	const INVALID_CORRECT_ALTERNATIVE = "Alternativa Correta invalida.";
	const OWNER_NO_HAVE_PRIVILEGES = "Usuário não tem privilégios suficientes";
	const INVALID_OWNER = "Dono deve ser um objeto do tipo Usuário.";
			
	/*Methods*/
	
	/**
	 * @param owner only UserModel class with the owner of the question. The user has Type administrator
	 * @param enunciate only string not null and not empty
	 * @param alternative_A only string not null and not empty
	 * @param alternative_B only string not null and not empty
	 * @param alternative_C only string not null and not empty
	 * @param alternative_D only string not null and not empty
	 * @param alternative_E only string not null and not empty
	 * @param correct_letter only A,B,C,D ou E value. Contain the correct answer
	 * @param image_path only string with the path to a new image
	 * @param identifier only number values
	 */
	public function __construct($owner,$enunciate, $alternative_A, 
							$alternative_B, $alternative_C, $alternative_D, 
							$alternative_E, $correct_letter,
							$image_path = "", $identifier = NULL)
	{
		$this->setIdentifier($identifier);
		$this->setEnunciate($enunciate);
		$this->setImagePath($image_path);
		$this->setCorrectLetter($correct_letter);
		$this->setOwner($owner);
		$this->setAlternative($alternative_A, 'A');
		$this->setAlternative($alternative_B, 'B');
		$this->setAlternative($alternative_C, 'C');
		$this->setAlternative($alternative_D, 'D');
		$this->setAlternative($alternative_E, 'E');
	}
	
	/* Getters and setters */
	private function setIdentifier($identifier)
	{
		if(is_null($identifier) || is_numeric($identifier))
		{
			$this->identifier = $identifier;			
		}
		else
		{
			throw new QuestionModelException(self::INVALID_IDENTIFIER);
		}
	}
	
	private function setEnunciate($enunciate)
	{
		//Remove Spaces
		$enunciate = trim($enunciate);
		
		if($enunciate != NULL && $enunciate != "")
		{
			$this->enunciate = $enunciate;
		}
		else
		{
			throw new QuestionModelException(self::NULL_ENUNCIATE);
		}
	}
	
	private function setImagePath($image_path)
	{
		$image_path = trim($image_path);
		
		if($image_path == NULL)
		{
			//Define Default image
			$this->image_path = realpath('.') . '/user_image/default.png';
		}
		else
		{
			if(file_exists($image_path)) 
			{
				$this->image_path = $image_path;
			}else
			{
				throw new QuestionModelException(self::INVALID_PATCH);
			}
		}
	}
	
	private function setCorrectLetter($correct_letter)
	{
		$correct_letter = strtoupper($correct_letter);
		if(in_array($correct_letter, array('A','B','C','D','E')))
		{
			$this->correct_letter = $correct_letter;
		}
		else
		{
				throw new QuestionModelException(self::INVALID_CORRECT_ALTERNATIVE);
		}
	}
	
	private function setOwner($owner)
	{		
		if(get_class($owner) == "UserModel")
		{
			if($owner->getType() == "ADMINISTRATOR")
			{
				$this->owner = $owner;
			}
			else
			{
				throw new QuestionModelException(self::OWNER_NO_HAVE_PRIVILEGES);
			}
		}
		else
		{
			throw new QuestionModelException(self::INVALID_OWNER);
		}
	}
	
	/**
	 * Method to set a value in alternative
	 * @param alternative string with the value of alternative
	 * @param letter string contain A or B or C or D or E, letter with the correspondent alternative
	 */
	private function setAlternative($alternative, $tipe)
	{
		switch($tipe)
		{
			case 'A':
				$this->alternative_A = $alternative;
			break;
			case 'B':
				$this->alternative_B = $alternative;
			break;
			case 'C':
				$this->alternative_C = $alternative;
			break;
			case 'D':
				$this->alternative_D = $alternative;
			break;
			case 'E':
				$this->alternative_E = $alternative;
			break;
		}
	}
	public function getOwner()
	{
		return $this->owner;
	}
}


class QuestionModelException extends Exception{
	
	public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

