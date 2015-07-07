<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ImagesController extends Controller
{

  public function __construct()
  {
    if (\Auth::check()) {
    $this->id = \Auth::user()->id;
    }
  }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
      //only members
      $this->middleware('auth');
      //validate
      $this->validate($request, [
        'image' => 'required|image|max:10000',
      ]);
      //check if user image directory exists
      $directory = storage_path().'/app/images/'.$this->id;
      if (!\File::exists($directory)) \File::makeDirectory($directory, 777, false);
      else {
        $images = \File::files($directory);
        if (!empty($images))
        {
          $new_directory = $directory.'/'.date("Y-m-d-H-i-s");
          \File::makeDirectory($new_directory);
          foreach($images as $img)
          {
            $file_path = explode('/', $img);
            \File::move($img, $new_directory.'/'.end($file_path));
          }
        }
      }

      $uploaded_image = $request->file('image');
      //copy original image
      $new_name = 'profile_original.'.$uploaded_image->getClientOriginalExtension();
      $uploaded_image->move($directory.'/', $new_name);
      //create two copies at different resolutions
      $image = \Image::make(\File::get($directory.'/'.$new_name));
      $image->resize(720, 720)->save($directory.'/profile_full.png');
      $image->resize(100, 100)->save($directory.'/profile_thumb.jpg');
      $user = \App\User::findOrFail(\Auth::user()->id);
      $user->has_picture = true;
      $user->save();
      \Session::flash('feedback_positive', 'You successfully uploaded your profile picture.');
      return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
      $user = \App\User::findOrFail($id);
      $directory = storage_path().'/app/images/'.$id.'/';
      if (\Auth::check() && $user->has_picture == 1 && \File::exists($directory.'profile_full.png'))
      {
        $image = \File::get($directory.'profile_full.png');
        $response = \Response::make($image);
      }
      else
      {
        $image = \File::get(storage_path().'/app/images/default.jpg');
        $response = \Response::make($image);
      }
      // set content-type
      $response->header('Content-Type', 'image/png');
      return $response;
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
