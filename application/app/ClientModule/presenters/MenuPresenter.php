<?php
/**
 * Class MenuPresenter
 */

namespace ClientModule;

use Nette\Application\UI\Form;

class MenuPresenter extends BasePresenter
{
	/** @var \TablesRepository */
	private $tablesRepository;

	protected function startup()
	{
		parent::startup();

		$this->tablesRepository = $this->context->tablesRepository;
	}


	/**
	 * @return Form
	 */
	public function createComponentSetTableForm()
	{
		$form = new Form;
		$form->addSelect('id_table', 'Jste u stolu:', $this->tablesRepository->getForSelect())
			->addRule(Form::IS_IN, 'Vyberte stůl z nabídky.', array_keys($this->tablesRepository->getForSelect()));
		$form->addSubmit('send', 'Vybrat');
		$form->onSuccess[] = callback($this, 'setTableFormSubmitted');
		return $form;
	}


	/**
	 * @param Form $form
	 */
	public function setTableFormSubmitted(Form $form)
	{
		$values = $form->getValues();
		$this->user->idTable = $values->id_table;
		$this->flashMessage('Stůl uložen.', 'ok');
		$this->flashMessage('Pokud si přesednete, můžete změnit stůl v průběhu objednávky.', 'info');
		$this->redirect('Offer:');
	}
}
