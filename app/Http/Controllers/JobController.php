<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobFilterRequest;
use App\Models\Job;
use App\Services\JobFilterService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(JobFilterRequest $request)
    {
        $query = Job::query();
        $filterService = new JobFilterService($query);
        $jobs = $filterService->apply($request)->paginate(10);

        return response()->json($jobs);
    }
}