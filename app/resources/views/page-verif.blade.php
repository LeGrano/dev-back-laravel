@if(Session::has('password'))
    <p>mot de passe : {{ Session::get('password') }}</p>
@endif