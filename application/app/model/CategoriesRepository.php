<?php
/**
 * Class CategoriesRepository
 */

class CategoriesRepository extends BaseRepository
{
	public function __construct(DibiConnection $db)
	{
		parent::__construct($db);

		$this->table = 'categories';
	}


	/**
	 * @param int $id
	 *
	 * @return array of DibiRow
	 */
	public function findByParent($id)
	{
		$query = 'SELECT * FROM %n WHERE %and';
		return $this->db->query($query, $this->table, array('id_categories' =>$id))->fetchAll();
	}

}
