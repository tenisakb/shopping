<?php

namespace App\Model;

use Nette;

class CardsManager
{
	use Nette\SmartObject;

	/**
	 * @var Nette\Database\Context
	 */
	private $database;

	public $DB_NAME = 'cards';

	public function __construct(Nette\Database\Context $database)
	{
		$this->database = $database;
	}

	public function getAllAvailableCardIds()
	{
		$ids = array();
		foreach ($this->database->table($this->DB_NAME)->where("user_id = ?", 0) as $row) {
			$ids[$row->id] = $row->id;
		}
		return $ids;
	}

	public function countAssigned()
	{
		return $this->database->table($this->DB_NAME)->where("user_id != ?", 0)->count();
	}


	/**
	 * Return simple string of users cards
	 */
	public function getCardsForUserSimpleText($userId) {
		$userCards = $this->database->table($this->DB_NAME)->where("user_id = ?", $userId);
		$cardsSimple = "";
		foreach ($userCards as $card) {
			if(strlen($cardsSimple) == 0) {
				$cardsSimple = $card->id;
			} else {
				$cardsSimple = $cardsSimple.", ".$card->id;
			}
		}
		return $cardsSimple;
	}

	public function updateCardsForUser($userId, $cards) {
		foreach ($cards as $card) {
			$this->database->query('UPDATE '.$this->DB_NAME.' SET', [
				'user_id' => $userId
			], 'WHERE id = ?', $card);
		}
	}
}