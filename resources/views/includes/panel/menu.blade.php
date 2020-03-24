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
    @if(auth()->user()->role == 'admin')
        <li class="nav-item">
            <a class="nav-link {{ Request::is('home')? 'active': '' }}" href="/home">
                <i class="ni ni-tv-2 text-danger"></i>
                <span class="nav-link-text">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('specialties')? 'active': '' }}" href="/specialties">
                <i class="ni ni-planet text-blue"></i>
                <span class="nav-link-text">Especialidades</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('doctors')? 'active': '' }}" href="/doctors">
                <i class="ni ni-single-02 text-orange"></i>
                <span class="nav-link-text">Médicos</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('patients')? 'active': '' }}" href="/patients">
                <i class="ni ni-satisfied text-info"></i>
                <span class="nav-link-text">Pacientes</span>
            </a>
        </li>
    @elseif(auth()->user()->role == 'doctor')
        <li class="nav-item">
            <a class="nav-link {{ Request::is('schedule')? 'active': '' }}" href="/schedule">
                <i class="ni ni-calendar-grid-58 text-danger"></i>
                <span class="nav-link-text">Gestionar Horario</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('specialties')? 'active': '' }}" href="/specialties">
                <i class="ni ni-time-alarm text-primary"></i>
                <span class="nav-link-text">Mis Citas</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('patients')? 'active': '' }}" href="/patients">
                <i class="ni ni-satisfied text-info"></i>
                <span class="nav-link-text">Mis Pacientes</span>
            </a>
        </li>
    @else {{-- patient --}}
        <li class="nav-item">
            <a class="nav-link {{ Request::is('home')? 'active': '' }}" href="/home">
                <i class="ni ni-send text-danger"></i>
                <span class="nav-link-text">Reservar Cita</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('specialties')? 'active': '' }}" href="/specialties">
                <i class="ni ni-time-alarm text-primary"></i>
                <span class="nav-link-text">Mis Citas</span>
            </a>
        </li>
    @endif
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
        <a class="nav-link" href="#" target="_blank">
            <i class="ni ni-sound-wave text-yellow"></i>
            <span class="nav-link-text">Frecuencia de Citas</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" target="_blank">
            <i class="ni ni-spaceship text-orange"></i>
            <span class="nav-link-text">Médicos más activos</span>
        </a>
    </li>
</ul>
@endif
