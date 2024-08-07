<?php
// app/Http/Controllers/CompanyInfoController.php
namespace App\Http\Controllers;

use App\Models\CompanyInfo;
use Illuminate\Http\Request;

class CompanyInfoController extends Controller
{
    public function create() {
        return view('company_infos.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'fax' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'patente' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        CompanyInfo::create($data);

        return redirect()->route('company_infos.show')->with('success', 'Informations de la société créées avec succès.');
    }

    public function show() {
        $companyInfo = CompanyInfo::firstOrFail();
        return view('company_infos.show', compact('companyInfo'));
    }

    public function edit($id) {
        $companyInfo = CompanyInfo::findOrFail($id);
        return view('company_infos.edit', compact('companyInfo'));
    }

    public function update(Request $request, $id) {
        $companyInfo = CompanyInfo::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
            'fax' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'patente' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $companyInfo->update($data);

        return redirect()->route('company_infos.show')->with('success', 'Informations de la société mises à jour avec succès.');
    }
}
