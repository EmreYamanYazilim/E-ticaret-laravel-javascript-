<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hoşgeldin</title>
</head>

<body>
    <p>
        Merhaba {{ $user->name }} <b>Hoşgeldiniz</b>
        <br>
    </p>

    <p>doğrulama buttonuna tıklayarak Mailinizi doğrulayabilirsiniz</p>


    <hr>
    <center><a href="{{ route('verify', ['token' => $token]) }}">Mailimi Doğrula</a></center>
</body>

</html>
