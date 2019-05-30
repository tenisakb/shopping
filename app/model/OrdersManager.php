<?php

namespace App\Model;

use Nette;

class OrdersManager
{
	use Nette\SmartObject;

	/**
	 * @var Nette\Database\Context
	 */
	private $database;
	private $itemsManager;

	public $DB_NAME = 'orders';
	public $DB_NAME_HAS_ITEMS = 'order_has_item';

	public function __construct(Nette\Database\Context $database, ItemsManager $itemsManager)
	{
		$this->database = $database;
		$this->itemsManager = $itemsManager;
	}

	public function countValueOfOrders($orders) {
		$totalValue = 0;
		foreach ($orders as $order) {
			foreach ($this->database->table($this->DB_NAME_HAS_ITEMS)->where("order_id = ?", $order->id) as $orderHasItem) {
				$totalValue = $totalValue + $this->itemsManager->getItemById($orderHasItem->item_id)->price;
			}
		}
		return $totalValue;
	}

	public function getLastMonthOrders($userId) {
		return $this->database->table($this->DB_NAME)->where("user_id = ? AND created_date > ?", $userId, date("Y-m-d H:i:s",strtotime("-1 month")));
	}
}