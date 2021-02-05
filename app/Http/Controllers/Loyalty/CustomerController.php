<?php

namespace App\Http\Controllers\Loyalty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Loyalty\Customer as Obj;
use App\Models\Loyalty\Reward;

use Illuminate\Support\Facades\Auth;


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
    
            return redirect()->route('Customer.index');
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

    public function dashboard(Obj $obj, Request $request, Reward $reward){

        $customers = array();
        $year = date("Y");
        $month = date("m");

        $total_customers = $obj->all()->count();

        $filter = $request->input('filter');

        if(!empty($filter)){
            if($filter == 'month'){
                $objs = $obj->whereYear('created_at', $year)->get();

                $new_customers = $objs->count();

                foreach($objs as $obj){
                    $key = date("M",strtotime($obj['created_at']));
                    if(array_key_exists($key, $customers)){
                        $customers[$key] += 1;
                    }
                    else{
                        $customers += array(
                            $key => 1,
                        ); 
                    }
                }
                $reward_objs = $reward->whereYear('created_at', $year)->get();

                $rewards = array();
            
                foreach($reward_objs as $reward){
                    $month = date("M",strtotime($reward['created_at']));
                    if(array_key_exists($month, $rewards)){
                        $rewards[$month]['credits'] += $reward['credits'];
                        $rewards[$month]['redeem'] += $reward['redeem'];
                    }
                    else{
                        $rewards += array(
                            $month => array(
                                "credits" => $reward['credits'],
                                "redeem" => $reward['redeem'],
                            ),
                        ); 
                    }
                }
            }
            else if($filter == 'day'){
                $objs = $obj->whereMonth('created_at', $month)->get();

                $new_customers = $objs->count();

                foreach($objs as $obj){
                    $key = date("d",strtotime($obj['created_at']));
                    if(array_key_exists($key, $customers)){
                        $customers[$key] += 1;
                    }
                    else{
                        $customers += array(
                            $key => 1,
                        ); 
                    }
                }

                $reward_objs = $reward->whereMonth('created_at', $month)->get();

                $rewards = array();
            
                foreach($reward_objs as $reward){
                    $key = date("d",strtotime($reward['created_at']));
                    if(array_key_exists($key, $rewards)){
                        $rewards[$key]['credits'] += $reward['credits'];
                        $rewards[$key]['redeem'] += $reward['redeem'];
                    }
                    else{
                        $rewards += array(
                            $key => array(
                                "credits" => $reward['credits'],
                                "redeem" => $reward['redeem'],
                            ),
                        ); 
                    }
                }
            }
        }
        else{
            $filter = "month";

            $objs = $obj->whereYear('created_at', $year)->get();

            $new_customers = $objs->count();

            foreach($objs as $obj){
                $key = date("M",strtotime($obj['created_at']));
                if(array_key_exists($key, $customers)){
                    $customers[$key] += 1;
                }
                else{
                    $customers += array(
                        $key => 1,
                    ); 
                }
            }

            $reward_objs = $reward->whereYear('created_at', $year)->get();

            $rewards = array();
        
            foreach($reward_objs as $reward){
                $key = date("M",strtotime($reward['created_at']));
                if(array_key_exists($key, $rewards)){
                    $rewards[$key]['credits'] += $reward['credits'];
                    $rewards[$key]['redeem'] += $reward['redeem'];
                }
                else{
                    $rewards += array(
                        $key => array(
                            "credits" => $reward['credits'],
                            "redeem" => $reward['redeem'],
                        ),
                    ); 
                }
            }
        }
        
        return view("apps.".$this->app.".".$this->module.".dashboard")
            ->with("app", $this)
            ->with("customers", json_encode($customers))
            ->with("rewards", json_encode($rewards))
            ->with("filter", $filter)
            ->with("new_customers", $new_customers)
            ->with("total_customers", $total_customers);
    }
}
