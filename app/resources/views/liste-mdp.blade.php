<!DOCTYPE html>
<html>

<head>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-900 text-white p-8">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold mb-4 text-center">Voici toutes vos informations !</h1>
        @if(session('success_team'))
        <div class="bg-green-500 text-white px-4 py-2 mb-4 rounded">
            <h2>{{ session('success_team') }}</h2>
        </div>
        @endif
        
        <hr class="my-12 h-0.5 border-t-0 bg-neutral-100 opacity-100 dark:opacity-50" />

        <h3 class="text-3xl font-bold mb-4 text-center">Mots de passes</h3>
        @if (empty(session('infos')[0]))
                <p class="text-center">Aucun mdp trouvé.</p>
                @else
        <table class="w-full table-fixed bg-gray-800 rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th class="w-1/3 py-2 text-center bg-gray-700">URL</th>
                    <th class="w-1/3 py-2 text-center bg-gray-700">Login</th>
                    <th class="w-1/3 py-2 text-center bg-gray-700">Mot de passe</th>
                </tr>
            </thead>
            <tbody>
                @foreach (session('infos')[0] as $data)
                <tr>
                    <td class="py-2 text-center border-b border-gray-700">{{ $data->site }}</td>
                    <td class="py-2 text-center border-b border-gray-700">{{ $data->login }}</td>
                    <td class="py-2 text-center border-b border-gray-700">{{ $data->password }} <a class="bg-blue-500 text-white px-2 py-1 rounded-full hover:bg-blue-700 hover:shadow" href="{{ route('modif-controller', ['id' => $data->id]) }}">Modifier</a></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        <hr class="my-12 h-0.5 border-t-0 bg-neutral-100 opacity-100 dark:opacity-50" />
        <h3 class="text-3xl font-bold mb-4 text-center">Equipes</h3>
        @if (empty(session('infos')[1]))
            <p class="text-center">Aucun équipe trouvée.</p>
        @else
        <table class="w-full table-fixed bg-gray-800 rounded-lg overflow-hidden">
            <thead>
                <tr>
                    <th class="w-1/3 py-2 text-center bg-gray-700">Nom de l'équipe</th>
                    <th class="w-1/3 py-2 text-center bg-gray-700">Nombres de membres</th>
                </tr>
            </thead>
            <tbody>
                @foreach (session('infos')[1] as $data)
                <tr>
                    <td class="py-2 text-center border-b border-gray-700">{{ $data->name }}
                        @if(in_array($data->id,  $usersTeams))
                        <a class="bg-gray-500 text-white px-2 py-1 rounded-full hover:bg-gray-700 hover:shadow" href="{{ route('manage-team', ['id' => $data->id]) }}">Gérer</a>
                        @endif
                    </td>
                    <td class="py-2 text-center border-b border-gray-700">
                        {{ $data->users_count }}
                        @if(!in_array($data->id,  $usersTeams))
                        <a class="bg-blue-500 text-white px-2 py-1 rounded-full hover:bg-blue-700 hover:shadow" href="{{ route('joinTeam', ['id' => $data->id]) }}">Rejoindre
                        </a>
                        @else
                        <a class="bg-red-500 text-white px-2 py-1 rounded-full hover:bg-blue-700 hover:shadow" href="{{ route('leaveTeam', ['id' => $data->id]) }}">Quitter
                        </a>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>

        </div>
        <div>
            <h3 class="text-3xl font-bold mb-4 mt-16 text-center">Mots de passes par teams</h3>
            @if (empty(session('infos')[2]))
            <p class="text-center">Aucun mot de passe par équipe trouvé.</p>
            @else
            <div class="flex justify-around">
                @foreach (session('infos')[2] as $data)
                <div class="card bg-gray-600 rounded-3xl px-4 py-6 divide-y divide-solid">
                    <h4 class="font-bold text-lg">{{ $data['team']->name }}</h4>
                    <div class="mdp-list">
                        @foreach ($data['team']->passwords as $password)
                        <p>- {{ $password->site }}</p>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        </body>
        </html>

