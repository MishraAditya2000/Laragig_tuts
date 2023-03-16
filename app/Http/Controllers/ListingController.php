<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    //Show All Listings
    public function index(){
        // dd(request('tag'));
        return view('listings.index',[
            'listings'=>Listing::latest()->
                        filter(request(['tag','search']))->Simplepaginate(3)
        ]);
    }

    //Show Single Listing
    public function show(Listing $listing){
        return view('listings.show',[
            'listing'=>$listing
        ]);
    }

    //Show Create Form
    public function create()
    {
        return view('listings.create');
    }

    public function store(Request $request){
    // dd($request->file('logo'));
    $formFields=$request->validate([
        'title'=>'required',
        
        'tags'=>'required',
        'company'=>['required',Rule::unique('listings'/*TABLE NAME*/,'company')],
        'location'=>'required',
        'website'=>'required',
        'email'=>['required','email'],
        'description'=>'required'
    ]);

    $formFields['user_id']=auth()->id();

    if($request->hasFile('logo')){
        $formFields['logo']=$request->file('logo')->store('logos','public');
    } 
    Listing::create($formFields);
    return redirect('/')->with('message','Lisitng Created Successfully!');
    }

    public function edit(Listing $listing){
        // dd($listing);
        return view('listings.edit',['listing'=>$listing]);
    }


    public function update(Request $request, Listing $listing){
        // dd($request->file('logo'));
        //Make sure login owner is the user
        if($listing->user_id!=auth()->id()){
            abort(403,'Unauthorised Action');
        }
        $formFields=$request->validate([
            'title'=>'required',
            
            'tags'=>'required',
            'company'=>['required'],
            'location'=>'required',
            'website'=>'required',
            'email'=>['required','email'],
            'description'=>'required'
        ]);

        if($request->hasFile('logo')){
            $formFields['logo']=$request->file('logo')->store('logos','public');
        } 

        $listing->update($formFields);
        return back()->with('message','Listing updated successfully');

    }

    public function destory(Listing $listing){
        if($listing->user_id!=auth()->id()){
            abort(403,'Unauthorised Action');
        }
        $listing->delete();
        return redirect('/')->with('message','DELTED SUCCESSFULLY');
    }

    public function manage(){
        return view('listings.manage',['listings'=>auth()->user()->listings()->get()]);
    }

}
