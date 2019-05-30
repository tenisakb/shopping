<?php

namespace App\Presenters;

use App\Model\CardsManager;
use App\Model\UsersManager;
use Nette;

class ReportsPresenter extends Nette\Application\UI\Presenter
{

	private $cardsManager;
	private $usersManager;


	public function __construct(CardsManager $cardsManager, UsersManager $usersManager)
	{
		$this->cardsManager = $cardsManager;
		$this->usersManager = $usersManager;
	}

	public function beforeRender()
	{
 		$this->template->userCount = $this->usersManager->count();
		$this->template->assignedCardsCount = $this->cardsManager->countAssigned();

		$usersWithPrices = "";
		foreach ($this->usersManager->getTopUsers(10) as $user => $totalSpend) {
			$usersWithPrices = $usersWithPrices.$user." (".$totalSpend." CZK) ";
		}
		$this->template->usersWithPrices = $usersWithPrices;
	}
}