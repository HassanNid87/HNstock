<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\Sale;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;


class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'minsolde' => 'nullable|numeric',
            'maxsolde' => 'nullable|numeric|gte:minsolde',
            'code' => 'nullable|string',
            'name' => 'nullable|string',
            'adresse' => 'nullable|string',
        ]);

        // Initialisation de la requête de base
        $query = Client::query();

        // Filtrage par code, nom ou adresse
        if ($request->filled('code')) {
            $code = $request->input('code');
            $query->where(function ($query) use ($code) {
                $query->where('name', 'like', "%{$code}%")
                    ->orWhere('adresse', 'like', "%{$code}%")
                    ->orWhere('code', 'like', "%{$code}%");
            });
        }

        // Filtrage par solde minimum
        if ($request->filled('minsolde')) {
            $query->where('solde', '>=', $request->minsolde);
        }

        // Filtrage par solde maximum
        if ($request->filled('maxsolde')) {
            $query->where('solde', '<=', $request->maxsolde);
        }

        // Exécution de la requête avec pagination
        $clients = $query->paginate(10);

        return view('client.index', compact('clients'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $client = new client();
        $isUpdate = false;
        return view('client.form', compact('client', 'isUpdate'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ClientRequest $request)
    {
        $formFields = $request->validated();
        if ($request->hasFile(key: 'photo')) {
            $formFields['photo'] = $request->file(key: 'photo')->store(path: 'client', options: 'public');
        }
        Client::create($formFields);
        return to_route(route: 'clients.index')->with('success', 'client create successfully');

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
        $isUpdate = true;
        return view('client.form', compact('client', 'isUpdate'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClientRequest $request, Client $client)
    {
        // Mettre à jour les autres champs du client
        $client->fill($request->validated());

        // Vérifier si un fichier d'image a été téléchargé
        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne image si elle existe
            if ($client->photo) {
                Storage::disk('public')->delete($client->photo);
            }

            // Enregistrer la nouvelle image et mettre à jour le champ `photo`
            $client->photo = $request->file('photo')->store('clients', 'public');
        }

        // Sauvegarder les modifications
        $client->save();

        return to_route('clients.index')->with('success', 'Client updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();
        return to_route(route: 'clients.index')->with('success', 'client deleted successfully');

        //dd($client);
    }


    public function clientSales(Client $client): JsonResponse
    {
        abort_if(blank($client), Response::HTTP_NOT_FOUND);

        return response()->json([
            'client' => $client,
            'sales' => Sale::where('client_id', $client->id)->get()
        ]);
    }

}
