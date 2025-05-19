<?php

namespace App\Http\Controllers\Mentor;


use App\Http\Controllers\Controller;



class RoleMentorController extends Controller
{
    public function mentor()
    {
        return view('pages.dashboardMentor');
    }


}
