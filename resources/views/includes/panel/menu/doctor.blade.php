<li class="nav-item">
    <a class="nav-link {{ Request::is('schedule')? 'active': '' }}" href="/schedule">
        <i class="ni ni-calendar-grid-58 text-danger"></i>
        <span class="nav-link-text">Gestionar Horario</span>
    </a>
</li>
<li class="nav-item">
    <a class="nav-link {{ Request::is('appointments')? 'active': '' }}" href="/appointments">
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
