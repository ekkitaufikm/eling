 {{-- config session --}}
@php
use Illuminate\Support\Facades\Session;
$user=Session::get('useractive');
@endphp
{{-- end config session --}}
<!--begin::Navbar-->
<div class="d-flex align-items-stretch" id="kt_header_nav">
    <!--begin::Menu wrapper-->
    <div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
        <!--begin::Menu-->
        <div class="menu menu-lg-rounded menu-column menu-lg-row menu-state-bg menu-title-gray-700 menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-400 fw-bold my-5 my-lg-0 align-items-stretch" id="#kt_header_menu" data-kt-menu="true">
            {{-- dashboard --}}
            <div data-kt-menu-trigger="click" onclick="document.location='{{url('dashboard')}}'" data-kt-menu-placement="bottom-start" class="menu-item @if($page=='dashboard') here show @endif menu-lg-down-accordion me-lg-1">
                <span class="menu-link py-3">
                    <span class="menu-title">Dashboard</span>
                    <span class="menu-arrow d-lg-none"></span>
                </span>
            </div>
            {{-- end dashboard --}}

            @if($user->hak_akses==1)
            {{-- masterdata --}}
            <div data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" class="menu-item @if($page=='master') here show @endif menu-lg-down-accordion me-lg-1">
                <span class="menu-link py-3">
                    <span class="menu-title">Data Master</span>
                    <span class="menu-arrow d-lg-none"></span>
                </span>
                <div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown menu-rounded-0 py-lg-4 w-lg-225px">
                    {{-- masterdata satuan kerja --}}
                    <div class="menu-item">
                        <a class="menu-link active py-3" href="{{url('master/satker')}}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Satuan Kerja</span>
                        </a>
                    </div>
                    {{-- end masterdata satuan kerja --}}
                    {{-- masterdata user --}}
                    <div class="menu-item">
                        <a class="menu-link active py-3" href="{{url('master/user')}}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">User Login</span>
                        </a>
                    </div>
                    {{-- end masterdata user --}}
                    {{-- masterdata Status Usulan Produk Hukum --}}
                        <div class="menu-item">
                        <a class="menu-link active py-3" href="{{url('master/setting-status')}}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Status Usulan Produk Hukum</span>
                        </a>
                    </div>
                    {{-- end masterdata Status Usulan Produk Hukum --}}
                    {{-- masterdata Pengaturan Landing Page --}}
                    <div class="menu-item">
                        <a class="menu-link active py-3" href="{{url('master/setting-dashboard')}}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Pengaturan Landing Page</span>
                        </a>
                    </div>
                    {{-- end masterdata Pengaturan Landing Page --}}
                    {{-- masterdata Slide Show --}}
                    <div class="menu-item">
                        <a class="menu-link active py-3" href="{{url('master/slider')}}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Slide Show</span>
                        </a>
                    </div>
                    {{-- end masterdata Slide Show --}}
                    {{-- masterdata Informasi --}}
                    <div class="menu-item">
                        <a class="menu-link active py-3" href="{{url('master/info')}}">
                            <span class="menu-bullet">
                                <span class="bullet bullet-dot"></span>
                            </span>
                            <span class="menu-title">Informasi</span>
                        </a>
                    </div>
                    {{-- end masterdata Informasi --}}
                </div>
            </div>
            {{-- end masterdata --}}
            @endif

            @php($arr_akses=array('6,7,8,9'))
            @if(!in_array($user->hak_akses,$arr_akses))
            {{-- usulan produk hukum --}}
            <div data-kt-menu-trigger="click" onclick="document.location='{{url('usulan')}}'" data-kt-menu-placement="bottom-start" class="menu-item @if($page=='usulan') here show @endif menu-lg-down-accordion me-lg-1">
                <span class="menu-link py-3">
                    <span class="menu-title">Usulan Produk Hukum</span>
                    <span class="menu-arrow d-lg-none"></span>
                </span>
            </div>
            {{-- end usulan produk hukum --}}
            @endif

            {{-- produk hukum --}}
            <div data-kt-menu-trigger="click" onclick="document.location='{{url('produk')}}'" data-kt-menu-placement="bottom-start" class="menu-item @if($page=='produk') here show @endif menu-lg-down-accordion me-lg-1">
                <span class="menu-link py-3">
                    <span class="menu-title">Produk Hukum</span>
                    <span class="menu-arrow d-lg-none"></span>
                </span>
            </div>
            {{-- end produk hukum --}}

            @if($user->hak_akses==1)
            {{-- usulan produk hukum dihapus --}}
            <div data-kt-menu-trigger="click" onclick="document.location='{{url('usulan/hapus')}}'" data-kt-menu-placement="bottom-start" class="menu-item @if($page=='usulan/hapus') here show @endif menu-lg-down-accordion me-lg-1">
                <span class="menu-link py-3">
                    <span class="menu-title">Usulan Dihapus</span>
                    <span class="menu-arrow d-lg-none"></span>
                </span>
            </div>
            {{-- end usulan produk hukum dihapus--}}
            @endif

            {{-- laporan produk hukum --}}
            <div data-kt-menu-trigger="click" onclick="document.location='{{url('laporan')}}'" data-kt-menu-placement="bottom-start" class="menu-item @if($page=='laporan') here show @endif menu-lg-down-accordion me-lg-1">
                <span class="menu-link py-3">
                    <span class="menu-title">Laporan</span>
                    <span class="menu-arrow d-lg-none"></span>
                </span>
            </div>
            {{-- end laporan produk hukum--}}

            {{-- buku panduan --}}
            <div data-kt-menu-trigger="click" onclick="document.location='{{asset('assets/buku_panduan.pdf')}}'" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion me-lg-1">
                <span class="menu-link py-3">
                    <span class="menu-title">Buku Panduan</span>
                    <span class="menu-arrow d-lg-none"></span>
                </span>
            </div>
            {{-- end buku panduan--}}
                    </div>
    </div>
</div>