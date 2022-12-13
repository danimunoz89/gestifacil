<!-- Modal -->
<div class="modal fade" id="modal-sheet-{{ $product->id }}" tabindex="-1" aria-labelledby="productSheet"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="card mb-3 p-2" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-10">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text"><strong>Fabricante:</strong> {{ $product->producer }}</p>
                        <p class="card-text"><strong>Descripción:</strong> {{ $product->description }}</p>
                        <p class="card-text"><strong>Formato:</strong> {{ $product->format }}</p>
                        <p class="card-text"><strong>Precio:</strong> {{ round(($product->unit_price) ,'2') }} € (sin IVA)</p>
                        @if ($product->stock == 0)
                            <p class="card-text"><strong>NO HAY STOCK DISPONIBLE EN ALMACEN</strong></p>
                        @else
                            <p class="card-text"><strong>HAY STOCK DISPONIBLE EN ALMACEN</strong></p>
                        @endif
                        <p class="card-text"><small class="text-muted">Ultima Actualización:
                                {{ date('d-m-Y', strtotime($product->updated_at)) }}</small></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary closebutton" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
