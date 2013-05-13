<?php
/**
 * Class FlashMessagesRepository
 */

class FlashMessagesRepository extends BaseRepository
{
	public function __construct(DibiConnection $db)
	{
		parent::__construct($db);

		$this->table = 'flash_messages';
	}


	/**
	 * @param int $id
	 *
	 * @return array of DibiRow
	 */
	public function findByClient($id)
	{
		$query = 'SELECT * FROM %n WHERE [to_client]=%i ORDER BY [posted] DESC';
		return $this->db->query($query, $this->table, $id)->fetchAll();
	}


	/**
	 * @param int $id
	 *
	 * @return mixed
	 */
	public function getCountUnreadForClient($id)
	{
		$query = 'SELECT COUNT([id]) FROM %n WHERE [unread] AND [to_client]=%i';
		return $this->db->query($query, $this->table, $id)->fetchSingle();
	}
}
