<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Building;
use App\Models\Room;
use App\Models\User;
use App\Models\Contract;
use App\Models\Invoice;
use App\Models\Issue;
use App\Models\Service;
use App\Models\ServiceReading;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalBuildings = Building::count();
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $occupancyRate = $totalRooms ? round(($occupiedRooms / $totalRooms) * 100) : 0;

        $totalUsers = User::count();
        $totalContracts = Contract::count();
        $totalInvoices = Invoice::count();
        $totalRevenue = Invoice::sum('total_amount');

        $pendingIssues = Issue::where('status', 'pending')->count();

        $pendingReadings = ServiceReading::with(['room.building', 'creator'])
            ->where('status', 'pending')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.pages.dashboard', compact(
            'totalBuildings',
            'totalRooms',
            'occupiedRooms',
            'occupancyRate',
            'totalUsers',
            'totalContracts',
            'totalInvoices',
            'totalRevenue',
            'pendingIssues',
            'pendingReadings'
        ));
    }
}
