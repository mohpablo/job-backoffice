<?php

namespace App\Http\Controllers;


use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;
use App\Models\Company;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use Illuminate\Http\Request;
use PHPUnit\Util\PHP\Job;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = JobVacancy::latest();

        if(auth()->guard('web')->user()->role  === 'company-owner'){
            $query->where('companyId', auth()->guard('web')->user()->companies->id);
        }
        // Archived
        if ($request->has('archived')) {
            $query->onlyTrashed();
        }
        $jobs = $query->paginate(6)->onEachSide(1);
        return view('job-vacancy.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();
        $jobCategories = JobCategory::all();
        return view('job-vacancy.create', compact('companies', 'jobCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyCreateRequest $request)
    {
        JobVacancy::create($request->validated());
        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $job = JobVacancy::findOrFail($id);
        $jobapplications = $job->jobApplications()->latest()->paginate(6)->onEachSide(1);
        return view('job-vacancy.show', compact('job', 'jobapplications'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $job = JobVacancy::findOrFail(($id));
        $jobCategories = JobCategory::all();
        $companies = Company::all();
        return view('job-vacancy.edit', compact('job', 'jobCategories', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $job = JobVacancy::findOrFail($id);
        $job->update($validated);

        if ($request->query('redirecttolist') ===  'false') {
            return redirect()->route('job-vacancies.show', $job->id)->with('success', 'Job vacancy updated successfully');
        }

        return redirect()->route('job-vacancies.index')->with('success', 'Job vacancy updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $job = JobVacancy::findOrFail($id);
        $job->delete();
        return redirect()->route('job-vacancies.index')->with('success', 'Job Category archived successfully');
    }

    public function restore(string $id)
    {
        $job = JobVacancy::withTrashed()->findOrFail($id);
        $job->restore();
        return redirect()->route('job-vacancies.index', ['archived' => true])->with('success', 'Job Category restored successfully');
    }
}
