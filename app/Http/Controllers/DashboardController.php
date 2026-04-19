<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->guard('web')->user()->role == 'admin') {
            $analytics = $this->getAdminAnalytics();
        } else {
            $analytics = $this->getCompanyOwnerAnalytics();
        }

        return view('dashboard.index', compact('analytics'));
    }

    private function getAdminAnalytics()
    {
        // last 30 days active users (job-seeker)
        $activeUser = User::where('last_login_at', '>=', now()
            ->subDays(30))->where('role', 'job-seeker')->count();

        // Total job (active)
        $totalJobs = JobVacancy::whereNull('deleted_at')->count();

        // total job applications
        $totalApplications = JobApplication::whereNull('deleted_at')->count();

        // most applied jobs (top 5)
        $mostAppliedJobs =  JobVacancy::withCount("jobApplications as TotalCount")
            ->whereNull('deleted_at')
            ->orderByDesc('TotalCount')
            ->limit(5)
            ->get();

        //  Conversation rates
        $conversationRates = JobVacancy::withCount("jobApplications as TotalCount")
            ->having('TotalCount', '>', 0)
            ->orderByDesc('TotalCount')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                $job->conversationRate = $job->viewCount > 0
                    ? round(($job->TotalCount / $job->viewCount) * 100, 2)
                    : 0;
                return $job;
            });

        $analytics = [
            'activeUser' => $activeUser,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversationRates' => $conversationRates,
        ];

        return $analytics;
    }

    private function getCompanyOwnerAnalytics()
    {
        $company = auth()->guard('web')->user()->companies;

        // last 30 days active users (job-seeker) who applied to this company jobs
        $activeUser = User::where('last_login_at', '>=', now()
            ->subDays(30))
            ->where('role', 'job-seeker')
            ->whereHas('jobApplications', function ($query) use ($company) {
                $query->whereIn('jobVacancyId', $company->jobVacancies->pluck('id'));
            })
            ->count();

        // Total job (active) for this company
        $totalJobs = $company->jobVacancies()->count();

        // total job applications for this company
        $totalApplications = JobApplication::whereIn('jobVacancyId', $company->jobVacancies->pluck('id'))->count();

        $mostAppliedJobs =  $company->jobVacancies()
            ->withCount("jobApplications as TotalCount")
            ->whereNull('deleted_at')
            ->orderByDesc('TotalCount')
            ->limit(5)
            ->get();

        //  Conversation rates for this company
        $conversationRates = $company->jobVacancies()
            ->withCount("jobApplications as TotalCount")
            ->having('TotalCount', '>', 0)
            ->orderByDesc('TotalCount')
            ->limit(5)
            ->get()
            ->map(function ($job) {
                $job->conversationRate = $job->viewCount > 0
                    ? round(($job->TotalCount / $job->viewCount) * 100, 2)
                    : 0;
                return $job;
            });

        $analytics = [
            'activeUser' => $activeUser,
            'totalJobs' => $totalJobs,
            'totalApplications' => $totalApplications,
            'mostAppliedJobs' => $mostAppliedJobs,
            'conversationRates' => $conversationRates,
        ];
        return $analytics;
    }
}
