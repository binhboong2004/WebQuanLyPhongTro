@extends('layouts.user')
@section('title', 'Đổi mật khẩu')
@section('content')
<main class="flex-1 overflow-y-auto relative p-4 lg:p-10" data-success="{{ session('success') ? '1' : '0' }}" data-success-msg="{!! htmlspecialchars(session('success') ?? '', ENT_QUOTES, 'UTF-8') !!}">
    <header class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-black text-slate-800">Đổi mật khẩu</h2>
        <div class="flex gap-4">
            <a href="{{ route('user.index') }}"
                class="bg-slate-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md hover:bg-slate-700 transition">
                Quay lại
            </a>
        </div>
    </header>

    <!-- Alert Messages -->
    @if ($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-md p-4 flex gap-3 items-start">
        <i class="fa fa-exclamation-circle text-red-500 mt-1"></i>
        <div>
            <p class="font-bold text-red-700 mb-2">Có lỗi xảy ra:</p>
            <ul class="text-red-600 text-sm space-y-1">
                @foreach ($errors->all() as $error)
                <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    @if (session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 rounded-md p-4 flex gap-3 items-start">
        <i class="fa fa-check-circle text-green-500 mt-1"></i>
        <div>
            <p class="font-bold text-green-700">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sidebar Info -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-md p-6 border border-teal-50 shadow-sm sticky top-10">
                <div class="mb-6 p-4 bg-orange-50 rounded-md border border-orange-100">
                    <div class="flex items-center gap-3 mb-2">
                        <i class="fa fa-lock text-orange-600 text-xl"></i>
                        <p class="font-bold text-orange-700">Bảo mật tài khoản</p>
                    </div>
                    <p class="text-xs text-orange-600 leading-relaxed">
                        Mật khẩu mạnh giúp bảo vệ tài khoản của bạn. Hãy cập nhật định kỳ.
                    </p>
                </div>

                <hr class="border-slate-100 my-4">

                <div class="space-y-4 text-sm">
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase mb-1">Tài khoản</p>
                        <p class="font-bold text-slate-700">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase mb-1">Người dùng</p>
                        <p class="font-bold text-slate-700">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-400 font-bold uppercase mb-1">Cập nhật lần cuối</p>
                        <p class="font-bold text-slate-700">{{ $user->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <div class="lg:col-span-2">
            <form action="{{ route('user.update-password', $user->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- All Password Fields in One Card -->
                <div class="bg-white rounded-md p-6 border border-teal-50 shadow-sm">
                    <!-- Current Password -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">
                            <i class="fa fa-key text-teal-600 mr-2"></i>Mật khẩu hiện tại
                        </label>
                        <input type="password" name="current_password" required
                            placeholder="Nhập mật khẩu hiện tại"
                            class="w-full px-4 py-3 border-2 border-teal-100 rounded-md focus:border-teal-500 focus:ring-teal-100 focus:ring-2 outline-none transition placeholder-slate-300">
                        @error('current_password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-slate-400 mt-2">Nhập mật khẩu hiện tại để xác minh danh tính</p>
                    </div>

                    <div class="border-t border-slate-200 my-6"></div>

                    <!-- New Password -->
                    <div class="mb-6">
                        <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">
                            <i class="fa fa-shield text-teal-600 mr-2"></i>Mật khẩu mới
                        </label>
                        <input type="password" name="password" required
                            placeholder="Nhập mật khẩu mới (tối thiểu 8 ký tự)"
                            class="w-full px-4 py-3 border-2 border-teal-100 rounded-md focus:border-teal-500 focus:ring-teal-100 focus:ring-2 outline-none transition placeholder-slate-300">
                        @error('password')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror

                        <div class="mt-4 space-y-2">
                            <p class="text-xs font-bold text-slate-600 uppercase">Yêu cầu:</p>
                            <div class="space-y-1 text-xs text-slate-500">
                                <div id="req-length" class="flex items-center gap-2">
                                    <i class="fa fa-circle text-slate-300 text-[6px]"></i>
                                    <span>Ít nhất 8 ký tự</span>
                                </div>
                                <div id="req-upper" class="flex items-center gap-2">
                                    <i class="fa fa-circle text-slate-300 text-[6px]"></i>
                                    <span>Chứa ít nhất một chữ hoa (A-Z)</span>
                                </div>
                                <div id="req-lower" class="flex items-center gap-2">
                                    <i class="fa fa-circle text-slate-300 text-[6px]"></i>
                                    <span>Chứa ít nhất một chữ thường (a-z)</span>
                                </div>
                                <div id="req-number" class="flex items-center gap-2">
                                    <i class="fa fa-circle text-slate-300 text-[6px]"></i>
                                    <span>Chứa ít nhất một số (0-9)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-slate-200 my-6"></div>

                    <!-- Confirm Password -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-3 uppercase tracking-wide">
                            <i class="fa fa-check text-teal-600 mr-2"></i>Xác nhận mật khẩu mới
                        </label>
                        <input type="password" name="password_confirmation" required
                            placeholder="Nhập lại mật khẩu mới"
                            class="w-full px-4 py-3 border-2 border-teal-100 rounded-md focus:border-teal-500 focus:ring-teal-100 focus:ring-2 outline-none transition placeholder-slate-300">
                        @error('password_confirmation')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-slate-400 mt-2">Nhập lại để đảm bảo không có lỗi</p>
                    </div>
                </div>

                <!-- Security Reminder -->
                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4 flex gap-3">
                    <i class="fa fa-info-circle text-yellow-600 mt-1"></i>
                    <div>
                        <p class="text-xs font-bold text-yellow-700 mb-1">LƯỚI BẢO TOÀN</p>
                        <p class="text-xs text-yellow-600">
                            Không chia sẻ mật khẩu với bất kỳ ai. SmartRent sẽ không bao giờ yêu cầu mật khẩu của bạn qua email hoặc tin nhắn.
                        </p>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-4">
                    <button type="submit"
                        class="flex-1 bg-gradient-to-r from-teal-500 to-teal-600 text-white font-bold px-8 py-4 rounded-lg shadow-md shadow-teal-200 hover:shadow-lg hover:from-teal-600 hover:to-teal-700 active:scale-95 transition">
                        <i class="fa fa-save mr-2"></i>Cập nhật mật khẩu
                    </button>
                    <a href="{{ route('user.index') }}"
                        class="flex-1 bg-slate-100 text-slate-700 font-bold px-8 py-4 rounded-lg shadow-sm hover:bg-slate-200 active:scale-95 transition text-center">
                        <i class="fa fa-times mr-2"></i>Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>

@endsection