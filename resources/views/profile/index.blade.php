@extends('layouts.master')


@section('content')
	<div class="container row">
        <div id="mdal-for-change-avatar" class="modal">
            <div class="modal-content">
                <h4>Select area to crop</h4>

                <div id="change-avatar-plugin" style="width: 250px;height: 250px;margin: 0 auto;"></div>
            </div>
            <div class="modal-footer">
                <!--<a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">Agree</a>-->
            </div>
        </div>
        <div class="col l4 hide-on-med-and-down aside-left-menu no-padding padding-r">
            <div class="collection white">
                <!-- Aside menu left -->
                @include('includes.aside-menu-left')
                <!-- End aside menu left -->
            </div>
        </div>
        <div class="col s12 l8 no-padding mmargin-t">

			@if(Auth::user()->status == '0')
				<div class="col s12 red border-thin mpadding mmargin-b">
					{!! Form::open(['route'=>'sendemailactivation','class'=>'no-margin']) !!}
						<span class="white-text">Your accound is inactive!</span>
						<button class="btn btn-flat lighten-1">
							<span class="white-text">Send email activation</span>
						</button>
					{!! Form::close() !!}
				</div>
				@if(!Auth::user()->email)
					<div class="col s12 red border-thin mmargin-b">
						<p class="white-text">Add your email for validate your account.</p>
					</div>
				@endif
			@endif
        	<div class="col s12 white border-thin">
	        	<div class="col s12 l4">
		        	<div class="center">
		        		<div class="col s12 l12 m4 offset-m4">
			        		<img src="{{ asset(Auth::user()->profile->avatar->medium) }}" width="100%" class="circle z-depth-1 mmargin-tb profile-avatar-large">
			        	</div>
			        	<div>
			        		<button class="waves-effect blue waves-light btn d-block edit-profile-avatar" id="edit-profile-avatar">Change <i class="icon-camera"></i></button>
			        	</div>	
		        	</div>
		        </div>
		        <div class="col s12 l8">
					<div class="collection with-header">
		        		<div class="collection-header">
		        			<h5 class="truncate">Personal info</h5>		        			
		    			</div>
		        		<div class="collection-item">Username: {{ Auth::user()->user_name }}</div>
		        		<div class="collection-item">Fisrt name: {{ Auth::user()->first_name }}</div>
		        		<div class="collection-item">Last name: {{ Auth::user()->last_name }}</div>
		        		<div class="collection-item">Email: {{ Auth::user()->email }}</div>
		        		<div class="collection-item">Age: {{ Auth::user()->birthday ? Auth::user()->age : "Not defined" }}</div>
	        			<a href="{{ url(route('profile-edit')) }}?personal" class="collection-item">Edit <i class="icon-edit"></i></a>
		      		</div>
				</div>
			</div>
	        <div class="col s12 white mmargin-t border-thin">
	        	<h4>Photos</h4>
	        	<div class="slider">
				    <div class="viewer show-photos-space">
				    	@if(isset($user_images))
							@foreach($user_images as $key => $image)
								<div id="profile-image-{{$key}}" class="col s12 m4 l3 viewer-image center mmargin-t animated" data-original="{{ $image->original }}">
									<div class="profile-image-square" style="overflow:hidden;border-radius: 2.5px 2.5px 0 0;">
										@if(\File::exists($image->medium))
											<a href="{{ url(route('show-photo')) }}" class="show-photo" data-photo-id="{{ encrypt($image->id) }}">
												<!--<img src="{{$image->small}}" class="z-depth-1 responsive-img" alt="" />-->
												<div class="backgroun-avatar-user-image" style="background-image: url('{{$image->medium}}');background-size:cover;background-repeat:no-repeat;background-position:center center;width: 100%;height: 7rem;"></div>
											</a>
										@else
											<a data-photo-id="{{ encrypt($image->id) }}">
												<img src="{{ asset('img/photo_unavailable.jpg') }}" alt="image-not-found" class="z-depth-1 responsive-img">
											</a>
										@endif
									</div>
									<a href="{{ route('editphoto') }}" class="blue mpadding left button-edit-profile-button" data-photo="{{ \Hashids::encode($image->id) }}" style="border-radius: 0 0 0 2.5px;width: 50%">
										<i class="icon-pencil white-text"></i>
									</a>
									<a href="{{ route('deletephoto') }}" class="red mpadding button-delete-profile-photo right" data-photo="{{ \Hashids::encode($image->id) }}" style="border-radius: 0 0 2.5px 0;width: 50%">
										<i class="icon-remove white-text"></i>
									</a>
								</div>
							@endforeach
						@else
							<h3 class="center">Nothing to show</h3>
						@endif
					  {{-- Sisez image = epic | bigger | normal | mini --}}
					</div>
					<div class="button-add-photos col s12 no-padding">
						<div class="col s12 margin-tb">
							<button class="waves-effect btn blue col s12 add-photos">
								<span>Add photos</span> <i class="icon-plus-sign"></i>
							</button>
						</div>
						<!--<div class="col s12 m6 margin-tb">
							<button class="waves-effect btn blue col s12">
								<span>Edit photos</span> <i class="icon-edit"></i>
							</button>
						</div>-->
					</div>
			  	</div>
	        </div>

	        <div class="col s12 white mmargin-t border-thin">	        	
	        	<div class="collection with-header">
	        		<div class="collection-header">
	        			<h5 class="truncate">Basic info</h5>	        			
	    			</div>
	        		<div class="collection-item">
						Signo: {{ Auth::user()->profile->zodiac_sign ? Auth::user()->profile->zodiac_sign : 'Not defined' }}
					</div>
	        		<div class="collection-item">
						Estatura: {{ Auth::user()->profile->height ? Auth::user()->profile->height : 'Not defined' }}
					</div>
	        		<div class="collection-item">
						Sexo: {{ Auth::user()->sex == "f" ? "Female" : "Male" }}
					</div>
	        		<div class="collection-item">
						Complexion: {{ Auth::user()->profile->complexion ? Auth::user()->profile->complexion : 'Not defined' }}
					</div>
	        		<div class="collection-item">
						Estado civil: {{ Auth::user()->profile->civil_status ? Auth::user()->profile->civil_status : 'Not defined' }}
					</div>
	        		<div class="collection-item">
						Hijos: {{ Auth::user()->profile->children ? Auth::user()->profile->children : 'Not defined' }}
					</div>
					<div class="collection-item">
						Language: {{ Auth::user()->language ? Auth::user()->profile->children : 'en' }}
					</div>
	        		<div class="collection-item">
						Educacion: {{ Auth::user()->profile->education ? Auth::user()->profile->education : 'Not defined' }}
					</div>
	        		<div class="collection-item">
						Fuma: {{ Auth::user()->profile->smoking ? Auth::user()->profile->smoking : 'Not defined' }}
					</div>

					<div class="collection-header">
						<h5 class="truncate" style="font-size: 1.5rem;">Location</h5>
					</div>
					<div class="collection-item">Country: {{ Auth::user()->profile->country ? Auth::user()->profile->country : "Not definded" }}</div>
					<div class="collection-item">State: {{ Auth::user()->profile->region ? Auth::user()->profile->region : "Not defined" }}</div>
					<div class="collection-item">City: {{ Auth::user()->profile->citie ? Auth::user()->profile->citie : "Not defined" }}</div>

        			<a href="{{ url(route('profile-edit')) }}?basic" class="collection-item">Edit <i class="icon-edit"></i></a>
	        	</div>
	        </div>
			<div class="col s12 white mmargin-t border-thin">
				<div class="content-header">
					<h4>States</h4>
				</div>
				@foreach(\Pheaks\State::whereIn('status',[0,1,2])->where('user_id', Auth::user()->id)->get()->reverse() as $key => $state)
					<article class="my-timeline-block margin-t z-depth-1" data-article="{{ Hashids::encode($state->id) }}">
						<div class="article-marker"></div>
						<div class="card">
							<div class="card-content">
								<div class="article-user-image">
									<span class="valign-wrapper">
										@if(!File::exists($state->user()->first()->profile->avatar->small))
											<img src="{{ asset('img/default_avatar.png') }}" width="50" alt="image-not-found" class="responsive-img circle">&nbsp;
										@else
											<img src="{{ asset($state->user()->first()->profile->avatar->small) }}" alt="" width="50" class="responsive-img circle">&nbsp;&nbsp;&nbsp;
										@endif
										<span class="valign"> {{ $state->user()->first()->user_name }}</span>
									</span>
									<a class='dropdown-button user-search-button-extra-options blue-grey lighten-5 d-inline-block v-align-middle hoverable border-thin' href='#' data-activates='feed-article-n_{{ $key }}'><i class="icon-angle-down"></i></a>

									<!-- Dropdown Structure -->
									<ul id='feed-article-n_{{ $key }}' class='dropdown-content user-search-button-extra-options-list'>
										<li>
											<a href="#!" class="blue-text waves-effect">Eliminar <i class="icon-remove red-text lighten-1 right"></i></a>
										</li>
									</ul>
								</div>
								<p class="mpadding-tb">I updated my state.</p>
								<div class="no-padding left">
									<p class="grey-text margin-b">{{ $state->state }}</p>
								</div>
							</div>
							<div class="card-action">
								<a href="#" class="mpadding {{\Pheaks\Http\Libraries\Checks::is_liked('state',$state->id) ? 'dislike-state-button blue-text' : 'like-state-button grey-text'}} text-lighten-1" data-state="{{ encrypt($state->id) }}">
									<i class="icon-heart"></i> <span class="like-count">{{ !empty(\Pheaks\State::find($state->id)->likes) ? \Pheaks\State::find($state->id)->likes()->where('status','1')->count() : '0' }}</span>
								</a>
								<a href="#" class="blue-text text-lighten-1 icon-comment-button" data-form="comment-form-{{$key}}">
									<i class="icon-comment"></i> {{ \Pheaks\State::find($state->id)->comments()->count() }}
								</a>
								<span class="cd-date right">
									<small><i class="icon-time"></i> {{ $state->created_at->diffForHumans() }}</small>
								</span>
							</div>
							<div class="row no-margin">
								<div class="col s12" id="comment-form-{{$key}}" style="display: none;">
									{!! Form::open(['route'=>'commentphoto','class'=>'comment-photo-form']) !!}
									<div class="input-field col s12 no-padding">
										<textarea id="input-comment-{{$key}}" class="materialize-textarea no-padding" name="comment_photo_text"></textarea>
										<label for="input-comment-{{$key}}">Write comment...</label>
									</div>
									<div class="col s12">
										<button type="submit" class="btn btn-block waves-light blue full-width">
											<i class="material-icons">send</i>
										</button>
									</div>
									<input type="hidden" name="content_elment" value="{{ encrypt($state->id) }}">
									{!! Form::close() !!}
								</div>
								@if(!empty(\Pheaks\State::find($state->id)->comments))
									<div class="col s12 commnets-{{$key}}" style="border-bottom: 1px solid #ececec;border-top: 1px solid #ececec;">
										@foreach(\Pheaks\State::find($state->id)->comments()->orderBy('id','desc')->limit(3)->get() as $comment_key => $comment)
											<div class="col s12 no-padding mpadding-tb comment-last" data-last="{{ Hashids::encode($comment->id) }}">
												<div>
													<div class="row valign-wrapper no-margin">
														<div class="col s1 no-padding" style="line-height:.5rem;">
															<a href="{{ route('accound', encrypt($comment->user->id)) }}">
																<img src="{{ asset($comment->user->profile->avatar->small) }}" width="35" alt="avatar" class="circle profile-image" />&nbsp;
															</a>
														</div>
														<div class="col s11 no-padding mpadding-l">
															<a href="{{ route('accound', encrypt($comment->user->id)) }}">
																<span class="truncate blue-text text-lighten-1">{{ $comment->user->user_name }}</span>
															</a>
															<small class="grey-text d-block"><i class="icon-time"></i> {{ $comment->created_at->diffForHumans() }}</small>
														</div>
													</div>
													<p class="no-margin mmargin-b">
														{{ $comment->comment }}
														{{--
                                                        @if($comment->file_id != null)
                                                            <p class="no-margin">
                                                                <img src="{{ Pheaks\Photo::find($comment->file_id )->small }}" alt="">
                                                            </p>
                                                        @endif
                                                        --}}
													</p>
												</div>
											</div>
										@endforeach
									</div>
									@if(\Pheaks\State::find($state->id)->comments()->count()>3)
										<div class="col s12 no-padding center">
											<a href="#" class="padding block morefeedcomments" data-type="{{ Hashids::encode($state->type) }}" data-object="{{ Hashids::encode($state->id) }}" data-comments="commnets-{{$key}}">
												<span>Show more comments</span>
											</a>
										</div>
									@endif
								@endif
							</div>
						</div> <!-- cd-timeline-content -->
					</article> <!-- cd-timeline-block -->
				@endforeach
			</div>
        </div>
	</div>
