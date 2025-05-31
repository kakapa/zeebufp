<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppController extends Controller
{
    /**
     * Class constructor.
     */
    public function __construct()
    {
        //$this->middleware([]);
    }

    /**
     * Receive the order from WhatsApp
     */
    public function receiveOrder(Request $request): JsonResponse
    {
        Log::info(
            'Api Triggered successfully by '
                . $request->input('From')
                . ' saying '
                . $request->input('Body')
        );

        $user = User::find(1);
        $user->update([
            'about' => $request->input('Body')
        ]);

        $this->sendReply($request->input('From'), 'Thank you for placing your order!');

        return response()->json(['message' => 'ping']);
    }

    /**
     * Send whatsapp reply back to the customer
     *
     * @param string $to
     * @param string $message
     * @return void
     */
    private function sendReply(string $to, string $message): void
    {
        $twilioSid = config('services.twilio.sid');
        $twilioToken = config('services.twilio.token');
        $twilioNumber = config('services.twilio.whatsapp_number'); // Twilio Sandbox number

        Log::info("Attempting to send WhatsApp message to $to");

        try {
            $response = Http::asForm()
                ->withBasicAuth($twilioSid, $twilioToken)
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$twilioSid}/Messages.json", [
                    'From' => $twilioNumber,
                    //'To' => "whatsapp:$to",
                    'To' => $to,
                    'Body' => $message,
                ]);

            Log::info("Response:", $response->json());
        } catch (\Throwable $th) {
            //throw $th;
            Log::error('Twilio error:', ['error' => $th->getMessage()]);
        }
    }
}
