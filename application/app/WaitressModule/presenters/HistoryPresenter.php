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

	/** @var \ExtrasRepository */
	private $extrasRepository;


	protected function startup()
	{
		parent::startup();

		$this->ordersRepository = $this->context->ordersRepository;
		$this->flashMessagesRepository = $this->context->flashMessagesRepository;
		$this->extrasRepository = $this->context->extrasRepository;
	}


	public function renderDefault($id, $idMessage)
	{
		if (isset($id)) {
			$orders = $this->ordersRepository->findBill($id);
			$this->template->idClient = $id;
			$this->template->idMessage = $idMessage;
		} else {
			$paginator = $this['paginator']->getPaginator();
			$paginator->itemCount = count($this->ordersRepository->findAll());

			$orders = $this->ordersRepository->findForHistory($paginator->itemsPerPage, $paginator->offset);
		}

		foreach ($orders as &$order) {
			if ($order->type == 'food') {
				$order->extras = $this->extrasRepository->findByIds($order->extras_items);
			}
		}
		$this->template->orders = $orders;
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
			$this->flashMessagesRepository->deleteByClient($id);

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
