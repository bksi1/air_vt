@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">


        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Редакция на sensor</h2>
            </div>

            <div class="pull-right">
                <br/>
                <a class="btn btn-primary" href="{{ route('sensor-index') }}">Обратно</a>
            </div>
        </div>
    </div>

    {!! Form::model($sensor, ['method' => 'post','route' => ['sensor-update', $sensor->id]]) !!}

    @include('sensor.form', ["sensor" => $sensor])

    {!! Form::close() !!}
    </div>
@endsection
