<?php

class APIRequest {

	protected
		$method,
		$queryString = array(),
		$body,

		$entity,
		$idEntity
	;

	function getMethod() { return $this->method; }
	function getEntity() { return $this->entity; }
	function getIdEntity() { return $this->idEntity; }
	function getBody() { return $this->body; }

	function hasQSParameter($name) { return array_key_exists($name, $this->queryString); }
	function getQSParameter($name) { return array_key_exists($name, $this->queryString) ? $this->queryString[$name] : null; }

	function decodeHTTPRequest() {

		$this->method = $_SERVER['REQUEST_METHOD'];
		$path = $_SERVER['PATH_INFO'];

		$this->queryString = $_GET;

		$this->body = json_decode(file_get_contents('php://input'), true);

		$p = explode('/', substr($path, 1));

		$this->entity = $p[0];

		$this->idEntity = array_key_exists(1, $p)
			? (int)$p[1]
			: null
		;
	}

		// funzioni con maggiore significato semantico

	function isGET() { return $this->method === 'GET'; }
	function isPOST() { return $this->method === 'POST'; }
	function isPUT() { return $this->method === 'PUT'; }
	function isDELETE() { return $this->method === 'DELETE'; }
	function hasEntityId() { return $this->idEntity !== null; }
}