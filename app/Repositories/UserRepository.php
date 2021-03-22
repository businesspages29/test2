<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class UserRepository
{
    // model property on class instances
    protected $model;

    // Constructor to bind model to repo
    public function __construct(User $model)
    {
    	$this->model = $model;
    }

    // Get all instances of model
    public function all()
    {
    	return $this->model->all();
    }

    public function getAuthID($userid)
    {
        return $this->model
        ->where('user_id',$userid)
        ->orderby('created_at','DESC')
        ->get();
    }

    public function getCountAuthID($userid)
    {
        return $this->model
        ->where('user_id',$userid)
        ->count();
    }
    // create a new record in the database
    public function create(array $data)
    {
        return $this->model->create($data);
    }

    // update record in the database
    public function update(array $data, $id)
    {
        $record = $this->model->find($id);
        $record->update($data);
        return $this->model->find($id);
    }

    // remove record from the database
    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    // show the record with the given id
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }
    public function getAllPaginated($count)
    {
        return $this->model->paginate($count);
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function requireById($id)
    {
        $model = $this->getById($id);

        if (!$model) {
//            abort(404);
             throw new EntityNotFoundException(404);
        }

        return $model;
    }

    public function getNew($attributes = array())
    {
        return $this->model->newInstance($attributes);
    }

    public function save($data)
    {
        if ($data instanceOf Model) {
            return $this->storeEloquentModel($data);
        } elseif (is_array($data)) {
            return $this->storeArray($data);
        }
    }

    // public function delete($model)
    // {
    //     return $model->delete();
    // }

    protected function storeEloquentModel($model)
    {
        if ($model->getDirty()) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }

    protected function storeArray($data)
    {
        $model = $this->getNew($data);
        return $this->storeEloquentModel($model);
    }
    
    public function getRandom($count)
    {
        return $this->model->orderByRaw('RAND()')->take($count)->get();
    }

    public function getAllCounted($count)
    {
        return $this->model->take($count)->get();
    }
}

?>