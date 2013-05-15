<?php
/**
 * Class FlashMessagesPresenter
 */

namespace ClientModule;

use Nette\DateTime;
use Nette\Diagnostics\Debugger;

class FlashMessagesPresenter extends BasePresenter
{
	/** @var \FlashMessagesRepository */
	private $flashMessagesRepository;

	/** @var \TablesRepository */
	private $tableRepository;


	protected function startup()
	{
		parent::startup();

		$this->flashMessagesRepository = $this->context->flashMessagesRepository;
		$this->tableRepository = $this->context->tablesRepository;
	}


	public function renderDefault()
	{
		$this->template->messages = $this->flashMessagesRepository->findByClient($this->idClient);
		$this->flashMessagesRepository->read($this->idClient);
	}


	public function actionCallWaitress()
	{
		try {
			$table = $this->tableRepository->findById($this->user->idTable);

			$message =
				'Klient ' .
				$this->user->name .
				' vás volá ke stolu ' .
				(isset($table->name) ? $table->name : $table->number) .
				'.'
			;
			$data = array(
				'posted' => new DateTime,
				'from' => 'client',
				'to' => 'waitress',
				'from_client' => $this->idClient,
				'id_tables' => $table->id,
				'message' => $message,
			);
			$this->flashMessagesRepository->insert($data);

			$this->flashMessage('Obsluha zavolána.', 'ok');
		} catch (\DibiDriverException $e) {
			Debugger::log($e);
			$this->flashMessage('Nepodařilo se přivolat obsluhu.', 'error');
		}

		$this->redirect('Offer:default');
	}


	public function actionPay($method)
	{
		try {
			$table = $this->tableRepository->findById($this->user->idTable);

			$message =
				'Klient ' .
				$this->user->name .
				' u stolu ' .
				(isset($table->name) ? $table->name : $table->number) .
				' bude platit ' .
				$this->paymentMethod[$method] .
				'.'
			;
			$data = array(
				'posted' => new DateTime,
				'from' => 'client',
				'to' => 'waitress',
				'from_client' => $this->idClient,
				'id_tables' => $table->id,
				'message' => $message,
			);
			$this->flashMessagesRepository->insert($data);

			$this->flashMessage('Požádáno o účet.', 'ok');
		} catch (\DibiDriverException $e) {
			Debugger::log($e);
			$this->flashMessage('Nepodařilo se informovat o placení.', 'error');
		}

		$this->redirect('Offer:default');
	}

}
