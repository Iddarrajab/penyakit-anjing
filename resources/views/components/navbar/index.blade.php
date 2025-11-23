<aside class="fixed inset-y-0 left-0 z-990 flex flex-col max-h-[90vh] max-w-64 p-0 my-4 overflow-hidden transition-transform duration-200 bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 ease-nav-brand rounded-2xl xl:ml-6 xl:translate-x-0 -translate-x-full xl:left-0" aria-expanded="false">
    <!-- Header -->
    <div class="h-19 relative">
        <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden" sidenav-close></i>
        <a class="block px-8 py-6 text-sm whitespace-nowrap text-slate-700" href="#">
            <img src="{{ asset('assets/img/logo-dark.png') }}" class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8" alt="main_logo" />
            <img src="{{ asset('assets/img/logo.png') }}" class="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-8" alt="main_logo" />
            <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">
                Klinik Anjing
            </span>
        </a>
    </div>

    <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:via-white" />

    <!-- Menu Navigasi (scrollable) -->
    <div class="grow overflow-y-auto px-0">
        <ul class="flex flex-col pl-0 mb-0">
            <li class="mt-0.5 w-full">
                <a class="py-2.5 text-sm ease-nav-brand mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-500/13 font-semibold text-slate-700' : ' dark:opacity-80' }}" href="/">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center xl:p-2.5">
                        <i class="text-blue-500 ni ni-tv-2"></i>
                    </div>
                    <span class="ml-1">Dashboard</span>
                </a>
            </li>
            <!-- <li class="mt-0.5 w-full">
                <a class="py-2.5 text-sm ease-nav-brand mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('dokter') ? 'bg-blue-500/13 font-semibold text-slate-700' : ' dark:opacity-80' }}" href="{{ route('dokter') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center">
                        <i class="text-orange-500 ni ni-calendar-grid-58"></i>
                    </div>
                    <span class="ml-1">Dokter</span>
                </a>
            </li> -->

            {{-- Admin --}}
            @if(Auth::guard('admin')->check())
            <li class="mt-0.5 w-full">
                <a class="py-2.5 text-sm ease-nav-brand mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('gejala.index') ? 'bg-blue-500/13 font-semibold text-slate-700' : ' dark:opacity-80' }}" href="{{ route('gejala.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center">
                        <i class="text-blue-500 ni ni-tv-2"></i>
                    </div>
                    <span class="ml-1">Gejala</span>
                </a>
            </li>
            <li class="mt-0.5 w-full">
                <a class="py-2.5 text-sm ease-nav-brand mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('penyakit.index') ? 'bg-blue-500/13 font-semibold text-slate-700' : ' dark:opacity-80' }}" href="{{ route('penyakit.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center fill-current stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-emerald-500 ni ni-credit-card"></i>
                    </div>
                    <span class="ml-1">Penyakit</span>
                </a>
            </li>
            <li class="mt-0.5 w-full">
                <a class="py-2.5 text-sm ease-nav-brand mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('aturan.index') ? 'bg-blue-500/13 font-semibold text-slate-700' : ' dark:opacity-80' }}" href="{{ route('aturan.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                        <i class="relative top-0 text-sm leading-normal text-cyan-500 ni ni-app"></i>
                    </div>
                    <span class="ml-1">Aturan</span>
                </a>
            </li>
            <li class="mt-0.5 w-full">
                <a class="py-2.5 text-sm ease-nav-brand mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('diagnosa.index') ? 'bg-blue-500/13 font-semibold text-slate-700' : ' dark:opacity-80' }}" href="{{ route('diagnosa.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center">
                        <i class="text-emerald-500 ni ni-credit-card"></i>
                    </div>
                    <span class="ml-1">Diagnosa</span>
                </a>
            </li>
            <li class="mt-0.5 w-full">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-2.5 text-sm ease-nav-brand mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors dark:opacity-80 hover:bg-red-100">
                        <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center">
                            <i class="text-red-600 ni ni-world-2"></i>
                        </div>
                        <span class="ml-1">Logout</span>
                    </button>
                </form>
            </li>

            {{-- User --}}
            @elseif(Auth::guard('web')->check())

            <li class="mt-0.5 w-full">
                <a class="py-2.5 text-sm ease-nav-brand mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('diagnosa.index') ? 'bg-blue-500/13 font-semibold text-slate-700' : ' dark:opacity-80' }}" href="{{ route('diagnosa.index') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center">
                        <i class="text-emerald-500 ni ni-credit-card"></i>
                    </div>
                    <span class="ml-1">Diagnosa</span>
                </a>
            </li>
            <li class="mt-0.5 w-full">
                <a class="py-2.5 text-sm ease-nav-brand mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors {{ request()->routeIs('diagnosa.create') ? 'bg-blue-500/13 font-semibold text-slate-700' : ' dark:opacity-80' }}" href="{{ route('diagnosa.create') }}">
                    <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center">
                        <i class="text-cyan-500 ni ni-app"></i>
                    </div>
                    <span class="ml-1">Buat Diagnosa</span>
                </a>
            </li>
            <li class="mt-0.5 w-full">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-2.5 text-sm ease-nav-brand mx-2 flex items-center whitespace-nowrap rounded-lg px-4 transition-colors dark:opacity-80 hover:bg-red-100">
                        <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center">
                            <i class="text-red-600 ni ni-world-2"></i>
                        </div>
                        <span class="ml-1">Logout</span>
                    </button>
                </form>
            </li>
            @endif
        </ul>
    </div>

    <!-- Footer -->
    <div class="mx-4 mb-4 mt-auto">
        <div class="relative flex flex-col min-w-0 break-words bg-transparent border-0 shadow-none rounded-2xl bg-clip-border" sidenav-card>
            <img class="w-1/2 mx-auto" src="{{ asset('assets/img/illustrations/icon-documentation.svg') }}" alt="sidebar illustrations" />
            <div class="flex-auto w-full p-4 pt-0 text-center">
                <div class="transition-all duration-200 ease-nav-brand">
                    <h6 class="mb-0 text-slate-700">Puskesmas Hewan</h6>
                    <p class="mb-0 text-xs font-semibold leading-tight">Sumber</p>
                </div>
            </div>
        </div>
        <a href="https://www.creative-tim.com/learning-lab/tailwind/html/quick-start/argon-dashboard/" target="_blank" class="inline-block w-full px-8 py-2 mb-4 text-xs font-bold text-center text-white transition-all ease-in rounded-lg shadow-md bg-slate-700 hover:shadow-xs hover:-translate-y-px">Hallo</a>
        <a class="inline-block w-full px-8 py-2 text-xs font-bold text-center text-white transition-all ease-in bg-blue-500 rounded-lg shadow-md hover:shadow-xs hover:-translate-y-px" href="https://www.creative-tim.com/product/argon-dashboard-pro-tailwind?ref=sidebarfree" target="_blank">Selamat Datang</a>
    </div>
</aside>