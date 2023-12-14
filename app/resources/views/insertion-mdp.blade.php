<!DOCTYPE html>
<html>
<head>
    <title>Formulaire</title>
</head>
<body>
    <h1>Insertion de mot de passe</h1>

    <form method="GET" action="{{ route('form.post') }}">
        @csrf

        <label for="url">URL :</label>
        <input type="text" name="url" id="url" value="{{ old('url') }}" required>
        @if(Session::has('url_error'))
            <p>{{ Session::get('url_error') }}</p>
        @endif

        <br>

        <label for="login">login :</label>
        <input type="login" name="login" id="login" value="{{ old('login') }}" required>
        @if(Session::has('login_error'))
            <p class="error">{{ Session::get('login_error') }}</p>

        @endif

        <br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" id="password" required>
        @if(Session::has('password_error'))
            <p class="error">{{ Session::get('password_error') }}</p>
        @endif

        <br>

        <button type="submit">Envoyer</button>
    </form>
</body>
</html>
