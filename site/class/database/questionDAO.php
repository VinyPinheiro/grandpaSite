<?php
/**
 * file: questionDAO.php
 * class to persist data in database tfrom questionModel
 */

require_once(realpath('.') . '/class/database/dao.php');
require_once(realpath('.') . '/class/database/userDAO.php');
require_once(realpath('.') . '/class/configuration/globals.php');

class QuestionDAO extends DAO
{
	/* Class attributes */
	private $question;
	
	/* Exceptions messengers */

	const INVALID_MODEL = "question deve ser um objeto do tipo QuestionModel.";
	const QUESTION_MODEL_ISNT_OBJECT = "question deve ser um objeto.";
	const EXISTENT_IDENTIFIER = "Identificador já cadastrado.";
	const NOT_EXISTENT_IDENTIFIER = "Identificador não cadastrado.";
	const INVALID_IDENTIFIER = "Para atualização o novo identificador não pode ser nulo nem vazio.";

	/* Help constants */
	
	const CLASS_EXCEPTION_CODE = 2;
	
	/* Methods */

	/**
	 * Define attributes necessaries for the DAO
	 * @param $host string with not null value and the host of database
	 * @param $user string with not null value and the user of database server 
	 * @param $passwoord string with not null value and the user password's
	 * @param $database string with not null value and the name of schema in database server
	 * @param $question QuestionModel object type
	 */ 
	public function __construct($host, $user, $password, $database, $question)
 	{
		parent::__construct($host, $user, $password, $database);
		$this->setQuestionModel($question);
	}
			
	/**
	 * Method to find and locate an Question By Identifier
	 * @param identifier contain an integer with the question code or a null value if a new question
	 * @return returns null if not found Question or returns a question with your data
	 */
	public static function findByIdentifier($identifier)
	{
		//Set variable to return for null
		$question = NULL;
		
		if($identifier != NULL && $identifier != "")
		{
			//Try open connection
			$connection = new DAO(Globals::HOST, Globals::USER, Globals::PASSWORD, Globals::DATABASE);
			$connection->connection();
			
			//Save result for query
			$data_result = $connection->query("SELECT enunciation,image,a,b,c,d,e,correct,email FROM QUESTION WHERE identifier = " . $identifier);
			
			//Verify if found register
			if($data_result->num_rows != 0)
			{
				$data = $data_result->fetch_array();
				$question = new QuestionModel(UserDAO::findByEmail($data['email']),$data['enunciation'],
					$data['a'],$data['b'],$data['c'],$data['d'],$data['e'],$data['correct'],
					$data['image'],$identifier);
			}
			else
			{
				$question = NULL;
			}
			
			$connection->disconnect();
		}
		else
		{
			$question = NULL;
		}
		
		return $question;
	}
		
	/**
	 * Method to save this Question in database
	 * @return Value of identifier of the inserted value
	 */
	public function register()
	{
		//Verify if register exists
		if(self::findByIdentifier($this->question->getIdentifier()) == NULL)
		{
			parent::query("INSERT INTO QUESTION(a,b,c,d,e,correct,enunciation,image,email,identifier) VALUES(".
				"'{$this->question->getAlternative_A()}','{$this->question->getAlternative_B()}',".
				"'{$this->question->getAlternative_C()}','{$this->question->getAlternative_D()}',".
				"'{$this->question->getAlternative_E()}','{$this->question->getCorrectLetter()}',".
				"'{$this->question->getEnunciate()}','{$this->question->getImagePath()}'," .
				"'{$this->question->getOwner()->getEmail()}','{$this->question->getIdentifier()}')");
				
			return parent::insert_id();
		}
		else
		{
			throw new DatabaseException(self::EXISTENT_IDENTIFIER, self::CLASS_EXCEPTION_CODE);
		}
	}
	
	/**
	 * Method to remove this Question for database
	 */
	public function delete()
	{
		//Verify if register exists
		if(self::findByIdentifier($this->question->getIdentifier()) != NULL)
		{
			parent::query("DELETE FROM QUESTION WHERE identifier = {$this->question->getIdentifier()}");
			$this->question = NULL;
		}
		else
		{
			throw new DatabaseException(self::NOT_EXISTENT_IDENTIFIER, self::CLASS_EXCEPTION_CODE);
		}
	}
	
	
	/**
	 * Method to update question data in database
	 * @param new_question not null value, the QuestionModel with the new values
	 */
	public function update($new_question)
	{
		if(intval($this->question->getIdentifier()) == $new_question->getIdentifier())
		{
			$this->updateSameIdentifier($new_question);
		}
		else
		{
			if(self::findByIdentifier($this->question->getIdentifier()) != NULL)
			{
				if(self::findByIdentifier($new_question->getIdentifier()) == NULL && $new_question->getIdentifier() != NULL)
				{
					parent::query("UPDATE QUESTION SET a = '{$new_question->getAlternative_A()}', b = '{$new_question->getAlternative_B()}'," .
						"c = '{$new_question->getAlternative_C()}',d = '{$new_question->getAlternative_D()}'," .
						"e = '{$new_question->getAlternative_E()}',correct = '{$new_question->getCorrectLetter()}'," .
						"enunciation = '{$new_question->getEnunciate()}', image = '{$new_question->getImagePath()}'," .
						"email = '{$new_question->getOwner()->getEmail()}', identifier = '{$new_question->getIdentifier()}' " .
						"WHERE identifier = '{$this->question->getIdentifier()}'");
						$this ->question = $new_question;
				}
				else
				{
					throw new DatabaseException(self::INVALID_IDENTIFIER, self::CLASS_EXCEPTION_CODE);
				}
			}
			else
			{
				throw new DatabaseException(self::NOT_EXISTENT_IDENTIFIER, self::CLASS_EXCEPTION_CODE);
			}
		}
	}
	
	/**
	 * Method to update question data in database, but identifier attribute not change
	 * @param new_question not null value, the QuestionModel with the new values
	 */
	private function updateSameIdentifier($new_question)
	{
		//Verify if register exists
		if(self::findByIdentifier($this->question->getIdentifier()) != NULL)
		{
			parent::query("UPDATE QUESTION SET a = '{$new_question->getAlternative_A()}', b = '{$new_question->getAlternative_B()}'," .
				"c = '{$new_question->getAlternative_C()}',d = '{$new_question->getAlternative_D()}'," .
				"e = '{$new_question->getAlternative_E()}',correct = '{$new_question->getCorrectLetter()}'," .
				"enunciation = '{$new_question->getEnunciate()}', image = '{$new_question->getImagePath()}'," .
				"email = '{$new_question->getOwner()->getEmail()}' WHERE identifier = '{$this->question->getIdentifier()}'");
				
				$this ->question = $new_question;
		}
		else
		{
			throw new DatabaseException(self::NOT_EXISTENT_IDENTIFIER, self::CLASS_EXCEPTION_CODE);
		}
	}
	
	
	/* Getter and Setter */

	private function setQuestionModel($question)
	{
		if(is_object($question))
		{
			if(get_class($question) == "QuestionModel")
			{
				$this->question = $question;
			}
			else
			{
				throw new DatabaseException(self::INVALID_MODEL, self::CLASS_EXCEPTION_CODE);
			}
		}
		else
		{
			throw new DatabaseException(self::QUESTION_MODEL_ISNT_OBJECT, self::CLASS_EXCEPTION_CODE);
		}
	}
}
