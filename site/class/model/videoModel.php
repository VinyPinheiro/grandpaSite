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
	private $questions; //Array contain all question objects from this video
	
	/* Exceptions messengers */
	
	const INVALID_IDENTIFIER = "Identificador da questão invalido.";
	const NULL_LINK = "Link não pode ser nulo ou vazio.";
	const LINK_GREAT_THAN_200 = "Link não pode ultrapassar 200 caracteres."; 

	/* Methods */
	
	/**
	 * @param identifier Number with the identifier code for the video. If is a new video, this value is null.
	 * @param link String with the youtube video identifier. Not null value and less 200 caracters
	 * @param position Only number with the position of video in the category
	 * @param questions Array contain all question objects from this video, if no has question, this value is NULL
	 */
	public function __construct($link, $position, $identifier = NULL, $questions = NULL)
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
			if(strlen($link) <= 200)
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
		$this->position = $position;
	}

	private function setQuestions($question)
	{
		$this->questions = $question;
	}
}

class VideoModelException extends Exception{
	
	public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

