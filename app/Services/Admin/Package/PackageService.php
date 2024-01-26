<?php

namespace App\Services\Admin\Package;

use App\Contracts\Admin\Package\PackageContract;
use App\Models\Plan;

class PackageService implements PackageContract
{
    public function index()
    {
        return "index";
    }
    public function addPlanFormView()
    {
        return "index";
    }
    public function getList()
    {
        $query = Plan::where('status', 1)->get();
        return $query;
    }
    public function getDetails(array $data)
    {
        $query = Plan::where('id', $data['plan_id'])->first();
        return $query;
    }
}
