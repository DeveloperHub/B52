<?php
/**
 * Class TablesRepository
 */

class TablesRepository extends BaseRepository
{
	public function __construct(DibiConnection $db)
	{
		parent::__construct($db);

		$this->table = 'tables';
	}


	/**
	 * @return array [id => name|number]
	 */
	public function getForSelect()
	{
		$query = 'SELECT [id], IFNULL([name],[number]) AS [name] FROM %n ORDER BY [number]';
		return $this->db->query($query, $this->table)->fetchPairs();
	}
}
