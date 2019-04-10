
<div class="modal-content">
    <div class="chage-lang-modal center row">
        <p>
            <span>Change password</span>
        </p>
        {!! Form::open(['url'=>'#','class'=>'form-change-password']) !!}
            <div class="input-field col s12 left-align">
                <input id="current_pass" type="password" name="current_pass" class="validate no-margin">
                <label for="current_pass">Enter your current password:</label>
            </div>
            <div class="input-field col m6 s12 left-align">
                <input id="password" type="password" name="password" class="validate no-margin">
                <label for="password">Enter your new password:</label>
            </div>
            <div class="input-field col m6 s12 left-align">
                <input id="password_confirmation" type="password" name="password_confirmation" class="validate no-margin">
                <label for="password_confirmation">Repeat your new password:</label>
            </div>
            <div class="input-filed col s12 m6 margin-t">
                <button class="btn waves-effect waves-light blue col s12" type="submit" name="action">Change</button>
            </div>
            <div class="input-filed col s12 m6 margin-t">
                <button type="button" class="modal-action modal-close waves-effect waves-blue btn-flat col s12">Cancel</button>
            </div>
        {!! Form::close() !!}
    </div>
</div>
<div class="modal-footer"></div>