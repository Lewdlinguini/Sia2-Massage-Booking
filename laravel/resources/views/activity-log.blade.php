@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Activity Log</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Time</th>
                <th>Activity</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $log)
                <tr>
                    <td>{{ $log['time'] }}</td>
                    <td>{{ $log['activity'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No activity recorded.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
@endsection
