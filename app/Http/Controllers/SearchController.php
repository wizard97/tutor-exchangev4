<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{

  public function __construct(Request $request)
  {
    //$request->session()->keep(['tutor_search_inputs']);
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
      $grades = \App\Grade::all();
      return view('search/index')->with('classes', $classes)->with('subjects', $subjects)->with('grades', $grades);
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
      'grade' => 'numeric',
      ]);
      $input = $request->all();
      //flash form data into session
      $request->session()->put('tutor_search_inputs', $input);
      //searchcounter++
      \App\Stat::increment('searches');

      return redirect('search/showresults');
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
      $search = new \App\Level;
      $search = $search->findtutors();
        //loop thorugh the form inputs
        $selected = 0;

        //get the search inputs from the session
        $form_inputs = $request->session()->get('tutor_search_inputs');
        $classes = array();

        //get array of selected classes
        if (!empty($form_inputs['classes'])) $classes = $form_inputs['classes'];
              //create seach query, pass in $selected by refrence
              $search = $search->where(function ($query) use($form_inputs, &$selected, $classes){

              //handle rates
              if (!empty($form_inputs['start_rate'])) $query->where('rate', '>=', $form_inputs['start_rate']);
              if (!empty($form_inputs['end_rate'])) $query->where('rate', '<=', $form_inputs['end_rate']);
              if (!empty($form_inputs['min_grade'])) $query->where('grade', '>=', $form_inputs['min_grade']);

              //build query for classes the user selects
              $query->where(function ($query) use($form_inputs, &$selected, $classes){
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
       //array with key user ids, containing an object of id and sqlcount
       $id_count = $search->get()->keyBy('user_id')->toArray();

       //user_id's who match criteria for array
       $tutors_id = array_keys($id_count);

       if (!empty($tutors_id))
       {
       $ids = implode(',', $tutors_id);
       $tutors_object =  new \App\Tutor;
       $basic_info = $tutors_object->tutorinfo($tutors_id)
       ->orderByRaw(\DB::raw("FIELD(tutors.user_id, $ids)"))
       ->select('users.id', 'users.fname', 'users.lname', 'users.account_type', 'users.last_login', 'users.last_login', 'users.created_at','tutors.*', 'grades.*')
       ->paginate(15);

       //results passed by reference, function adds tutor match%, classes and reviews
       $results = \App\Tutor::add_classes_reviews($basic_info, $selected, $id_count);
      }
      else $results = array();

      $num_results = count($id_count);
      return view('search/showresults', ['results' => $results, 'num_results' => $num_results]);
     }



    /**
     * Show tutor profile
     *
     * @param  int  $id
     * @return Response
     */
    public function showtutorprofile($id)
    {
      //get subjects
      $subjects = \App\SchoolClass::groupBy('class_type')->get()->pluck('class_type');
      //get basic tutor info
      $tutor = \App\Tutor::get_tutor_profile($id);
      return view('search/showtutorprofile')->with('tutor', $tutor)->with('subjects', $subjects);
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
