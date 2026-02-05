<aside class="w-72 bg-slate-900 text-white flex flex-col overflow-y-auto custom-scrollbar">
    <div class="p-6 border-b border-slate-800">
        <h1 class="text-2xl font-black text-blue-400 italic tracking-tighter">SMARTRENT <span
                class="text-[10px] block font-normal text-slate-500 uppercase tracking-widest">Hệ thống quản
                trị</span></h1>
    </div>

    <nav class="flex-1 p-4 space-y-1">

        <a href="{{ route('admin.dashboard') }}"
            class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fa fa-chart-line w-6"></i> Tổng quan
        </a>

        <div class="dropdown-item">
            <div class="nav-item dropdown-toggle justify-between cursor-pointer {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <span><i class="fa fa-user-shield w-6"></i> Quản lý tài khoản</span>
                <i class="fa fa-chevron-down text-[10px] transition-transform duration-300 {{ request()->routeIs('users.*') ? 'rotate-180' : '' }}"></i>
            </div>
            <div class="sub-menu {{ request()->routeIs('users.*') ? '' : 'hidden' }}">
                <a href="{{ route('users.index') }}"
                    class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('users.index') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa fa-users-cog mr-2"></i> Danh sách tài khoản
                </a>
                <a href="{{ route('users.create') }}"
                    class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('users.create') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa fa-user-plus mr-2"></i> Cấp tài khoản mới
                </a>
            </div>
        </div>

        <div class="dropdown-item">
            <div class="nav-item dropdown-toggle justify-between cursor-pointer {{ request()->routeIs('buildings.*') || request()->routeIs('rooms.*') ? 'active' : '' }}">
                <span><i class="fa fa-building w-6"></i> Quản lý Phòng & Tòa nhà</span>
                <i class="fa fa-chevron-down text-[10px] transition-transform duration-300 {{ request()->routeIs('buildings.*') || request()->routeIs('rooms.*') ? 'rotate-180' : '' }}"></i>
            </div>
            <div class="sub-menu {{ request()->routeIs('buildings.*') || request()->routeIs('rooms.*') ? '' : 'hidden' }}">
                <a href="{{ route('buildings.index') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('buildings.index') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa fa-city mr-2"></i> Quản lý Tòa nhà
                </a>
                <a href="{{ route('buildings.create') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('buildings.create') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa-solid fa-plus mr-2"></i> Thêm tòa nhà
                </a>
                <a href="{{ route('rooms.index') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('rooms.index') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa fa-door-open mr-2"></i> Quản lý Phòng
                </a>
                <a href="{{ route('rooms.create') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('rooms.create') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa-solid fa-plus mr-2"></i> Thêm phòng
                </a>
            </div>
        </div>

        <div class="dropdown-item">
            <div class="nav-item dropdown-toggle justify-between cursor-pointer {{ request()->routeIs('services.buildings.*') || request()->routeIs('services.rooms.*') ? 'active' : '' }}">
                <span><i class="fa fa-building w-6"></i> Quản lý Dịch vụ</span>
                <i class="fa fa-chevron-down text-[10px] transition-transform duration-300 {{ request()->routeIs('services.buildings.*') || request()->routeIs('services.rooms.*') ? 'rotate-180' : '' }}"></i>
            </div>
            <div class="sub-menu {{ request()->routeIs('services.buildings.*') || request()->routeIs('services.rooms.*') ? '' : 'hidden' }}">
                <a href="{{ route('services.buildings.index') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('services.buildings.index') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa fa-city mr-2"></i> Dịch vụ theo tòa nhà
                </a>
                <a href="{{ route('services.buildings.create') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('services.buildings.create') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa-solid fa-plus mr-2"></i> Thêm dịch vụ tòa nhà
                </a>
                <a href="{{ route('services.rooms.index') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('services.rooms.index') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa fa-door-open mr-2"></i> Dịch vụ theo Phòng
                </a>
                <a href="{{ route('services.rooms.create') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('services.rooms.create') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa-solid fa-plus mr-2"></i> Thêm dịch vụ phòng
                </a>
            </div>
        </div>

        <div class="dropdown-item">
            <div class="nav-item dropdown-toggle justify-between cursor-pointer {{ request()->routeIs('tenants.*') || request()->routeIs('contracts.*') ? 'active' : '' }}">
                <span><i class="fa fa-file-signature w-6"></i> Người thuê & HĐ</span>
                <i class="fa fa-chevron-down text-[10px] transition-transform duration-300 {{ request()->routeIs('tenants.*') || request()->routeIs('contracts.*') ? 'rotate-180' : '' }}"></i>
            </div>
            <div class="sub-menu {{ request()->routeIs('tenants.*') || request()->routeIs('contracts.*') ? '' : 'hidden' }}">
                <a href="{{ route('tenants.index') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('tenants.*') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa fa-id-card mr-2"></i> Danh sách người thuê
                </a>
                <a href="{{ route('contracts.index') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('contracts.*') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa fa-file-contract mr-2"></i> Danh sách hợp đồng
                </a>
                <a href="{{ route('contracts.create') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('contracts.create') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa-solid fa-plus mr-2"></i> Lập hợp đồng thuê
                </a>
            </div>
        </div>

        <div class="dropdown-item">
            <div class="nav-item dropdown-toggle justify-between cursor-pointer {{ request()->routeIs('finance.*') ? 'active' : '' }}">
                <span><i class="fa fa-wallet w-6"></i> Quản lý tài chính</span>
                <i class="fa fa-chevron-down text-[10px] transition-transform duration-300 {{ request()->routeIs('finance.*') ? 'rotate-180' : '' }}"></i>
            </div>
            <div class="sub-menu {{ request()->routeIs('finance.*') ? '' : 'hidden' }}">
                <a href="{{ route('finance.readings.index') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('finance.readings.*') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa fa-check-double mr-2"></i> Phê duyệt chỉ số
                </a>
                <a href="{{ route('finance.invoices.index') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('finance.invoices.*') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa fa-file-invoice-dollar mr-2"></i> Danh sách đóng tiền
                </a>
            </div>
        </div>

        <div class="dropdown-item">
            <div class="nav-item dropdown-toggle justify-between cursor-pointer {{ request()->routeIs('issues.*') || request()->routeIs('notifications.*') ? 'active' : '' }}">
                <span><i class="fa fa-comments w-6"></i> Phản hồi & Thông báo</span>
                <i class="fa fa-chevron-down text-[10px] transition-transform duration-300 {{ request()->routeIs('issues.*') || request()->routeIs('notifications.*') ? 'rotate-180' : '' }}"></i>
            </div>
            <div class="sub-menu {{ request()->routeIs('issues.*') || request()->routeIs('notifications.*') ? '' : 'hidden' }}">
                <a href="{{ route('issues.index') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('issues.*') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa fa-comments mr-2"></i> Trả lời phản hồi
                </a>
                <a href="{{ route('notifications.index') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('notifications.index') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa fa-list mr-2"></i> Danh sách thông báo
                </a>
                <a href="{{ route('notifications.create') }}" class="block py-2 px-8 hover:bg-slate-800 rounded-lg {{ request()->routeIs('notifications.create') ? 'text-blue-400 font-bold' : '' }}">
                    <i class="fa-solid fa-plus mr-2"></i> Gửi thông báo mới
                </a>
            </div>
        </div>
        <a href="{{ route('logout') }}"
            class="nav-item text-red-400 hover:text-red-300"
            onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket mr-3"></i>
            Đăng xuất
        </a>

        <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </nav>
</aside>