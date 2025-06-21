<div class="mb-4">
    <nav>
        <ul class="nav nav-tabs flex flex-row flex-wrap w-full rounded-lg overflow-hidden shadow bg-[#23272f] border-b-0" style="border-bottom: none;">
            @php
                $isOwner = auth()->check() && auth()->id() === $user->id;
                $isAdminOwner = auth()->check() && auth()->user()->role === 'admin' && auth()->id() === $user->id;
                $tabClass = "px-4 py-2 text-base font-medium transition border-0";
                $activeClass = "active text-white bg-cyan-600 shadow font-bold";
                $inactiveClass = "text-gray-300 bg-transparent hover:bg-cyan-800/60 hover:text-white";
            @endphp

            {{-- Основна сторінка --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('profile.index') ? $activeClass : $inactiveClass }} {{ $tabClass }}"
                   href="{{ route('profile.index') }}">
                    <i class="bi bi-person"></i> Основна інформація
                </a>
            </li>

            @if($isOwner || $isAdminOwner)
                {{-- Редагування --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.edit') ? $activeClass : $inactiveClass }} {{ $tabClass }}"
                       href="{{ route('profile.edit') }}">
                        <i class="bi bi-pencil-square"></i> Редагування профілю
                    </a>
                </li>

                {{-- Для worker --}}
                @if($user->role === 'worker' || $isAdminOwner)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.services') ? $activeClass : $inactiveClass }} {{ $tabClass }}"
                           href="{{ route('profile.services') }}">
                            <i class="bi bi-gear"></i> Мої послуги
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.service_requests') ? $activeClass : $inactiveClass }} {{ $tabClass }}"
                           href="{{ route('profile.service_requests') }}">
                            <i class="bi bi-gear"></i> Заявки на мої послуги
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.suggestions') ? $activeClass : $inactiveClass }} {{ $tabClass }}"
                           href="{{ route('profile.suggestions') }}">
                            <i class="bi bi-lightbulb"></i> Рекомендовані вакансії
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.job_requests') ? $activeClass : $inactiveClass }} {{ $tabClass }}"
                           href="{{ route('profile.job_requests') }}">
                            <i class="bi bi-send"></i> Мої заявки
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.job_offers') ? $activeClass : $inactiveClass }} {{ $tabClass }}"
                           href="{{ route('profile.job_offers') }}">
                            <i class="bi bi-envelope-open"></i> Пропозиції для мене
                        </a>
                    </li>
                @endif

                {{-- Для employer --}}
                @if($user->role === 'employer' || $isAdminOwner)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.jobs') ? $activeClass : $inactiveClass }} {{ $tabClass }}"
                           href="{{ route('profile.jobs') }}">
                            <i class="bi bi-briefcase"></i> Мої вакансії
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.job_requests_for_my_jobs') ? $activeClass : $inactiveClass }} {{ $tabClass }}"
                           href="{{ route('profile.job_requests_for_my_jobs') }}">
                            <i class="bi bi-inbox"></i> Заявки на мої вакансії
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.my_job_offers') ? $activeClass : $inactiveClass }} {{ $tabClass }}"
                           href="{{ route('profile.my_job_offers') }}">
                            <i class="bi bi-envelope"></i> Мої пропозиції
                        </a>
                    </li>
                @endif

                {{-- Відгуки --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.my_reviews') ? $activeClass : $inactiveClass }} {{ $tabClass }}"
                       href="{{ route('profile.my_reviews') }}">
                        <i class="bi bi-star"></i> Мої відгуки
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profile.reviews_about_me') ? $activeClass : $inactiveClass }} {{ $tabClass }}"
                       href="{{ route('profile.reviews_about_me') }}">
                        <i class="bi bi-chat-left-text"></i> Відгуки про мене
                    </a>
                </li>

                {{-- Вихід --}}
                <li class="nav-item ms-auto">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger ms-2 action-btn">Вийти</button>
                    </form>
                </li>
            @endif
        </ul>
    </nav>
</div>
