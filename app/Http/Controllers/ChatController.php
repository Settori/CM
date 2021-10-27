<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\Test;
use App\Models\Message;
use Auth;
use Redirect;
use App\Events\MessageSent;


class ChatController extends Controller
{

    public function broadcast(Request $request) {

        try {
            Message::create([
                'user_id' => Auth::user()->id,
                'content' => $request->get('message')
            ]);
            MessageSent::dispatch(Auth::user(), (string) $request->get('message'));

            return Redirect::back();
        }
        catch (Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }

    public function reloadPage(Request $request) {
        try {
            Test::dispatch();
            return Redirect::back();
        }
        catch (Exception $e) {
            return Redirect::back()->with(['error' => $e->getMessage()]);
        }
    }
}
