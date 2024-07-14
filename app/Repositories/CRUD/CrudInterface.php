<?php

namespace App\Repositories\CRUD;

interface CrudInterface
{

    /** This Interface Binded With Repositories In AppServiceProvider.php **/


    /** To Get List of Data in Paginated **/
    public function all();

    /** To Create Item Data in DB **/
    public function create($data);

    /** To Show Item Data **/
    public function show($id);

    /** To Update Item Data **/
    public function update($data, $id);

    /** To Destroy Item Data **/
    public function delete($id);

}
