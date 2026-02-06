<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\RoomMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RoomMemberController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Lấy phòng được thuê của người dùng
        $contract = Contract::where('tenant_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$contract) {
            $contract = Contract::where('tenant_id', $user->id)->latest()->first();
        }

        $room = $contract ? $contract->room : null;

        if (!$room) {
            return redirect()->route('user.index')->with('error', 'Bạn chưa có phòng được gán.');
        }

        $members = $room->members()->get();

        return view('user.pages.thanhvienocung', compact('room', 'members', 'user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $contract = Contract::where('tenant_id', $user->id)
            ->where('status', 'active')
            ->latest()
            ->first();

        if (!$contract) {
            $contract = Contract::where('tenant_id', $user->id)->latest()->first();
        }

        $room = $contract ? $contract->room : null;

        if (!$room) {
            return redirect()->back()->with('error', 'Không tìm thấy phòng của bạn.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'id_card' => 'required|string|max:20',
            'phone' => 'required|string|max:15',
            'id_card_front' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_card_back' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập tên thành viên.',
            'id_card.required' => 'Vui lòng nhập số CCCD.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'id_card_front.required' => 'Vui lòng tải lên ảnh mặt trước CCCD.',
            'id_card_front.image' => 'Ảnh mặt trước phải là hình ảnh.',
            'id_card_front.max' => 'Ảnh mặt trước không vượt quá 2MB.',
            'id_card_back.required' => 'Vui lòng tải lên ảnh mặt sau CCCD.',
            'id_card_back.image' => 'Ảnh mặt sau phải là hình ảnh.',
            'id_card_back.max' => 'Ảnh mặt sau không vượt quá 2MB.',
        ]);

        // Handle file uploads
        $idCardFrontPath = null;
        $idCardBackPath = null;

        if ($request->hasFile('id_card_front')) {
            $file = $request->file('id_card_front');
            $filename = time() . '_front_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/id_cards'), $filename);
            $idCardFrontPath = 'uploads/id_cards/' . $filename;
        }

        if ($request->hasFile('id_card_back')) {
            $file = $request->file('id_card_back');
            $filename = time() . '_back_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/id_cards'), $filename);
            $idCardBackPath = 'uploads/id_cards/' . $filename;
        }

        RoomMember::create([
            'room_id' => $room->id,
            'name' => $request->name,
            'id_card' => $request->id_card,
            'phone' => $request->phone,
            'id_card_front' => $idCardFrontPath,
            'id_card_back' => $idCardBackPath,
            'is_registered' => 0,
        ]);

        return redirect()->route('room-member.index')->with('success', 'Thêm thành viên thành công!');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $member = RoomMember::findOrFail($id);

        // Verify member belongs to user's room
        $contract = Contract::where('tenant_id', $user->id)->latest()->first();
        if (!$contract || $contract->room_id !== $member->room_id) {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa thành viên này.');
        }

        $room = $member->room;
        $members = $room->members()->get();

        return view('user.pages.thanhvienocung', compact('room', 'members', 'user', 'member'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $member = RoomMember::findOrFail($id);

        // Verify member belongs to user's room
        $contract = Contract::where('tenant_id', $user->id)->latest()->first();
        if (!$contract || $contract->room_id !== $member->room_id) {
            return redirect()->back()->with('error', 'Bạn không có quyền chỉnh sửa thành viên này.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'id_card' => 'required|string|max:20',
            'phone' => 'required|string|max:15',
            'id_card_front' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_card_back' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'Vui lòng nhập tên thành viên.',
            'id_card.required' => 'Vui lòng nhập số CCCD.',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'id_card_front.image' => 'Ảnh mặt trước phải là hình ảnh.',
            'id_card_front.max' => 'Ảnh mặt trước không vượt quá 2MB.',
            'id_card_back.image' => 'Ảnh mặt sau phải là hình ảnh.',
            'id_card_back.max' => 'Ảnh mặt sau không vượt quá 2MB.',
        ]);

        // Handle front image
        if ($request->hasFile('id_card_front')) {
            if ($member->id_card_front && file_exists(public_path($member->id_card_front))) {
                unlink(public_path($member->id_card_front));
            }
            $file = $request->file('id_card_front');
            $filename = time() . '_front_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/id_cards'), $filename);
            $member->id_card_front = 'uploads/id_cards/' . $filename;
        }

        // Handle back image
        if ($request->hasFile('id_card_back')) {
            if ($member->id_card_back && file_exists(public_path($member->id_card_back))) {
                unlink(public_path($member->id_card_back));
            }
            $file = $request->file('id_card_back');
            $filename = time() . '_back_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/id_cards'), $filename);
            $member->id_card_back = 'uploads/id_cards/' . $filename;
        }

        $member->update([
            'name' => $request->name,
            'id_card' => $request->id_card,
            'phone' => $request->phone,
            'id_card_front' => $member->id_card_front,
            'id_card_back' => $member->id_card_back,
        ]);

        return redirect()->route('room-member.index')->with('success', 'Cập nhật thành viên thành công!');
    }

    public function destroy($id)
    {
        $user = Auth::user();
        $member = RoomMember::findOrFail($id);

        // Verify member belongs to user's room
        $contract = Contract::where('tenant_id', $user->id)->latest()->first();
        if (!$contract || $contract->room_id !== $member->room_id) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa thành viên này.');
        }

        // Delete images
        if ($member->id_card_front && file_exists(public_path($member->id_card_front))) {
            unlink(public_path($member->id_card_front));
        }
        if ($member->id_card_back && file_exists(public_path($member->id_card_back))) {
            unlink(public_path($member->id_card_back));
        }

        $member->delete();

        return redirect()->route('room-member.index')->with('success', 'Xóa thành viên thành công!');
    }
}
