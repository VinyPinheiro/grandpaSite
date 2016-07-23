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
	
	/* Exceptions messengers */
	
	const INVALID_IDENTIFIER = "Identificador da questão invalido.";

	/* Methods */
	
	/**
	 * @param identifier Number with the identifier code for the video. If is a new video, this value is null.
	 * @param link String with the youtube video identifier. Not null value and less 200 caracters
	 * @param position Only number with the position of video in the category
	 */
	public function __construct($link, $position, $identifier = NULL)
	{
		$this->setIdentifier($identifier);	
		$this->setLink($link);	
		$this->setPosition($position);	
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
		$this->link = $link;
	}

	private function setPosition($position)
	{
		$this->position = $position;
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

