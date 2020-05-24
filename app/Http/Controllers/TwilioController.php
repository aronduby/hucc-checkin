<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Twilio\TwiML\MessagingResponse;

class TwilioController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function incoming(Request $request) {
        // figure out if we're doing a checkin or out
        $msg = $request->input('Body');

        if (Str::startsWith(strtoupper($msg), 'IN')) {
            $this->in($request);
        } elseif (Str::startsWith(strtoupper($msg), 'OUT')) {
            $this->out($request);
        } else {
            $this->help($request);
        }
    }

    /**
     * Actions to check the user in
     *
     * @param Request $request
     */
    public function in(Request $request) {
        // create a checkin (maybe check for an unclosed checkin first?)
        // get a name if it doesn't already exist (eventually)
        $rsp = new MessagingResponse();

        try {
            $checkin = Checkin::create([
                'phone' => $request->input('From'),
                'in' => now()
            ]);

            $rsp->message('Thanks for checking in. When you leave remember to text the word OUT to check out.');
        } catch (\Exception $e) {
            $rsp->message('Sorry, but something went wrong, please try checking in again');
            Log::error($e->getMessage());
        }

        print $rsp;
    }

    /**
     * Actions to check the user out
     *
     * @param Request $request
     */
    public function out(Request $request) {
        // get an unclosed checkin and close it
        $rsp = new MessagingResponse();

        $existing = Checkin::open()->where('phone', '=', $request->input('From'))->first();
        if (!$existing) {
            $rsp->message('We were unable to find an open checkin for this number. You need to send IN first');
        } else {

            try {
                $existing->out = now();
                $existing->save();
                $rsp->message("You've been checked out. Thanks for helping us stay safe!");

            } catch (\Exception $e) {
                $rsp->message('Sorry, but something went wrong, please try checking in again');
            }
        }

        print $rsp;
    }

    public function help(Request $request) {
        Log::warning('Unknown SMS received', $request->all());
        $smsRsp = new MessagingResponse();
        $smsRsp->message("Sorry, I don't know how to handle that message. To check in send IN, to check out send OUT");

        print $smsRsp;
    }
}
