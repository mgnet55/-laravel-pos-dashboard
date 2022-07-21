<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Http\Requests\UpdateClientRequest;
use App\Models\Client;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $clients = Client::when($SearchText = request('search'), fn($query) => $query->filterByName($SearchText))
            ->latest()
            ->paginate();

        return view('dashboard.clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('dashboard.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreClientRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function store(StoreClientRequest $request)
    {
        $client = new Client($request->validated());
        $client->saveOrFail();
        session()->flash('success', __('messages.added_successfully'));

        return redirect(status: 200)->route('dashboard.clients.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Client $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Client $client
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Client $client)
    {
        return view('dashboard.clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateClientRequest $request
     * @param Client $client
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function update(UpdateClientRequest $request, Client $client)
    {
        $client->updateOrFail($request->validated());
        if ($client->wasChanged()) {
            session()->flash('success', __('messages.updated_successfully'));
        }

        return redirect()->route('dashboard.clients.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $client
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function destroy(Client $client)
    {
        $client->deleteOrFail();
        session()->flash('success', __('messages.deleted_successfully'));

        return redirect(status: 200)->route('dashboard.clients.index');
    }
}
