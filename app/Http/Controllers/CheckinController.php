<?php

namespace App\Http\Controllers;

use App\Models\Checkin;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CheckinController extends Controller
{

    public function view()
    {
        $checkins = $this->index();
        return view('checkins', compact('checkins'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return Checkin::orderBy('in', 'desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Checkin
     */
    public function store(Request $request)
    {
        $checkin = new Checkin($request->all(['phone', 'in', 'out']));
        $checkin->save();
        return $checkin;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checkin  $checkin
     * @return Checkin
     */
    public function show(Checkin $checkin)
    {
        return $checkin;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checkin  $checkin
     * @return Checkin
     */
    public function update(Request $request, Checkin $checkin)
    {
        $input = $request->all('phone', 'in', 'out');
        $fields = [];
        foreach($input as $k => $v) {
            if ($v) {
                $fields[$k] = $v;
            }
        }

        if (count($fields)) {
            $checkin->fill($fields);
            $checkin->save();
        }

        return $checkin;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Checkin $checkin
     * @return bool|null
     * @throws \Exception
     */
    public function destroy(Checkin $checkin)
    {
        return $checkin->delete();
    }
}
