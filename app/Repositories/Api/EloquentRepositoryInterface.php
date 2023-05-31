<?php

namespace App\Repositories\Api;

interface EloquentRepository
{
    /**
     * @param $data
     * @return mixed
     */
    public function create(array $data);

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * @param int $id
     * @return mixed
     */
    public function delete(int $id);

    /**
     * @param array $data
     * @return mixed
     */
    public function createOrFail(array $data);

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function updateOrFail(int $id, array $data);

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteOrFail(int $id);

    /**
     * @param int $id
     * @return mixed
     */
    public function findOrFail(int $id);
}