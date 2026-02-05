<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Contract;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class TenantContractController extends Controller
{
    // List tenants (users with role 'tenant' or users who have contracts)
    public function indexTenants()
    {
        $tenants = User::where('role', 'tenant')->with('contracts.room.building')->orderBy('name')->paginate(20);
        return view('admin.pages.danhsachnguoithue', compact('tenants'));
    }

    // List contracts
    public function indexContracts()
    {
        $contracts = Contract::with('tenant', 'room.building')->orderBy('start_date', 'desc')->paginate(20);
        return view('admin.pages.danhsachhopdong', compact('contracts'));
    }

    // Show form to create a new contract
    public function createContract()
    {
        $rooms = Room::with('building')->orderBy('building_id')->orderBy('room_number')->get();
        $tenants = User::where('role', 'tenant')->orderBy('name')->get();
        return view('admin.pages.laphopdongthue', compact('rooms', 'tenants'));
    }

    // Store a new contract
    public function storeContract(Request $request)
    {
        $data = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'deposit' => 'nullable|numeric',
            'contract_type' => 'nullable|string|max:50',
            'status' => 'nullable|string|max:50',
            'contract_file' => 'nullable|string'
        ]);

        // Create contract and mark room as occupied in a transaction
        DB::transaction(function () use ($data) {
            $contract = Contract::create($data);

            $room = Room::find($data['room_id']);
            if ($room) {
                $room->status = 'occupied';
                $room->save();
            }
        });

        return redirect()->route('contracts.index')->with('success', 'Hợp đồng thuê đã được tạo.');
    }
}
