<?php

namespace App\Http\Controllers;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Option;
use App\Models\Duty;
use App\Models\Point;
use App\Models\Event;
use App\Models\Week;
use App\Models\Image;
use App\Models\Message;
use Image as Imagick;
use Auth;
use Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;


use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function main_view() {
        return Inertia::render('Main', [
            'duties' => Duty::with(['points' => function($q){
                $q->where('user_id', Auth::user()->id);
            }])->get(),
            'points' => Point::with('duty')->where('user_id', Auth::user()->id)->orderBy('id', 'DESC')->paginate(8)->withQueryString()->onEachSide(2),
        ]);
    }

    public function cm_view() {

        return Inertia::render('CM', [
            'week' => Week::whereDate('day', '<=', date('Y-m-d'))->with('user')->first(),
            'messages' => Message::with('user')->orderBy('id', 'DESC')->take(5)->get()->reverse()->values(),
            'image' => Image::inRandomOrder()->first() ? Image::inRandomOrder()->first()->image : null,
            'event' => Event::whereDate('date', '>=', date('Y-m-d H:i:s'))->orderBy('date', 'ASC')->first()
        ]);
    }

    public function chat_view() {
        return Inertia::render('Chat', [
            'messages' => Message::with('user')->orderBy('id', 'DESC')->take(20)->get()->reverse()->values()
        ]);
    }

    public function images_view() {
        return Inertia::render('Images', [
            'messages' => Message::with('user')->orderBy('id', 'DESC')->take(20)->get()->reverse()->values(),
            'images' => Image::orderBy('id', 'DESC')->paginate(12)->withQueryString()->onEachSide(2),
        ]);
    }
    public function settings_view() {
        return Inertia::render('Settings', [

        ]);
    }
    public function events_view() {
        return Inertia::render('Events', [
            'events' => Event::orderBy('id', 'DESC')->paginate(10)->withQueryString()->onEachSide(2),
        ]);
    }
    public function addEvent(Request $request) {
        // dd($request->all());
        try {
            $request->validate([
                'name' => 'required',
                'date' => 'required',
                'time' => 'required',
            ]);
            Event::create([
                'name' => $request->get('name'),
                'date' => $request->get('date') . " " . $request->get('time') . ":00",
                'user_id' => Auth::user()->id,
            ]);
            return Redirect::back();
        }
        catch (Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    public function removeEvent(Event $event) {
        try {
            $event->delete();
            return Redirect::back();
        }
        catch (Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    public function removeImage(Image $image) {
        try {
            $image->delete();
            return Redirect::back();
        }
        catch (Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    public function getImage(Request $request) {
        try {
            return Image::inRandomOrder()->first() ? Image::inRandomOrder()->first()->image : null;
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function saveImage(Request $request) {
        if (preg_match('/^data:image\/(\w+);base64,/', $request->get('image'))) {
            $data = substr($request->get('image'), strpos($request->get('image'), ',') + 1);
            $data = base64_decode($data);
            $img = Imagick::make($data)->resize(1000, 700)->encode('jpg');
            $imgsmall = Imagick::make($data)->resize(200, 160)->encode('jpg');
            $filename = Str::random(40);
            // $img->save(storage_path('\app\public\news\\' . $filename));
            Storage::disk('local')->put('public\\images\\'.$filename.'.jpg', $img);
            Storage::disk('local')->put('public\\images\\'.$filename.'_small.jpg', $imgsmall);
            Image::create([
                'user_id' => Auth::user()->id,
                'image' => $filename
            ]);
        }
        return Redirect::back();
    }

    public function getWeather() {
        $response = file_get_contents("https://api.openweathermap.org/data/2.5/weather?lat=50.079040&lon=19.888770&appid=4bbf6173b25f7d08c5ffa4b142d96c82&units=metric&lang=pl");
        return json_decode($response);
    }
}
