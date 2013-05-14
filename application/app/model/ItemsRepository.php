<?php
/**
 * Class ItemsRepository
 */

class ItemsRepository extends BaseRepository
{
	/** @var string */
	private $subtable;

	public function __construct(DibiConnection $db)
	{
		parent::__construct($db);

		$this->table = 'items';
		$this->subtable = 'items_variations';
	}


	/**
	 * @param int $id
	 *
	 * @return array of DibiRow
	 */
	public function findByParent($id)
	{
		$query = 'SELECT * FROM %n WHERE [active] AND %and';
		return $this->db->query($query, $this->table, array('id_categories' => $id))->fetchAll();
	}


	/**
	 * @return array of DibiRow
	 */
	public function findAll()
	{
		$query =
			'SELECT [i].*, IFNULL([v.quantity],[i.quantity]) AS [quantity], IFNULL([v.price],[i.price]) AS [price] ' .
			'FROM %n AS [i]' .
			'LEFT JOIN %n AS [v] ON [v.id_items]=[i.id] AND [v.active] ' .
			'WHERE [i.active]'
		;
		return $this->db->query($query)->fetchAll();
	}

}
