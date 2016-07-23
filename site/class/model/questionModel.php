<?php
/**
 * file: questionModel.php
 * class to create a question object
 */
 
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
	
	public function __construct($owner,$enunciate, $alternative_A, 
							$alternative_B, $alternative_C, $alternative_D, 
							$alternative_E, $correct_letter,
							$image_path = NULL, $identifier = NULL)
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
		$this->identifier = $identifier;
	}
	private function setEnunciate($enunciate)
	{
		$this->enunciate = $enunciate;
	}
	private function setImagePath($image_path)
	{
		$this->image_path = $image_path;
	}
	private function setCorrectLetter($correct_letter)
	{
		$this->correct_letter = $correct_letter;
	}
	private function setOwner($owner)
	{
		$this->owner = $owner;
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
}


class UserQuestionException extends Exception{
	
	public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

