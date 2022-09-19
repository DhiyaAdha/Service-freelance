<?php

namespace App\Http\Controllers\Dashboard;

// model
use App\Models\User;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Service;
use App\Models\AdvantageUser;
use App\Models\AdvantageService;
use App\Models\ThumbnailService;
use App\Models\Tagline;

// request validation
use App\Models\ExperienceUser;
use App\Http\Controllers\Controller;

// storage
use Illuminate\Support\Facades\Auth;

// request response
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request;

// Helper
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use App\Http\Requests\Dashboard\MyOrder\UpdateMyOrderRequest;


class MyOrderController extends Controller
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
        $orders = Order::where('freelancer_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.dashboard.my-order.index', compact('orders'));

        // mengarahkan pada view nya
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
    public function show(Order $order)
    {

        $service = Service::where('id', $order['service_id'])->first();

        $thumbnail = ThumbnailService::where('service_id', $order['service_id'])->get();
        $advantage_service = AdvantageService::where('service_id', $order['service_id'])->get();
        $advantage_user = AdvantageUser::where('service_id', $order['service_id'])->get();
        $tagline = Tagline::where('service_id', $order['service_id'])->get();

        return view('pages.dashboard.order.detail', compact('order', 'thumbnail', 'advantage_service', 'advantage_user', 'tagline', 'service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('pages.dashboard.order.edit', compact('order'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMyOrderRequest $request, Order $order)
    {
        $data = $request->all();

            if(isset($data['file'])){
                $data['file'] = $request->file('file')
                ->store('assets/file', 'public');
        
            }

            
            $order = Order::find($order->id);
            $order->file = $data['file'];
            $order->note = $data['note'];
            $order->save();

            toast()->success('Submit order has been success');
            return redirect()->route('member.order.index');

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

    // Custom
    public function accepted($id)
    {
        $order = Order::find($id);
        $order->order_status_id = 2;
        $order->save();

        toast()->success('Accept order has been success');
        return back();
    }

    public function rejected($id)
    {
        $order = Order::find($id);
        $order->order_status_id = 3;
        $order->save();

        toast()->success('Reject order has been success');
        return back();
    }
}
