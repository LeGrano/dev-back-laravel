<!-- resources/views/add-user.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white p-8">

    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-4 text-center">Ajouter des utilisateurs à l'équipe {{ $team->name }}</h1>
        @if(session('error'))
        <div class="bg-red-500 text-white px-4 py-2 mb-4 rounded">
            <h2>{{ session('error') }}</h2>
        </div>
        @endif
        <form action="{{ route('addUsers') }}" method="GET" class="max-w-md mx-auto">
            @csrf
            <input type="hidden" name="team_id" value="{{ $team->id }}">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-400">Utilisateurs à ajouter</label>
                @if ($availableUsers->isEmpty())
                    <div class="text-center text-gray-400">Pas d'utilisateur disponible</div>
                @else
                @foreach($availableUsers as $user)
                    <div class="flex items-center">
                        <input type="checkbox" name="user_ids[]" id="user_{{ $user->id }}" value="{{ $user->id }}" class="mr-2">
                        <label for="user_{{ $user->id }}">{{ $user->name }}</label>
                    </div>
                @endforeach
                @endif
                
            </div>

            <div class="flex items-center justify-between">
            @if ($availableUsers->isEmpty())
                <p>Pas d'utilisateur disponible</p>
            @else
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 hover:shadow">Ajouter</button>
            @endif
            </div>
        </form>
    </div>
    <div class="container mx-auto bg-slate-500 rounded-lg">
    <h1 class="font-bold text-3xl text-center mb-4">Ajoutez des mdp dans la team</h1>

    <form action="{{ route('add-team-password') }}" method="GET" class="max-w-md mx-auto">
            @csrf
            <input type="hidden" name="team_id" value="{{ $team->id }}">
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-400">mdp à ajouter</label>
                @if ($passwords->isEmpty())
                    <div class="text-center text-gray-400">Pas de mots de passe disponible</div>
                @else
                @foreach($passwords as $password)
                    <div class="flex items-center">
                        <input type="checkbox" name="passwords_ids[]" id="password_{{ $password->id }}" value="{{ $password->id }}" class="mr-2">
                        <label for="password_{{ $password->id }}">{{ $password->site }}</label>
                    </div>
                @endforeach
                @endif
                
            </div>

            <div class="flex items-center justify-between">
            @if ($passwords->isEmpty())
                <p></p>
            @else
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 hover:shadow">Ajouter</button>
            @endif
            </div>
        </form>


    <table class="w-full table-fixed bg-gray-800 rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th class="w-1/3 py-2 text-center bg-gray-700">URL</th>
                    <th class="w-1/3 py-2 text-center bg-gray-700">Login</th>
                    <th class="w-1/3 py-2 text-center bg-gray-700">Mot de passe</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($passwords as $data)
                <tr>
                    <td class="py-2 text-center border-b border-gray-700">{{ $data->site }}</td>
                    <td class="py-2 text-center border-b border-gray-700">{{ $data->login }}</td>
                    <td class="py-2 text-center border-b border-gray-700">{{ $data->password }} <a class="bg-blue-500 text-white px-2 py-1 rounded-full hover:bg-blue-700 hover:shadow" href="#">Ajouter</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
</div>
</body>

</html>
