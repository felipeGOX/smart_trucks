<?php

namespace App\Listeners;

use App\Events\SendNotifications;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PushNotificationslistener
{
    public function handle(SendNotifications $event)
    {
        $clientes = User::select("name")->where("id_barrio", $event->id_barrio)->get();


        $message = "Hey! " . $nombreCliente["name"] . " apareces en está foto";
        $data = [
            'title' => 'Photomemories',
            'body' => $message,
            'send' => [
                'nombreEvento' => $nombreEvento['descripcion'],
                'foto' => $event->foto
            ]
        ];
        $getTokenCliente = RegistrarToken::select("expo_token")->where("cliente_id", $event->clienteId)->first();


        if ($getTokenCliente !== null) {
            $expoPushToken = $getTokenCliente["expo_token"];
            $this->createExpoMessage($message, $data, $expoPushToken);
        } else {
            return;
        }
    }


    function createExpoMessage($message, $data, $expoPushToken)
    {
        $client = new Client();
        $response = $client->post('https://exp.host/--/api/v2/push/send', [
            'headers' => [
                'Accept' => 'application/json',
                'Accept-Encoding' => 'gzip, deflate',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'to' => $expoPushToken,
                'sound' => 'default',
                'title' => $data['title'],
                'body' => $data['body'],
                'data' => $data['send'],
            ],
        ]);

        return $response->getBody();
    }
}
