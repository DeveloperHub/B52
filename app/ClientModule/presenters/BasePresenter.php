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


	protected function startup()
	{
		parent::startup();

		$this->extrasRepository = $this->context->extrasRepository;
		$this->flashMessagesRepository = $this->context->flashMessagesRepository;

		$this->idClient = 1;
	}


	protected function beforeRender()
	{
		parent::beforeRender();

		$this->template->countMessages = $this->flashMessagesRepository->getCountUnreadForClient($this->idClient);
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
