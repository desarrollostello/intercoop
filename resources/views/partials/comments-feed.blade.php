@foreach($comments as $key => $comment)
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