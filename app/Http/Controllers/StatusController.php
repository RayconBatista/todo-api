<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\Models\Status;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index() 
    {
        $data = Status::paginate(15);
        return StatusResource::collection($data);
    }
}
