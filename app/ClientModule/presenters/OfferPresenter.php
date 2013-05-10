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

	/** @var \ItemsVariationsRepository */
	private $itemsVariationsRepository;

	/** @var \ExtrasRepository */
	private $extrasRepository;

	protected function startup()
	{
		parent::startup();

		$this->categoriesRepository = $this->context->categoriesRepository;
		$this->itemsRepository = $this->context->itemsRepository;
		$this->itemsVariationsRepository = $this->context->itemsVariationsRepository;
		$this->mainMenuRepository = $this->context->mainMenuRepository;
		$this->extrasRepository = $this->context->extrasRepository;
	}


	/**
	 * @param $id
	 */
	public function renderDefault($id)
	{
		$this->template->parent = $this->categoriesRepository->findbyId($id);
		$this->template->categories = $this->categoriesRepository->findByParent($id);
		$items = $this->itemsRepository->findByParent($id);
		foreach ($items as &$item) {
			$item->variations = $this->itemsVariationsRepository->findByItem($item->id);
		}
		$this->template->items = $items;
		$this->template->mainMenu = $this->mainMenuRepository->findAll();
	}


	/**
	 * @param $id
	 */
	public function renderDetail($id)
	{
		$item = $this->itemsRepository->findById($id);
		$this->template->item = $item;
		$this->template->variations = $this->itemsVariationsRepository->findByItem($id);
		$extras = $this->extrasRepository->findByCategory($item->id_categories);
		array_merge($extras, $this->extrasRepository->findByItem($id));
		$this->template->extras = $extras;
	}
}
