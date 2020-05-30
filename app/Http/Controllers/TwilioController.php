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
        $msg = $request->input('Body');
        $from = $request->input('From');
        $rspMsg = 'How did you get this response?!?!??!?';

        $matched = preg_match_all('/(in|out) ?([\d:apm]+)?/i', $msg, $matches);

        // 0 => array of all the full matches - command + arguments
        // 1 => array of all the commands - in|out
        // 2 => array of all the arguments - time

        if (!$matched) {
            $rspMsg = $this->help($request);
        } else {
            try {
                for ($i = 0; $i < count($matches[1]); $i++) {
                    $cmd = $matches[1][$i];
                    $ts = strtotime($matches[2][$i]);

                    switch (strtoupper($cmd)) {
                        case 'IN':
                            $rspMsg = $this->in($from, $ts);
                            break;

                        case 'OUT':
                            $rspMsg = $this->out($from, $ts);
                            break;

                        default:
                            $rspMsg = $this->help($request);
                            break;
                    }
                }
            } catch (\Exception $e) {
                $rspMsg = 'Sorry, but something went wrong. Please try that again.';
            }
        }

        $rsp = new MessagingResponse();
        $rsp->message($rspMsg);
        print $rsp;
    }

    /**
     * Actions to check the user in
     *
     * @param string $from the phone number its from
     * @param bool|string|int $ts the timestamp supplied as the argument
     * @return string the response message
     */
    public function in($from, $ts = false) {
        // create a checkin (maybe check for an unclosed checkin first?)
        // get a name if it doesn't already exist (eventually)
        $ts = $ts ? $ts : now();

        Checkin::create([
            'phone' => $from,
            'in' => $ts,
            'reminded' => $ts
        ]);

        return 'Thanks for checking in. When you leave remember to text the word OUT to check out.';
    }

    /**
     * Actions to check the user out
     *
     * @param string $from the phone number its from
     * @param bool|string|int $ts the timestamp supplied as the argument
     * @return string the response message
     */
    public function out($from, $ts = false) {
        // get an unclosed checkin and close it

        $existing = Checkin::open()->where('phone', '=', $from)->first();
        if (!$existing) {
            return 'We were unable to find an open checkin for this number. You need to send IN first';

        } else {
            $existing->out = $ts ? $ts : now();
            $existing->save();

            return "You've been checked out. Thanks for helping us stay safe!";
        }
    }

    public function help(Request $request) {
        Log::warning('Unknown SMS received', $request->all());
        return "Sorry, I don't know how to handle that message. To check in send IN, to check out send OUT";
    }
}
