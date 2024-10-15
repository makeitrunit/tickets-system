@extends('layout')

@section('title', 'Estado de compra')
@section('content')
    <main class="mt-8">
        <h2 class="text-center text-3xl font-bold mb-4">Estado de compra</h2>
        @if($purchase->status === 0)
            <p id="status-message">Esperando...</p>
        @else
            <div class="max-w-md mx-auto my-5 bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-800">Detalle de la Compra</h2>
                    <div class="mt-4">
                        <p class="text-gray-600">
                            <span class="font-bold">Estado de la compra:</span>
                            @if($purchase->status === 1)
                                <span id="purchase-status" class="text-green-600">Completada</span>
                            @else
                                <span id="purchase-status" class="text-red-500">Error</span>
                            @endif
                        </p>
                        <p class="text-gray-600 mt-2">
                            <span class="font-bold">Cantidad de asientos:</span>
                            <span id="seat-quantity">{{$purchase->qty}}</span>
                        </p>
                        <ul>

                        </ul>
                        <p class="text-gray-600 mt-2">
                            <span class="font-bold">ID de compra:</span>
                            <span id="purchase-id" class="text-gray-800">{{$purchase->id}}</span>
                        </p>
                        <p class="text-gray-600 mt-2">
                            <span class="font-bold">QR:</span>
                        </p>
                        <div class="mt-2">{!! $purchase->qr !!}</div>

                        <p class="text-gray-600 mt-6 print:hidden">
                            <a href="{{url('/')}}">
                                <button type="button"
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                    Volver
                                </button>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </main>
@endsection

@if($purchase->status === 0)
    <script>
        let statusInterval;

        const checkPurchaseStatus = async () => {
            try {
                const response = await fetch(`{{ route('api.purchase.status', ['purchaseId' => $purchase->id]) }}`);

                if (!response.ok) {
                    throw new Error('Error en la petición');
                }

                const data = await response.json();

                if (data.data.status === 0) {
                    document.getElementById('status-message').innerText = 'Estado: En proceso...';
                } else {
                    if (data.data.status === 1) {
                        document.getElementById('status-message').innerText = 'Compra completada con éxito!';
                    } else {
                        document.getElementById('status-message').innerText = 'Ha ocurrido un error intenta nuevamente!';
                    }
                    location.reload();
                    clearInterval(statusInterval);
                }
            } catch (error) {
                document.getElementById('status-message').innerText = 'Error: ' + error.message;
                clearInterval(statusInterval);
            }
        };

        setTimeout(() => {
            checkPurchaseStatus();

            statusInterval = setInterval(checkPurchaseStatus, 3000);
        }, 5000);
    </script>
@endif

