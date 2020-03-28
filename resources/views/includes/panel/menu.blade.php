<!-- Nav items -->
<!-- Heading -->
<h6 class="navbar-heading p-0 text-muted">
    <span class="docs-normal">
        @if(auth()->user()->role == 'admin')
            Gestionar Datos
        @else
            Menú
        @endif
    </span>
</h6>
<ul class="navbar-nav">
{{--    @if(auth()->user()->role == 'admin')--}}
{{--        @include('includes.panel.menu.admin')--}}
{{--    @elseif(auth()->user()->role == 'charts')--}}
{{--        @include('includes.panel.menu.charts')--}}
{{--    @else --}}{{-- patient --}}
{{--        @include('includes.panel.menu.patient')--}}
{{--    @endif--}}
    @include('includes.panel.menu.'.auth()->user()->role)
    <li class="nav-item">
        <a class="nav-link" href="" onclick="event.preventDefault(); document.getElementById('formLogout').submit();">
            <i class="ni ni-key-25"></i>
            <span class="nav-link-text">Cerrar Sesión</span>
        </a>
        <form action="{{ route('logout') }}" method="POST" style="display: none" id="formLogout">
            @csrf
        </form>
    </li>
</ul>
@if(auth()->user()->role == 'admin')
<!-- Divider -->
<hr class="my-3">
<!-- Heading -->
<h6 class="navbar-heading p-0 text-muted">
    <span class="docs-normal">Reportes</span>
</h6>
<!-- Navigation -->
<ul class="navbar-nav mb-md-3">
    <li class="nav-item">
        <a class="nav-link {{ Request::is('charts/appointments/line')? 'active': '' }}" href="{{ url('charts/appointments/line') }}" >
            <i class="ni ni-sound-wave text-yellow"></i>
            <span class="nav-link-text">Frecuencia de Citas</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::is('charts/doctors/column')? 'active': '' }}" href="{{ url('charts/doctors/column') }}" >
            <i class="ni ni-spaceship text-orange"></i>
            <span class="nav-link-text">Médicos más activos</span>
        </a>
    </li>
</ul>
@endif
