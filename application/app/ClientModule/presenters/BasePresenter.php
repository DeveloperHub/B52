<?php
/**
 * Class BasePresenter
 */

namespace ClientModule;

abstract class BasePresenter extends \BasePresenter
{
	/** @var \ExtrasRepository */
	private $extrasRepository;

	/** @var \FlashMessagesRepository */
	private $flashMessagesRepository;

	/** @var int */
	protected $idClient;

	/** @var \Nette\Http\SessionSection */
	protected $user;

	/** @var array */
	protected $paymentMethod;


	protected function startup()
	{
		parent::startup();

		if (!$this->getUser()->isInRole('client')) {
			$this->flashMessage('Přihlašte se.', 'info');
			$this->redirect(':Sign:in');
		}

		$this->extrasRepository = $this->context->extrasRepository;
		$this->flashMessagesRepository = $this->context->flashMessagesRepository;

		$this->paymentMethod = array(
			'cash' => 'hotově',
			'card' => 'kartou',
		);

		$this->idClient = $this->getUser()->getId();

		$this->user = $this->getSession('user');
		$data = $this->getUser()->getIdentity()->getData();
		$this->user->name = $data['name'];
	}


	protected function beforeRender()
	{
		parent::beforeRender();

		$this->template->countMessages = $this->flashMessagesRepository->getCountUnreadForClient($this->idClient);
		$this->template->idClient = $this->idClient;
	}


	/**
	 * @param int $idCategory
	 * @param int $idItem
	 *
	 * @return array of DibiRow
	 */
	protected function getExtras($idCategory, $idItem)
	{
		return array_merge($this->extrasRepository->findByCategory($idCategory), $this->extrasRepository->findByItem($idItem));
	}
}
