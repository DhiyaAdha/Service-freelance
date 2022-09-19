<?php

namespace App\Http\Controllers\Dashboard;

// model
use App\Models\User;
use App\Models\Order;
use App\Models\Service;
use App\Models\AdvantageService;
use App\Models\Tagline;
use App\Models\AdvantageUser;
use App\Models\ThumbnailService;

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
use App\Http\Requests\Dashboard\Service\StoreServiceRequest;
use App\Http\Requests\Dashboard\Service\UpdateServiceRequest;


class ServiceController extends Controller
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
        $service = Service::where('user_id', Auth::user()->id)
                ->orderBy('created_at', 'desc')
                ->get();

        return view ('pages.dashboard.service.index', compact('service'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('pages.dashboard.service.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreServiceRequest $request)
    {
        
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;

        // add to service
        $service = Service::create($data);

        // add to advantage service
        foreach($data['advantage-service'] as $key => $value){
            $advantage_service = new AdvantageService();
            $advantage_service->service_id = $service->id;
            $advantage_service->advantage_id = $value;
            $advantage_service->save();
        }

        // add to advantage user
        foreach($data['advantage-user'] as $key => $value){
            $advantage_user = new AdvantageUser();
            $advantage_user->service_id = $service->id;
            $advantage_user->advantage_id = $value;
            $advantage_user->save();
        }

        // add to thumbnail service
        if ($request->hasFile('thumbnail'))
        {
            foreach($request->file('thumbnail') as $file){

                $path = $file->store(
                    'assets/service/thumbnail', 'public'
                );
                
                $thumbnail_service = new ThumbnailService();
                $thumbnail_service->service_id = $service['id'];
                $thumbnail_service->thumbnail = $path;
                $thumbnail_service->save();
            }

        }

                // add to tagline
                foreach($data['tagline'] as $key => $value){
                    $tagline = new Tagline();
                    $tagline->service_id = $service->id;
                    $tagline->tagline = $value;
                    $tagline->save();
                }   

        toast()->success('Save has been success');
        return redirect()->route('member.service.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {

        $advantage_service = AdvantageService::where('service_id', $service['id'])->get();
        $tagline = Tagline::where('service_id', $service['id'])->get();
        $advantage_user = AdvantageUser::where('service_id', $service['id'])->get();
        $thumbnail_service = ThumbnailService::where('service_id', $service['id'])->get();

        return view ('pages.dashboard.service.edit', compact('service', 'advantage_service', 'tagline', 'advantage_user', 'thumbnail_service'));

        // return view ('pages.dashboard.service.edit');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateServiceRequest $request, Service $service)
    {
        $data = $request->all();

        // update service
        $service->update($data);

        // update to Advantage Service 1
        foreach($data['advantage-service'] as $key => $value){
            $advantage_service = AdvantageService::find($key);
            $advantage_service->advantage = $value;
            $advantage_service->save();
        }

        // add new advantage Service 1
        if(isset($data['advantage_service'])){
            foreach($data['advantage_service'] as $key => $value){
                $advantage_service = AdvantageService::find($key);
                $advantage_service->service_id = $service['id'];
                $advantage_service->advantage = $value;
                $advantage_service->save();
            }
        }


        // update to Advantage User 2
        foreach($data['advantage-user'] as $key => $value){
            $advantage_user = AdvantageUser::find($key);
            $advantage_user->advantage = $value;
            $advantage_user->save();
        }

        // add new advantage User 2
        if(isset($data['advantage_service'])){
            foreach($data['advantage_user'] as $key => $value){
                $advantage_user = AdvantageUser::find($key);
                $advantage_user->service_id = $service['id'];
                $advantage_user->advantage = $value;
                $advantage_user->save();
            }
        }


        // update to Tagline 3
        foreach($data['tagline'] as $key => $value){
            $tagline = Tagline::find($key);
            $tagline->advantage = $value;
            $tagline->save();
        }

        // add new Tagline 3
        if(isset($data['tagline'])){
            foreach($data['tagline'] as $key => $value){
                $tagline = Tagline::find($key);
                $tagline->service_id = $service['id'];
                $tagline->advantage = $value;
                $tagline->save();
            }
        }


        // update to Thumbnail Service 4
        if($request->hasfile('thumbnails')){
            foreach ($request->file('thumbnails') as $key => $file)
            {
                // get old photo thumbnail
                /* Ambil foto yang lama, supaya storage tidak berat */

                $get_photo = ThumbnailService::where('id', $key)->first();

                // store photo
                $path = $file->store(
                    'assets/service/thumbnail', 'public'
                );

                // update thumbail
                $thumbnail_service = ThumbnailService::find($key);
                $thumbnail_service->thumbnail = $path;
                $thumbnail_service->save();

                // delete old photo thumbnail
                $data = 'storage/'.$get_photo['photo'];
                if(File::exists($data)){
                    File::delete($data);
                }else{
                    File::delete('storage/app/public/'.$get_photo['photo']);
                }
            }
        }

        // add to thumbnail service 
        if($request->hasFile('thumbnail')){
            foreach($request->file('thumbnail') as $file){

                $path = $file->store(
                    'assets/service/thumbnail', 'public'
                );
                
                $thumbnail_service = new ThumbnailService();
                $thumbnail_service->service_id = $service['id'];
                $thumbnail_service->thumbnail = $path;
                $thumbnail_service->save();
            }
        }

        toast()->success('Update has been success');
        return redirect()->route('member.service.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
