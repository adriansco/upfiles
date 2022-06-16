@extends('layouts.app')

@section('title')
    Dashboard
@endsection

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Dashboard</h3>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-xl-3">
                                    <div class="card bg-c-blue order-card">
                                        <div class="card-block">
                                            <h5>Usuarios</h5>
                                            @php
                                                use App\Models\User;
                                                $cant_usuarios = User::count();
                                            @endphp
                                            <h2 class="text-right"><i
                                                    class="fa fa-users f-left"></i><span>{{ $cant_usuarios }}</span></h2>
                                            <p class="m-b-0 text-right"><a href="{{ route('users.index') }}"
                                                    class="text-white">Ver
                                                    más <i class="fa fa-angle-right arrow-bb"></i></a></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xl-3">
                                    <div class="card bg-c-green order-card">
                                        <div class="card-block">
                                            <h5>Roles</h5>
                                            @php
                                                use Spatie\Permission\Models\Role;
                                                $cant_roles = Role::count();
                                            @endphp
                                            <h2 class="text-right"><i
                                                    class="fa fa-user-lock f-left"></i><span>{{ $cant_roles }}</span></h2>
                                            <p class="m-b-0 text-right"><a href="{{ route('roles.index') }}"
                                                    class="text-white">Ver más <i
                                                        class="fa fa-angle-right arrow-bb"></i></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xl-3">
                                    <div class="card bg-c-pink order-card">
                                        <div class="card-block">
                                            <h5>Empleados Activos</h5>
                                            @php
                                                use App\Models\Employee;
                                                $cant_empleados = Employee::where('status', 'A')->count();
                                            @endphp
                                            <h2 class="text-right"><i
                                                    class="fa fa-users f-left"></i><span>{{ $cant_empleados }}</span></h2>
                                            <p class="m-b-0 text-right"><a href="{{ route('employees.index') }}"
                                                    class="text-white">Ver más <i
                                                        class="fa fa-angle-right arrow-bb"></i></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 col-xl-3">
                                    <div class="card bg-c-pink order-card">
                                        <div class="card-block">
                                            <h5>Empleados Baja</h5>
                                            @php
                                                $cant_empleados_baja = Employee::where('status', 'B')->count();
                                            @endphp
                                            <h2 class="text-right"><i
                                                    class="fa fa-users f-left"></i><span>{{ $cant_empleados_baja }}</span>
                                            </h2>
                                            <p class="m-b-0 text-right"><a href="#{{-- {{ route('employees.index') }} --}}"
                                                    class="text-white">Ver más <i
                                                        class="fa fa-angle-right arrow-bb"></i></a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
