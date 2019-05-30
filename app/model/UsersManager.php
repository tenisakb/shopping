<?php

namespace App\Model;

use App\Exceptions\MissingFieldException;
use App\Exceptions\WrongAddressException;
use App\Exceptions\WrongEmailFormatException;
use App\Exceptions\WrongNameException;
use App\Exceptions\WrongPhoneFormatException;
use App\Exceptions\WrongSurnameException;
use Nette;

class UsersManager
{
	use Nette\SmartObject;

	/**
	 * @var Nette\Database\Context
	 */
	private $database;
	private $cardsManager;
	private $ordersManager;

	public $DB_NAME = 'users';

	public function __construct(Nette\Database\Context $database, CardsManager $cardsManager, OrdersManager $ordersManager)
	{
		$this->database = $database;
		$this->cardsManager = $cardsManager;
		$this->ordersManager = $ordersManager;
	}

	public function getAllUsers()
	{
		return $this->database->table($this->DB_NAME);
	}

	/**
	 * Adds cardsSimple to the array, which summaries cards of user
	 */
	public function getAllUsersArray()
	{
		$data = array();

		foreach ($this->getAllUsers() as $user) {
			$groups = array();

			$data[] = [
				'id' => $user->offsetGet("id"),
				'name' => $user->offsetGet("name"),
				'surname' => $user->offsetGet("surname"),
				'email' => $user->offsetGet("email"),
				'address' => $user->offsetGet("address"),
				'phone' => $user->offsetGet("phone"),
				'cards' => $groups,
				'cardsSimple' => $this->cardsManager->getCardsForUserSimpleText($user->offsetGet("id"))
			];
		}

		return $data;
	}

	/**
	 * Returns array of top users with user name + surname as key and spent amount as value.
	 */
	public function getTopUsers($limit)
	{
		$data = array();

		foreach ($this->getAllUsers() as $user) {
			$data[$user->name." ".$user->surname] =  $this->ordersManager->countValueOfOrders($this->ordersManager->getLastMonthOrders($user->id));
		}
		arsort($data);
		return array_slice($data, 0, $limit);
	}

	public function insertUser($data)
	{

		if (strlen($data['name']) == 0 || strlen($data['name'] > 32))
			throw new WrongNameException("invalid name format - length");

		if (strlen($data['surname']) == 0 || strlen($data['surname'] > 32))
			throw new WrongSurnameException("invalid surname format - length");

		if (strlen($data['address']) == 0 || strlen($data['address'] > 32))
			throw new WrongAddressException("invalid address format - length");

		if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL))
			throw new WrongEmailFormatException("wrong email format");

		if (!preg_match("/^[0-9]{9}$/", $data['phone']))
			throw new WrongPhoneFormatException("wrong phone format, needs to be equal to exactly 9 digits");

		try {
			$row = $this->database->table($this->DB_NAME)->insert([
				'name' => $data['name'],
				'surname' => $data['surname'],
				'address' => $data['address'],
				'email' => $data['email'],
				'phone' => $data['phone']]);
		} catch (\Exception $ex) {
			throw new MissingFieldException("database insert failed");
		}

		$this->cardsManager->updateCardsForUser($row->offsetGet('id'), $data['cardsSimple']);
	}

	public function count()
	{
		return $this->database->table($this->DB_NAME)->count();
	}
}