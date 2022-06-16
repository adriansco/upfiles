@extends('layouts.app')
@section('title')
    Usuarios
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Usuarios</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Users Content</h3>

                            <div class="text-right p-2">
                                <a class="btn btn-primary" href="{{ route('users.create') }}"><i
                                        class="fas fa-plus"></i>
                                    Nuevo</a>
                            </div>
                            {{-- table table-bordered --}}
                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff">Nombre</th>
                                    <th style="color: #fff">E-mail</th>
                                    <th style="color: #fff">Usuario</th>
                                    <th style="color: #fff">Roll</th>
                                    <th class="text-center" style="color: #fff; width: 17%;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($users as $item)
                                        <tr>
                                            <td style="display: none;">{{ $item->id }}</td>
                                            <td style="">{{ $item->name }}</td>
                                            <td style="">{{ $item->email }}</td>
                                            <td style="">{{ $item->username }}</td>
                                            <td style="">
                                                @if (!empty($item->getRoleNames()))
                                                    @foreach ($item->getRoleNames() as $role)
                                                        <h5><span class="badge badge-dark">{{ $role }}</span></h5>
                                                    @endforeach
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-info" href="{{ route('users.edit', $item->id) }}"><i
                                                        class="fa fa-edit"></i> Editar</a>
                                                {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $item->id], 'style' => 'display:inline']) !!}
                                                {{-- {!! Form::submit('Eliminar', ['class' => 'btn btn-danger']) !!} --}}
                                                {{ Form::button('<i class="fa fa-trash-alt" aria-hidden="true"></i> Eliminar', ['class' => 'btn btn-danger', 'type' => 'submit']) }}
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $users->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
