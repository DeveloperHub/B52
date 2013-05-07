<?php
/**
 * Class MainMenuPresenter
 */

namespace ClientModule;

class MainMenuPresenter extends BasePresenter
{
	/** @var \MainMenuRepository */
	private $mainMenuRepository;


	protected function startup()
	{
		parent::startup();
		$this->mainMenuRepository = $this->context->mainMenuRepository;
	}

	public function renderDefault()
	{
		$this->template->mainMenu = $this->mainMenuRepository->findAll();
	}
}
