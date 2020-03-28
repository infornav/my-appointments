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
<li class="nav-item">
    <a class="nav-link {{ Request::is('appointments')? 'active': '' }}" href="/appointments">
        <i class="ni ni-time-alarm text-primary"></i>
        <span class="nav-link-text">Citas Médicas</span>
    </a>
</li>
