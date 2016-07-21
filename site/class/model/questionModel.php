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
	
	
}
