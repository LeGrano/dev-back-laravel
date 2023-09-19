

<div class="container">
    <h1>Page de vérification</h1>
    <table>
        <thead>
            <tr>
                <th>URL</th>
                <th>Email</th>
                <th>mot de passe</th>
              
            </tr>
        </thead>
        <tbody>
            @foreach (Session::get('jsonData') as $data)
                <tr>
                    <td>{{ $data['url'] }}</td>
                    <td>{{ $data['email'] }}</td>
                    <td>{{ $data['password'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

