@extends('layouts.admin')

@section('content')
    @if(!empty($users))
        <table class="striped highlight responsive-table">
            <thead>
            <tr><th data-field="avatar">Avatar</th>
                <th data-field="id">Id</th>
                <th data-field="user_name">Username</th>
                <th data-field="first_name">Name</th>
                <th data-field="last-name">Last name</th>
                <th data-field="status">Status</th>
            </tr>
            </thead>

            <tbody>
            @foreach($users as $key => $user)
                <tr>
                    <td>
                        <img src="{{ asset($user->profile->avatar->small) }}" alt="avatar" class="circle responsice-image" width="50">
                    </td>
                    <td>
                        {{ $user->id }}
                    </td>
                    <td>{{ $user->user_name }}</td>
                    <td>{{ $user->first_name }}</td>
                    <td>{{ $user->last_name }}</td>
                    <td>{{ $user->status=='0' ? 'Inactive' : 'Active' }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection