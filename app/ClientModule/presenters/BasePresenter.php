<?php
/**
 * Class BasePresenter
 */

namespace ClientModule;

abstract class BasePresenter extends \BasePresenter
{
	/** @var \ExtrasRepository */
	private $extrasRepository;

	/** @var int */
	protected $idClient;


	protected function startup()
	{
		parent::startup();

		$this->extrasRepository = $this->context->extrasRepository;

		$this->idClient = 1;
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
