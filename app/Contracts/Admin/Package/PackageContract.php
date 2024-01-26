<?php

namespace App\Contracts\Admin\Package;

interface PackageContract
{
    public function index();
    public function addPlanFormView();
    public function getList();
    public function getDetails(array $data);
}
