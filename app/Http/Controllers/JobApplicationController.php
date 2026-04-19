<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobApplicationUpdataRequset;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = JobApplication::latest();

    if(auth()->guard('web')->user()->role  === 'company-owner'){
        $query->whereHas('jobVacancy', function ($q) {
            $q->where('companyId', auth()->guard('web')->user()->companies->id);
        });
    }

        // Archived
        if ($request->has('archived')) {
            $query->onlyTrashed();
        }
        $applications = $query->paginate(6)->onEachSide(1);
        return view('job-application.index', compact('applications'));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = JobApplication::findOrFail($id);
        return view('job-application.show', compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $application = JobApplication::findOrFail($id);
        return view('job-application.edit', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationUpdataRequset $request, string $id)
    {
        $application = JobApplication::findOrFail($id);
        $application->update([
            "status" => $request->input("status")
        ]);
       if($request->query('redirecttolist') ===  'false'){
            return redirect()->route('job-applications.show', $application->id)->with('success', 'Job Application updated successfully');
       }
       return redirect()->route('job-applications.index')->with('success', 'Job Application updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $application = JobApplication::findOrFail($id);
        $application->delete();
        return redirect()->route('job-applications.index')->with('success', 'Job Application archived successfully');
    }

    public function restore(string $id)
    {
        $application = JobApplication::withTrashed()->findOrFail($id);
        $application->restore();
        return redirect()->route('job-applications.index')->with('success', 'Job Application restored successfully');
    }
}
