
@extends('layouts.master')

@section('content')
    <div class="container row">
        <div class="col l4 hide-on-med-and-down aside-left-menu no-padding padding-r">
            <div class="collection white">
                <!-- Aside menu left -->
                @include('includes.aside-menu-left')
                <!-- End aside menu left -->
            </div>
        </div>
        <div class="col s12 l8 no-padding mmargin-t">
            @if(isset($user) && $user != null)
                <div class="col s12 white border-thin">
                <div class="col s12 no-padding margin-b">
                    <div class="center">
                        <div class="col s12">
                            <div class="col s12 m4 mmargin-tb">
                                @if(\File::exists($user->profile->avatar->medium))
                                    <a href="{{ url(route('show-photo')) }}" class="show-photo" data-photo-id="{{ encrypt($user->profile->avatar->id) }}">
                                        <img src="{{ asset($user->profile->avatar->medium) }}" class="responsive-img circle z-depth-1 profile-avatar-large">
                                    </a>
                                @else
                                    <a>
                                        <img src="{{ asset('img/photo_unavailable.jpg') }}" alt="image-not-found" class="responsive-img circle z-depth-1 profile-avatar-large">
                                    </a>
                                @endif
                                <p class="no-margin">{{ $user->user_name }}</p>
                                <p class="no-margin">
                                    <small>{{ $user->first_name ." ". $user->last_name }}</small>
                                </p>
                            </div>
                            <div class="col s12 m8 mmargin-tb">
                                <div class="">
                                    <div class="col s12 no-padding border-thin">
                                        <div class="d-block">
                                            <a class="left padding center col s6 light-blue lighten-1 white-text" style="border-right: thin solid #e0e0e0">
                                                <p class="no-padding no-margin flow-text">
                                                    <span>
                                                        {{ \Pheaks\Contacts::where('user_from',$user->id)
                                                        ->orWhere('user_to',$user->id)
                                                        ->where('status','1')->get()->count() }}
                                                    </span>
                                                </p>
                                                <p class="no-padding no-margin">
                                                    <i class="material-icons">person_add</i> <span>Contacts</span>
                                                </p>
                                            </a>
                                            <a class="right padding center col s6 light-blue lighten-1 white-text">
                                                <p class="no-padding no-margin flow-text">
                                                    <span>
                                                        {{ $user->likes()->count() }}
                                                    </span>
                                                </p>
                                                <p class="no-padding no-margin">
                                                    <i class="material-icons">star</i> <span>Likes</span>
                                                </p>
                                            </a>
                                        </div>
                                        <div class="d-block">
                                            <div class="padding col s12 grey lighten-5 left-align">
                                                <p class="no-margin">
                                                    <b>State:</b>
                                                </p>
                                                <p class="no-margin mmargin-t">
                                                    @if(\Pheaks\State::where(['user_id'=>$user->id,'privacy'=>'1','status'=>'1'])->orderBy('created_at','desc')->first()!=null)
                                                        {!! str_limit(\Pheaks\State::where(['user_id'=>$user->id,'privacy'=>'1','status'=>'1'])->orderBy('created_at','desc')->first()->state, $limit = 50, $end = ' ... <a href="">More</a>') !!}
                                                    @else
                                                        Not defined
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 no-padding">
                            @if(Checks::is_contact($user->id))
                                <div class="col s12 m4 l4 margin-t">
                                    <a href="{{ route('messages-user', encrypt($user->id)) }}" class="waves-effect blue waves-light btn d-block tooltipped no-padding" data-position="top" data-tooltip="Message <i class='icon-envelope blue-text lighteen-2'></i>" id="sen-contact-message">
                                        <span class="hide-on-small-only">Message</span> <i class="icon-envelope"></i>
                                    </a>
                                </div>
                                <div class="col s12 m4 l4 margin-t">
                                    @if(Checks::is_liked('user',$user->id))
                                        <button class="waves-effect pink waves-light btn d-block tooltipped disabled" data-position="top" data-tooltip="Like <i class='icon-heart pink-text lighteen-1'></i>">
                                            <span class="hide-on-small-only">Like</span> <i class="icon-heart"></i>
                                        </button>
                                    @else
                                        <button class="waves-effect pink waves-light btn d-block tooltipped add-like-user" data-position="top" data-tooltip="Like <i class='icon-heart pink-text lighteen-1'></i>">
                                            <span class="hide-on-small-only">Like</span> <i class="icon-heart"></i>
                                        </button>
                                    @endif
                                </div>
                                <div class="col s12 m4 l4 margin-t">
                                    @if(Checks::contact_request_sended($user->id))
                                        <button class="waves-effect red waves-light btn d-block tooltipped cancel-contact-button" data-position="top" data-tooltip="Cancel Request <i class='icon-remove red-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Cancel</span> <i class="icon-remove"></i>
                                        </button>
                                    @elseif(Checks::contact_is_request($user->id))
                                        <button class="waves-effect blue waves-light btn d-block tooltipped acept-contact-button" data-position="top" data-tooltip="Acept Request <i class='icon-ok blue-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Acept</span> <i class="icon-ok"></i>
                                        </button>
                                    @elseif(Checks::is_contact($user->id))
                                        <button class="waves-effect red waves-light btn d-block tooltipped delete-contact-button" data-position="top" data-tooltip="Delete Contact <i class='icon-minus red-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Delete</span> <i class="icon-minus"></i>
                                        </button>
                                    @else
                                        <button class="waves-effect green waves-light btn d-block tooltipped add-contact-button" data-position="top" data-tooltip="Add Contact <i class='icon-plus green-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Add</span> <i class="icon-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            @else
                                <div class="col s12 m6 margin-t">
                                    @if(Checks::is_liked('user',$user->id))
                                        <button class="waves-effect pink waves-light btn d-block tooltipped disabled" data-position="top" data-tooltip="Like <i class='icon-heart pink-text lighteen-1'></i>">
                                            <span class="hide-on-small-only">Like</span> <i class="icon-heart"></i>
                                        </button>
                                    @else
                                        <button class="waves-effect pink waves-light btn d-block tooltipped add-like-user" data-position="top" data-tooltip="Like <i class='icon-heart pink-text lighteen-1'></i>">
                                            <span class="hide-on-small-only">Like</span> <i class="icon-heart"></i>
                                        </button>
                                    @endif
                                </div>
                                <div class="col s12 m6 margin-t">
                                    @if(Checks::contact_request_sended($user->id))
                                        <button class="waves-effect red waves-light btn d-block tooltipped cancel-contact-button" data-position="top" data-tooltip="Cancel Request <i class='icon-remove red-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Cancel</span> <i class="icon-remove"></i>
                                        </button>
                                    @elseif(Checks::contact_is_request($user->id))
                                        <button class="waves-effect blue waves-light btn d-block tooltipped acept-contact-button" data-position="top" data-tooltip="Acept Request <i class='icon-ok blue-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Acept</span> <i class="icon-ok"></i>
                                        </button>
                                    @elseif(Checks::is_contact($user->id))
                                        <button class="waves-effect red waves-light btn d-block tooltipped delete-contact-button" data-position="top" data-tooltip="Delete Contact <i class='icon-minus red-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Delete</span> <i class="icon-minus"></i>
                                        </button>
                                    @else
                                        <button class="waves-effect green waves-light btn d-block tooltipped add-contact-button" data-position="top" data-tooltip="Add Contact <i class='icon-plus green-text text-lighteen-1'></i>">
                                            <span class="hide-on-small-only">Add</span> <i class="icon-plus"></i>
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- @if(Checks::is_contact($user->id))
                <div class="col s12 mmargin-tb">
                    <form action="#">
                        <div class="input-field col s12">
                            <textarea id="textarea1" class="materialize-textarea message-to-contact counter" length="200"></textarea>
                            <label for="textarea1">Send message</label>
                        </div>
                        <div class="input-field col s12">
                            <a href="#" type="submit" class="btn btn-sm btn-block blue lighten-1 button-to-submit-message">Send <i class="material-icons">SEND</i></a>
                        </div>
                    </form>
                </div>
                @endif--}}
                </div>

                <div class="col s12 white mmargin-t border-thin">
                <h4>Photos</h4>
                <div class="slider">
                    <div class="viewer">
                        @if(isset($users_images) && !empty($users_images)&&$users_images->count()>0)
                            @foreach($users_images as $key => $image)
                                <div id="user-image-{{ $key }}" class="col s12 m4 l3 viewer-image center mmargin-t">
                                    @if(\File::exists($image->medium))
                                        <a href="{{ url(route('show-photo')) }}" class="show-photo" data-photo-id="{{ encrypt($image->id) }}">
                                            {{--<img src="{{ asset($image->medium) }}" class="z-depth-1 img-responsive profile-image" />--}}
                                                <div class="backgroun-avatar-user-image" style="background-image: url('{{asset($image->medium)}}');background-size:cover;background-repeat:no-repeat;background-position:center center;width: 100%;height: 7rem;"></div>
                                        </a>
                                    @else
                                        <a data-photo-id="{{ encrypt($image->id) }}">
                                            <img src="{{ asset('img/photo_unavailable.jpg') }}" alt="image-not-found" class="z-depth-1 responsive-img">
                                        </a>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <h3 class="center">Nothing to show</h3>
                        @endif
                        {{-- Sisez image = epic | bigger | normal | mini --}}
                    </div>
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
@if(isset($user) && $user != null)
    @section('main-javascripts')
        @parent
        @include('javascripts.user-actions-buttons')
        @include('javascripts.content-interactivity')

    @endsection
@endif