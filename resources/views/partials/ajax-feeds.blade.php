@if(isset($feeds)&&!empty($feeds))

    @foreach($feeds as $key => $feed)
        @switch($feed->type)
            @case(0)
                @if(\Pheaks\State::find($feed->object)->status!=1 || \Pheaks\State::find($feed->object)->privacy!=1)
                    @continue
                @endif
                <article class="my-timeline-block margin-t z-depth-1" data-article="{{ Hashids::encode($feed->feed_id) }}">
                    <div class="article-marker"></div>
                    <div class="card">
                        <div class="card-content">
                            <div class="article-user-image">
                                <a href="{{ $feed->user_id==Auth::user()->id ? url(route('profile')) : url(route('accound',encrypt($feed->user_id))) }}" class="valign-wrapper">
                                    @if(!File::exists($feed->small))
                                        <img src="{{ asset('img/default_avatar.png') }}" width="50" alt="image-not-found" class="responsive-img circle">&nbsp;
                                    @else
                                        <img src="{{ asset($feed->small) }}" alt="" width="50" class="responsive-img circle">&nbsp;&nbsp;&nbsp;
                                    @endif
                                    <span class="valign"> {{ $feed->user_name }}</span>
                                </a>
                                <a class='dropdown-button user-search-button-extra-options blue-grey lighten-5 d-inline-block v-align-middle hoverable border-thin' href='#' data-activates='feed-article-n_{{ $key }}'><i class="icon-angle-down"></i></a>
                            @if($feed->user_id==Auth::user()->id)
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_{{ $key }}' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Eliminar <i class="icon-remove red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                            @else
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_{{ $key }}' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Reportar \ Bloquear <i class="icon-flag red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <p class="mpadding-tb">@if($feed->user_id==Auth::user()->id) I updated my @else<b>{{$feed->user_name}}</b> updated your @endif state.</p>
                            <div class="no-padding left">
                                <p class="grey-text margin-b">{{ \Pheaks\State::find($feed->object)->state }}</p>
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="#" class="mpadding {{\Pheaks\Http\Libraries\Checks::is_liked('state',$feed->object) ? 'dislike-state-button blue-text' : 'like-state-button grey-text'}} text-lighten-1" data-state="{{ encrypt($feed->object) }}">
                                <i class="icon-heart"></i> <span class="like-count">{{ !empty(\Pheaks\State::find($feed->object)->likes) ? \Pheaks\State::find($feed->object)->likes()->where('status','1')->count() : '0' }}</span>
                            </a>
                            <a href="#" class="blue-text text-lighten-1 icon-comment-button" data-form="comment-form-{{$key}}">
                                <i class="icon-comment"></i> {{ \Pheaks\State::find($feed->object)->comments()->count() }}
                            </a>
                            <span class="cd-date right">
                                                <small><i class="icon-time"></i> {{ $feed->created_at->diffForHumans() }}</small>
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
                                <input type="hidden" name="content_elment" value="{{ encrypt($feed->object) }}">
                                {!! Form::close() !!}
                            </div>
                            @if(!empty(\Pheaks\State::find($feed->object)->comments))
                                <div class="col s12 commnets-{{$key}}" style="border-bottom: 1px solid #ececec;border-top: 1px solid #ececec;">
                                    @foreach(\Pheaks\State::find($feed->object)->comments()->orderBy('id','desc')->limit(3)->get() as $comment_key => $comment)
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
                                @if(\Pheaks\State::find($feed->object)->comments()->count()>3)
                                    <div class="col s12 no-padding center">
                                        <a href="#" class="padding block morefeedcomments" data-type="{{ Hashids::encode($feed->type) }}" data-object="{{ Hashids::encode($feed->object) }}" data-comments="commnets-{{$key}}">
                                            <span>Show more comments</span>
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div> <!-- cd-timeline-content -->
                </article> <!-- cd-timeline-block -->
                @breakswitch
            @case( 1 )
                @if(\Pheaks\Photo::find($feed->object)->status!=1 || \Pheaks\Photo::find($feed->object)->privacy!=1)
                    @continue
                @endif
                <article class="my-timeline-block margin-t z-depth-1" data-article="{{ Hashids::encode($feed->feed_id) }}">
                    <div class="article-marker"></div>
                    <div class="card">
                        <div class="card-content">
                            <div class="article-user-image">
                                <a href="{{ $feed->user_id==Auth::user()->id ? url(route('profile')) : url(route('accound',encrypt($feed->user_id))) }}" class="valign-wrapper">
                                    @if(!File::exists($feed->small))
                                        <img src="{{ asset('img/default_avatar.png') }}" width="50" alt="image-not-found" class="responsive-img circle">&nbsp;
                                    @else
                                        <img src="{{ asset($feed->small) }}" alt="" width="50" class="responsive-img circle">&nbsp;&nbsp;&nbsp;
                                    @endif
                                    <span class="valign"> {{ $feed->user_name }}</span>
                                </a>
                                <a class='dropdown-button user-search-button-extra-options blue-grey lighten-5 d-inline-block v-align-middle hoverable border-thin' href='#' data-activates='feed-article-n_{{ $key }}'><i class="icon-angle-down"></i></a>
                            @if($feed->user_id==Auth::user()->id)
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_{{ $key }}' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Eliminar <i class="icon-remove red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                            @else
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_{{ $key }}' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Reportar \ Bloquear <i class="icon-flag red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <p class="mpadding-tb">@if($feed->user_id==Auth::user()->id) {{ trans('home_page.update_my_avtar') }} @else {!! trans('home_page.update_your_avatar',['user_name'=>$feed->user_name]) !!} @endif {{ trans('home_page.complete_avatar_label') }}</p>
                            <div class="no-padding center">
                                @if(!File::exists(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->medium))
                                    <img src="{{ asset('img/photo_unavailable.jpg') }}" alt="image-not-found" class="responsive-img valign-wrapper">
                                @else
                                    <a href="{{ url(route('show-photo')) }}" class="show-photo" data-photo-id="{{ encrypt($feed->object) }}">
                                        <img src="{{ asset(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->medium ) }}" alt="avatar-large" class="responsive-img">
                                    </a>
                                @endif
                            </div>
                            <div class="card-action">
                                <a href="#" class="mpadding {{\Pheaks\Http\Libraries\Checks::is_liked('photo',$feed->object) ? ' dislike-photo-button blue-text' : ' like-photo-button grey-text'}} text-lighten-1" data-photo="{{ encrypt($feed->object) }}">
                                    <i class="icon-heart"></i> <span class="like-count">{{ !empty(\Pheaks\Photo::find($feed->object)->likes) ? \Pheaks\Photo::find($feed->object)->likes()->where('status','1')->count() : '0' }}</span>
                                </a>
                                <a href="#" class="blue-text text-lighten-1 icon-comment-button" data-form="comment-form-{{$key}}">
                                    <i class="icon-comment"></i> {{ \Pheaks\Photo::find($feed->object)->comments()->count() }}
                                </a>
                                <span class="cd-date right">
                                                    <small class="created_at" data-created="{{$feed->created_at}}"><i class="icon-time"></i> {{ $feed->created_at->diffForHumans() }}</small>
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
                                    <input type="hidden" name="content_elment" value="{{ encrypt($feed->object) }}">
                                    {!! Form::close() !!}
                                </div>
                                @if(!empty(\Pheaks\Photo::find($feed->object)->comments))
                                    <div class="col s12 commnets-{{$key}}" style="border-bottom: 1px solid #ececec;border-top: 1px solid #ececec;">
                                        @foreach(\Pheaks\Photo::find($feed->object)->comments()->orderBy('id','desc')->limit(3)->get() as $comment_key => $comment)
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
                                    @if(\Pheaks\Photo::find($feed->object)->comments()->count()>3)
                                        <div class="col s12 no-padding center">
                                            <a href="#" class="padding block morefeedcomments" data-type="{{ Hashids::encode($feed->type) }}" data-object="{{ Hashids::encode($feed->object) }}" data-comments="commnets-{{$key}}">
                                                <span>Show more comments</span>
                                            </a>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div> <!-- cd-timeline-content -->
                </article> <!-- cd-timeline-block -->
                @breakswitch
            @case(2)
                <article class="my-timeline-block margin-t z-depth-1" data-article="{{ Hashids::encode($feed->feed_id) }}">
                    <div class="article-marker"></div>
                    <div class="card">
                        <div class="card-content">
                            <div class="article-user-image">
                                <a href="{{ $feed->user_id==Auth::user()->id ? url(route('profile')) : url(route('accound',encrypt($feed->user_id))) }}" class="valign-wrapper">
                                    @if(!File::exists($feed->small))
                                        <img src="{{ asset('img/default_avatar.png') }}" width="50" alt="image-not-found" class="responsive-img circle">&nbsp;
                                    @else
                                        <img src="{{ asset($feed->small) }}" alt="" width="50" class="responsive-img circle">&nbsp;&nbsp;&nbsp;
                                    @endif
                                    <span class="valign"> {{ $feed->user_name }}</span>
                                </a>
                                <a class='dropdown-button user-search-button-extra-options blue-grey lighten-5 d-inline-block v-align-middle hoverable border-thin' href='#' data-activates='feed-article-n_{{ $key }}'><i class="icon-angle-down"></i></a>
                            @if($feed->user_id==Auth::user()->id)
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_{{ $key }}' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Eliminar <i class="icon-remove red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                            @else
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_{{ $key }}' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Reportar \ Bloquear <i class="icon-flag red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <p class="mpadding-tb">@if($feed->user_id==Auth::user()->id) {{ trans('home_page.update_my_avtar') }} @else {!! trans('home_page.update_your_avatar',['user_name'=>$feed->user_name]) !!} @endif {{ trans('home_page.complete_avatar_label') }}</p>
                            <div class="no-padding center">
                                @if(!File::exists(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->large))
                                    <img src="{{ asset('img/photo_unavailable.jpg') }}" alt="image-not-found" class="responsive-img valign-wrapper">
                                @else
                                    <a href="{{ url(route('show-photo')) }}" class="show-photo" data-photo-id="{{ encrypt($feed->object) }}">
                                        <img src="{{ asset(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->large ) }}" alt="avatar-large" class="responsive-img">
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="#" class="mpadding {{\Pheaks\Http\Libraries\Checks::is_liked('photo',$feed->object) ? ' dislike-photo-button blue-text' : ' like-photo-button grey-text'}} text-lighten-1" data-photo="{{ encrypt($feed->object) }}">
                                <i class="icon-heart"></i> <span class="like-count">{{ !empty(\Pheaks\Photo::find($feed->object)->likes) ? \Pheaks\Photo::find($feed->object)->likes()->where('status','1')->count() : '0' }}</span>
                            </a>
                            <a href="#" class="blue-text text-lighten-1 icon-comment-button" data-form="comment-form-{{$key}}">
                                <i class="icon-comment"></i> {{ \Pheaks\Photo::find($feed->object)->comments()->count() }}
                            </a>
                            <span class="cd-date right">
                                                    <small class="created_at" data-created="{{$feed->created_at}}"><i class="icon-time"></i> {{ $feed->created_at->diffForHumans() }}</small>
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
                                <input type="hidden" name="content_elment" value="{{ encrypt($feed->object) }}">
                                {!! Form::close() !!}
                            </div>
                            @if(!empty(\Pheaks\Photo::find($feed->object)->comments))
                                <div class="col s12 commnets-{{$key}}" style="border-bottom: 1px solid #ececec;border-top: 1px solid #ececec;">
                                    @foreach(\Pheaks\Photo::find($feed->object)->comments()->orderBy('id','desc')->limit(3)->get() as $comment_key => $comment)
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
                                @if(\Pheaks\Photo::find($feed->object)->comments()->count()>3)
                                    <div class="col s12 no-padding center">
                                        <a href="#" class="padding block morefeedcomments" data-type="{{ Hashids::encode($feed->type) }}" data-object="{{ Hashids::encode($feed->object) }}" data-comments="commnets-{{$key}}">
                                            <span>Show more comments</span>
                                        </a>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div> <!-- cd-timeline-content -->
                </article> <!-- cd-timeline-block -->
                @breakswitch
            @case(3)
                <article class="my-timeline-block margin-t z-depth-1" data-article="{{ Hashids::encode($feed->feed_id) }}">
                    <div class="article-marker"></div>
                    <div class="card">
                        <div class="card-content">
                            <div class="article-user-image">
                                <a href="{{ $feed->user_id==Auth::user()->id ? url(route('profile')) : url(route('accound',encrypt($feed->user_id))) }}" class="valign-wrapper">
                                    @if(!File::exists($feed->small))
                                        <img src="{{ asset('img/default_avatar.png') }}" width="50" alt="image-not-found" class="responsive-img circle">&nbsp;
                                    @else
                                        <img src="{{ asset($feed->small) }}" alt="" width="50" class="responsive-img circle">&nbsp;&nbsp;&nbsp;
                                    @endif
                                    <span class="valign"> {{ $feed->user_name }}</span>
                                </a>
                                <a class='dropdown-button user-search-button-extra-options blue-grey lighten-5 d-inline-block v-align-middle hoverable border-thin' href='#' data-activates='feed-article-n_{{ $key }}'><i class="icon-angle-down"></i></a>
                            @if($feed->user_id==Auth::user()->id)
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_{{ $key }}' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Eliminar <i class="icon-remove red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                            @else
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_{{ $key }}' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Reportar \ Bloquear <i class="icon-flag red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <p class="mpadding-tb">@if($feed->user_id==Auth::user()->id) I updated my @else<b>{{$feed->user_name}}</b> updated your @endif profile avatar.</p>
                            <div class="no-padding center">
                                @if(!File::exists(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->large))
                                    <img src="{{ asset('img/photo_unavailable.jpg') }}" alt="image-not-found" class="responsive-img valign-wrapper">
                                @else
                                    <a href="{{ url(route('show-photo')) }}" class="show-photo" data-photo-id="{{ encrypt($feed->object) }}">
                                        <img src="{{ asset(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->large ) }}" alt="avatar-large" class="responsive-img">
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="#" class="mpadding {{\Pheaks\Http\Libraries\Checks::is_liked('photo',$feed->object) ? ' dislike-photo-button blue-text' : ' like-photo-button grey-text'}} text-lighten-1" data-photo="{{ encrypt($feed->object) }}">
                                <i class="icon-heart"></i> <span class="like-count">{{ !empty(\Pheaks\Photo::find($feed->object)->likes) ? \Pheaks\Photo::find($feed->object)->likes()->where('status','1')->count() : '0' }}</span>
                            </a>
                            <a href="#" class="blue-text text-lighten-1 icon-comment-button" data-form="comment-form-{{$key}}">
                                <i class="icon-comment"></i> {{ \Pheaks\Photo::find($feed->object)->comments()->count() }}
                            </a>
                            <span class="cd-date right">
                                            <small><i class="icon-time"></i> {{ $feed->created_at->diffForHumans() }}</small>
                                        </span>
                            <div class="col s12" id="comment-form-{{$key}}" style="float: none;display: none;">
                                {!! Form::open(['route'=>'commentphoto','class'=>'comment-photo-form']) !!}
                                <div class="row">
                                    <div class="input-field col s12 no-padding">
                                        <textarea id="input-comment-{{$key}}" class="materialize-textarea no-padding" name="comment_photo_text"></textarea>
                                        <label for="input-comment-{{$key}}">Write comment...</label>
                                    </div>
                                    <div class="col s12">
                                        <button type="submit" class="btn btn-block waves-light blue full-width">
                                            <i class="material-icons">send</i>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="content_elment" value="{{ encrypt($feed->object) }}">
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div> <!-- cd-timeline-content -->
                </article> <!-- cd-timeline-block -->
                @breakswitch
            @case(4)
                <article class="my-timeline-block margin-t z-depth-1" data-article="{{ Hashids::encode($feed->feed_id) }}">
                    <div class="article-marker"></div>
                    <div class="card">
                        <div class="card-content">
                            <div class="article-user-image">
                                <a href="{{ $feed->user_id==Auth::user()->id ? url(route('profile')) : url(route('accound',encrypt($feed->user_id))) }}" class="valign-wrapper">
                                    @if(!File::exists($feed->small))
                                        <img src="{{ asset('img/default_avatar.png') }}" width="50" alt="image-not-found" class="responsive-img circle">&nbsp;
                                    @else
                                        <img src="{{ asset($feed->small) }}" alt="" width="50" class="responsive-img circle">&nbsp;&nbsp;&nbsp;
                                    @endif
                                    <span class="valign"> {{ $feed->user_name }}</span>
                                </a>
                                <a class='dropdown-button user-search-button-extra-options blue-grey lighten-5 d-inline-block v-align-middle hoverable border-thin' href='#' data-activates='feed-article-n_{{ $key }}'><i class="icon-angle-down"></i></a>
                            @if($feed->user_id==Auth::user()->id)
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_{{ $key }}' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Eliminar <i class="icon-remove red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                            @else
                                <!-- Dropdown Structure -->
                                    <ul id='feed-article-n_{{ $key }}' class='dropdown-content user-search-button-extra-options-list'>
                                        <li>
                                            <a href="#!" class="blue-text waves-effect">Reportar \ Bloquear <i class="icon-flag red-text lighten-1 right"></i></a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                            <p class="mpadding-tb">@if($feed->user_id==Auth::user()->id) I updated my @else<b>{{$feed->user_name}}</b> updated your @endif profile avatar.</p>
                            <div class="no-padding center">
                                @if(!File::exists(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->large))
                                    <img src="{{ asset('img/photo_unavailable.jpg') }}" alt="image-not-found" class="responsive-img valign-wrapper">
                                @else
                                    <a href="{{ url(route('show-photo')) }}" class="show-photo" data-photo-id="{{ encrypt($feed->object) }}">
                                        <img src="{{ asset(\Pheaks\Photo::select(['original','large','medium','small'])->where('id','=', $feed->object)->first()->large ) }}" alt="avatar-large" class="responsive-img">
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-action">
                            <a href="#" class="mpadding {{\Pheaks\Http\Libraries\Checks::is_liked('photo',$feed->object) ? ' dislike-photo-button blue-text' : ' like-photo-button grey-text'}} text-lighten-1" data-photo="{{ encrypt($feed->object) }}">
                                <i class="icon-heart"></i> <span class="like-count">{{ !empty(\Pheaks\Photo::find($feed->object)->likes) ? \Pheaks\Photo::find($feed->object)->likes()->where('status','1')->count() : '0' }}</span>
                            </a>
                            <a href="#" class="blue-text text-lighten-1 icon-comment-button" data-form="comment-form-{{$key}}">
                                <i class="icon-comment"></i> {{ \Pheaks\Photo::find($feed->object)->comments()->count() }}
                            </a>
                            <span class="cd-date right">
                                            <small><i class="icon-time"></i> {{ $feed->created_at->diffForHumans() }}</small>
                                        </span>
                            <div class="col s12" id="comment-form-{{$key}}" style="float: none;display: none;">
                                {!! Form::open(['route'=>'commentphoto','class'=>'comment-photo-form']) !!}
                                <div class="row">
                                    <div class="input-field col s12 no-padding">
                                        <textarea id="input-comment-{{$key}}" class="materialize-textarea no-padding" name="comment_photo_text"></textarea>
                                        <label for="input-comment-{{$key}}">Write comment...</label>
                                    </div>
                                    <div class="col s12">
                                        <button type="submit" class="btn btn-block waves-light blue full-width">
                                            <i class="material-icons">send</i>
                                        </button>
                                    </div>
                                </div>
                                <input type="hidden" name="content_elment" value="{{ encrypt($feed->object) }}">
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div> <!-- cd-timeline-content -->
                </article> <!-- cd-timeline-block -->
                @breakswitch
            @default
                @breakswitch
        @endswitch
    @endforeach

@endif