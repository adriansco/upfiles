@extends('layouts.app')
@section('title')
    Alta rol
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Alta rol</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-dark alert-dimissible fade show" role="alert">
                                    <strong>¡Revisar lo siguiente!</strong>
                                    @foreach ($errors->all() as $error)
                                        <span class="badge badge-danger">{{ $error }}</span>
                                    @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span arial-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="name">Nombre</label>
                                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <label for="name">Permisos</label>
                                        @foreach ($permission as $item)
                                            <br>
                                            {!! Form::checkbox('permissions[]', $item->id, false, ['class' => 'name']) !!}
                                            {{ $item->name }}
                                        @endforeach
                                        {{-- {!! Form::text('name', null, ['class' => 'form-control']) !!} --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 text-right p-2">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i>
                                    Guardar</button>
                            </div>
                            {!! Form::close() !!}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
