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
}
