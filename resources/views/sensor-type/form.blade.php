<div class="panel with-nav-tabs panel-default col-12">
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tabBg" role="tab">
                <div class="form-group">
                    <strong>Title:</strong>
                    {!! Form::text('title', null, array('placeholder' => 'Title','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <strong>Unit of measurment:</strong>
                    {!! Form::text('unit', null, array('placeholder' => 'Unit of measurment','class' => 'form-control')) !!}
                </div>
                <div class="form-group">
                    <strong>Min threshold:</strong>
                    {!! Form::text('min', null, array('placeholder' => 'Min threshold','class' => 'form-control tinymce')) !!}
                </div>
                <div class="form-group">
                    <strong>Max threshold:</strong>
                    {!! Form::text('max', null, array('placeholder' => 'Max threshold','class' => 'form-control')) !!}
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
