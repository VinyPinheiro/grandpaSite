<?php
/**
 * file: model.userModelTest.php
 */
 
class UserModelTest extends PHPUnit_Framework_TestCase
{
	
	public function testCreateValidUser()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","123456789","1995-02-14","MAN","STUDENT");
		
		$correctName = strcmp("Vinicius Pinheiro", $user->getName()) == 0;
		$correctEmail = strcmp("viny-pinheiro@hotmail.com", $user->getEmail()) == 0;
		$correctDate = strcmp("1995-02-14", $user->getBirthdate()) == 0;
		$correctSex = strcmp("MAN", $user->getSex()) == 0;
		$correctType = strcmp("STUDENT", $user->getType()) == 0;
		
		assert ($correctName,"Expected \"Vinicius Pinheiro\" but receive " . $user->getName());
		assert ($correctName,"Expected \"viny-pinheiro@hotmail.com\" but receive " . $user->getEmail());
		assert ($user->verifyPassword("123456789"), "Diferents passwords");
		assert ($correctDate,"Expected \"1995-02-14\" but receive " . $user->getBirthdate());
		assert ($correctSex,"Expected \"MAN\" but receive " . $user->getSex());
		assert ($correctType,"Expected \"STUDENT\" but receive " . $user->getType());
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Nome não pode ser nulo.
	*/
	public function testNULLName()
	{
		$user = new UserModel(NULL,"viny-pinheiro@hotmail.com","12345678","1995-02-14","MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Nome não pode ser nulo.
	*/
	public function testEmptyName()
	{
		$user = new UserModel("","viny-pinheiro@hotmail.com","12345678","1995-02-14","MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Nome não pode ser nulo.
	*/
	public function testOnlySpacesInName()
	{
		$user = new UserModel("     ","viny-pinheiro@hotmail.com","12345678","1995-02-14","MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Nome não pode ter mais que 200 caracteres.
	*/
	public function testNameGreaterThan200()
	{
		$user = new UserModel("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"
		     ,"viny-pinheiro@hotmail.com","12345678","1995-02-14","MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Email inválido.
	*/
	public function testEmailWithoutAt()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheirohotmail.com","12345678","1995-02-14","MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Email inválido.
	*/
	public function testEmailWithoutdomain()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@.com","12345678","1995-02-14","MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Email inválido.
	*/
	public function testEmailWithoutaddress()
	{
		$user = new UserModel("Vinicius Pinheiro","@hotmail.com","12345678","1995-02-14","MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Email inválido.
	*/
	public function testNULLEmail()
	{
		$user = new UserModel("Vinicius Pinheiro",NULL,"12345678","1995-02-14","MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Email inválido.
	*/
	public function testEmptyEmail()
	{
		$user = new UserModel("Vinicius Pinheiro","","12345678","1995-02-14","MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Senha menor que 8 caracteres.
	*/
	public function testSmallerPassword()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","1234567","1995-02-14","MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Senha maior que 40 caracteres.
	*/
	public function testGreatPassword()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","01234567890123456789012345678901234567890","1995-02-14","MAN","STUDENT");
	}
	
	public function testWithEncriptedPassword()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","$2y$10$9vrLr8EgCVvXHtEe8AqekeCyTTJakERw6eihlksz9q3toJMCHr5Ae","1995-02-14","MAN","STUDENT");
		assert ($user->verifyPassword("senha"), "Diferents passwords");
	}
	
	public function testWithEncriptedPasswordAndWrongComparation()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","$2y$10$9vrLr8EgCVvXHtEe8AqekeCyTTJakERw6eihlksz9q3toJMCHr5Ae","1995-02-14","MAN","STUDENT");
		assert (!$user->verifyPassword("senhaa"), "Returned equals password, but the second is diferent");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Data não pode ser nula.
	*/
	public function testNULLBirthdate()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678",NULL,"MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Data não pode ser nula.
	*/
	public function testEmptyBirthdate()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","","MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Formato da data inválido.
	*/
	public function testWrongFormatBirthdate()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1995-14-02","MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Data invalida.
	*/
	public function testWrongBirthdate()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1995-02-31","MAN","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Data invalida.
	*/
	public function testWrongLeapBirthdate()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1995-02-29","MAN","STUDENT");
	}
	
	public function testLeapBirthdate()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1996-02-29","MAN","STUDENT");
	}
	
	public function testMaleSex()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1995-02-14","MAN","STUDENT");
	}
	
	public function testFemaleSex()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1995-02-14","WOMAN","STUDENT");
	}
	
	
	public function testMaleSexLowerCase()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1995-02-14","man","STUDENT");
	}
	
	public function testFemaleSexLowerCase()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1995-02-14","woman","STUDENT");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Sexo invalido
	*/
	public function testWrongSex()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1995-02-14","WeMEN","STUDENT");
	}
	
	public function testStudentType()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1995-02-14","MAN","STUDENT");
	}
	
	public function testAdministratorType()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1995-02-14","WOMAN","ADMINISTRATOR");
	}
	
	
	public function testStudentTypeLowerCase()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1995-02-14","man","student");
	}
	
	public function testAdministratorTypeLowerCase()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1995-02-14","woman","administrator");
	}
	
	/**
	* @expectedException UserModelException
	* @expectedExceptionMessage Tipo de registro invalido.
	*/
	public function testWrongType()
	{
		$user = new UserModel("Vinicius Pinheiro","viny-pinheiro@hotmail.com","12345678","1995-02-14","MAN","ERRADO");
	}
}

