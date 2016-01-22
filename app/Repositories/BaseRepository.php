<?php namespace App\Repositories;
abstract class BaseRepository {
	/**
	 * The Model instance.
	 *
	 * @var Illuminate\Database\Eloquent\Model
	 */
	protected $model;
	/**
	 * Get number of records.
	 *
	 * @return 
	 */
	public function getNumber()
	{
		return $this->model->count();
	}
	/**
	 * Destroy a model.
	 *
	 * @param  int $id
	 * @return void
	 */
	public function destroy($id)
	{
		$this->getById($id)->delete();
	}
	/**
	 * Get Model by id.
	 *
	 * @param  int  $id
	 * @return App\Models\Model
	 */
	public function getById($id)
	{
		return $this->model->findOrFail($id);
	}
}
