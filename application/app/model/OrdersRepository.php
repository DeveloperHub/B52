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
			'SELECT [o].*,[t.number],[c.name] AS [client],[i.type],[i.name] AS [item],IFNULL([v.quantity],[i.quantity]) AS [quantity] ' .
			'FROM %n AS [o] ' .
			'LEFT JOIN %n AS [t] ON [o.id_tables]=[t.id] ' .
			'LEFT JOIN %n AS [c] ON [o.id_clients]=[c.id] ' .
			'LEFT JOIN %n AS [i] ON [o.id_items]=[i.id] ' .
			'LEFT JOIN %n AS [v] ON [o.id_items_variations]=[v.id] ' .
			'WHERE [o.status] NOT IN %l ' .
			'ORDER BY [o.ordered]'
		;
		return $this->db->query($query, $this->table, 'tables', 'clients', 'items', 'items_variations', array('in basket', 'done', 'canceled', 'paid'))->fetchAssoc('id_tables,type,id');
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


	/**
	 * @param int $limit
	 * @param int $offset
	 *
	 * @return array of DibiRow
	 */
	public function findForHistory($limit, $offset)
	{
		$query =
			'SELECT [o].*,[t.number],[c.name] AS [client],[i.type],[i.name] AS [item], ' .
			'IFNULL([i.quantity],[v.quantity]) AS [quantity] ' .
			'FROM %n AS [o] ' .
			'LEFT JOIN %n AS [t] ON [o.id_tables]=[t.id] ' .
			'LEFT JOIN %n AS [c] ON [o.id_clients]=[c.id] ' .
			'LEFT JOIN %n AS [i] ON [o.id_items]=[i.id] ' .
			'LEFT JOIN %n AS [v] ON [o.id_items_variations]=[v.id] ' .
			'WHERE [o.status]!="in basket" ' .
			'ORDER BY [o.ordered] DESC' .
			'%lmt %ofs'
		;
		return $this->db->query($query, $this->table, 'tables', 'clients', 'items', 'items_variations', $limit, $offset)->fetchAll();
	}


	/**
	 * @param int $idClient
	 *
	 * @return array of DibiRow
	 */
	public function findForBasket($idClient)
	{
		$query =
			'SELECT [o.id], [o.extras_items], [i.name],' .
			'IFNULL([i.quantity],[v.quantity]) AS [quantity], IFNULL([i.price],[v.price]) AS [price] ' .
			'FROM %n AS [o] ' .
			'LEFT JOIN %n AS [i] ON [i.id]=[o.id_items] ' .
			'LEFT JOIN %n AS [v] ON [v.id]=[o.id_items_variations] ' .
			'WHERE [o.status]="in basket" AND [id_clients]=%i'
		;
		return $this->db->query($query, $this->table, 'items', 'items_variations', $idClient)->fetchAll();
	}


	/**
	 * @param int $idClient
	 *
	 * @return array of DibiRow
	 */
	public function findForReceipt($idClient)
	{
		$query =
			'SELECT [o.id], [o.status], [o.extras_items], [i.name],' .
			'IFNULL([i.quantity],[v.quantity]) AS [quantity], IFNULL([i.price],[v.price]) AS [price] ' .
			'FROM %n AS [o] ' .
			'LEFT JOIN %n AS [i] ON [i.id]=[o.id_items] ' .
			'LEFT JOIN %n AS [v] ON [v.id]=[o.id_items_variations] ' .
			'WHERE [id_clients]=%i'
		;
		return $this->db->query($query, $this->table, 'items', 'items_variations', $idClient)->fetchAll();
	}


	/**
	 * @param int $idClient
	 */
	public function sendAnOrder($idClient)
	{
		$data = array(
			'status' => 'wait',
			'ordered' => new \Nette\DateTime(),
		);
		$where = array(
			'status' => 'in basket',
			'id_clients' => $idClient,
		);
		$query = 'UPDATE %n SET %a WHERE %and';
		$this->db->query($query, $this->table, $data, $where);
	}


	/**
	 * @param int $idClient
	 *
	 * @return array of DibiRow
	 */
	public function findBill($idClient)
	{
		$query =
				'SELECT [o].*,[t.number],[c.name] AS [client],[i.type],[i.name] AS [item], ' .
				'IFNULL([i.quantity],[v.quantity]) AS [quantity] ' .
				'FROM %n AS [o] ' .
				'LEFT JOIN %n AS [t] ON [o.id_tables]=[t.id] ' .
				'LEFT JOIN %n AS [c] ON [o.id_clients]=[c.id] ' .
				'LEFT JOIN %n AS [i] ON [o.id_items]=[i.id] ' .
				'LEFT JOIN %n AS [v] ON [o.id_items_variations]=[v.id] ' .
				'WHERE [o.id_clients]=%i AND [o.status]="done" ' .
				'ORDER BY [ordered] DESC'
		;
		return $this->db->query($query, $this->table, 'tables', 'clients', 'items', 'items_variations', $idClient)->fetchAll();
	}


	/**
	 * @param int $id
	 */
	public function paid($id)
	{
		$query = 'UPDATE %n SET [status]="paid" WHERE [id_clients]=%i AND [status]="done"';
		$this->db->query($query, $this->table, $id);
	}


	/**
	 * @param int $interval
	 *
	 * @return mixed
	 */
	public function getCountNew($interval)
	{
		$query = 'SELECT COUNT([id]) FROM %n WHERE [ordered]>NOW() - INTERVAL %i SECOND';
		return $this->db->query($query, $this->table, $interval)->fetchSingle();
	}
}
