<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceReading;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;

class FinanceController extends Controller
{
    // List pending/All service readings for approval
    public function indexReadings()
    {
        $readings = ServiceReading::with('room.building', 'creator')->orderBy('reading_date', 'desc')->paginate(20);
        return view('admin.pages.pheduyetchiso', compact('readings'));
    }

    // Approve a reading (simple status update)
    public function approveReading(Request $request, $id)
    {
        $reading = ServiceReading::findOrFail($id);
        $reading->status = 'approved';
        $reading->admin_note = $request->input('admin_note');
        $reading->save();

        return redirect()->route('finance.readings.index')->with('success', 'Đã phê duyệt chỉ số.');
    }

    public function rejectReading(Request $request, $id)
    {
        Log::info('FinanceController@rejectReading called', ['id' => $id, 'input' => $request->all(), 'user_id' => auth()?->id()]);

        $request->validate([
            'admin_note' => 'required|string|max:1000',
        ]);

        $reading = ServiceReading::findOrFail($id);
        $reading->status = 'rejected';
        $reading->admin_note = $request->input('admin_note');
        $reading->save();

        Log::info('ServiceReading rejected', ['id' => $reading->id, 'admin_note' => $reading->admin_note, 'user_id' => auth()?->id()]);

        return redirect()->route('finance.readings.index')->with('success', 'Đã từ chối chỉ số, đã gửi ghi chú cho người dùng.');
    }
    
    public function indexInvoices()
    {
        $invoices = Invoice::with('room.building', 'reading')->orderBy('month_year', 'desc')->paginate(20);
        return view('admin.pages.danhsachdongtien', compact('invoices'));
    }

    public function showInvoice($id)
    {
        $invoice = Invoice::with('room.building', 'reading', 'details')->findOrFail($id);
        return view('admin.pages.chitiethoadon', compact('invoice'));
    }
}
