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


	/**
	 * @return array of DibiRow
	 */
	public function findForWaitress()
	{
		$query = 'SELECT * FROM %n WHERE [to]="waitress" ORDER BY [posted] DESC';
		return $this->db->query($query, $this->table)->fetchAll();
	}


	/**
	 * @return mixed
	 */
	public function getCountUnreadForWaitress()
	{
		$query = 'SELECT COUNT([id]) FROM %n WHERE [unread] AND [to]="waitress"';
		return $this->db->query($query, $this->table)->fetchSingle();
	}


	/**
	 * @param int $idClient
	 */
	public function read($idClient)
	{
		$query = 'UPDATE %n SET [unread]=0 WHERE [to_client]=%i';
		$this->db->query($query, $this->table, $idClient);
	}


	/**
	 * @param int $id
	 */
	public function deleteByClient($id)
	{
		$query = 'DELETE FROM %n WHERE [to_client]=%i';
		$this->db->query($query, $this->table, $id);
	}
}
