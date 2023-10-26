<!DOCTYPE html>
<html>
<head>
    <title>Créer une team</title>
</head>
<body>


<div class="container">
    <h1>Formulaire team</h1>
    <form method="GET" action="{{ route('insert-team-controller') }}">
        @csrf

        <div class="form-group">
            <label for="team">Team name</label>
            <input id="team" type="team" class="form-control" name="team" required>
            @if(Session::has('team_error'))
                <p class="error">{{ Session::get('team_error') }}</p>
            @endif

        </div>

        <button type="submit" class="btn btn-primary">Créer la team</button>
    </form>
</div>

</body>
</html> 
