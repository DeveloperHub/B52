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

}
