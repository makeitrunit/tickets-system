@extends('layout')

@section('title', 'Página Principal')
@section('content')
    {{dd($purchase)}}
@endsection

<script>
    import Echo from "laravel-echo";

    window.Pusher = require('pusher-js');

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'your-pusher-key',
        cluster: 'your-cluster',
        forceTLS: true
    });

    window.Echo.channel('ticket-purchases')
        .listen('TicketPurchased', (event) => {
            console.log('Status:', event.status);
            if (event.status === 'success') {
                document.getElementById('status-message').innerText = 'Compra realizada con éxito!';
            } else {
                document.getElementById('status-message').innerText = 'Error: ' + event.message;
            }
        });

</script>
