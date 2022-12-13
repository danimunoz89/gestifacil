<!-- Modal -->
<div class="modal fade" id="modal-sheet-{{ $salesorder->id }}" tabindex="-1" aria-labelledby="detailsSheet"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="card mb-3 p-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                    <img class="prodcatssheet" src="/img/gestifacil/pedidos.png">
                </div>
                <div class="col-md-8">
                    <div class="card-body">
                        <h5 class="card-title">{{ $salesorder->client }}</h5>
                        <p class="card-text"><strong>Fecha pedido:</strong> {{ $salesorder->order_date }}</p>
                        <p class="card-text"><strong>Nota pedido:</strong> {{ $salesorder->note }}</p>
                        <p class="card-text"><strong>Coste pedido:</strong> {{ round(($salesorder->total_price * 1.21) ,'2') }} € (IVA
                            incl.)
                        </p>

                        <h5 class="card-title text-decoration-underline">DETALLES PEDIDO</h5>
                    </div>
                </div>
                <div class="col-md-8">
                    @forelse ($details as $detail)
                        @if ($detail->id_order == $salesorder->id)
                            <div class="card-body">
                                <h5 class="card-title">{{ $detail->name_product }}</h5>
                                <p class="card-text"><strong>Precio:</strong> {{ round(($detail->unit_price) ,'2')}} €</p>
                                <p class="card-text"><strong>Cantidad:</strong> {{ $detail->quantity }} uds.</p>
                            </div>
                        @endif
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary closebutton" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
