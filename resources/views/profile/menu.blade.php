<div class="mb-4">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}" href="{{ route('profile.index') }}">Основна інформація</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}" href="{{ route('profile.edit') }}">Редагування профілю</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile.reviews') ? 'active' : '' }}" href="{{ route('profile.reviews') }}">Мої відгуки</a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('profile.suggestions') ? 'active' : '' }}" href="{{ route('profile.suggestions') }}">Запропоновані вакансії</a>
        </li>
        <li class="nav-item ms-auto">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger">Вийти</button>
            </form>
        </li>
    </ul>
</div>