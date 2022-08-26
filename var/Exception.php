<?php
namespace SSF;

// Exception
class Exception extends \Exception {
	protected $className;

	public function __construct(string $className, string $message) {
		parent::__construct($message);
		$this->className = $className;
	}

	public function __toString(): string {
		return "{$this->className}: {$this->message}\n";
	}
}
