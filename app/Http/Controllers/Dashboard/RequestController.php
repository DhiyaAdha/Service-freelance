<?php

namespace App\Http\Controllers\Dashboard;

// model
use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\OrderStatus;


// request validation
use App\Models\ExperienceUser;
use App\Http\Controllers\Controller;

// storage
use Illuminate\Support\Facades\Auth;

// request response
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Helper
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class RequestController extends Controller
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
        $orders = Order::where('buyer_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

            return view('pages.dashboard.request.index', compact('orders'));
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
        //detail
        $order = Order::where('id', $id)->first();

        return view ('pages.dashboard.request.detail', compact('order'));
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

    // CUSTOM
    
    /* approve 
    sudah melakukan pembayaran */
    public function approve($id)
    {
        $order = Order::where('id', $id)->first();

        //update order
        $order = Order::find($order['id']);
        $order->order_status_id = 1;
        $order->save();

        toast()->success('Approved has been success');
        return redirect()->route('dashboard.request.index');
    }

    




}
