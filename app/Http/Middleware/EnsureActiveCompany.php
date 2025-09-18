<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;


class EnsureActiveCompany
{
public function handle(Request $request, Closure $next)
{
$user = $request->user();
if (! $user || ! $user->active_company_id) {
return response()->json(['error' => 'No active company selected.'], 403);
}


// Optionally: load and attach the company to the request
$company = $user->companies()->where('id', $user->active_company_id)->first();
if (! $company) {
return response()->json(['error' => 'Active company not found or not owned by user.'], 403);
}


$request->attributes->set('company', $company);


return $next($request);
}
}