<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::paginate(3);
        return view('client.index', compact('clients'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $client = new client();
        $isUpdate=false;
        return view('client.form', compact('client', 'isUpdate'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
       $formFields = $request->validated();
       if($request->hasFile(key:'photo')) {
        $formFields['photo'] = $request->file(key:'photo')->store(path:'client', options: 'public');
               }
        Client::create($formFields);
        return to_route(route:'clients.index')->with('success', 'client create successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        $isUpdate=true;
        return view('client.form', compact('client', 'isUpdate'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, Client $client)
    {
        $client->fill($request->validated())->save();
        return to_route(route:'clients.index')->with('success', 'client updated successfully');

        //dd($client);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
      $client->delete();
      return to_route(route:'clients.index')->with('success', 'client deleted successfully');

        //dd($client);
    }
}
