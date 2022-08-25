<?php
namespace SSF;

// Exception
class Exception extends \Exception {
	public function __construct(string $message) {
		parent::__construct($message);
	}

	public function __toString(): string {
		return __CLASS__ . " error: {$this->message}\n";
	}
}
