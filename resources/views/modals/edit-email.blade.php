
<div class="modal-content">
    <div class="chage-lang-modal center row">
        <p>
            <span>Edit your email</span>
        </p>
        {!! Form::open(['url'=>'#','class'=>'form-edit-email']) !!}
            <div class="input-field col s12">
                <input id="email" type="email" name="email" class="validate no-margin" @if(Auth::user()->email) value="{{ Auth::user()->email }}" @endif>
                <label for="email" @if(Auth::user()->email) class="active" @endif>Enter your email:</label>
                <div>
                    <small class="orange-text lighten-1">You'll have to validate this mail.</small>
                </div>
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