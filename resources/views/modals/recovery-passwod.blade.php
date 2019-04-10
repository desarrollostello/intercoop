		
	<div class="modal-content">
		<div class="chage-lang-modal center row">
			<p>
				<span>Recobery your password</span>
			</p>
			{!! Form::open(['url'=>'/']) !!}
				<div class="input-field col s12">
                    <input id="email" type="email" class="validate">
                    <label for="email">Enter your email:</label>
                </div>
                <div class="input-filed col s12 m6">                        
                    <button class="btn waves-effect waves-light blue col s12" type="submit" name="action">Forgot</button>
                </div>
                <div class="input-filed col s12 m6">                	
                    <button type="button" class="modal-action modal-close waves-effect waves-blue btn-flat col s12">Cancel</button>
                </div>
			{!! Form::close() !!}
		</div>
	</div>
	<div class="modal-footer"></div>