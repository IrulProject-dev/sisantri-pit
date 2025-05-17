<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RoleSantriController extends Controller
{
    public function santri()
    {
        return view('pages.dashboardSantri');
    }
}
