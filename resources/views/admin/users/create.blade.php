@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Créer un Utilisateur</h2>
    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nom</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Mot de passe</label>
            <input type="password" name="password" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Rôle</label>
            <select name="role_id" class="w-full border p-2 rounded" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded w-full">Enregistrer</button>
    </form>
</div>
@endsection