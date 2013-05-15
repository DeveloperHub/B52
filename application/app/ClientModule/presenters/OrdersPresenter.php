<?php
/**
 * Class OrdersPresenter
 */

namespace ClientModule;

use Nette\Application\UI\Form;
use Nette\Callback;
use Nette\DateTime;
use Nette\Utils\Strings;

class OrdersPresenter extends BasePresenter
{
	/** @var \OrdersRepository */
	private $ordersRepository;

	/** @var \ItemsRepository */
	private $itemsRepository;

	/** @var \ItemsVariationsRepository */
	private $itemsVariationsRepository;

	/** @var \TablesRepository */
	private $tablesRepository;

	/** @var \ExtrasRepository */
	private $extrasRepository;

	/** @var \ClientsRepository */
	private $clientsRepository;

	/** @var \DibiRow */
	private $item;

	/** @var array of DibiRow */
	private $extras;


	protected function startup()
	{
		parent::startup();

		$this->ordersRepository = $this->context->ordersRepository;
		$this->itemsRepository = $this->context->itemsRepository;
		$this->itemsVariationsRepository = $this->context->itemsVariationsRepository;
		$this->tablesRepository = $this->context->tablesRepository;
		$this->extrasRepository = $this->context->extrasRepository;
		$this->clientsRepository = $this->context->clientsRepository;
	}


	/**
	 * @param $id
	 * @param null $idVariation
	 */
	public function actionItem($id, $idVariation)
	{
		$this->item = $this->itemsRepository->findById($id);
		if (isset($idVariation)) {
			$variation = $this->itemsVariationsRepository->findById($idVariation);
			$this->item->quantity = $variation->quantity;
			$this->item->price = $variation->price;
		}
		$this->extras = $this->getExtras($this->item->id_categories, $this->item->id);
	}
	public function renderItem()
	{
		$this->template->item = $this->item;
		$this->template->extras = $this->extras;
	}


	public function renderBasket()
	{
		$orders = $this->ordersRepository->findForBasket($this->idClient);
		foreach ($orders as &$order) {
			$order->extras = $this->extrasRepository->findByIds($order->extras_items);
		}
		$this->template->orders = $orders;
	}


	public function renderReceipt()
	{
		$orders = $this->ordersRepository->findForReceipt($this->idClient);
		foreach ($orders as &$order) {
			$order->extras = $this->extrasRepository->findByIds($order->extras_items);
		}
		$this->template->orders = $orders;
	}


	/**
	 * @return Form
	 */
	public function createComponentOrderForm()
	{
		$idItem = $this->getParameter('id');
		$idVariation = $this->getParameter('idVariation');

		$form = new Form;
		$form->addHidden('item', $idItem);

		if (isset($idVariation)) {
			$variations = $this->itemsVariationsRepository->findByItem($idItem);
			$allowed = array();
			foreach ($variations as $variation) {
				$allowed[] = $variation->id;
			}
			$form->addHidden('variation', $idVariation)
				->addRule(Form::IS_IN, 'Ve variacích položek není dobré se hrabat ;o)', $allowed);
		}

		$form->addText('count', 'Počet')
				->setType('number')
				->setDefaultValue(1)
				->addRule(Form::INTEGER, 'Počet musí být číslo.')
				->addRule(Form::RANGE, 'Počet musí být minimálně %d.', array(1, 255));

		$extrasContainer = $form->addContainer('extras');
		foreach ($this->extras as $name => $extra) {
			$options = array('' => '---');
			foreach ($extra as $item) {
				$options[$item->id] = $item->name;
			}
			$extrasContainer->addSelect(Strings::webalize($name), $name, $options);
		}

		$options = $this->tablesRepository->getForSelect();
		$form->addSelect('table', 'Stůl č.', $options)
			->setDefaultValue($this->user->idTable)
			->addRule(Form::IS_IN, 'Stůl musí být z výběru.', array_keys($options));

		$form->addTextArea('note', 'Poznámka');

		$form->addSubmit('send', 'Objednat');

		$form->onSuccess[] = callback($this, 'orderFormSuccess');

		return $form;
	}


	/**
	 * @param Form $form
	 */
	public function orderFormSuccess(Form $form)
	{
		$values = $form->getValues();

		$this->user->idTable = $values->table;

		$data = array(
			'id_items' => $values->item,
			'id_tables' => $values->table,
			'id_clients' => $this->idClient,
			'ordered' => new DateTime(),
			'count' => $values->count,
			'note' => $values->note,
		);

		if (isset($values->variation)) {
			$data['id_items_variations'] = $values->variation;
		}

		if (count($values->extras)) {
			$extras = array();
			foreach ($values->extras as $id) {
				$extras[] = $id;
			}
			$data['extras_items'] = implode(':', $extras);
		}

		$this->ordersRepository->insert($data);
		$this->flashMessage('Objednávka odeslána.', 'ok');
		$this->redirect('Offer:default');
	}
}
