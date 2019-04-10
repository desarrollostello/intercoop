@extends('layouts.master')
@inject('request','Illuminate\Http\Request')
@section('content')
	<div class="container row">

		<div class="col l4 hide-on-med-and-down aside-left-menu no-padding padding-r">
			<div class="collection">
				<!-- Aside menu left -->
			@include('includes.aside-menu-left')
			<!-- End aside menu left -->
			</div>
		</div>
		<div class="col s12 l8 no-padding mmargin-t">
			<div class="col s12 white no-padding border-thin">
				<div class="col s12 no-padding">
					<div class="col s12 no-padding">
						<ul class="chat-tabs tabs">
							<li class="tab col s3">
								<a href="#received" class="blue-text text-lighten-1">Messages</a>
							</li>
							<li class="tab col s3" style="border-left: thin solid #29b6f6;text-transform: none;">
								<a href="#chat" class="tab-chat active" class="blue-text text-lighten-1">{{ Pheaks\User::find(decrypt($request->u_id))->user_name }}</a>
							</li>
						</ul>
					</div>
					<div id="received" class="col s12">
						<div class="collection">
							@if(isset($messages))
								@foreach($messages as $key => $message)
								<!-- Aside menu left -->
									<div class="collection-item">
										<a href="{{ route('messages-user', $message->last()->user_to == Auth::user()->id ? encrypt($message->last()->user_from) : encrypt($message->last()->user_to)) }}" class="show-user" data-userid="{{ $message->last()->user_to == Auth::user()->id ? encrypt($message->last()->user_from) : encrypt($message->last()->user_to) }}">
											<div class="d-inline-block v-align-middle valign-wrapper">
												<img src="{{ asset(Pheaks\User::find($message->last()->last_user)->profile->avatar->small) }}" class="valign responsive-img circle" alt="" width="40">
											</div>
											<div class="d-inline-block v-align-middle" style="width: 75%">
												<p class="value-notif truncate no-margin"><b>{{ $message->last()->user_name }}</b> <small class="">{{ $message->last()->message }}</small></p>
												<p class="no-margin"><span class="user-name">{{Pheaks\User::find($message->last()->last_user)->user_name}}</span><small class="grey-text right">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$message->last()->created_at)->diffForHumans() }}</small></p>
											</div>
										</a>
									</div>
									<!-- End aside menu left -->
								@endforeach
							@endif
						</div>
					</div>
					<div id="chat" class="col s12" style="display: none">
						@if($first_messages&&$first_messages!=null)
						<ul id="list-chat" class="list-chat" data-user="{{ $request->u_id }}" data-user-name="{{Pheaks\User::find(decrypt($request->u_id))->user_name}}">
							@foreach($first_messages as $key => $message)
								@if($message->user_from == Auth::user()->id)
									<li id="item-chat" class="item-chat right-align right-element" data-created="{{ strtotime($message->created) }}">
										<div class="item-chat-content mpadding @if(Auth::user()->sex=='f') pink @else blue @endif lighten-1 margin-r" style="display: inline-block;vertical-align: top;border-radius: 5px;border-bottom-right-radius: 0;">
											<span class="white-text">{{ $message->message }}</span>
											<small class="d-block grey-text text-lighten-1 create-at">{{ $message->created_at->diffForHumans() }}</small>
										</div>
										<div style="display: inline-block;vertical-align: middle">
											<img src="{{ asset( Auth::user()->profile->avatar->small ) }}" class="circle img-responsive" width="40" alt="">
										</div>
									</li>
								@else
									<li id="item-chat" class="item-chat left-align left-item" data-created="{{ strtotime($message->created) }}">
										<div class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="{{$message->from->user_name}}" style="display: inline-block;vertical-align: baseline">
											<img src="{{ asset( $message->from->profile->avatar->small ) }}" class="circle img-responsive" width="40" alt="">
											<span class="truncate" style="width: 3rem;">
												{{ $message->from->user_name }}
											</span>
										</div>
										<div class="item-chat-content mpadding grey lighten-1 margin-l" style="display: inline-block;vertical-align: top;border-radius: 5px;border-bottom-left-radius: 0;">
											<span class="white-text">{{ $message->message }}</span>
											<small class="d-block grey-text text-darken-1 create-at">{{ $message->created_at->diffForHumans() }}</small>
										</div>
									</li>
								@endif
							@endforeach
						</ul>
						@endif
						<div class="row">
							<div class="switch padding">
								<label class="right">
									<i class="icon-volume-off"></i>
									<input type="checkbox" id="chat-sound-control">
									<span class="lever"></span>
									<i class="icon-volume-up"></i>
								</label>
							</div>
						</div>

						<form action="">
							<div class="input-field col s9 l10 v-align-middle d-inline-block">
								<!--<a href="" class="prefix">
									<i class="material-icons ">photo</i>
								</a>-->
								<textarea id="textarea1" class="materialize-textarea no-padding" cols="1" rows="1"></textarea>
							</div>
							<div class="input-field col s3 l2 v-align-middle d-inline-block">
								<button class="btn btn-block blue lighten-1" style="max-width: 100%;">
									<i class="material-icons">send</i>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<audio id="chatAudio">
		<source src="{{ asset('sounds/pop-sound.ogg') }}" type="audio/ogg">
		<source src="{{ asset('sounds/pop-sound.mp3') }}" type="audio/mpeg">
		<source src="{{ asset('sounds/pop-sound.wav') }}" type="audio/wav">
	</audio>
	<style>
		#chat > ul.list-chat, #received > div{
			max-height: 60vh;
			overflow: hidden;
			overflow-y: scroll;
		}
		li.item-chat{
			margin-bottom: 7.5px;
		}
		li.item-chat > .item-chat-content{
			position: relative;
			max-width: 80%;
		}
		li.item-chat.right-align > .item-chat-content:after{
			right: -10px;
		}
		li.item-chat.right-align > .item-chat-content.blue:after{
			border-bottom-color: #42A5F5;
		}
		li.item-chat.right-align > .item-chat-content.pink:after{
			border-bottom-color: #ec407a;
		}
		li.item-chat.left-align > .item-chat-content:after{
			border-bottom-color: #bdbdbd;
			left: -10px;
		}
		li.item-chat > .item-chat-content:after{
			position: absolute;
			bottom: 0;
			width: 0;
			height: 0;
			content: '';
			border: 10px solid transparent;
		}
		.indicator{
			background-color: #29b6f6 !important;
		}
		.btn{
			padding: 0 1rem;
		}
	</style>
@endsection

@section('main-javascripts')
	@parent
	@include('javascripts.main-messages')
@endsection