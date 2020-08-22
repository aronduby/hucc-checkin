@extends('app')

@section('content')

    <table>
        <thead>
            <tr>
                <th>Phone</th>
                <th>In</th>
                <th>Out</th>
            </tr>
        </thead>
        <tbody>
            @forelse($checkins as $checkin)
                <tr>
                    <td><x-phone :phone="$checkin->phone"></x-phone></td>
                    <td><x-date-time :dt="$checkin->in"></x-date-time></td>
                    <td><x-date-time :dt="$checkin->out"></x-date-time></td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">no entries yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>

@endsection
