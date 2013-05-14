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

}
