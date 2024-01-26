<?php

namespace App\Contracts\Admin\Job;

interface JobContract
{
    public function allJobs();
    public function storeJob(array $data);
    public function findJob($id);
    public function updateJob(array $data, $id);
    public function destroyJob($id);
}
