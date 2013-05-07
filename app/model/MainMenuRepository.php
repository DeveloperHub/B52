<?php
/**
 * Class MainMenuRepository
 */

class MainMenuRepository extends BaseRepository
{
	public function __construct(DibiConnection $db)
	{
		parent::__construct($db);

		$this->table = 'main_menu';
	}

}
