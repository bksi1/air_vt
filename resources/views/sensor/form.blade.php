<div class="panel with-nav-tabs panel-default col-12">
    <div class="panel-body">
        <div class="tab-content">
            <div class="tab-pane active" id="tabBg" role="tab">
                <div class="form-group">
                    <strong>Device:</strong>
                    {!!Form::select('device_id', $devices, null, ['id' => 'device_id', 'class' => 'form-control select2'])!!}
                </div>
                <div class="form-group">
                    <strong>Sensor type:</strong>
                    {!!Form::select('sensor_type', $sensorTypes, null, ['id' => 'sensor_type', 'class' => 'form-control'])!!}
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
