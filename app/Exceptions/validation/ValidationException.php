<?php


namespace App\Exceptions;

use Nette\Neon\Exception;

class ValidationException extends Exception
{
	public $error_message;
}