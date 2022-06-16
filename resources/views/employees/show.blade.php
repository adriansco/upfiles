@extends('layouts.app')

@section('title')
    Expediente
@endsection

@section('css')
    <link href="{{ asset('DataTables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <!-- Modal -->
    <form enctype="multipart/form-data" class="modal fade" id="exampleModal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Nuevo documento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- init control --}}
                    <input hidden value="{{ $employee->payroll }}" name="employee_payroll" id="employee_payroll">
                    {{-- Control permiso --}}
                    <input type="hidden" id="ctrl_permission" name="ctrl_permission"
                        value="{{ auth()->user()->can('borrar-documento') }}">
                    {{-- end control --}}
                    <div class="form-group">
                        <label for="title">Titulo</label>
                        <select class="form-control form-control-sm" id="title" name="title">
                            <option value="" selected>Por favor, seleccione</option>
                            <option value="Datos personales">Datos personales</option>
                            <option value="Contratos">Contratos</option>
                            <option value="Constancia de situación fiscal">Constancia de situación fiscal</option>
                            <option value="Cuenta bancaria">Cuenta bancaria</option>
                            <option value="Alta IMSS">Alta IMSS</option>
                            <option value="IMSS">IMSS</option>
                        </select>

                        <div class="invalid-feedback">Oh no! El nombre no es válido.</div>
                        <div class="valid-feedback">¡Ok!</div>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlFile1">Archivo</label>
                        <input type="file" class="form-control" id="inputfile" name="file">

                        <div class="invalid-feedback" id="div-error">Oh no! El archivo no es válido, verificar nombre y
                            extensión.</div>
                        <div class="valid-feedback">¡Ok!</div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- onclick="this.classList.toggle('button--loading')" --}}
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary button" id="btn-register"><span
                            class="button__text">Guardar</span></button>
                </div>
            </div>
        </div>
    </form>
    {{-- Content --}}
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Expediente empleado</h3>
        </div>
        {{-- https://www.youtube.com/watch?v=hPlpijpl9VU --}}
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="section-title">Datos del empleado:</h2>
                            <h6 class="mt-4">Nombre: <small class="text-muted">{{ $employee->name }}</small>
                            </h6>
                            <h6 class="mt-4"># Nómina: <small
                                    class="text-muted">{{ $employee->payroll }}</small>
                            </h6>
                            <h6 class="mt-4">Status: <small
                                    class="text-muted">{{ $employee->status }}</small>
                            </h6>

                            <h2 class="section-title">Expediente laboral individual del trabajador</h2>
                            @can('crear-documento')
                                <div class="text-right p-1">
                                    <button class="btn btn-space btn-primary mb-2" data-toggle="modal"
                                        data-target="#exampleModal"><i class="fas fa-plus"></i> Agregar documento</button>
                                </div>
                            @endcan
                            <table id="files" class="table table-striped" style="width: 100%">
                                <thead style="background-color: #6777ef;">
                                    <tr>
                                        <th style=" display: none;">ID
                                        </th>
                                        <th style="color: #fff; width:20%;">Path</th>
                                        <th style="color: #fff; width:20%;">Nómina</th>
                                        <th style="color: #fff; width:20%;">Documento</th>
                                        <th style="color: #fff; width:20%;">Creado</th>
                                        <th class="text-center" style="color: #fff; width:20%;">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
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
    <script src="{{ asset('web/js/file-ajax.js') }}"></script>
@endsection
