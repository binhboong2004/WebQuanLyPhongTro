<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderBy('created_at', 'desc')->paginate(20);
        return view('admin.pages.danhsachthongbao', compact('notifications'));
    }

    public function create()
    {
        return view('admin.pages.guithongbao');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:2000',
            'type' => 'required|in:general,alert,update',
        ]);

        Notification::create([
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'type' => $request->input('type'),
        ]);

        return redirect()->route('notifications.index')->with('success', 'Gửi thông báo thành công.');
    }
}
