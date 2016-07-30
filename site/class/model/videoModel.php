<?php
/**
 * file: videoModel.php
 * class to create a user object
 */

class VideoModel
{
	
	/* Class attributes */
	
	private $identifier; //Number with the identifier code for the video. If is a new video, this value is null.
	private $link; //String with the youtube video identifier. Not null value and less 200 caracters
	private $position; //Only number with the position of video in the category
	private $questions; //Array associative contain all question objects from this video
	
	/* Exceptions messengers */
	
	const INVALID_IDENTIFIER = "Identificador da questão invalido.";
	const NULL_LINK = "Link não pode ser nulo ou vazio.";
	const LINK_GREAT_THAN_200 = "Link não pode ultrapassar 200 caracteres.";
	const ONLY_UNSIGNED_VALUE = "Apenas valores positivos.";
	const ONLY_NUMERIC_NUMBER = "Apenas valores numéricos.";
	const ALL_OBJECTS_MUST_BE_QUESTIONMODEL = "Todos os objetos do vetor de questões devem ser do tipo QuestionModel";
	const QUESTION_ISNT_ARRAY = "As questões devem estar em um array";

	/* Help constants */

	const MAX_CARACTERS = 200;
	const DEFAULT_VIDEO_POSITION = 0;

	/* Methods */
	
	/**
	 * @param identifier Number with the identifier code for the video. If is a new video, this value is null.
	 * @param link String with the youtube video identifier. Not null value and less 200 caracters
	 * @param position Only number with the position of video in the category
	 * @param questions Array contain all question objects from this video, if no has question, this value is NULL
	 */
	public function __construct($link, $position, $identifier = NULL, $questions = array())
	{
		$this->setIdentifier($identifier);	
		$this->setLink($link);	
		$this->setPosition($position);	
		$this->setQuestions($questions);
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
			throw new VideoModelException(self::INVALID_IDENTIFIER);
		}
	
	}

	private function setLink($link)
	{
		$link = trim($link);
		
		if($link != NULL && $link != "")
		{
			if(strlen($link) <= self::MAX_CARACTERS)
			{
				$this->link = $link;
			}
			else
			{
				throw new VideoModelException(self::LINK_GREAT_THAN_200);
			}
		}
		else
		{
			throw new VideoModelException(self::NULL_LINK);
		}
	}

	private function setPosition($position)
	{
		if(is_numeric($position))
		{
			$position = intval($position);
			if($position >= self::DEFAULT_VIDEO_POSITION)
			{
				$this->position = $position;
			}
			else
			{
				throw new VideoModelException(self::ONLY_UNSIGNED_VALUE);
			}
		}
		else
		{
			throw new VideoModelException(self::ONLY_NUMERIC_NUMBER);
		}
	}

	private function setQuestions($question)
	{
		if(is_array($question))
		{
			if(count($question) > 0)
			{
				//Verify if all objects in $question is a QuestionModel type
				for($i = 0; $i < count($question); $i++)
				{
					if(is_object($question[$i]))
					{
						if(get_class($question[$i]) == "QuestionModel")
						{
							// Nothing to do.
						}
						else
						{
							throw new VideoModelException(self::ALL_OBJECTS_MUST_BE_QUESTIONMODEL);
						}
					}
					else
					{
						throw new VideoModelException(self::ALL_OBJECTS_MUST_BE_QUESTIONMODEL);
					}

				}

				//We came up here the array is valid
				$this->questions = $question;
			}
			else
			{
				$this->questions = $question;
			}
		}
		else
		{
			throw new VideoModelException(self::QUESTION_ISNT_ARRAY);
		}
	}
	
	public function getPosition()
	{
		return $this->position;
	}
}

/**
 * @codeCoverageIgnore
 */
class VideoModelException extends Exception{
	
	public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

