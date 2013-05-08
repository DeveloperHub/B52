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


	protected function startup()
	{
		parent::startup();

		$this->ordersRepository = $this->context->ordersRepository;
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
		$data = array('status' => $status);
		$this->ordersRepository->update($data, $id);
		$this->redirect('this');
	}
}
