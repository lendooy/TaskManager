@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto bg-white p-6 rounded-lg shadow">
    <h2 class="text-xl font-bold mb-4">Éditer l'Utilisateur : {{ $user->name }}</h2>
    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Nom</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border p-2 rounded" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border p-2 rounded" required>
        </div>
        
        <div class="mb-4">
            <label class="block text-gray-700 mb-2">Mot de passe (laisser vide si inchangé)</label>
            <input type="password" name="password" class="w-full border p-2 rounded">
        </div>
        
        <div class="mb-6">
            <label class="block text-gray-700 mb-2">Rôle</label>
            <select name="role_id" class="w-full border p-2 rounded" required>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="flex justify-end gap-2">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 border rounded text-gray-600">Annuler</a>
            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Mettre à jour</button>
        </div>
    </form>
</div>
@endsection