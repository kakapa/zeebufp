<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Http\Requests\StoreClientRequest;
use App\Http\Resources\ClientResource;
use App\Notifications\ClientAdded;
use Illuminate\Support\Facades\Cache;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return inertia()->render('Clients/Index', [
            'clients' => ClientResource::collection(
                Cache::rememberForever('clients', function () {
                    return Client::all();
                })
            ),
            'client' => session('client') ?? null,
            'success' => session('success') ?? null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreClientRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreClientRequest $request)
    {
        $client = Client::create($request->validated());

        // Clear the cache to ensure the new client is available
        Cache::forget('clients');

        // Notify the user about the new client
        auth()->user()->notify(new ClientAdded($client, route('clients.show', $client)));

        return redirect()->route('dashboard')
            ->with('success', 'Client created successfully.')
            ->with('client', new ClientResource($client));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Client  $client
     * @return \Inertia\Response
     */
    public function show(Client $client)
    {
        return inertia()->render('Clients/Show', [
            'client' => new ClientResource($client),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\StoreClientRequest  $request
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreClientRequest $request, Client $client)
    {
        $client->update($request->validated());

        // Clear the cache to ensure the updated client is available
        Cache::forget('clients');

        return redirect()->route('dashboard')
            ->with('success', 'Client updated successfully.')
            ->with('client', new ClientResource($client));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Client  $client
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Client $client)
    {
        $client->delete();

        // Clear the cache to ensure the client is removed
        Cache::forget('clients');

        return redirect()->route('dashboard')
            ->with('success', 'Client deleted successfully.');
    }
}