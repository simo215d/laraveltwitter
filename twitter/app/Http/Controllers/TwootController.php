<?php

namespace App\Http\Controllers;

use App\Models\Twoot;
use App\Models\User;
use Illuminate\Http\Request;
use Auth;
use DB;

class TwootController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //jeg bruger mine models til at tilgå deres all metode. :: betyder at det er en static metode
        $twoots = Twoot::all();
        $users = User::all();

        //da det ikke er normale php arrays, men laravel collections kan jeg nemt bruge metoderne, som laravel har lavet
        //sortby sortere mine twoots i en ascending (lav til høj)
        $sortedtwootsAsc = $twoots->sortBy('created_at');
        //men jeg vil have nyeste twoots (højest) øverst, så jeg bruger sortDesc som vender min liste om
        $sortedtwootsDesc = $sortedtwootsAsc->sortDesc();

        //jeg returnere viewet twoots.index blade filen, som kan modtage variabler ligesom handlebars i nodejs
        return view('twoots.index',['twoots'=>$sortedtwootsDesc], ['users'=>$users]);
    }
     
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('twoots.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
        ]);
        try {
            $user_id = Auth::user()->id;
        } catch (\Throwable $th) {
            return redirect()->route('twoots.index')
                        ->with('error','Make sure youre logged in!');
        }
        Twoot::create($request->all() + ['owner_fk' => $user_id]);
     
        return redirect()->route('twoots.index')
                        ->with('success','Twoot created successfully.');
    }
     
    /**
     * Display the specified resource.
     *
     * @param  \App\Twoot  $twoot
     * @return \Illuminate\Http\Response
     */
    public function show(Twoot $twoot)
    {
        return view('twoots.show',compact('twoot'));
    } 
     
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Twoot  $twoot
     * @return \Illuminate\Http\Response
     */
    public function edit(Twoot $twoot)
    {
        return view('twoots.edit',compact('twoot'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Twoot  $twoot
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Twoot $twoot)
    {
        $request->validate([
            'content' => 'required',
        ]);
    
        $twoot->update($request->all());
    
        return redirect()->route('twoots.index')
                        ->with('success','Twoot updated successfully');
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Twoot  $twoot
     * @return \Illuminate\Http\Response
     */
    public function destroy(Twoot $twoot)
    {
        $twoot->delete();
    
        return redirect()->route('twoots.index')
                        ->with('success','Twoot deleted successfully');
    }
}
