<?php

namespace App\Presenters;

use App\Exceptions\ValidationException;
use App\Model\CardsManager;
use App\Model\UsersManager;
use Nette;
use Ublaboo\DataGrid\DataGrid;


class UsersPresenter extends Nette\Application\UI\Presenter
{
	/** @var UsersManager */
	private $usersManager;

	/** @var CardsManager */
	private $cardsManager;

	public function __construct(UsersManager $usersManager, CardsManager $cardsManager)
	{
		$this->usersManager = $usersManager;
		$this->cardsManager = $cardsManager;
	}

	public function createComponentSimpleGrid($name)
	{
		$grid = new DataGrid($this, $name);

		$availableCards=$this->cardsManager->getAllAvailableCardIds();
		$grid->setDataSource($this->usersManager->getAllUsersArray());

		/**
		 * Add form
		 */
		$grid->addInlineAdd()
			->onControlAdd[] = function($container) use ($availableCards) {
			$container->addText('name', '');
			$container->addText('surname', '');
			$container->addTextArea('address', '')->setAttribute("style","height:100px;");
			$container->addEmail('email', '');
			$container->addText('phone', '')->setAttribute("pattern","[0-9]{9}")->setAttribute("placeholder","XXXXXXXXX")->setAttribute("maxlength",9)->setAttribute("title","title");
			$container->addMultiSelect('cardsSimple', '', $availableCards)->setAttribute("size",5)->setAttribute("style","height: 100%; min-width: 120px;");
		};

		$grid->getInlineAdd()->onSubmit[] = function($values) {
			try{
				$this->usersManager->insertUser($values);
			} catch (ValidationException $ex) {
				$this->flashMessage('Failed. Reason: '.$ex->getMessage(), 'error');
				$this->redirect('Users:Default');
				return;
			}

			$this->flashMessage('Success! User sucessfully created.', 'success');
			$this->redirect('Users:Default');
		};

		/**
		 * Columns
		 */
		$grid->addColumnText('id', 'Id')
			->addAttributes(["width" => "6%"])
			->setAlign('left')
			->setSortable();

		$grid->addColumnText('name', 'Name')
			->setSortable();

		$grid->addColumnText('surname', 'Surname')
			->setSortable();

		$grid->addColumnText('address', 'Address')
			->setSortable();

		$grid->addColumnText('email', 'Email')
			->setSortable();

		$grid->addColumnText('phone', 'Phone')
			->setSortable();

		$grid->addColumnText('cardsSimple', 'Cards')
			->setSortable();


		/**
		 * Filters
		 */
		$grid->addFilterText('id', 'Search', ['id']);
		$grid->addFilterText('name', 'Search', ['name']);
		$grid->addFilterText('surname', 'Search', ['surname']);
		$grid->addFilterText('address', 'Search', ['address']);
		$grid->addFilterText('email', 'Search', ['email']);
		$grid->addFilterText('phone', 'Search', ['phone']);
		$grid->addFilterText('cardsSimple', 'Search', ['cardsSimple']);
	}
}
