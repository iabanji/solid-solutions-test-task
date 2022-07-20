<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeaveRequest;
use App\Http\Requests\DeleteLeaveRequest;
use App\TreeLeave;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    public function deleteLeave(DeleteLeaveRequest $request, int $id): JsonResponse
    {
        TreeLeave::find($id)->delete();
        return new JsonResponse([
            'has_leaves' => TreeLeave::count() > 0,
            'msg' => 'Success'
        ]);
    }

    public function createLeave(CreateLeaveRequest $request): JsonResponse
    {
        $leave = TreeLeave::create([
            'parent_id' => $request->input('parent_id'),
            'title' => $request->input('title'),
        ]);
        return new JsonResponse(['leave_id' => $leave->id, 'msg' => 'Success']);
    }
}
