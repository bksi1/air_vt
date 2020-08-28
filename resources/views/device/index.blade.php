@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><span>{{ __('Devices') }}</span><a class="btn btn-primary float-right" href="{{ route('device-create') }}" role="button">Добави</a></div>

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
                                <th>Latitude</th>
                                <th>Longitude</th>
                                <th>Token</th>
                                <th width="280px">Действие</th>

                            </tr>
                            @foreach ($devices as $device)
                                <tr>
                                    <td>{{ $device->id }}</td>
                                    <td>{{ $device->title }}</td>
                                    <td>{{ $device->latitude }}</td>
                                    <td>{{ $device->longitude }}</td>
                                    <td>{{ $device->token }}</td>
                                    <td>
                                        <a class="btn btn-primary" href="{{ route('device-edit',$device->id) }}">Редактирай</a>
                                        {!! Form::open(['method' => 'DELETE','route' => ['device-destroy', $device->id],'style'=>'display:inline']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        {!! $devices->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
