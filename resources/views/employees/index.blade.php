@extends('layouts.app')
@section('title')
    Empleados
@endsection
@section('css')
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Empleados</h3>
            {{-- {{ auth()->user()->hasRole('Administrador') }} --}}
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @can('crear-empleado')
                                <div class="text-right pb-3">
                                    <a class="btn btn-primary" href="{{ route('employees.create') }}"><i
                                            class="fas fa-plus"></i>
                                        Nuevo</a>
                                </div>
                            @endcan
                            {{-- VALIDAR POR TIPO DE USUARIO Y MOSTRA ACCIONES DIFERENTES, CRAERA TABLA Y RUTA PARA CADA UNO
                            @can('update', $post)
                                <table id="employees" class="display table table-striped" style="width:100%">
                            @endcan --}}
                            {{-- ctrl table --}}
                            <input hidden value="{{ $status }}" name="ctrl_status" id="ctrl_status">

                            {{-- <label>Elija un sabor de nieve:
                                <select class="nieve" name="nieve">
                                    <option value="">Seleccione Uno …</option>
                                    <option value="chocolate">Chocolate</option>
                                    <option value="sardina">Sardina</option>
                                    <option value="vainilla">Vainilla</option>
                                </select>
                            </label> --}}

                            <div class="resultado"></div>

                            <table id="employees" class="display table table-striped" style="width:100%">
                                <thead style="background-color: #6777ef;">
                                    <tr>
                                        <th style="color: #fff"># Nómina</th>
                                        <th style="color: #fff">Nombre</th>
                                        <th style="color: #fff">Status</th>
                                        <th style="color: #fff">Creación</th>
                                        <th style="color: #fff">Última actualización</th>
                                        <th class="text-center" style="color: #fff">&nbsp;</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('web/js/tables-custom.js') }}"></script>
@endsection
