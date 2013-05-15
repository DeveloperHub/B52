<?php
/**
 * Class ClientsRepository
 */

class ClientsRepository extends BaseRepository
{
	public function __construct(DibiConnection $db)
	{
		parent::__construct($db);

		$this->table = 'clients';
	}


	/**
	 * @param string $email
	 *
	 * @return DibiRow|FALSE
	 */
	public function findByEmail($email)
	{
		$query = 'SELECT * FROM %n WHERE [email]=%s';
		return $this->db->query($query, $this->table, $email)->fetch();
	}
}
