<?php

namespace App\Http\Controllers\Loyalty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Loyalty\Customer as Obj;
use App\Models\Loyalty\Reward;

use Illuminate\Support\Facades\Auth;
use App\Charts\CustomerChart;


class CustomerController extends Controller
{
    /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Loyalty';
        $this->module   =   'Customer';
        $theme = session()->get('theme');
        $this->componentName = 'themes.'.$theme.'.layouts.app';

        $user = Auth::user();
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj, Request $request)
    {

        $objs = $obj->sortable()->paginate();

        return view("apps.".$this->app.".".$this->module.".index")
                ->with("app", $this)
                ->with("objs", $objs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Obj $obj)
    {
        // Authorize the request
        // $this->authorize('create', $obj);

        return view("apps.".$this->app.".".$this->module.".createedit")
                ->with("stub", "create")
                ->with("app", $this)
                ->with("objs", $obj);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj, Request $request, Reward $reward)
    {
        // Authorize the request
        // $this->authorize('create', $obj);  

        $validated = $request->validate([
            "name" => 'required',
            "phone" => 'required|digits:10',
            "email" => 'required',
            "address" => 'required',
            "credits" => "required",
        ]);

        // Check if record already exists
        $check = $obj->where("phone", $request->phone)->exists();
        
        // Store the records only if check returns false
        if($check){
            return view("apps.".$this->app.".".$this->module.".createedit")
                    ->with("alert", "User Already Exists")
                    ->with("stub", "create")
                    ->with("app", $this)
                    ->with("objs", $obj);
        }
        else{
            $obj->create([
                "name" => $request->input('name'),
                "phone" => $request->input('phone'),
                "email" => $request->input('email'),
                "address" => $request->input('address'),
            ]);
    
            $objs = $obj->where("phone", $request->input('phone'))->first();
        
            $reward->create([
                "customer_id" => $objs->id,
                "phone" => $request->phone,
                "credits" => $request->input('credits')
            ]);
    
            return redirect()->route('Reward.public');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Obj $obj, $id)
    {
        $obj = $obj->where("id", $id)->first();

        // Return to create if record was not found
        return view("apps.".$this->app.".".$this->module.".show")
                ->with("app", $this)
                ->with("obj", $obj);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Obj $obj)
    {
        // Retrieve Specific record
        $obj = $obj->where("id", $id)->first();
        // Authorize the request
        // $this->authorize('create', $obj);

        return view("apps.".$this->app.".".$this->module.".createedit")
                ->with("stub", "update")
                ->with("app", $this)
                ->with("obj", $obj);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Obj $obj, $id)
    {

        // load the resource
        $obj = $obj->where('id',$id)->first();
        // authorize the app
        // $this->authorize('update', $obj);

        //update the resource
        $obj->update($request->all());

        return redirect()->route($this->module.'.index');
    }
                                                                                                                                                                                            
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Obj $obj)
    {   

        // load the resource
        $obj = $obj->where('id',$id)->first();
        // authorize
        // $this->authorize('update', $obj);
        // delete the resource
        $obj->delete();

        return redirect()->route($this->module.'.index');
    }

    public function dashboard(Obj $obj){

        $objs = $obj->select("name")->get();

        $chart = new CustomerChart;

        $chart->labels(['Jan', 'Feb', 'Mar']);

        $chart->dataset('Users by trimester', 'line', [10, 25, 13]);


        return view("apps.".$this->app.".".$this->module.".dashboard")
            ->with("app", $this)
            ->with("obj", $obj)
            ->with("chart", $chart);
    }
}
