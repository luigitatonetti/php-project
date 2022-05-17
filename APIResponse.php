<?php

class APIResponse {

	protected
		$headers = array(),
		$responseCode = 200,
		$body = null
	;

	function setResponseCode($code) {

		$this->responseCode = $code;
	}

	function setBody($body) {

		$this->body = $body;
	}

	function addHeader($name, $value) {

		$this->headers[] = "{$name}: {$value}";
	}

	function printAnswer() {

		foreach ($this->headers as $h)
			header($h);

		http_response_code($this->responseCode);

		if ($this->body !== null)
			echo json_encode($this->body);
	}
}