<?php

namespace App\Http\Controllers\Loyalty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Loyalty\Reward as Obj;
use App\Models\Loyalty\Customer;

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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj)
    {

        return view("apps.".$this->app.".".$this->module.".index")
                ->with("app", $this)
                ->with("obj", $obj);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Obj $obj)
    {
        // Authorize the request
        $this->authorize('create', $obj);

        $this->componentName = 'themes.'.env('ADMIN_THEME').'.layouts.app';

        return view("apps.".$this->app.".".$this->module.".createEdit")
                ->with("stub", "create")
                ->with("app", $this)
                ->with("objs", $obj)
                ->with("categories", $categories)
                ->with("tags", $tags);
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

        return redirect()->route($this->module.'.public');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Obj $obj, Request $request)
    {
        $phone = $request->input('phone');
        
        $objs = $obj->where('phone', $phone)->get(); 
        
        if($objs->count() >= 1){        
            $remaining_credits = 0;
            
            foreach($objs as $reward){
                $remaining_credits = $remaining_credits + ($reward->credits - $reward->redeem);
            }
            
            return view("apps.".$this->app.".".$this->module.".public")
                ->with("app", $this)
                ->with("objs", $objs)
                ->with("phone", $phone)
                ->with("remaining_credits", $remaining_credits);
        }  

        return view("apps.".$this->app.".".$this->module.".public")
                ->with("app", $this)
                ->with("objs", $objs)
                ->with("phone", $phone)
                ->with("alert", "No Records Found. Please talk with the Sales Executive");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($slug, Obj $obj)
    {
        // Retrieve Specific record
        $obj = $obj->getRecord($slug);
        // Authorize the request
        $this->authorize('create', $obj);

        $this->componentName = 'themes.'.env('ADMIN_THEME').'.layouts.app';

        return view("apps.".$this->app.".".$this->module.".createEdit")
                ->with("stub", "update")
                ->with("app", $this)
                ->with("obj", $obj)
                ->with("categories", $categories)
                ->with("tags", $tags);
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

        // load the resource
        $obj->where('phone',$phone)->first();
        // authorize the app
        // $this->authorize('update', $obj); 

        //update the resource
        $obj->create([
            "credit" => $request->input("credit"),
            "redeem" => $request->input("redeem"),
        ]);

        return redirect()->route($this->module.'.public');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize
        $this->authorize('update', $obj);
        // delete the resource
        $obj->delete();

        return redirect()->route($this->module.'.list');
    }

    public function public(Obj $obj, Request $request){

        if(!empty($request->input('phone'))){
            $phone = $request->input('phone');
        
            $objs = $obj->where('phone', $phone)->get(); 
            
            if($objs->count() >= 1){        
                $remaining_credits = 0;
                
                foreach($objs as $reward){
                    $remaining_credits = $remaining_credits + ($reward->credits - $reward->redeem);
                }
                
                return view("apps.".$this->app.".".$this->module.".public")
                    ->with("app", $this)
                    ->with("objs", $objs)
                    ->with("phone", $phone)
                    ->with("remaining_credits", $remaining_credits);
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
