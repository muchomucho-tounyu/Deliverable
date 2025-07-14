<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('posts.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                    <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index')">
                        {{ __('Index') }}
                    </x-nav-link>
                    <x-nav-link :href="route('posts.create')" :active="request()->routeIs('posts.create')">
                        {{ __('Create') }}
                    </x-nav-link>
                    <x-nav-link :href="route('mypage')" :active="request()->routeIs('mypage')">
                        {{ __('Mypage') }}
                    </x-nav-link>
                    <x-nav-link :href="route('map')" :active="request()->routeIs('map')">
                        {{ __('マップで検索') }}
                    </x-nav-link>
                </div>
            </div>
            <!-- 右側：検索ボックス -->
            <div class="hidden sm:flex items-center space-x-4">
                <form action="{{ route('posts.search') }}" method="GET" class="flex">
                    <input type="text" name="keyword"
                        placeholder="聖地・作品・人物で検索"
                        class="w-48 border border-gray-300 rounded-l px-3 py-1 text-sm">
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1 text-sm rounded-r">
                        検索
                    </button>
                </form>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <a href="{{ route('mypage') }}" class="flex items-center">
                        @if(Auth::user()->image && Auth::user()->image !== 'null')
                        @if(str_starts_with(Auth::user()->image, 'http'))
                        <img src="{{ Auth::user()->image }}" alt="ユーザーアイコン"
                            class="w-8 h-8 rounded-full object-cover border-2 border-gray-200 hover:border-blue-300 transition-colors">
                        @else
                        <img src="{{ asset(Auth::user()->image) }}" alt="ユーザーアイコン"
                            class="w-8 h-8 rounded-full object-cover border-2 border-gray-200 hover:border-blue-300 transition-colors">
                        @endif
                        @else
                        <!-- デフォルトのユーザーアイコン（SVG） -->
                        <div class="w-8 h-8 rounded-full bg-gray-200 border-2 border-gray-300 hover:border-blue-300 transition-colors flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        @endif
                    </a>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <!-- ダッシュボードリンク削除済み -->
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-200">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('mypage')">
                        {{ __('Mypage') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('map')">
                        {{ __('マップで検索') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
</nav>