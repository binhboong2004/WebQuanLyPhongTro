<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Building;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::with('building')->latest()->paginate(20);
        return view('admin.pages.quanlyphong', compact('rooms'));
    }

    public function create()
    {
        $buildings = Building::orderBy('name')->get();
        return view('admin.pages.themphong', compact('buildings'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'room_number' => 'required|string|max:50',
            'price_base' => 'required|numeric',
            'status' => 'required|in:available,occupied,maintenance'
        ]);

        Room::create($data);
        return redirect()->route('rooms.index')->with('success', 'Phòng đã được tạo.');
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        $buildings = Building::orderBy('name')->get();
        return view('admin.pages.chinhsuaphong', compact('room', 'buildings'));
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $data = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'room_number' => 'required|string|max:50',
            'price_base' => 'required|numeric',
            'status' => 'required|in:available,occupied,maintenance'
        ]);

        $room->update($data);
        return redirect()->route('rooms.index')->with('success', 'Cập nhật phòng thành công.');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect()->route('rooms.index')->with('success', 'Phòng đã được xóa.');
    }
}
