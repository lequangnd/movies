<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div style="width:600px; margin: 0 auto;">
        <div style="text-align:center;">
            <h2>Xin chào: {{$user->name}}</h2>
            <p>Email này giúp bạn kích hoạt tài khoản</p>
            <p>Vui lòng click vào link dưới đây kích hoạt tài khoản</p>
            <p><a href="{{route('actived_login',['id'=>$user->id,'token'=>$user->token])}}" style="display:inline-block; background: green; color:#fff; padding: 7px 25px; font-weight:bold">Kích hoạt</a></p>
        </div>
    </div>
</body>

</html>