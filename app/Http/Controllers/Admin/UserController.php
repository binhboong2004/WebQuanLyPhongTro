<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Hiển thị danh sách tài khoản
     */
    public function index()
    {
        $users = User::orderByRaw("FIELD(role, 'admin', 'tenant')")
            ->latest()
            ->paginate(10);

        return view('admin.pages.danhsachtaikhoan', compact('users'));
    }

    /**
     * Hiển thị form tạo tài khoản
     */
    public function create()
    {
        return view('admin.pages.capmoitaikhoan');
    }

    /**
     * Lưu tài khoản mới vào Database
     */
    public function store(Request $request)
    {
        // 1. Kiểm tra dữ liệu
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'nullable|string|max:15',
            'role'     => 'required|in:admin,tenant',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required'      => 'Vui lòng nhập họ tên.',
            'email.required'     => 'Vui lòng nhập email.',
            'email.email'        => 'Email không đúng định dạng.',
            'email.unique'       => 'Email này đã tồn tại trên hệ thống.',
            'password.required'  => 'Vui lòng nhập mật khẩu.',
            'password.min'       => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        // 2. Tạo User (Đảm bảo model User đã có $fillable)
        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // 3. Chuyển hướng kèm thông báo
        return redirect()->route('users.index')->with('success', 'Đã cấp tài khoản thành công cho ' . $request->name);
    }
}