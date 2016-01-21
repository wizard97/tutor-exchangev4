<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\User\User;

class ProfileImageController extends Controller
{

  public function __construct()
  {
    if (\Auth::check()) {
    $this->id = \Auth::user()->id;
    }
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return Response
   */
  public function getShowFull($id)
  {
    $user = User::findOrFail($id);
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
   * Return thumbnail version of profile
   *
   * @return Response
   */
  public function getShowSmall($id)
  {
    $user = User::findOrFail($id);
    $directory = storage_path().'/app/images/'.$id.'/';
    if (\Auth::check() && $user->has_picture == 1 && \File::exists($directory.'profile_thumb.jpg'))
    {
      $image = \File::get($directory.'profile_thumb.jpg');
      $response = \Response::make($image);
    }
    else
    {
      //return redirect('/img/default_thumb.jpg');

      $image = \File::get(storage_path().'/app/images/default_thumb.jpg');
      $response = \Response::make($image);

    }
    // set content-type
    $response->header('Content-Type', 'image/png');
    return $response;
  }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postStore(Request $request)
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

      // Crop image so it is 1:1
      $image->fit(min($image->width(), $image->height()));
      $image->resize(720, 720)->save($directory.'/profile_full.png');
      $image->resize(100, 100)->save($directory.'/profile_thumb.jpg');
      $user = \App\User::findOrFail($this->id);
      $user->has_picture = true;
      $user->save();
      \Session::put('feedback_positive', 'You successfully uploaded your profile picture.');
      return back();
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function getDestroy()
    {
      //only members
      $this->middleware('auth');

      $directory = storage_path().'/app/images/'.$this->id;
      if (\File::exists($directory))
      {
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
      $user = User::findOrFail($this->id);
      $user->has_picture = false;
      $user->save();
      \Session::put('feedback_positive', 'You successfully deleted your profile picture.');
      return back();
    }
}
