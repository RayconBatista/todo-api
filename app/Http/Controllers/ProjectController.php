<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\Todo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $projects = Project::with('todos')->latest()->paginate();
        return ProjectResource::collection($projects);
    }

    /**
     * @throws AuthorizationException
     */
    public function show(Project $project)
    {
        $project->load('todos');
        return ProjectResource::make($project);
    }

    /**
     * @throws AuthorizationException
     */
    public function destroy(Project $project)
    {
        try {
            if ($project->todos()->count() > 0) {
                return response()->json(['status' => 'warning', 'message' => 'O projeto ainda tem todos registrados'], 200);
            }
    
            $project->delete();
    
            return response()->json(['status' => 'success', 'message' => 'Projeto excluído com sucesso']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }
    // /**
    //  * @throws AuthorizationException
    //  */
    // public function destroy(Project $project):void
    // {
    //     // $this->authorize('destroy', $project);
    //     $project->delete();
        
    // }
}
