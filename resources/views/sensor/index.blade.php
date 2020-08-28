@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><span>{{ __('Sensors') }}</span><a class="btn btn-primary float-right" href="{{ route('sensor-create') }}" role="button">{{__('Add')}}</a></div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (! empty($sensors))
                            <table class="table table-bordered">
                                <tr>
                                    <th>id</th>
                                    <th>Device</th>
                                    <th>Sensor Type</th>
                                    <th width="280px">Действие</th>

                                </tr>

                                @foreach ($sensors as $sensor)
                                    <tr>
                                        <td>{{ $sensor->id }}</td>
                                        <td>{{ $sensor->device->title }}</td>
                                        <td>{{ $sensor->sensorType->title }}</td>
                                        <td>
                                            <a class="btn btn-primary" href="{{ route('device-edit',$sensor->id) }}">Редактирай</a>
                                            {!! Form::open(['method' => 'DELETE','route' => ['device-destroy', $sensor->id],'style'=>'display:inline']) !!}
                                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            {!! $sensors->links() !!}
                        @else
                            {{ __('No records found')  }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
