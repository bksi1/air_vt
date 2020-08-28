<div class="panel with-nav-tabs panel-default col-12">
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tabBg" role="tab">
                <div class="form-group">
                    <strong>Title:</strong>
                    {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <strong>Latitude:</strong>
                    {!! Form::text('latitude', null, array('placeholder' => 'Latitude','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <strong>Longitude:</strong>
                    {!! Form::text('longitude', null, array('placeholder' => 'Longitude','class' => 'form-control tinymce')) !!}
                </div>
                <div class="form-group">
                    <strong>Token:</strong>
                    {!! Form::text('token', null, array('placeholder' => 'Token','class' => 'form-control')) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="panel-footer">
        <div class="col-12 text-right">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </div><br class="clear" />
</div>
