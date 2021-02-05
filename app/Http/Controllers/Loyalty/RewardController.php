<?php

namespace App\Http\Controllers\Loyalty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Loyalty\Reward as Obj;
use App\Models\Loyalty\Customer;

use Illuminate\Support\Facades\Auth;

class RewardController extends Controller
{

    /**
     * Define the app and module object variables and component name 
     *
     */
    public function __construct(){
        // load the app, module and component name to object params
        $this->app      =   'Loyalty';
        $this->module   =   'Reward';
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
    public function index(Obj $obj)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Obj $obj)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Obj $obj, Request $request)
    {
        // Authorize the request
        // $this->authorize('create', $obj);
        
        // Get customer id
        $customer = Customer::where("phone", $request->input('phone'))->first();
        // ddd($customer);

        $credit = $request->input('credit');
        $redeem = $request->input('redeem');

        // ddd($credit);

        // Store the records
        $obj->create([
            "customer_id" => $customer->id,
            "phone" => $customer->phone,
            "credits" => $request->input('credit'),
            "redeem" => $request->input('redeem'),
        ]);

        return redirect()->route($this->module.'.public', ['phone' => $customer->phone]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Obj $obj, Request $request)
    {
 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($slug, Obj $obj)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Obj $obj, $phone)
    {


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
   
    }

    public function public(Obj $obj, Request $request){

        if(!empty($request->input('phone'))){
            $phone = $request->input('phone');
        
            $objs = $obj->where('phone', $phone)->get(); 
            
            if($objs->count() >= 1){        
                $remaining_credits = 0;
                $rewards = array();

                $year = date("Y");

                foreach($objs as $reward){
                    $remaining_credits = $remaining_credits + ($reward->credits - $reward->redeem);
                }
                
                $objs_year = $obj->whereYear('created_at', $year)->get();

                foreach($objs_year as $obj){
                    $key = date("M",strtotime($obj['created_at']));
                    if(array_key_exists($key, $rewards)){
                        $rewards[$key] += 1;
                    }
                    else{
                        $rewards += array(
                            $key => 1,
                        ); 
                    }
                }
                
                return view("apps.".$this->app.".".$this->module.".public")
                    ->with("app", $this)
                    ->with("objs", $objs)
                    ->with("phone", $phone)
                    ->with("remaining_credits", $remaining_credits)
                    ->with("rewards", json_encode($rewards));
            }  
    
            return view("apps.".$this->app.".".$this->module.".public")
                    ->with("app", $this)
                    ->with("objs", $objs)
                    ->with("phone", $phone)
                    ->with("alert", "No Records Found. Please talk with the Sales Executive");
        }

        return view("apps.".$this->app.".".$this->module.".public")
            ->with("app", $this);
    }
}
