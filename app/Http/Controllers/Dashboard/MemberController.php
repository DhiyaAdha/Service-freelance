<?php

namespace App\Http\Controllers\Dashboard;

// model
use App\Models\User;
use App\Models\DetailUser;
use App\Models\ExperienceUser;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Service;
use App\Models\AdvantageUser;
use App\Models\AdvantageService;
use App\Models\ThumbnailService;
use App\Models\Tagline;

// request validation
use App\Http\Controllers\Controller;

// storage
use Illuminate\Support\Facades\Auth;

// request response
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Helper
use Illuminate\Support\Facades\Auth as FacadesAuth;

class MemberController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('freelancer_id', Auth::user()->id)->get();

        $progress = Order::where('freelancer_id', Auth::user()->id)
                        ->where('order_status_id', 2)
                        ->count();

        /* completed &freelancer
        distinc = menghindari hasil query kelar double */ 
        $completed = Order::where('freelancer_id', Auth::user()->id)
                        ->where('order_status_id', 1)
                        ->count();
        $freelancer = Order::where('buyer_id', Auth::user()->id)
                        ->where('order_status_id', 2)
                        ->distinct('freelancer_id')
                        ->count();

        return view('pages.dashboard.index', compact('orders', 'progress', 'completed', 'freelancer'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return abort(404);
    }
}
