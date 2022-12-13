<!-- Modal -->
<div class="modal fade" id="modal-sheet-{{ $client->id }}" tabindex="-1" aria-labelledby="clientSheet" aria-hidden="true">
    <div class="modal-dialog">
        <div class="card mb-3 p-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="/img/gestifacil/clientes.png" class="img-fluid rounded-start">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $client->name }}</h5>
                        <p class="card-text"><strong>CIF:</strong> {{ $client->cif }}</p>
                        <p class="card-text"><strong>Dirección:</strong> {{ $client->address }}</p>
                        <p class="card-text"><strong>CP:</strong> {{ $client->zip }}</p>
                        <p class="card-text"><strong>Localidad:</strong> {{ $client->town }}</p>
                        <p class="card-text"><strong>Provincia:</strong> {{ $client->province }}</p>
                        <p class="card-text"><strong>Email:</strong> {{ $client->email }}</p>
                        <p class="card-text"><strong>Teléfono:</strong> {{ $client->phone }}</p>
                        <p class="card-text"><strong>Dueño/Responsable:</strong> {{ $client->owner }}</p>
                        <p class="card-text"><small class="text-muted">Ultima Actualización:
                                {{ date('d-m-Y', strtotime($client->updated_at)) }}</small></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary closebutton" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
