
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
        	<div class="col s12 white border-thin">
        		<div class="col s12 no-padding">
					<h5 class="left">Contacts</h5>
					<div class="right mmargin-t">
						<select class="browser-default contacts-order">
							<option value="1">All</option>
							<option value="2">You added</option>
                            <option value="3">They added you</option>
						</select>
					</div>
				</div>
        		<div class="col s12 no-padding margin-t contacts-content">
        			@if($users!=null||!empty($user))
						@foreach($users as $key => $user)
                            @if($user->user_f->id == Auth::user()->id)
                                <div class="avatar col s12 m4 l6 center requested">
                                    <div class="card">
                                        <div class="card-content white-text margin-b">
                                            @if(!File::exists($user->user_t->profile->avatar->medium))
                                                <img src="{{ asset('img/default_avatar.png') }}" width="100%" alt="image-not-found" class="responsive-img">&nbsp;
                                            @else
                                                <a href="{{ url(route('show-photo')) }}" class="show-photo" data-photo-id="{{ encrypt($user->user_t->profile->avatar->id) }}">
                                                    <img src="{{ asset($user->user_t->profile->avatar->medium) }}" alt="user-avatar" width="100%" class="responsive-img">
                                                </a>
                                            @endif
                                            <a href="{{ url(route('accound',encrypt($user->user_t->id))) }}" class="center">
                                                <span class="col s8 right-align no-padding mmargin-tb">
                                                    <span class="title truncate">{{ $user->user_t->user_name }}</span>
                                                </span>
                                                <span class="col s4 left-align no-padding mmargin-tb">
                                                    <span>
                                                        &nbsp;{!! $user->user_t->sex == 'f' ? '<i class="icon-female pink-text"></i>' : '<i class="icon-male blue-text"></i>' !!} <span class="grey-text">·</span>
                                                    </span>
                                                    <i class="material-icons">cake</i>
                                                    <span>{{ $user->user_t->age }}</span>
                                                </span>
                                            </a>
                                        </div>
                                        <div class="card-action">
                                            @if(Checks::contact_request_sended($user->user_t->id))
                                                <button class="waves-effect red waves-light btn d-block tooltipped cancel-contact-button" data-user="{{encrypt($user->user_t->id)}}" data-position="top" data-tooltip="Cancel Request <i class='icon-remove red-text text-lighteen-1'></i>">
                                                    <span class="hide-on-small-only">Cancel</span> <i class="icon-remove"></i>
                                                </button>
                                            @elseif(Checks::contact_is_request($user->user_t->id))
                                                <button class="waves-effect blue waves-light btn d-block tooltipped acept-contact-button" data-user="{{encrypt($user->user_t->id)}}" data-position="top" data-tooltip="Acept Request <i class='icon-ok blue-text text-lighteen-1'></i>">
                                                    <span class="hide-on-small-only">Acept</span> <i class="icon-ok"></i>
                                                </button>
                                            @elseif(Checks::is_contact($user->user_t->id))
                                                <button class="waves-effect red waves-light btn d-block tooltipped delete-contact-button" data-user="{{encrypt($user->user_t->id)}}" data-position="top" data-tooltip="Delete Contact <i class='icon-minus red-text text-lighteen-1'></i>">
                                                    <span class="hide-on-small-only">Delete</span> <i class="icon-minus"></i>
                                                </button>
                                            @else
                                                <button class="waves-effect green waves-light btn d-block tooltipped add-contact-button" data-user="{{encrypt($user->user_t->id)}}" data-position="top" data-tooltip="Add Contact <i class='icon-plus green-text text-lighteen-1'></i>">
                                                    <span class="hide-on-small-only">Add</span> <i class="icon-plus"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @else
                                @if($user->user_f->status!=1)
                                    @continue
                                @endif
                                <div class="avatar col s12 m4 l6 center addeded">
                                    <div class="card">
                                        <div class="card-content white-text btn-block margin-b">
                                            @if(!File::exists($user->user_f->profile->avatar->medium))
                                                <img src="{{ asset('img/default_avatar.png') }}" width="100%" alt="image-not-found" class="responsive-img">&nbsp;
                                            @else
                                                <a href="{{ url(route('show-photo')) }}" class="show-photo" data-photo-id="{{ encrypt($user->user_f->profile->avatar->id) }}">
                                                    <img src="{{ asset($user->user_f->profile->avatar->medium) }}" alt="user-avatar" width="100%" class="responsive-img">
                                                </a>
                                            @endif
                                            <a href="{{ url(route('accound',encrypt($user->user_f->id))) }}" class="center">
                                                <span class="col s8 right-align no-padding mmargin-tb">
                                                    <span class="title truncate">{{ $user->user_f->user_name }}</span>
                                                </span>
                                                <span class="col s4 left-align no-padding mmargin-tb">
                                                    <span>
                                                        &nbsp;{!! $user->user_f->sex == 'f' ? '<i class="icon-female pink-text"></i>' : '<i class="icon-male blue-text"></i>' !!} <span class="grey-text">·</span>
                                                    </span>
                                                    <i class="material-icons">cake</i>
                                                    <span>{{ $user->user_t->age }}</span>
                                                </span>
                                            </a>
                                        </div>
                                        <div class="card-action">
                                            @if(Checks::contact_request_sended($user->user_f->id))
                                                <button class="waves-effect red waves-light btn d-block tooltipped cancel-contact-button" data-user="{{encrypt($user->user_f->id)}}" data-position="top" data-tooltip="Cancel Request <i class='icon-remove red-text text-lighteen-1'></i>">
                                                    <span class="hide-on-small-only">Cancel</span> <i class="icon-remove"></i>
                                                </button>
                                            @elseif(Checks::contact_is_request($user->user_f->id))
                                                <button class="waves-effect blue waves-light btn d-block tooltipped acept-contact-button" data-user="{{encrypt($user->user_f->id)}}" data-position="top" data-tooltip="Acept Request <i class='icon-ok blue-text text-lighteen-1'></i>">
                                                    <span class="hide-on-small-only">Acept</span> <i class="icon-ok"></i>
                                                </button>
                                            @elseif(Checks::is_contact($user->user_f->id))
                                                <button class="waves-effect red waves-light btn d-block tooltipped delete-contact-button" data-user="{{encrypt($user->user_f->id)}}" data-position="top" data-tooltip="Delete Contact <i class='icon-minus red-text text-lighteen-1'></i>">
                                                    <span class="hide-on-small-only">Delete</span> <i class="icon-minus"></i>
                                                </button>
                                            @else
                                                <button class="waves-effect green waves-light btn d-block tooltipped add-contact-button" data-user="{{encrypt($user->user_f->id)}}" data-position="top" data-tooltip="Add Contact <i class='icon-plus green-text text-lighteen-1'></i>">
                                                    <span class="hide-on-small-only">Add</span> <i class="icon-plus"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
						@endforeach
                    @else
                        <h2 class="padding-lr center">Nothing to show</h2>
                        <div class="center padding-b">
                            <a href="{{ url(route('search')) }}"class="btn waves-effect waves-block blue">Find people</a>
                        </div>
					@endif
        		</div>
        	</div>
        </div>
	</div>
