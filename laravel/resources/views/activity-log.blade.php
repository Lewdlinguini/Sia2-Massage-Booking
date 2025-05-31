@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="display-4 fw-bold mb-3" style="color: #b97f5a; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
    Activity Log
    </h1>

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
