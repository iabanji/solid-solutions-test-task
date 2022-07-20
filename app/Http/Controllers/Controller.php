<?php

namespace App\Http\Controllers;

use App\TreeLeave;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function leaves()
    {
        $leaves = TreeLeave::query()->whereNull('parent_id')->get();
        return view('leaves', ['leaves' => $leaves]);
    }
}
