<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(
            $request->user()->companies()->get()
        );
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'address'  => 'required|string',
            'industry' => 'required|string',
        ]);

        $company = $request->user()->companies()->create($data);

        // If no active company, set this one
        if (! $request->user()->active_company_id) {
            $request->user()->update([
                'active_company_id' => $company->id
            ]);
        }

        return response()->json($company, 201);
    }

    public function update(Request $request, Company $company)
    {
        // Ensure the company belongs to the user
        if ($company->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'name'     => 'sometimes|required|string|max:255',
            'address'  => 'sometimes|required|string',
            'industry' => 'sometimes|required|string',
        ]);

        $company->update($data);

        return response()->json($company);
    }

    public function destroy(Request $request, Company $company)
    {
        // Ensure the company belongs to the user
        if ($company->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $company->delete();

        // If deleted company was active, unset or assign another
        if ($request->user()->active_company_id === $company->id) {
            $nextCompany = $request->user()->companies()->first();
            $request->user()->update([
                'active_company_id' => $nextCompany?->id
            ]);
        }

        return response()->json(['message' => 'Company deleted']);
    }
}
