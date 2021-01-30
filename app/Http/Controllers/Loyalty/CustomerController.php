<?php

namespace App\Http\Controllers\Loyalty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Loyalty\Customer as Obj;
use App\Models\Loyalty\Reward;

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
        $this->authorize('create', $obj);
        
        // Check for when to publish
        if($request->input('publish') == "now" ){
            $status = 1;
        }
        else if($request->input('publish') == "save_as_draft"){
            $status = 0;
        }   
        
        // Store the records
        $obj = $obj->create($request->all() + ['status' => $status]);

        if($request->input('tag_ids')){
            foreach($request->input('tag_ids') as $tag_id){
                if(!$obj->tags->contains($tag_id)){
                    $obj->tags()->attach($tag_id);
                }
            }
        }

        return redirect()->route($this->module.'.index');
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

        $obj = $obj->where('phone', $phone)->first();

        if($obj){        
            $remaining_credits = 0;

            foreach($obj->rewards as $reward){
                $remaining_credits = $remaining_credits + ($reward->credits - $reward->redeem);
            }
    
            return view("apps.".$this->app.".".$this->module.".show")
                    ->with("app", $this)
                    ->with("obj", $obj)
                    ->with("remaining_credits", $remaining_credits);
        }   

        // return view("apps.".$this->app.".".$this->module.".show")
        //         ->with("app", $this)
        //         ->with("obj", $obj);
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
    public function update(Request $request, Obj $obj, $id)
    {

        // load the resource
        $obj = Obj::where('id',$id)->first();
        // authorize the app
        $this->authorize('update', $obj);

        // Check for when to publish
        if($request->input('publish') == "now" ){
            $status = 1;
        }
        else if($request->input('publish') == "save_as_draft"){
            $status = 0;
        }   

        //update the resource
        $obj->update($request->all() + ['status' => $status]);

        $obj->tags()->detach();

        if($request->input('tag_ids')){
            foreach($request->input('tag_ids') as $tag_id){
                if(!$obj->tags->contains($tag_id)){
                    $obj->tags()->attach($tag_id);
                }
            }
        }
        
        return redirect()->route($this->module.'.list');
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
}