@endsection
@section('main-javascripts')
    @parent
    <script>
        $(function(){$('.add-contact-button').click(function(){
            var element = $(this);
            var user = element.data("user");
            $.ajax({
                url: '{{ url(route("addcontact")) }}',
                type: 'POST',
                data: { _token:$('#application-token').data('token'),_user:user},
                beforeSend: function(){
                    $('.spinner-icon-hidden').removeClass('hidden-block');
                },
                success: function(data){
                    $('.spinner-icon-hidden').addClass('hidden-block');
                    var decoded = JSON.parse(data);
                    if(decoded.status=='success'){
                        element.removeClass('add-contact-button').addClass('cancel-contact-button');
                        element.removeClass('green').addClass('red');
                        element.attr('data-tooltip',"Cancel <i class='icon-remove red-text lighteen-1'></i>").tooltip({delay: 50,html:true});
                        element.children('span').text('Cancel');
                        element.find('i').removeClass('icon-plus').addClass('icon-remove');
                        var $toastContent = $('<div class="green lighten-1">'+decoded.message+'</div>');
                        Materialize.toast($toastContent, 4000);
                    }else if(decoded.status=='error'){
                        var $toastContent = $('<div class="red lighten-1">'+decoded.message+'</div>');
                        Materialize.toast($toastContent, 4000);
                    }
                },
                error: function(){
                    $('.spinner-icon-hidden').addClass('hidden-block');
                }
            }).statusCode(statusCodes());
        });
            $('.cancel-contact-button').click(function(){
                var element = $(this);
                var user = element.data("user");
                $.ajax({
                    url: '{{ url(route("cancelcontact")) }}',
                    type: 'POST',
                    data: { _token:$('#application-token').data('token'),_user:user},
                    beforeSend: function(){
                        $('.spinner-icon-hidden').removeClass('hidden-block');
                    },
                    success: function(data){
                        $('.spinner-icon-hidden').addClass('hidden-block');
                        console.log(data);
                        /*var decoded = JSON.parse(data);
                         if(decoded.status=='success'){
                         element.removeClass('add-contact-button');
                         element.removeClass('green').addClass('red');
                         element.attr('data-tooltip',"Cancel <i class='icon-remove red-text lighteen-1'></i>").tooltip({delay: 50,html:true});
                         element.children('span').text('Cancel');
                         element.find('i').removeClass('icon-plus').addClass('icon-remove');
                         var $toastContent = $('<div class="green lighten-1">'+decoded.message+'</div>');
                         Materialize.toast($toastContent, 4000);
                         }else if(decoded.status=='error'){
                         var $toastContent = $('<div class="red lighten-1">'+decoded.message+'</div>');
                         Materialize.toast($toastContent, 4000);
                         }*/
                    },
                    error: function(){
                        $('.spinner-icon-hidden').addClass('hidden-block');
                    }
                }).statusCode(statusCodes());
            });
            $('.delete-contact-button').click(function(){
                var element = $(this);
                var user = element.data("user");
                mbox.confirm('Are you sure you want to delete?', function(yes) {
                    if (yes) {
                        //mbox.alert('Oh noes! You cannot do that right now!');
                        $.ajax({
                            url: '{{ route('deletecontact') }}',
                            type: 'POST',
                            data: { _token:$('#application-token').data('token'),_user:user},
                            beforeSend: function(){
                                $('.spinner-icon-hidden').removeClass('hidden-block');
                            },
                            success: function(data){
                                $('.spinner-icon-hidden').addClass('hidden-block');
                                var decoded = JSON.parse(data);
                                if(decoded.status=='success'){
                                    element.removeClass('add-contact-button');
                                    element.removeClass('green').addClass('red');
                                    element.attr('data-tooltip',"Cancel <i class='icon-remove red-text lighteen-1'></i>").tooltip({delay: 50,html:true});
                                    element.children('span').text('Cancel');
                                    element.find('i').removeClass('icon-plus').addClass('icon-remove');
                                    var $toastContent = $('<div class="green lighten-1"><i class="icon-ok-sign"></i> '+decoded.message+'</div>');
                                    Materialize.toast($toastContent, 4000);
                                }else if(decoded.status=='error'){
                                    var $toastContent = $('<div class="red lighten-1">'+decoded.message+'</div>');
                                    Materialize.toast($toastContent, 4000);
                                }
                            }
                        }).statusCode(statusCodes());
                    }
                });
            });
            $('.acept-contact-button').click(function (e) {
                e.preventDefault();
                var element = $(this);
                var user = element.data("user");
                $.ajax({
                    url: '{{ route('aceptcontact') }}',
                    type: 'POST',
                    data: {_token:$('#application-token').data('token'),_user:user},
                    beforeSend: function(){

                    },
                    success: function(data){
                        var response = JSON.parse(data);
                        if(response.status != 'unefined' && response.status == 'success'){
                            element.removeClass('acept-contact-button').addClass('delete-contact-button');
                            element.removeClass('blue').addClass('red');
                            element.attr('data-tooltip',"Delete <i class='icon-minus red-text lighteen-1'></i>").tooltip({delay: 50,html:true});
                            element.children('span').text('Delete');
                            element.find('i').removeClass('icon-ok').addClass('icon-minus');
                            var $toastContent = $('<div class="green lighten-1">'+response.message+'</div>');
                            Materialize.toast($toastContent, 4000);
                        }
                    }
                }).statusCode(statusCodes());
            });
            $('.add-like-user').click(function(){
                var element = $(this);
                var user = element.data("user");
                var user_name = $('title').text();
                $.ajax({
                    url: '{{ url(route("userlike")) }}',
                    type: 'POST',
                    data: {_token:$('#application-token').data('token'),_user:user},
                    beforeSend: function(){
                        $('.spinner-icon-hidden').removeClass('hidden-block');
                    },
                    success: function(data){
                        $('.spinner-icon-hidden').addClass('hidden-block');
                        var decoded = JSON.parse(data);
                        if(decoded.status=='success'){
                            element.addClass('disabled');
                            var $toastContent = $('<div class="green lighten-1">Now like you '+user_name+'</div>');
                            Materialize.toast($toastContent, 4000);
                        }else{
                            var $toastContent = $('<div class="red lighten-1">Now like you '+decoded.message+'</div>');
                            Materialize.toast($toastContent, 4000);
                        }
                    }
                }).statusCode(statusCodes());
            });
            $('.contacts-order').change(function(e){
                var element = $(this);
                var value = parseInt(element.val());
                var contacts = $('.contacts-content');
                contacts.children('div').show();
                switch(value){
                    case 1:
                        if(contacts.children('div').is(':hidden')) {
                            contacts.children('div').show();
                        }
                        break;
                    case 2:
                        contacts.children('.addeded').toggle();
                        break;
                    case 3:
                        contacts.children('.requested').toggle();
                        break;
                }
                e.preventDefault();
            });
        });
    </script>

    @include('javascripts.content-interactivity')
@endsection