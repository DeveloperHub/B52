<?php
/**
 * Class BasePresenter
 */

namespace WaitressModule;

abstract class BasePresenter extends \BasePresenter
{
	/** @var \FlashMessagesRepository */
	private $flashMessagesRepository;


	protected function startup()
	{
		parent::startup();

		$this->flashMessagesRepository = $this->context->flashMessagesRepository;
	}


	protected function beforeRender()
	{
		parent::beforeRender();

		$this->template->countMessages = $this->flashMessagesRepository->getCountUnreadForWaitress();
	}

}
