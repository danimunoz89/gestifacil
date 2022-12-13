<!-- Modal -->
<div class="modal fade" id="modal-delete-{{ $category->id }}" tabindex="-1" aria-labelledby="deleteCategory"
    aria-hidden="true">
    <div class="modal-dialog">
        <form method="post" action="{{ route('categoria_eliminar', $category->id) }}">
            <!--csrf es un token, que se renueva cada vez que iniciamos sesión con un usuario,
            y que evita la falsificación de peticiones externas al usuario para velar por la integridad de los datos
            que se envían entre cliente y servidor-->            
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="deleteCategory">ELIMINAR CATEGORÍA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Deseas eliminar la categoría {{ $category->name }}?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary closebutton" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-danger" value="Eliminar">
                </div>
            </div>
        </form>
    </div>
</div>
