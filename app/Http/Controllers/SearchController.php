<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
      $classes = \App\SchoolClass::with('class_levels')->orderBy('class_order', 'asc')
      ->get()
      ->groupBy('class_type');
      $subjects = \App\SchoolClass::groupBy('class_type')->get()->pluck('class_type');
      return view('search/index')->with('classes', $classes)->with('subjects', $subjects);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
     public function showresults(Request $request)
     {
       //get the classes and levels, and join that on the tutor_levels table
      $search = \DB::table('levels')
              ->join('tutor_levels', 'levels.id', '=', 'tutor_levels.level_id')
              ->join('tutors', 'tutors.user_id', '=', 'tutor_levels.user_id')
              ->join('users', 'tutors.user_id', '=', 'users.id')
              ->select(\DB::raw('count(*) as class_matches, tutors.*, users.*'));

        //loop thorugh the form inputs
       if ($request->has('classes') && is_array($request->input('classes'))) {
         $classes = $request->input('classes');

          foreach($classes as $class_id)
          {
            if ($request->has('class_'.$class_id))
            {
              $search = $search->orWhere(function ($query) use($class_id, $request){
                $query->where('levels.class_id', $class_id)
                      ->where('levels.level_num', '>=', $request->input('class_'.$class_id));
            });
            }
          }
       }
       //find a way to efficiently use paginate
       $results = $search->where('tutor_active', '1')->groupBy('tutor_levels.user_id')->orderBy('class_matches', 'desc')->paginate(15);
       return view('search/showresults', ['results' => $results]);
     }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
