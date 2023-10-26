
<style>
    table {
 border-width:1px; 
 border-style:solid; 
 border-color:black;
 width:50%;
 }
td { 
 border-width:1px;
 border-style:solid; 
 border-color:red;
 width:50%;
 }
</style>
<div class="container">
<h1>Voici toutes vos informations !</h1>
    <table>
        <thead>
            <tr>
                <th>URL</th>
                <th>Login</th>
                <th>mot de passe</th>
              
            </tr>
        </thead>
        <tbody>
            <a href="{{route('dashboard')}}">Retour au dashboard</a>
            @foreach ($infos as $data)
                <tr>
                    <td>{{ $data->site }}</td>
                    <td>{{ $data->login }}</td>
                    <td>{{ $data->password }}<a href="{{route('modif-controller', ['id' => $data->id])}}">Modifier</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>