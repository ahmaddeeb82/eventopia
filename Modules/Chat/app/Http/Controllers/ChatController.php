<?php

namespace Modules\Chat\Http\Controllers;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ChatController extends Controller
{
    private $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://localhost:3000']);
    }

    public function sendMessage(Request $request)
    {
        $response = $this->client->post('/send-message', [
            'json' => $request->all()
        ]);

        if ($response->getStatusCode() == 200) {
            return response()->json(['message' => 'Message sent successfully']);
        } else {
            return response()->json(['message' => 'Failed to send message'], $response->getStatusCode());
        }
    }

    public function joinRoom(Request $request)
    {
        $response = $this->client->post('/join-room', [
            'json' => $request->all()
        ]);

        if ($response->getStatusCode() == 200) {
            return response()->json(['message' => 'Joined room successfully']);
        } else {
            return response()->json(['message' => 'Failed to join room'], $response->getStatusCode());
        }
    }

    public function leaveRoom(Request $request)
    {
        $response = $this->client->post('/leave-room', [
            'json' => $request->all()
        ]);

        if ($response->getStatusCode() == 200) {
            return response()->json(['message' => 'Left room successfully']);
        } else {
            return response()->json(['message' => 'Failed to leave room'], $response->getStatusCode());
        }
    }


}
