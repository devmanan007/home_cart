<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCareerRequest;
use App\Http\Requests\UpdateCareerRequest;
use App\Models\Job;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Job::latest()->paginate(10);
        return view('admin.careers.index', compact('careers'));
    }

    public function create()
    {
        return view('admin.careers.form');
    }

    public function store(StoreCareerRequest $request)
    {
        Job::create($request->validated());

        return to_route('admin.careers.index')
            ->with('success', 'Job listing created successfully.');
    }

    public function edit(Job $job)
    {
        return view('admin.careers.form', compact('job'));
    }

    public function update(UpdateCareerRequest $request, Job $job)
    {
        $job->update($request->validated());

        return to_route('admin.careers.index')
            ->with('success', 'Job listing updated successfully.');
    }

    public function destroy(Job $job)
    {
        $job->delete();

        return to_route('admin.careers.index')
            ->with('success', 'Job listing deleted successfully.');
    }
}
