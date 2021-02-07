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
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Obj $obj, Request $request)
    {

        // Check if any search query is present
        $query = $request->input("query");

        // Retrieve records
        $objs = $obj->where("name", "LIKE", "%{$query}%")->sortable()->paginate(10);

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

        // Validate the request object
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
        // Retrieve the record
        $obj = $obj->where("id", $id)->first();

        // Retrieve related records
        $rewards = $obj->rewards()->orderBy('id', 'desc')->paginate(10);

        return view("apps.".$this->app.".".$this->module.".show")
                ->with("app", $this)
                ->with("obj", $obj)
                ->with("rewards", $rewards);
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

        // Initialize required variables
        $customers = array();
        $year = date("Y");
        $month = date("m");

        // Get total count of customers in the database
        $total_customers = $obj->all()->count();

        // Get the filter if exists
        $filter = $request->input('filter');

        // Check if filter not empty
        if(!empty($filter)){
            if($filter == 'month'){
                // Retrieve records of that particular year
                $objs = $obj->whereYear('created_at', $year)->get();

                // Get count of the customers in that particular year
                $new_customers = $objs->count();

                // Create an array of customers in that particular year for each month
                // Associative array format:
                    // {
                    //      "Jan": 1,
                    //      "Feb": 2, 
                    // }
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

                // Retrieve records of that particular year
                $reward_objs = $reward->whereYear('created_at', $year)->get();

                // Create an array to store the rewards data
                $rewards = array();
            
                // Create an array of credit and redeem points of that particular year for each month
                // Associative array format:
                    // {
                    //      "Jan": {
                    //                  "credits": 100,
                    //                  "redeem": 40
                    //              },
                    //      "Feb": {
                    //                  "credits": 30,
                    //                  "redeem":10,
                    //              }, 
                    // }
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
                // Retrieve records of that particular month
                $objs = $obj->whereMonth('created_at', $month)->get();

                // Get the number of customers in that particular month
                $new_customers = $objs->count();

                // Create an array of customers in that particular month for each day
                // Associative array format:
                    // {
                    //      "1": 9,
                    //      "2": 15, 
                    // }
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

                // Retrieve credit and redeem points in that particular month
                $reward_objs = $reward->whereMonth('created_at', $month)->get();

                // Initialize array to store the rewards data
                $rewards = array();

                // Create an array of credit and redeem points of that particular month for each day
                // Associative array format:
                    // {
                    //      "2": {
                    //                  "credits": 100,
                    //                  "redeem": 40
                    //              },
                    //      "5": {
                    //                  "credits": 30,
                    //                  "redeem":10,
                    //              }, 
                    // }
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
            // Default filter is det to month
            $filter = "month";

            // Retrieve records of that particular year
            $objs = $obj->whereYear('created_at', $year)->get();

            // Get count of the customers in that particular year
            $new_customers = $objs->count();

            // Create an array of customers in that particular year for each month
            // Associative array format:
                // {
                //      "Jan": 1,
                //      "Feb": 2, 
                // }
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

            // Retrieve records of that particular year
            $reward_objs = $reward->whereYear('created_at', $year)->get();

            // Create an array to store the rewards data
            $rewards = array();
                        
            // Create an array of credit and redeem points of that particular year for each month
            // Associative array format:
                // {
                //      "Jan": {
                //                  "credits": 100,
                //                  "redeem": 40
                //              },
                //      "Feb": {
                //                  "credits": 30,
                //                  "redeem":10,
                //              }, 
                // }
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
