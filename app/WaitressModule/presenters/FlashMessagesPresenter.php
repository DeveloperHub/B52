<?php
/**
 * Class FlashMessages
 */

namespace WaitressModule;

use Nette\DateTime;
use Nette\Diagnostics\Debugger;

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
		$messages = $this->flashMessagesRepository->findForWaitress();
		foreach ($messages as &$message) {
			preg_match('~platit~', $message->message, $match);
			if (count($match)) {
				$message->pay = true;
			} else {
				$message->pay = false;
			}
		}
		$this->template->messages = $messages;
	}


	/**
	 * @param int $id
	 */
	public function handleRead($id)
	{
		try {
			$message = $this->flashMessagesRepository->findById($id);

			$data = array(
				'posted' => new DateTime,
				'from' => 'waitress',
				'to' => 'client',
				'to_client' => $message->from_client,
				'message' => 'Víme o Vás.',
			);
			$this->flashMessagesRepository->insert($data);
			$this->flashMessagesRepository->update(array('unread' => false), $message->id);
		} catch (\DibiDriverException $e) {
			Debugger::log($e, 'error');
			$this->flashMessage('Chyba při potvrzení notifikace.');
		}

		$this->redirect('this');
	}
}
