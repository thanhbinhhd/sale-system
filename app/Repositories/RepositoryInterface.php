<?php

namespace App\Repositories;

interface RepositoryInterface {
	/**
	 * Get number of records
	 *
	 */
	public function getNumber();
	/**
	 * Update columns in the record by id.
	 *
	 * @param $id
	 * @param $input
	 */
	public function updateColumn($id, $input);

	/**
	 * Destroy a model.
	 *
	 * @param  $id
	 */
	public function destroy($id);

	/**
	 * Get model by id.
	 *
	 */
	public function getById($id);

	/**
	 * @param $name
	 */
	public function getByName($name);

	/**
	 * Get all the records
	 *
	 */
	public function all();
	/**
	 * Get number of the records
	 *
	 * @param  int $number
	 * @param  string $sort
	 * @param  string $sortColumn
	 */
	public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at');
	/**
	 * Store a new record.
	 *
	 * @param  $input
	 */
	public function store($input);
	/**
	 * Update a record by id.
	 *
	 * @param  $id
	 * @param  $input
	 */
	public function update($id, $input);

	/**
	 * Save the input's data.
	 *
	 * @param  $model
	 * @param  $input
	 */
	public function save($model, $input);
}