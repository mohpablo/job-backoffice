<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\JobApplication;
use App\Models\JobCategory;
use App\Models\JobVacancy;
use App\Models\Resume;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // seed the root admin
        User::firstOrCreate(
            [
                'email' => 'admin@admin.com',
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Seed  Data to test with 
        $jobData = json_decode(file_get_contents(database_path('data/job_data.json')), true);
        $jobApplications = json_decode(file_get_contents(database_path('data/job_applications.json')), true);

        foreach ($jobData['jobCategories'] as $category) {
            JobCategory::firstOrCreate([
                'name' => $category
            ]);
        }

        foreach ($jobData['companies'] as $company) {
            // create companies owner
            $companyOwner = User::firstOrCreate(
                [
                    'email' => fake()->unique()->safeEmail(),
                ],
                [
                    'name' => fake()->name(),
                    'password' => Hash::make('12345678'),
                    'role' => 'company-owner',
                    'email_verified_at' => now(),
                ]
            );
            Company::firstOrCreate([
                'name' => $company['name'],
            ], [
                'address' => $company['address'],
                'industry' => $company['industry'],
                'website' => $company['website'],
                'owner_id' => $companyOwner->id,
            ]);
        }

        foreach ($jobData['jobVacancies'] as $jobVacancy) {
            // get company
            $company = Company::where('name', $jobVacancy['company'])->firstOrFail();

            // get category
            $category = JobCategory::where('name', $jobVacancy['category'])->firstOrFail();

            JobVacancy::firstOrCreate([
                'title' => $jobVacancy['title'],
                'companyId' => $company->id,
            ], [
                'description' => $jobVacancy['description'],
                'location' => $jobVacancy['location'],
                'type' => $jobVacancy['type'],
                'salary' => $jobVacancy['salary'],
                'jobcategoryId' => $category->id,
                'companyId' => $company->id,
            ]);
        }

        foreach ($jobApplications['jobApplications'] as $jobApplication) {
            // get random job vacancy
            $jobVacancy = JobVacancy::inRandomOrder()->first();

            // create user
            $applicant = User::firstOrCreate(
                [
                    'email' => fake()->unique()->safeEmail(),
                ],
                [
                    'name' => fake()->name(),
                    'password' => Hash::make('12345678'),
                    'role' => 'job-seeker',
                    'email_verified_at' => now(),
                ]
            );

            // create resume
            $resume = Resume::firstOrCreate([
                'fileName' => $jobApplication['resume']['filename'],
                'fileUrl' => $jobApplication['resume']['fileUri'],
                'summary' => $jobApplication['resume']['summary'],
                'contactDetails' => $jobApplication['resume']['contactDetails'],
                'education' => $jobApplication['resume']['education'],
                'experience' => $jobApplication['resume']['experience'],
                'skills' => $jobApplication['resume']['skills'],
                'userId' => $applicant->id,
            ]);

            // create job application
            JobApplication::firstOrCreate([
                'jobVacancyId' => $jobVacancy->id,
                'userId' => $applicant->id,
                'resumeId' => $resume->id,
            ], [
                'status' => $jobApplication['status'],
                'aiGeneratedScore' => $jobApplication['aiGeneratedScore'],
                'aiGeneratedFeedback' => $jobApplication['aiGeneratedFeedback'],
            ]);
        }
    }
}
