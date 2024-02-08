<!DOCTYPE html>
<html>
<head>
    <title>Créer une team</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-900 text-white p-8 ">


<div class="container mx-auto bg-slate-500 rounded-lg">
    <h1 class="font-bold text-3xl text-center mb-4">Insérez une team en 30 secondes !</h1>
    <form method="GET" action="{{ route('insert-team-controller') }}">
        @csrf

        <div class="form-group flex flex-col mx-96">
            <label class="mb-2" for="team">Team name</label>
            <input id="team" type="team" class="form-control mb-8 rounded-xl p-2 text-black" name="team" required>
            @if(Session::has('team_error'))
                <p class="error">{{ Session::get('team_error') }}</p>
            @endif 
            
        </div>
        <div class="flex justify-center">
            <button type="submit" class="m-auto btn btn-primary bg-blue-700 rounded-3xl px-4 py-2">Créer la team</button>
        </div>
        
    </form>
</div>

</body>
</html> 
