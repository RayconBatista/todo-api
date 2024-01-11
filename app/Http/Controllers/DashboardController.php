<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(protected Task $task)
    {
        $this->middleware('auth:api');
    }

    public function tasks()
    {
        $tasksWithStatus = $this->task->with('status')->get();

        $groupedData = $tasksWithStatus->groupBy('status_id')->map(function ($group) {
            return $group->count();
        });

        $chartData = [
            'values' => $groupedData->values()->all(),
            'colors' => $tasksWithStatus->pluck('status.color')->unique()->values()->all(),
            'labels' => $tasksWithStatus->pluck('status.label')->unique()->values()->all(),
        ];

        return response()->json([
            'data' => $chartData
        ]);
    }
}
