<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Contract;
use App\Models\Room;
use App\Models\Invoice;
use App\Models\ServiceReading;

class UserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $contract = Contract::where('tenant_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        if (! $contract) {
            $contract = Contract::where('tenant_id', $user->id)->latest()->first();
        }

        $room = $contract ? $contract->room : null;
        $members = $room ? $room->members()->get() : collect();
        $invoice = $room ? $room->invoices()->latest()->first() : null;
        $reading = $room ? $room->readings()->latest()->first() : null;

        return view('user.pages.index', compact('contract', 'room', 'members', 'invoice', 'reading'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.pages.chinhsuathongtin', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Kiểm tra người dùng chỉ có thể sửa thông tin của chính mình
        if (Auth::id() !== $user->id) {
            return redirect()->route('user.index')->with('error', 'Bạn không có quyền cập nhật thông tin người dùng khác.');
        }

        $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone'  => 'nullable|string|max:15',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required'     => 'Vui lòng nhập họ tên.',
            'email.required'    => 'Vui lòng nhập email.',
            'email.email'       => 'Email không đúng định dạng.',
            'email.unique'      => 'Email này đã tồn tại trên hệ thống.',
            'phone.max'         => 'Số điện thoại không được vượt quá 15 ký tự.',
            'avatar.image'      => 'Tệp phải là một hình ảnh.',
            'avatar.mimes'      => 'Hình ảnh phải có định dạng: jpeg, png, jpg, hoặc gif.',
            'avatar.max'        => 'Hình ảnh không được vượt quá 2MB.',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && file_exists(public_path($user->avatar))) {
                unlink(public_path($user->avatar));
            }

            $file = $request->file('avatar');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/avatars'), $filename);
            $user->avatar = 'uploads/avatars/' . $filename;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('user.edit')->with('success', 'Lưu thay đổi thành công!');
    }

    public function changePassword()
    {
        $user = Auth::user();
        return view('user.pages.doimatkhau', compact('user'));
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Kiểm tra người dùng chỉ có thể đổi mật khẩu của chính mình
        if (Auth::id() !== $user->id) {
            return redirect()->route('user.index')->with('error', 'Bạn không có quyền đổi mật khẩu người dùng khác.');
        }

        $request->validate([
            'current_password' => 'required|string',
            'password'         => 'required|string|min:8|confirmed',
        ], [
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'password.required'         => 'Vui lòng nhập mật khẩu mới.',
            'password.min'              => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
            'password.confirmed'        => 'Xác nhận mật khẩu không khớp.',
        ]);

        // Kiểm tra mật khẩu hiện tại
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
        }

        // Cập nhật mật khẩu mới
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.change-password')->with('success', 'Đổi mật khẩu thành công!');
    }
}
