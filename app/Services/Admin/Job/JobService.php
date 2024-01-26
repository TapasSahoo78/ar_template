<?php

namespace App\Services\Admin\Job;

use App\Contracts\Admin\Job\JobContract;
use App\Models\Job as SELF_MODEL;
use Illuminate\Support\Str;

class JobService implements JobContract
{

    public function allJobs()
    {
        return SELF_MODEL::latest()->get();
    }

    public function storeJob($data)
    {
        return SELF_MODEL::create($data);
    }

    public function findJob($id)
    {
        return SELF_MODEL::find($id);
    }

    public function updateJob($data, $id)
    {
        $bus = SELF_MODEL::where('id', $id)->first();
        $bus->name = $data['name'];
        $bus->save();
    }

    public function destroyJob($id)
    {
        $clients = SELF_MODEL::find($id);
        $clients->delete();
    }
}
