<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	protected function startup()
	{
		parent::startup();

		$this->template->registerHelperLoader('Helpers::loader');
	}


	/**
	 * @return VisualPaginator
	 */
	protected function createComponentPaginator()
	{
		$visualPaginator = new VisualPaginator;
		$paginator = $visualPaginator->getPaginator();
		$paginator->setItemsPerPage(25);
		return $visualPaginator;
	}
}
