@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><span>{{ __('Sensor Types') }}</span><a class="btn btn-primary float-right" href="{{ route('sensor-type-create') }}" role="button">Добави</a></div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <table class="table table-bordered">
                            <tr>
                                <th>id</th>
                                <th>Title</th>
                                <th>Unit</th>
                                <th>Min</th>
                                <th>Max</th>
                                <th width="280px">Действие</th>

                            </tr>
                            @foreach ($sensorTypes as $sensorType)
                                <tr>
                                    <td>{{ $sensorType->id }}</td>
                                    <td>{{ $sensorType->title }}</td>
                                    <td>{!! $sensorType->unit !!}</td>
                                    <td>{{ $sensorType->min }}</td>
                                    <td>{{ $sensorType->max }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('sensor-type-edit',$sensorType->id) }}">Редактирай</a>
                                        {!! Form::open(['method' => 'DELETE','route' => ['sensor-type-destroy', $sensorType->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $sensorTypes->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
