<?php

namespace App\Services;

use App\Repositories\Crud\CrudInterface;
use App\Traits\HelperTrait;

class CrudService
{
    use HelperTrait;

    /** Here We Inject Interface To Uses Its Methods  **/
    public function __construct(protected CrudInterface $crud) {

    }


    /** To Get List of Data in Paginated **/
    public function all()
    {
        return $this->crud->all();
    }

    /** To Create Item Data in DB **/
    public function create($data)
    {
        return $this->crud->create($data);
    }

    /** To Show Item Data **/
    public function show($id)
    {
        return $this->crud->show($id);
    }

    /** To Update Item Data **/
    public function update($data, $id)
    {
        return $this->crud->update($data, $id);
    }

    /** To Destroy Item Data **/
    public function delete($id)
    {
        return $this->crud->delete($id);
    }

}
