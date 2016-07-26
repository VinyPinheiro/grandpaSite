<?php
/**
 * file: dao.php
 * class to manipulate database connection
 */
 
class DAO
{
	/* Class attributes */
	private $host;
	private $user;
	private $password;
	private $database;
	private $connection;
	
	/* Exception messengers */
	
	const WRONG_QUERY = "Query não foi compilada com sucesso.";
	const CONNECTION_FAILED = "Falha na conexão.";
	const INVALID_HOST = "Host inválido.";
	const NULL_HOST = "Host não pode ser vazio ou nulo.";
	const NULL_USER = "User não pode ser vazio ou nulo.";
	const NULL_DATABASE = "Database não pode ser vazio ou nulo.";
	
	/**
	 * Define attributes necessaries for the DAO
	 * @param $host string with not null value and the host of database
	 * @param $user string with not null value and the user of database server 
	 * @param $passwoord string with not null value and the user password's
	 * @param $database string with not null value and the name of schema in database server
	 */ 
	public function __construct($host, $user, $password, $database)
	{
		setHost($host);
		setUser($user);
		setPasword($password);
		setDatabase($database);
		
	}
	
	/**
	 * Method to open and execute a new query in database
	 * @param $query DML, DTL or DQL for database
	 * @return resultset for the query
	 */
	protected function query($query)
	{
		$this->connection();
		
		$resultset = $this->connection->query($query);
		
		if($resultset)
		{
			return $resultset;
		}
		else
		{
			throw new DatabaseException(self::WRONG_QUERY);
		}
		
	}
	
	/**
	 * Method to return errors in sql
	 * @return string with error messenger
	 */
	protected function getErrors()
	{
		return $this->connection->error;
	}
	
	/**
	 * Mehod to close connection with database server
	 */
	protected function disconnect(){
		
		$this->connection->close();
	}
	
	/**
	 * Method to return the inserted id by auto_increment, return 0 if
	 *   not used an insert on table with auto_increment
	 */
	protected function insert_id(){
		
		return $this->connection->insert_id;
	}
	
	/**
	 * Method to try open a new connection
	 */
	protected function connection()
	{
		
		$this->connection = new mysqli($this->host, $this->user, $this->password, $this->database);
		
		if(!mysqli_connect_errno())
		{
			// Nothing to do
		}
		else
		{
			throw new DatabaseException(self::CONNECTION_FAILED);
		}
	}

	private function setHost($host)
	{
		if($host != NULL && $host != "")
		{
			if(filter_var($host,FILTER_VALIDATE_URL))
			{
				$this->host = $host;
			}
			else
			{
				throw new DatabaseException(self::INVALID_HOST);
			}
		}
		else
		{
			throw new DatabaseException(self::NULL_HOST);
		}
	}

	private function setUser($user)
	{
		if($user != NULL && $user != "")
		{
			$this->user = $user;
		}
		else
		{
			throw new DatabaseException(self::NULL_USER);
		}
	}
	
	private function setDatabase($database)
	{
		if($database != NULL && $database != "")
		{
			$this->database = $database;
		}
		else
		{
			throw new DatabaseException(self::NULL_DATABASE);
		}
	}

	private function setPassword($password)
	{
		$this->password = $password;
	}
}

class DatabaseException extends Exception{
	
	public function __construct($message, $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

?>
