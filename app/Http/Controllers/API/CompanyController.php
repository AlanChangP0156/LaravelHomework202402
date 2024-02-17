<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;


class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $query = Company::query();

        // if ($request->has('name')) {
        //     $query->where('name', 'like', '%' . $request->name . '%');
        // }

        //$companies = $query->with('comments')->get();

        $name = $request->input('name', '');
        $companies = Company::when(
            $name,
            fn($query, $name) => $query->name($name)
        );


        $filter = $request->input('filter', '');
        $companies = match ($filter) {
            'ascending_name' => $companies->ascendingName(),
            'descending_name' => $companies->descendingName(),
            'latest_rated' => $companies->latestRated(),
            'oldest_rated' => $companies->oldestRated(),
            'highest_rated' => $companies->highestRated(),
            'lowest_rated' => $companies->lowestRated(),
            default => $companies->withAvgRating()
        };

        return CompanyResource::collection($companies->with('comments')->get());
        //return Company::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        //return $company;
        //return new CompanyResource($company);
        //return CompanyResource::collection(Company::with('comments')->get());
        //這樣可以載入 comments 跟 user 的資料
        return new CompanyResource(
            $company->load('comments.user')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