@endsection

@section('main-javascripts')
	@parent
    <script src="{{ asset('js/croppic.min.js') }}"></script>
	<script>
		$(function(){
		    var croppicOptions = {
                customUploadButtonId:'edit-profile-avatar',
                uploadUrl: '{{ url(route('upload-avatar')) }}',
                cropUrl: '{{ url(route('crop-avatar')) }}',
                uploadData:{
                    "_token": $('#application-token').data('token'),
                },
                cropData:{
                    "_token": $('#application-token').data('token'),
                },
                onBeforeImgUpload: 	function(){
                    $('.spinner-icon-hidden').removeClass('hidden-block');
                },
                onAfterImgUpload: 	function(data){
                    $('.spinner-icon-hidden').addClass('hidden-block');
                    $('#mdal-for-change-avatar').openModal();
                },
                onImgDrag:		function(){ console.log('onImgDrag') },
                onImgZoom:		function(){ console.log('onImgZoom') },
                onBeforeImgCrop: 	function(){ console.log('onBeforeImgCrop') },
                onAfterImgCrop:		function(data){
                    $('.profile-avatar-large').attr('src',data.url);
                    $('.profile-avatar-small').attr('src',data.small);
					$('.show-photos-space').append('<div></div>');
                    $('#mdal-for-change-avatar').closeModal();
                    crop_reset();
                    console.log(data);
                },
                onReset:		function(){
					$('.spinner-icon-hidden').addClass('hidden-block');
				},
                onError:		function(errormsg){
                    var $toas_message = "<div class='red lighten-1'>"+errormsg+"</div>";
                    Materialize.toast($toas_message, 4000);
                },
                imgEyecandy:false,
				rotateControls:false
            };

            var cropperHeader = new Croppic('change-avatar-plugin', croppicOptions);
            var crop_reset = function () {
                cropperHeader.reset();
            }
		});
	</script>
	@include('javascripts.content-interactivity')
@endsection