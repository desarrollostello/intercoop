@extends('layouts.master')

@section('content')
    <div class="container row">
        <div class="col s12 no-padding mmargin-t">
            @if(isset($user) && $user != null)
                <div class="col s12 white border-thin">
                    <div class="col s12 no-padding">
                        <div class="center">
                            <div class="col s12">
                                <a href="{{ url(route('show-photo')) }}" class="show-photo" data-photo-id="{{ encrypt($user->profile->avatar->id) }}">
                                    <img src="{{ asset(File::exists($user->profile->avatar->medium) ? $user->profile->avatar->medium : 'img/default_avatar.png') }}" width="200" class="circle z-depth-1 mmargin-tb profile-avatar-large">
                                </a>
                            </div>
                            <div class="col s12 no-padding">
                                <div class="col s12 m4 l4 margin-t">
                                    <button class="waves-effect pink waves-light btn d-block tooltipped" data-position="top" data-tooltip="Heart <i class='icon-heart pink-text lighteen-1'></i>" id="edit-profile-avatar">
                                        <span class="hide-on-small-only">Heart</span> <i class="icon-heart"></i>
                                    </button>
                                </div>
                                <div class="col s12 m4 l4 margin-t">
                                        <button class="waves-effect yellow waves-light btn d-block tooltipped" data-position="top" data-tooltip="Like <i class='icon-star yellow-text lighteen-1'></i>">
                                            <span class="hide-on-small-only">Like</span> <i class="icon-star"></i>
                                        </button>
                                </div>
                                <div class="col s12 m4 l4 margin-t">
                                    <button class="waves-effect green waves-light btn d-block tooltipped" data-position="top" data-tooltip="Add Contact <i class='icon-plus green-text text-lighteen-1'></i>">
                                        <span class="hide-on-small-only">Add</span> <i class="icon-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col s12 margin-t">
                        <ul class="collapsible popout" data-collapsible="accordion">
                            <li>
                                <div class="collapsible-header hoverable"><i class="material-icons">view_list</i>{{ $user->user_name }}</div>
                                <div class="collection collapsible-body">
                                    <div class="collection-item"><b>Fisrt name:</b> {{ $user->first_name }}</div>
                                    <div class="collection-item"><b>Last name:</b> {{ $user->last_name }}</div>
                                    {{--<div class="collection-item">Email: {{ $user->email }}</div>--}}
                                    <div class="collection-item"><b>Age:</b> {{ $user->birthday ? $user->age : "Not degined" }}</div>
                                    <div class="collection-item"><b>Sex:</b> {{ $user->sex=='f' ? 'female' : 'male'}}</div>
                                    <div class="collection-item"><b>Contry:</b> {{ $user->profile->country ? $user->profile->country : "Not defined" }}</div>
                                    <div class="collection-item"><b>State:</b> {{ $user->profile->region ? $user->profile->region : "Not defined" }}</div>
                                    <div class="collection-item"><b>Citie:</b> {{ $user->profile->citie ? $user->profile->citie : "Not defined"}}</div>
                                    <div class="collection-item">
                                        <p class="no-padding"><b>Description:</b></p>
                                        <p class="padding-tb">
                                            {{ $user->profile->description ? $user->profile->description : "Not defined" }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            @else
               <div class="col s12 white border-thin">
                   <h5>User Not found</h5>
               </div>
            @endif
        </div>
    </div>
@endsection