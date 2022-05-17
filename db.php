<?php

class DB {

	protected
		$host,
		$username,
		$password,
		$dbname
	;

	function __construct($host, $username, $password, $dbname) {

		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->dbname = $dbname;
	}

	protected
		$connection,
		$connectionOpen = false
	;

	function isConnectionOpen() { return $this->connectionOpen; }
	function getConnection() { return $this->connection; }

	function openConnection() {

		$connectionString = "mysql:host={$this->host};dbname={$this->dbname};";

		try {

			$this->connection = new PDO($connectionString, $this->username, $this->password);

			$this->connectionOpen = true;

		} catch (PDOException $e) {

			$this->connectionOpen = false;
		}
	}

	function select($sql, $parameters = array()) {

		$st = $this->getConnection()->prepare($sql);
		if ($st->execute($parameters) /* === true */) {

			$rows = array();
			while (($row = $st->fetch(PDO::FETCH_ASSOC)) !== false)
				$rows[] = $row;

			return $rows;

		} else {

			return false;
		}
	}
}