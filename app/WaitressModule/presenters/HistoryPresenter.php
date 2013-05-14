<?php
/**
 * Class HistoryPresenter
 */

namespace WaitressModule;

use Nette\DateTime;
use Nette\Diagnostics\Debugger;

class HistoryPresenter extends BasePresenter
{
	/** @var \OrdersRepository */
	private $ordersRepository;

	/** @var \FlashMessagesRepository */
	private $flashMessagesRepository;


	protected function startup()
	{
		parent::startup();

		$this->ordersRepository = $this->context->ordersRepository;
		$this->flashMessagesRepository = $this->context->flashMessagesRepository;
	}


	public function renderDefault($id, $idMessage)
	{
		if (isset($id)) {
			$this->template->orders = $this->ordersRepository->findBill($id);
			$this->template->idClient = $id;
			$this->template->idMessage = $idMessage;
		} else {
			$paginator = $this['paginator']->getPaginator();
			$paginator->itemCount = count($this->ordersRepository->findAll());

			$this->template->orders = $this->ordersRepository->findForHistory($paginator->itemsPerPage, $paginator->offset);
		}
	}


	/**
	 * @param int $id
	 * @param int $idMessage
	 */
	public function handlePay($id, $idMessage)
	{
		try {
			$this->ordersRepository->paid($id);
			$this->flashMessagesRepository->update(array('unread' => false), $idMessage);

			$data = array(
				'posted' => new DateTime,
				'from' => 'waitress',
				'to' => 'client',
				'to_client' => $id,
				'message' => 'Připravujeme účet.',
			);
			$this->flashMessagesRepository->insert($data);
		} catch (\DibiDriverException $e) {
			Debugger::log($e, 'error');
			$this->flashMessage('Nepodařilo se zaplatit objednávky.', 'error');
			$this->redirect('this');
		}

		$this->redirect('FlashMessages:default');
	}
}
