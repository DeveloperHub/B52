<?php
/**
 * Class BaseRepository
 */

abstract class BaseRepository extends \Nette\Object
{
	/** @var DibiConnection */
	protected $db;

	/** @var string */
	protected $table;


	/**
	 * @param DibiConnection $db
	 */
	public function __construct(DibiConnection $db)
	{
		$this->db = $db;
	}


	/**
	 * @return array of DibiRow
	 */
	public function findAll()
	{
		$query = 'SELECT * FROM %n';
		return $this->db->query($query, $this->table)->fetchAll();
	}


	/**
	 * @param array $by
	 *
	 * @return array of DibiRow
	 */
	public function findBy(array $by)
	{
		$query = 'SELECT * FROM %n WHERE %and';
		return $this->db->query($query, $this->table, $by)->fetchAll();
	}


	/**
	 * @param int $id
	 *
	 * @return DibiRow|FALSE
	 */
	public function findById($id)
	{
		$query = 'SELECT * FROM %n WHERE [id]=%i';
		return $this->db->query($query, $this->table, $id)->fetch();
	}


	/**
	 * @param array $data
	 *
	 * @return int
	 */
	public function insert(array $data)
	{
		$query = 'INSERT INTO %n %v';
		$this->db->query($query, $this->table, $data);
		return $this->db->insertId();
	}


	/**
	 * @param array $data
	 * @param int $id
	 *
	 * @return int
	 */
	public function update(array $data, $id)
	{
		$query = 'UPDATE %n SET %a WHERE [id]=%i';
		$this->db->query($query, $this->table, $data, $id);
		return $this->db->affectedRows;;
	}


	/**
	 * @param int $id
	 *
	 * @return int
	 */
	public function delete($id)
	{
		$query = 'DELETE FROM %n WHERE [id]=%i';
		$this->db->query($query, $this->table, $id);
		return $this->db->affectedRows;
	}

}
