<?php
/**
 * Class ExtrasRepository
 */

class ExtrasRepository extends BaseRepository
{
	/** @var string */
	private $subtable;

	/** @var string */
	private $keysTable;


	public function __construct(DibiConnection $db)
	{
		parent::__construct($db);

		$this->table = 'extras';
		$this->subtable = 'extras_items';
		$this->keysTable = 'keys_categories_and_item_and_extras_items';
	}


	/**
	 * @param int $category
	 *
	 * @return array od DibiRow
	 */
	public function findByCategory($category)
	{
		$query =
			'SELECT [e.name] AS [extra], [i.id], [i.name], [i.detail], [i.quantity], [i.price] ' .
			'FROM %n AS [e] ' .
			'LEFT JOIN %n AS [i] ON [i.id_extras]=[e.id] AND [i.active] ' .
			'LEFT JOIN %n AS [k] ON [k.id_extras_items]=[i.id] ' .
			'WHERE [e.active] AND [k.id_categories]=%i'
		;
		return $this->db->query($query, $this->table, $this->subtable, $this->keysTable, $category)->fetchAssoc('extra,id');
	}


	/**
	 * @param int $item
	 *
	 * @return array od DibiRow
	 */
	public function findByItem($item)
	{
		$query =
			'SELECT [e.name] AS [extra], [i.id], [i.name], [i.detail], [i.quantity], [i.price] ' .
			'FROM %n AS [e] ' .
			'LEFT JOIN %n AS [i] ON [i.id_extras]=[e.id] AND [i.active] ' .
			'LEFT JOIN %n AS [k] ON [k.id_extras_items]=[i.id] ' .
			'WHERE [e.active] AND [k.id_items]=%i'
		;
		return $this->db->query($query, $this->table, $this->subtable, $this->keysTable, $item)->fetchAssoc('extra,id');
	}


	/**
	 * @param string $ids "id:id:id"
	 *
	 * @return array of DibiRow
	 */
	public function findByIds($ids)
	{
		$ids = explode(':', $ids);
		$query = 'SELECT * FROM %n WHERE [id] IN %in';
		return $this->db->query($query, $this->subtable, $ids)->fetchAll();
	}

}
