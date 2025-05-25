<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service; 
class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all(); 
        return view('services.index', compact('services'));
    }
}