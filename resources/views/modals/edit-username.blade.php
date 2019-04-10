
<div class="modal-content">
    <div class="chage-lang-modal center row">
        <p>
            <span>Edit your email</span> <span class="spinner-icon-hidden hidden-block" style="vertical-align: middle;width: 10px;"><i class="icon-spinner icon-spin"></i></span>
        </p>
        {!! Form::open(['url'=>'#','class'=>'form-edit-username']) !!}
            <div class="input-field col s12 left-align">
                <input id="user_name" type="text" name="user_name" class="validate no-margin username" value="{{ Auth::user()->user_name }}">
                <label for="email" class="active">Enter your username:</label>
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