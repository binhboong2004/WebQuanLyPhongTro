<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Building;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::latest()->paginate(15);
        return view('admin.pages.quanlytoanha', compact('buildings'));
    }

    public function create()
    {
        return view('admin.pages.themtoanha');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
        ]);

        Building::create($data);
        return redirect()->route('buildings.index')->with('success', 'Tòa nhà đã được tạo.');
    }

    public function edit($id)
    {
        $building = Building::findOrFail($id);
        return view('admin.pages.chinhsuatoanha', compact('building'));
    }

    public function update(Request $request, $id)
    {
        $building = Building::findOrFail($id);
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
        ]);

        $building->update($data);
        return redirect()->route('buildings.index')->with('success', 'Cập nhật tòa nhà thành công.');
    }

    public function destroy($id)
    {
        $building = Building::findOrFail($id);
        $building->delete();
        return redirect()->route('buildings.index')->with('success', 'Tòa nhà đã được xóa.');
    }
}
