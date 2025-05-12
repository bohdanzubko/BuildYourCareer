@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Мої відгуки</h1>

    @include('profile.partials.menu')

    <p>Тут буде список відгуків користувача.</p>
</div>
@endsection


resources/views/profile/suggestions.blade.php:

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Запропоновані вакансії</h1>

    @include('profile.partials.menu')

    <p>Тут буде список рекомендованих вакансій для вас.</p>
</div>
@endsection