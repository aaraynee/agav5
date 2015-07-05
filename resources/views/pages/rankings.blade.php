@extends('layouts.master')

@section('content')

    <table class="uk-table">
        <thead>
            <tr>
                <th></th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        @foreach($rankings->table() as $position => $row)
            <tr>
                <td><?php echo $position; ?></td>
                <td><?php echo $row['details']->name; ?></td>
                <td><?php echo $row['points']; ?></td>
            </tr>
        @endforeach
    </table>

@stop
