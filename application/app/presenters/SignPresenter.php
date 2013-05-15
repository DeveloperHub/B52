<?php
/**
 * Class SignPresenter
 */

use Nette\Application\UI\Form,
	Nette\Security as NS;
use Nette\Diagnostics\Debugger;

class SignPresenter extends BasePresenter
{
	/** @var \ClientsRepository */
	private $clientsRepository;


	protected function startup()
	{
		parent::startup();

		$this->clientsRepository = $this->context->clientsRepository;
	}


	protected function createComponentSignUpForm()
	{
		$form = new Form;
		$form->addText('name', 'Jméno:', 30, 50)
				->setRequired('Vyplňte %label.');
		$form->addText('email', 'E-mail:', 30, 50)
				->setType('email')
				->setRequired('Vyplňte %label.')
				->addRule(Form::EMAIL, 'Napište %label správně.');
		$form->addPassword('password', 'Heslo:', 30)
				->setRequired('Vyplňte %label.');
		$form->addPassword('pass_checkup', 'Heslo znova:', 30)
				->setRequired('Vyplňte %label.')
				->addRule(Form::EQUAL, 'Hesla se musí shodovat.', $form['password']);
		$form->addSubmit('signup', 'Registrovat se');
		$form->onSuccess[] = $this->signUpFormSubmitted;
		return $form;
	}


	public function signUpFormSubmitted(Form $form)
	{
		try {
			$values = $form->getValues();

			$data = array(
				'name' => $values->name,
				'email' => $values->email,
				'password' => \Authenticator::calculateHash($values->password),
			);
			$idClient = $this->clientsRepository->insert($data);
			$client = $this->clientsRepository->findById($idClient);

			$user = $this->getUser();
			$user->setExpiration('+1 days', false);
			$user->login($client->email, $values->password);

			$this->flashMessage('Registrace proběhla úspěšně. Jste přihlášeni.', 'ok');
			$this->redirect('Client:Offer:');
		} catch (\DibiDriverException $e) {
			if ($e->getCode() == 1062) {
				$this->flashMessage('Tento e-mail je již zaregistrovaný.', 'info');
				$form->addError(null);
			} else {
				Debugger::log($e, 'error');
				$this->flashMessage('Nepodařilo se Vás zaregistroval.', 'warning');
				$form->addError(null);
			}
		} catch (NS\AuthenticationException $e) {
			Debugger::log($e);
			$this->flashMessage('Chyba při přihlašování.', 'warning');
			$form->addError(null);
		}
	}


	protected function createComponentSignInForm()
	{
		$form = new Form;
		$form->addText('email', 'E-mail:', 30, 50)
				->setType('email')
				->setRequired('Vyplňte %label.');
		$form->addPassword('password', 'Heslo:', 30)
				->setRequired('Vyplňte %label.');
		$form->addSubmit('signin', 'Přihlásit se');
		$form->onSuccess[] = $this->signInFormSubmitted;
		return $form;
	}


	public function signInFormSubmitted(Form $form)
	{
		try {
			$user = $this->getUser();
			$values = $form->getValues();
			$user->setExpiration('+1 days', false);
			$user->login($values->email, $values->password);
			$this->flashMessage('Přihlášení bylo úspěšné.', 'ok');
			$this->redirect('Client:Offer:');
		} catch (NS\AuthenticationException $e) {
			$this->flashMessage('Neplatný e-mail nebo heslo.', 'error');
			$form->addError(null);
		}
	}
}
