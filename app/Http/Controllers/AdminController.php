<?php

namespace App\Http\Controllers;

use App\Models\Pedido;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function orders()
    {
        return view('dashboard');
    }
    public function products()
    {
        return view('products');
    }

    
}
