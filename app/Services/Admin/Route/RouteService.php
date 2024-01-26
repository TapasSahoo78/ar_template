<?php

namespace App\Services\Admin\Route;

use App\Contracts\Admin\Route\RouteContract;
use App\Models\Route as SELF_MODEL;
use Illuminate\Support\Str;

class RouteService implements RouteContract
{

    public function allRoutes()
    {
        return SELF_MODEL::latest()->get();
    }

    public function getAllRoutes()
    {
        $quer = SELF_MODEL::with(['getBusStop' => function ($q) {
            $q->orderBy('order_column', 'asc');
        }])->get();

        // $quer = SELF_MODEL::all();
        return $quer;
    }
    public function storeRoute($data)
    {
        $data['slug'] = Str::slug($data['name']);
        return SELF_MODEL::create($data);
    }

    public function findRoute($id)
    {
        return SELF_MODEL::find($id);
    }

    public function updateRoute($data, $id)
    {
        $routes = SELF_MODEL::where('id', $id)->first();
        $routes->name = $data['name'];
        $routes->color = $data['color'];
        $routes->save();
    }

    public function destroyRoute($id)
    {
        $clients = SELF_MODEL::find($id);
        $clients->delete();
    }
}
