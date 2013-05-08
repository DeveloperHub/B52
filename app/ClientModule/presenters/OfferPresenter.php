<?php
/**
 * Class OfferPresenter
 */

namespace ClientModule;

class OfferPresenter extends BasePresenter
{
	/** @var \MainMenuRepository */
	private $mainMenuRepository;

	/** @var \CategoriesRepository */
	private $categoriesRepository;

	/** @var \ItemsRepository */
	private $itemsRepository;


	protected function startup()
	{
		parent::startup();

		$this->categoriesRepository = $this->context->categoriesRepository;
		$this->itemsRepository = $this->context->itemsRepository;
		$this->mainMenuRepository = $this->context->mainMenuRepository;
	}


	/**
	 * @param $id
	 */
	public function renderDefault($id)
	{
		$this->template->parent = $this->categoriesRepository->findbyId($id);
		$this->template->categories = $this->categoriesRepository->findByParent($id);
		$this->template->items = $this->itemsRepository->findByParent($id);
		$this->template->mainMenu = $this->mainMenuRepository->findAll();
	}


	/**
	 * @param $id
	 */
	public function renderDetail($id)
	{
		$this->template->item = $this->itemsRepository->findById($id);
	}
}
