<?php
/**
 * Class OrdersRepository
 */

class OrdersRepository extends BaseRepository
{
	public function __construct(DibiConnection $db)
	{
		parent::__construct($db);

		$this->table = 'orders';
	}


	/**
	 * @return array
	 */
	public function findForWaitress()
	{
		$query =
			'SELECT [o].*,[t.number],[c.name] AS [client],[i.type],[i.name] AS [item],[i.quantity] ' .
			'FROM %n AS [o] ' .
			'LEFT JOIN %n AS [t] ON [o.id_tables]=[t.id] ' .
			'LEFT JOIN %n AS [c] ON [o.id_clients]=[c.id] ' .
			'LEFT JOIN %n AS [i] ON [o.id_items]=[i.id] ' .
			'WHERE [status] NOT IN %l ' .
			'ORDER BY [ordered]'
		;
		return $this->db->query($query, $this->table, 'tables', 'clients', 'items', array('done', 'canceled'))->fetchAssoc('id_tables,type,id');
	}


	/**
	 * @param int $id
	 *
	 * @return DibiRow|FALSE
	 */
	public function findWithItemById($id)
	{
		$query =
			'SELECT [o].*,[i].* ' .
			'FROM %n AS [o] ' .
			'LEFT JOIN %n AS [i] ON [o.id_items]=[i.id] ' .
			'WHERE [o.id]=%i'
		;
		return $this->db->query($query, $this->table, 'items', $id)->fetch();
	}
}
