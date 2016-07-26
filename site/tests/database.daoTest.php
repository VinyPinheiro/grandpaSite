<?php
/**
 * file: database.daoTest.php
 */
 
class DaoTest extends PHPUnit_Framework_TestCase
{
	private $connection;
	
	public function setUp()
	{
		$this->connection = new DAO(Globals::$HOST, Globals::$USER, Globals::$PASSWORD, Globals::$DATABASE);
	}
	
	public function testCorrectQuery()
	{
		$this->useDatabaseQuery();
	}	
	
	/**
	 * @expectedException DatabaseException
	 * @expectedExceptionMessage DAO::WRONG_QUERY
	 */
	public function testWrongQuery()
	{
		$this->connection->query("usse " . Globals::$DATABASE . ";");
	}	
	
	
	private function useDatabaseQuery()
	{
		$this->connection->query("use " . Globals::$DATABASE . ";");
		$this->connection->disconnect();
	}
}

