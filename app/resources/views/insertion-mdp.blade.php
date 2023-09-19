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

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        @if(Session::has('email_error'))
            <p class="error">{{ Session::get('email_error') }}</p>
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
