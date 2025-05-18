<?php

namespace App\Repositories;

use App\Interfaces\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $model;

    /**
     * Create a new class instance.
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getAllUsers()
    {
        return $this->model->all();
    }

    public function getUserById(int $id)
    {
        return $this->model->find($id);
    }

    public function createUser(array $data)
    {
        return $this->model->create($data);
    }

    public function updateUser(int $id, array $data)
    {
        $user = $this->getUserById($id);
        if (!$user) {
            return null;
        }
        $user->update($data);
        return $user;
    }

    public function deleteUser(int $id)
    {
        $user = $this->getUserById($id);
        if (!$user) {
            return false;
        }
        $user->delete();
        return $user;
    }

}
