<?php
/**
 * Class ItemsVariationsRepository
 */

class ItemsVariationsRepository extends BaseRepository
{
	public function __construct(DibiConnection $db)
	{
		parent::__construct($db);

		$this->table = 'items_variations';
	}


	/**
	 * @param int $id_items
	 *
	 * @return array
	 */
	public function findByItem($id_items)
	{
		return $this->findBy(array('id_items' => $id_items));
	}

}
