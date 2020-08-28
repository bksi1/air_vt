@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="row">

        <div class="col-lg-12 margin-tb">

            <div class="pull-left">

                <h2>Добавяне на device</h2>

            </div>

            <div class="pull-right">

                <br/>

                <a class="btn btn-primary" href="{{ route('sensor-type-index') }}">Обратно</a>

            </div>

        </div>

    </div>

    {!! Form::model( null, ['method' => 'post','route' => ['sensor-type-store']]) !!}

    @include('sensor-type.form', [])

    {!! Form::close() !!}
    </div>
@endsection
