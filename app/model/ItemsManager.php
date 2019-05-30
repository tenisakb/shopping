<?php

namespace App\Model;

use Nette;

class ItemsManager
{
	use Nette\SmartObject;

	/**
	 * @var Nette\Database\Context
	 */
	private $database;

	public $DB_NAME = 'items';

	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	public function getItemById($itemId)
	{
		return $this->database->table($this->DB_NAME)->where("id = ?", $itemId)->fetch();
	}
}