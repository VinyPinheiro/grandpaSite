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
	private $videos; // Array with Videos belonging to this category, value is null if attribute son_category have values.
					// The position attribute of each video must contain a unique and sequential ID ranging from 1 to 1 starting with the value 1
	
	/* Exceptions messengers */
	
	const INVALID_IDENTIFIER = "Identificador da categoria invalido.";
	const NULL_NAME = "O nome não pode ser nulo ou vazio.";
	const OWNER_NO_HAVE_PRIVILEGES = "Usuário não tem privilégios suficientes";
	const INVALID_OWNER = "Dono deve ser um objeto do tipo Usuário.";
	const OWNER_ISNT_OBJECT = "Dono deve ser um objeto.";
	const ALL_OBJECTS_MUST_BE_CATEGORYMODEL = "Todos os objetos do vetor de categorias devem ser do tipo CategoryModel";
	const SON_CATEGORY_ISNT_ARRAY = "As questões devem estar em um array";
	const ALL_OBJECTS_MUST_BE_VIDEOMODEL = "Todos os objetos do vetor de videos devem ser do tipo VideoModel";
	const VIDEO_ISNT_ARRAY = "Os videos devem estar em um array";
	const ALL_POSITIONS_ARE_NOT_UNIQUE_NOR_FAULT = "Alguma video repete a posição ou está faltando algum video da sequencia.";

	/* Method */
	
	/**
	 * @param name String Not null with the name of the category 
	 * @param owner UserModel object with the creator of this category
	 * @param videos Array with Videos belonging to this category, value is null if attribute son_category have values. The position attribute of each video must contain a unique and sequential ID ranging from 1 to 1 starting with the value 1
	 * @param son_category Array with Categories daughters of this category, value is null if attribute videos have values
	 * @param identifier Integer with the code of category or not null if the category is a new
	 */
	public function __construct($name, $owner, $videos = NULL, $son_category = NULL, $identifier = NULL)
	{
		$this->setIdentifier($identifier);
		$this->setName($name);
		$this->setOwner($owner);
		$this->setSonCategory($son_category);
		$this->setVideos($videos);
	}
	
	/**
	 * Method to using with usort to sort the video object by position
	 * @param video1 receive a VideoModel object, not null values
	 * @param video2 receive a VideoModel object, not null values
	 * @return -1 if video1 is before video2 and 1 if video1 after video2 or video1 equals video2
	 */
	private function compare($video1, $video2)
	{
		//Initialize variable with 0 (equals)
		$compare_result = 0;
		
		//Verify if position of video1 is before position video2
		if($video1->getPosition() < $video2->getPosition())
		{
			$compare_result = -1;
		}
		else
		{
			$compare_result = 1;
		}
		
		return $compare_result;
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
	
	private function setSonCategory($son_category)
	{
		if($son_category != NULL && $son_category != "")
		{
			if(is_array($son_category))
			{
				//Verify if all objects in $son_category is a CategoryModel type
				for($i = 0; $i < count($son_category); $i++)
				{
					if(is_object($son_category[$i]))
					{
						if(get_class($son_category[$i]) == "CategoryModel")
						{
							// Nothing to do.
						}
						else
						{
							throw new CategoryModelException(self::ALL_OBJECTS_MUST_BE_CATEGORYMODEL);
						}
					}
					else
					{
						throw new CategoryModelException(self::ALL_OBJECTS_MUST_BE_CATEGORYMODEL);
					}
				}

				//We came up here the array is valid
				$this->son_category = $son_category;
			}
			else
			{
				throw new CategoryModelException(self::SON_CATEGORY_ISNT_ARRAY);
			} 
		}
		else
		{
			$this->son_category = NULL;
		} 
	}
	
	public function setVideos($videos)
	{
		if($videos != NULL && $videos != "")
		{
			if(is_array($videos))
			{
				// Sort by position attribute the videos in the array
				usort($videos,"CategoryModel::compare");
				
				//Verify if all objects in $son_category is a CategoryModel type
				for($i = 0; $i < count($videos); $i++)
				{
					if(is_object($videos[$i]))
					{
						if(get_class($videos[$i]) == "VideoModel")
						{
							// Verifies that the position of the videos this sequential ordered ranging from 1 to 1 starting at 1
							if($videos[$i]->getPosition() == ($i + 1))
							{
								// Nothing to do.
							}
							else
							{
								throw new CategoryModelException(self::ALL_POSITIONS_ARE_NOT_UNIQUE_NOR_FAULT);
							}
						}
						else
						{
							throw new CategoryModelException(self::ALL_OBJECTS_MUST_BE_VIDEOMODEL);
						}
					}
					else
					{
						throw new CategoryModelException(self::ALL_OBJECTS_MUST_BE_VIDEOMODEL);
					}
				}

				//We came up here the array is valid
				$this->videos = $videos;
			}
			else
			{
				throw new CategoryModelException(self::VIDEOS_ISNT_ARRAY);
			} 
		}
		else
		{
			$this->videos = NULL;
		} 
	}
	
	public function getSons()
	{
		return $this->son_category;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getIdentifier()
	{
		return $this->identifier;
	}
	
	public function getOwner()
	{
		return $this->owner;
	}
	
	public function getVideos()
	{
		return $this->videos;
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
