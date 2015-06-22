<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{

  public function __construct(Request $request)
  {
    $request->session()->keep(['tutor_search_inputs']);
  }

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
    public function search(Request $request)
    {
      $this->validate($request, [
      'start_rate' => 'min:0|numeric',
      'end_rate' => 'min:0|numeric',
      ]);
      $input = $request->all();
      //flash form data into session

      $request->session()->flash('tutor_search_inputs', $input);

    return redirect('search/showresults');
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
      $search = \App\Level::findtutors();
        //loop thorugh the form inputs
        $selected = 0;

        //get the search inputs from the session
        $form_inputs = $request->session()->get('tutor_search_inputs');
        $classes = array();

        if (!empty($form_inputs['classes'])) $classes = $form_inputs['classes'];
              //create seach query, pass in $selected by refrence
              $search = $search->where(function ($query) use($form_inputs, &$selected, $classes){
              $query->where('tutor_active', '1')->where(function ($query) use($form_inputs, &$selected, $classes){

                foreach($classes as $class_id)
                {
                  if (!empty($form_inputs['class_'.$class_id]))
                  {
                    $query->orWhere(function ($query) use($class_id, $form_inputs, &$selected){

                    $query->where('levels.class_id', $class_id);
                    $query->where('levels.level_num', '>=', $form_inputs['class_'.$class_id]);
                    $selected++;
                    });
                  }
                }

              });
            });
       //user_id's who match criteria for array
       $tutors_id = $search->get()->pluck('user_id')->all();

       //collection of user ids and class_matches
       $id_count_collection = $search->get()->keyBy('user_id');

       if (!empty($tutors_id))
       {
       $ids = implode(',', $tutors_id);
       $results = \App\Tutor::tutorinfo($tutors_id)
       ->orderByRaw(\DB::raw("FIELD(user_id, $ids)"))
       ->paginate(15);

       foreach($results as $tutor)
       {
         $id = $tutor->user_id;
         if ($selected < 1) $percent_match = 100;
         else $percent_match = number_format(($id_count_collection->get($id)->class_matches/$selected)*100, 0);
         $tutor->percent_match = $percent_match;
       }

      }
      else $results = collect(array());
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
