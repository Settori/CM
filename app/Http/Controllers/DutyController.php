<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Duty;
use App\Models\Point;
use Inertia\Inertia;
use Redirect;
use Auth;

class DutyController extends Controller
{

    function addPoint(Duty $duty, Request $request) {
        try {
            $p = Point::create([
                'user_id' => Auth::user()->id,
                'duty_id' => $duty->id
            ]);
            return Redirect::back();
        }
        catch (Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    function removePoint(Point $point) {
        try {
            // dd($point);
            Point::find($point->id)->delete();
            // $point->delete();
            return Redirect::back();
        }
        catch (Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
