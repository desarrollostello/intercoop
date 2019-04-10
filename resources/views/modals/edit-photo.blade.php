@if(isset($photo)&&!empty($photo))
    <div class="modal-content">
        <div class="chage-lang-modal center row">
            <p>
                <span>Edit photo</span>
            </p>
            {!! Form::open(['route'=>'savephoto','class'=>'form-edit-photo']) !!}
            <input type="hidden" name="photo" value="{{ \Vinkla\Hashids\Facades\Hashids::encode($photo->id) }}">
            <div class="input-field col s12">
                {!! Html::image($photo->medium, 'image', ['width'=>'50%']) !!}
            </div>
            <div class="col s12">
                <p>
                    <input type="checkbox" class="filled-in" name="is_avatar" id="define-avatar-box" @if($photo->is_avatar) disabled @endif/>
                    <label for="define-avatar-box">Define as avatar</label>
                </p>
                <p>
                    <span>
                        <input name="privacy" type="radio" id="public-privacy" value="1" class="with-gap" @if($photo->is_avatar) disabled checked="checked" @endif @if($photo->privacy=='1') checked="checked" @endif />
                        <label for="public-privacy">Public</label>
                    </span>
                    <span>
                        <input name="privacy" type="radio" id="justme-privacy" value="0" class="with-gap" @if($photo->is_avatar) disabled @endif @if($photo->privacy=='0') checked="checked" @endif/>
                        <label for="justme-privacy">just me.</label>
                    </span>
                </p>
            </div>
            <div class="input-filed col s12 m6 margin-t">
                <button class="btn waves-effect waves-light blue col s12" type="submit" name="action">Update</button>
            </div>
            <div class="input-filed col s12 m6 margin-t">
                <button type="button" class="modal-action modal-close waves-effect waves-blue btn-flat col s12">Cancel</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="modal-footer"></div>
@endif
