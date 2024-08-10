<?php

namespace App\Http\Controllers;

use App\Enums\TimeBreakdown;
use App\Repository\DashboardRepository;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct(
        protected DashboardRepository $dashboardRepository
    ) {
    }

    public function view()  {
        return view("dashboard.view");
    }


    public function summary(Request $request) {
        $type = $request->enum('period' , TimeBreakdown::class);

        $data['summary'] = $this->dashboardRepository->getSummary($type);
        return view('dashboard.inc.summary.summary' , $data);
    }

}
