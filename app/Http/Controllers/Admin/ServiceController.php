<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Service;
use App\Models\Building;
use App\Models\Room;

class ServiceController extends Controller
{

    public function indexBuilding()
    {
        $services = Service::whereNotNull('building_id')
            ->with('building')
            ->select('services.*')
            ->join('buildings', 'services.building_id', '=', 'buildings.id')
            ->orderBy('buildings.name')
            ->orderBy('services.name')
            ->paginate(20);
        $buildings = Building::orderBy('name')->get();
        return view('admin.pages.dichvutheotoa', compact('services', 'buildings'));
    }

    public function createBuilding()
    {
        $buildings = Building::orderBy('name')->get();
        return view('admin.pages.themdichvutheotoa', compact('buildings'));
    }

    public function storeBuilding(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'name')
                    ->where('building_id', $request->building_id)
                    ->whereNull('room_id')
            ],
            'unit' => 'nullable|string|max:50',
            'price_per_unit' => 'required|numeric',
            'building_id' => 'nullable|exists:buildings,id'
        ], [
            'name.unique' => 'Dịch vụ này đã tồn tại trong tòa nhà này rồi.'
        ]);

        Service::create($data);
        return redirect()->route('services.buildings.index')->with('success', 'Dịch vụ tòa nhà đã được tạo.');
    }

    public function editBuilding($id)
    {
        $service = Service::findOrFail($id);
        $buildings = Building::orderBy('name')->get();
        return view('admin.pages.chinhsuadichvutheotoa', compact('service', 'buildings'));
    }

    public function updateBuilding(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'name')
                    ->where('building_id', $request->building_id)
                    ->whereNull('room_id')
                    ->ignore($id)
            ],
            'unit' => 'nullable|string|max:50',
            'price_per_unit' => 'required|numeric',
            'building_id' => 'nullable|exists:buildings,id'
        ], [
            'name.unique' => 'Dịch vụ này đã tồn tại trong tòa nhà này rồi.'
        ]);

        $service->update($data);
        return redirect()->route('services.buildings.index')->with('success', 'Dịch vụ tòa nhà đã được cập nhật.');
    }

    public function destroyBuilding($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('services.buildings.index')->with('success', 'Dịch vụ đã bị xóa.');
    }

    // Services for rooms (re-using Service model for now)
    public function indexRoom()
    {
        $services = Service::whereNotNull('room_id')
            ->with('room', 'room.building')
            ->select('services.*')
            ->join('rooms', 'services.room_id', '=', 'rooms.id')
            ->join('buildings', 'rooms.building_id', '=', 'buildings.id')
            ->orderBy('buildings.name')
            ->orderBy('rooms.room_number')
            ->orderBy('services.name')
            ->paginate(20);
        $rooms = Room::with('building')->orderBy('building_id')->orderBy('room_number')->get();
        return view('admin.pages.dichvutheophong', compact('services', 'rooms'));
    }

    public function createRoom()
    {
        $rooms = Room::with('building')->orderBy('building_id')->orderBy('room_number')->get();
        return view('admin.pages.themdichvutheophong', compact('rooms'));
    }

    public function storeRoom(Request $request)
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'name')
                    ->where('room_id', $request->room_id)
                    ->whereNull('building_id')
            ],
            'unit' => 'nullable|string|max:50',
            'price_per_unit' => 'required|numeric',
            'room_id' => 'nullable|exists:rooms,id'
        ], [
            'name.unique' => 'Dịch vụ này đã tồn tại trong phòng này rồi.'
        ]);

        Service::create($data);
        return redirect()->route('services.rooms.index')->with('success', 'Dịch vụ phòng đã được tạo.');
    }

    public function editRoom($id)
    {
        $service = Service::findOrFail($id);
        $rooms = Room::with('building')->orderBy('building_id')->orderBy('room_number')->get();
        return view('admin.pages.chinhsuadichvutheophong', compact('service', 'rooms'));
    }

    public function updateRoom(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('services', 'name')
                    ->where('room_id', $request->room_id)
                    ->whereNull('building_id')
                    ->ignore($id)
            ],
            'unit' => 'nullable|string|max:50',
            'price_per_unit' => 'required|numeric',
            'room_id' => 'nullable|exists:rooms,id'
        ], [
            'name.unique' => 'Dịch vụ này đã tồn tại trong phòng này rồi.'
        ]);

        $service->update($data);
        return redirect()->route('services.rooms.index')->with('success', 'Dịch vụ phòng đã được cập nhật.');
    }

    public function destroyRoom($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->route('services.rooms.index')->with('success', 'Dịch vụ đã bị xóa.');
    }
}
