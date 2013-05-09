<?php
/**
 * Class HistoryPresenter
 */

namespace WaitressModule;

class HistoryPresenter extends BasePresenter
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
		$paginator = $this['paginator']->getPaginator();
		$paginator->itemCount = count($this->ordersRepository->findAll());

		$this->template->orders = $this->ordersRepository->findForHistory($paginator->itemsPerPage, $paginator->offset);
	}
}
