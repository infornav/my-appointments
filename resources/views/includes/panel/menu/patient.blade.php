<li class="nav-item">
    <a class="nav-link {{ Request::is('appointments/create')? 'active': '' }}" href="/appointments/create">
        <i class="ni ni-send text-danger"></i>
        <span class="nav-link-text">Reservar Cita</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('appointments')? 'active': '' }}" href="/appointments">
        <i class="ni ni-time-alarm text-primary"></i>
        <span class="nav-link-text">Mis Citas</span>
    </a>
</li>
