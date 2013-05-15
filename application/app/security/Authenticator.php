<?php
/**
 * Class Authenticator
 */

use Nette\Security as NS;

class Authenticator extends Nette\Object implements NS\IAuthenticator
{
	/** @var ClientsRepository */
	private $clientsRepository;


	public function __construct(ClientsRepository $repository)
	{
		$this->clientsRepository = $repository;
	}


	public function authenticate(array $credentials)
	{
		list($email, $password) = $credentials;
		$row = $this->clientsRepository->findByEmail($email);
		if (!$row) {
			throw new NS\AuthenticationException('Špatné jméno nebo heslo.', self::INVALID_CREDENTIAL);
		}
		if ($row->password !== self::calculateHash($password, $row->password)) {
			throw new NS\AuthenticationException('Špatné jméno nebo heslo.', self::INVALID_CREDENTIAL);
		}

		unset($row->password);
		return new NS\Identity($row->id, 'client', $row->toArray());
	}


	/**
	 * @param string $password
	 * @param null|string $salt
	 *
	 * @return string
	 */
	public static function calculateHash($password, $salt = null)
	{
		if ($salt === null) {
			$salt = '$2a$07$' . Nette\Utils\Strings::random(22);
		}
		return crypt($password, $salt);
	}
}
