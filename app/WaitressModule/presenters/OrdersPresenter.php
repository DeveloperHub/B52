<?php
/**
 * Class OrdersPresenter
 */

namespace WaitressModule;

use Nette\DateTime;

class OrdersPresenter extends BasePresenter
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


	public function renderDefault()
	{
		$this->template->tables = $this->ordersRepository->findForWaitress();
	}


	/**
	 * @param int $id
	 * @param string $status
	 */
	public function handleChangeStatus($id, $status)
	{
		$update = array('status' => $status);
		$this->ordersRepository->update($update, $id);

		$order = $this->ordersRepository->findWithItemById($id);

		$message =
			($status == 'in progress' ? 'Připravují' : ($status == 'done' ? 'Nesou' : 'Zrušili')) .
			' objednávku: ' . $order->count . 'x ' . $order->name
		;
		$insert = array(
			'posted' => new DateTime,
			'from' => 'waitress',
			'to' => 'client',
			'to_client' => $order->id_clients,
			'message' => $message,
		);
		$this->flashMessagesRepository->insert($insert);

		$this->redirect('this');
	}
}
