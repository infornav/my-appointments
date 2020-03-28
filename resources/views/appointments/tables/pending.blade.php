<div class="table-responsive">
    <!-- Projects table -->
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
        <tr>
            <th scope="col">Descripción</th>
            <th scope="col">Especialidad</th>
            @if($role == 'patient')
                <th scope="col">Médico</th>
            @elseif($role == 'charts')
                <th scope="col">Paciente</th>
            @endif
            <th scope="col">Fecha</th>
            <th scope="col">Hora</th>
            <th scope="col">Tipo</th>
            <th scope="col">Opciones</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pendingAppointments as $appointment)
            <tr>
                <th scope="row">
                    {{  $appointment->description }}
                </th>
                <td>
                    {{  $appointment->specialty->name }}
                </td>
                @if($role == 'patient')
                    <td>
                        {{  $appointment->doctor->name }}
                    </td>
                @elseif($role == 'charts')
                    <td>
                        {{  $appointment->patient->name }}
                    </td>
                @endif
                <td>
                    {{  $appointment->scheduled_date }}
                </td>
                <td>
                    {{  $appointment->scheduled_time_12 }}
                </td>
                <td>
                    {{  $appointment->type }}
                </td>
                <td>
                    @if($role == 'admin')
                        <a class="btn btn-sm btn-primary" title="Ver cita"
                           href="{{ url('appointments/'.$appointment->id) }}" data-toggle="tooltip">
                            <i class="ni ni-zoom-split-in"></i>
                        </a>
                    @endif
                    @if($role == 'charts' || $role == 'admin')
                        <form action="{{ url('appointments/'.$appointment->id.'/confirm') }}" method="POST"
                              class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success" title="Confirmar Cita" data-toggle="tooltip" >
                                <i class="ni ni-check-bold"></i>
                            </button>
                        </form>
                        <a href="{{ url('appointments/'.$appointment->id.'/cancel') }}" class="btn btn-sm btn-danger">
                            <i class="ni ni-fat-delete"></i>
                        </a>
                    @else
                        <form action="{{ url('appointments/'.$appointment->id.'/cancel') }}" method="POST"
                              class="d-inline-block">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger" title="Cancelar Cita" data-toggle="tooltip" >
                                <i class="ni ni-fat-delete"></i>
                            </button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="card-body">
    {{ $pendingAppointments->links() }}
</div>
