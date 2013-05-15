<?php

/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{
	/** @var array */
	protected $orderStatus;


	protected function startup()
	{
		parent::startup();

		$this->template->registerHelperLoader('Helpers::loader');

		$this->orderStatus = array(
			'wait' => 'čeká',
			'in progress' => 'v přípravě',
			'done' => 'hotovo',
			'paid' => 'zaplaceno',
		);

		if ($this->getPresenter()->getName() == 'Sign' && $this->getUser()->isLoggedIn()) {
			$this->redirect('Client:Offer:');
		}
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
