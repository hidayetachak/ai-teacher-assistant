<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Package;


class HomeController extends Controller
{
            public function index()
            {
                $packages = Package::where('is_active', true)
                                ->orderBy('price', 'asc')
                                ->get();

                return view('welcome', compact('packages'));
            }
}