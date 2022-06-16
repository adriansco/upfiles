@extends('layouts.app')
@section('title')
    Roles
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Roles</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="text-center">Roles Content</h3>
                            @can('crear-rol')
                                <div class="text-right p-2">
                                    <a class="btn btn-primary" href="{{ route('roles.create') }}"><i
                                            class="fas fa-plus"></i>
                                        Nuevo</a>
                                </div>
                            @endcan

                            <table class="table table-striped mt-2">
                                <thead style="background-color: #6777ef;">
                                    <th style="display: none;">ID</th>
                                    <th style="color: #fff">Nombre</th>
                                    <th style="color: #fff">Creación</th>
                                    <th style="color: #fff">Última actualización</th>
                                    <th class="text-center" style="color: #fff; width: 17%;">Acciones</th>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $item)
                                        <tr>
                                            <td style="display: none;">{{ $item->id }}</td>
                                            <td style="">{{ $item->name }}</td>
                                            <td style="">{{ $item->created_at }}</td>
                                            <td style="">{{ $item->updated_at }}</td>
                                            <td class="text-center">
                                                @can('editar-rol')
                                                    <a class="btn btn-info" href="{{ route('roles.edit', $item->id) }}"><i
                                                            class="fa fa-edit"></i></a>
                                                @endcan
                                                @can('borrar-rol')
                                                    {!! Form::open(['method' => 'DELETE', 'route' => ['roles.destroy', $item->id], 'style' => 'display:inline']) !!}
                                                    {{ Form::button('<i class="fa fa-trash-alt" aria-hidden="true"></i>', ['class' => 'btn btn-danger', 'type' => 'submit']) }}
                                                @endcan
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination justify-content-end">
                                {!! $roles->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
