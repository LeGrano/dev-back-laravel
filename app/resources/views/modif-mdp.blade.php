<!DOCTYPE html>
<html>
<head>
    <title>Modifier mdp</title>
</head>
<body>


<div class="container">
    <h1>Modify Password (Site: {{ $info->site }})</h1>
    <form method="GET" action="{{ route('valid-modif-controller', ['id' => $info->id]) }}">
        @csrf

        <div class="form-group">
            <label for="new_password">New Password</label>
            <input id="new_password" type="password" class="form-control" name="new_password" required>
            @if(Session::has('newPassword_error'))
    <p class="error">{{ Session::get('newPassword_error') }}</p>
@endif

        </div>

        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</div>

</body>
</html>
