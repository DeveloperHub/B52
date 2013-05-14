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

	/** @var \ExtrasRepository */
	private $extrasRepository;


	protected function startup()
	{
		parent::startup();

		$this->ordersRepository = $this->context->ordersRepository;
		$this->flashMessagesRepository = $this->context->flashMessagesRepository;
		$this->extrasRepository = $this->context->extrasRepository;
	}


	public function renderDefault()
	{
		$tables = $this->ordersRepository->findForWaitress();
		foreach ($tables as &$table) {
			foreach ($table['food'] as &$food) {
				$food->extras = $this->extrasRepository->findByIds($food->extras_items);
			}
		}
		$this->template->tables = $tables;
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
			($status == 'in progress' ? 'Připravujeme' : ($status == 'done' ? 'Neseme' : 'Rušíme')) .
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
