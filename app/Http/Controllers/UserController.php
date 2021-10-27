<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use Image as Imagick;
use Auth;
use Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class UserController extends Controller
{
    public function editUser(Request $request) {
        $user = User::find($request->get('user')['id']);
        if (preg_match('/^data:image\/(\w+);base64,/', $request->get('image'))) {
            $data = substr($request->get('image'), strpos($request->get('image'), ',') + 1);
            $data = base64_decode($data);
            $img = Imagick::make($data)->resize(200, 200)->encode('jpg');
            Storage::disk('local')->put('public\\avatars\\'.Auth::user()->id.'.jpg', $img);
            $user->avatar = true;
        }

        $user->name = $request->get('user')['name'];
        $user->save();
        return Redirect::back();
    }
}
