<!-- Modal -->
<div class="modal fade" id="modal-delete-{{ $salesorder->id }}" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{ route('pedido_eliminar', $salesorder->id) }}">
            <!--csrf es un token, que se renueva cada vez que iniciamos sesión con un usuario,
            y que evita la falsificación de peticiones externas al usuario para velar por la integridad de los datos
            que se envían entre cliente y servidor-->
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="deleteOrder">ELIMINAR PEDIDO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Deseas eliminar el pedido con ID {{ $salesorder->id }}?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closebutton" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-danger" value="Eliminar">
                </div>
            </div>
        </form>
    </div>
</div>
