<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

    public function edit($id)
    {
        $user = User::findOrFail($id); // Tìm user theo ID, không thấy sẽ báo lỗi 404
        return view('admin.pages.chinhsuataikhoan', compact('user'));
    }

    /**
     * Cập nhật thông tin tài khoản (PUT/PATCH)
     * Thêm mới: Xử lý lưu dữ liệu sau khi sửa
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            // unique:users,email,'.$id giúp bỏ qua kiểm tra trùng email của chính nó
            'email'    => 'required|string|email|max:255|unique:users,email,'.$id,
            'phone'    => 'nullable|string|max:15',
            'role'     => 'required|in:admin,tenant',
            'password' => 'nullable|string|min:8|confirmed', // Mật khẩu có thể để trống nếu không muốn đổi
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;

        // Chỉ cập nhật mật khẩu nếu người dùng nhập mới
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Đã cập nhật tài khoản ' . $user->name);
    }

    /**
     * Xóa tài khoản (DELETE)
     * Thêm mới: Xử lý xóa user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Chặn không cho Admin tự xóa chính mình (nếu cần)
        if (Auth::id() == $id) {
            return back()->with('error', 'Bạn không thể tự xóa chính mình!');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Đã xóa tài khoản thành công!');
    }
}