<?php
/**
 * Class FlashMessagesPresenter
 */

namespace ClientModule;

class FlashMessagesPresenter extends BasePresenter
{
	/** @var \FlashMessagesRepository */
	private $flashMessagesRepository;


	protected function startup()
	{
		parent::startup();

		$this->flashMessagesRepository = $this->context->flashMessagesRepository;
	}


	public function renderDefault()
	{
		$this->template->messages = $this->flashMessagesRepository->findByClient($this->idClient);
	}


	/**
	 * @param int $id
	 */
	public function handleRead($id)
	{
		$this->flashMessagesRepository->update(array('unread' => false), $id);
		$this->redirect('this');
	}
}
