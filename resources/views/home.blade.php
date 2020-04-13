@extends('layouts.panel')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">Bienvenido</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                Por favor selecciona una opción del menú lateral izquierdo
            </div>
        </div>
    </div>
    @if(auth()->user()->role == 'admin')
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-light ls-1 mb-1">Notificación General</h6>
                            <h2 class="mb-0">Enviar mensaje a todos los usuarios</h2>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('notification'))
                        <div class="alert alert-success" role="alert">
                            {{ session('notification') }}
                        </div>
                    @endif
                    <form action="{{ url('fcm/send') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="title">Título</label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ config('app.name') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="body">Mensaje</label>
                            <textarea name="body" id="body" id="" rows="2" class="form-control" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar notificación</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card shadow">
                <div class="card-header bg-transparent">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="text-uppercase text-muted ls-1 mb-1">Total de citas</h6>
                            <h5 class="h3 mb-0">Según día de la semana</h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Chart -->
                    <div class="chart">
                        <canvas id="chart-bars" class="chart-canvas"></canvas>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
