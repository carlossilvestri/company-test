<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DTOs\CompanyDTO;

class HomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $companyDTO = CompanyDTO::fromModel(auth()->user()->company);
        return view('home', compact('companyDTO'));
    }
}
