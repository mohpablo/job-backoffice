<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public $industries;
    public function __construct()
    {
        $this->industries = ['Technology', 'Business', 'Design', 'Finance', 'Healthcare', 'Education', 'Other'];
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Active
        $query = Company::latest();
        // Archived
        if ($request->has('archived')) {
            $query->onlyTrashed();
        }
        $companies = $query->paginate(6)->onEachSide(1);
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;
        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        $data = $request->validated();

        // create owner
        $owner = User::create([
            'name' => $data['owner_name'],
            'email' => $data['owner_email'],
            'password' => Hash::make($data['owner_password']),
            'role' => 'company-owner',
        ]);

        // return error if owner did not create
        if (!$owner) {
            return redirect()->route('companies.create')->with('error', 'Owner could not be created');
        }

        // create company
        Company::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'industry' => $data['industry'],
            'website' => $data['website'],
            'owner_id' => $owner->id
        ]);
        return redirect()->route('companies.index')->with('success', 'Job Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);
        $jobs = $company->jobVacancies()
            ->latest()
            ->paginate(3)
            ->onEachSide(1)
            ->withQueryString();

        $applications = $company->jobApplications()
            ->latest()
            ->paginate(3)
            ->onEachSide(1)
            ->withQueryString();
        return view('company.show', compact('company', 'jobs', 'applications'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $industries = $this->industries;
        $company = Company::findOrFail($id);
        return view('company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $company = Company::findOrFail($id);
        // update owner
        $owner = User::findOrFail($company->owner_id);
        $ownerdata = [];
        $ownerdata['name'] = $data['owner_name'];
        if ($data['owner_password']) {
            $ownerdata['password'] = Hash::make($data['owner_password']);
        }
        $owner->update(
            $ownerdata
        );
        $company->update(
            [
                'name' => $data['name'],
                'address' => $data['address'],
                'industry' => $data['industry'],
                'website' => $data['website'],
            ]
        );
        if (auth()->guard('web')->user()->role === 'company-owner') {
            return redirect()->route('my-company.show', $company->id)->with('success', 'Job company updated successfully');
        }
        if ($request->query('redirecttolist') ===  'false') {
            return redirect()->route('companies.show', $company->id)->with('success', 'Job company updated successfully')->with('success', 'Job company updated successfully');
        }
        return redirect()->route('companies.index')->with('success', 'Job company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Job Category archived successfully');
    }

    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('companies.index', ['archived' => true])->with('success', 'Job Category restored successfully');
    }
}
