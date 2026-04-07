<!DOCTYPE html>

<html lang="id">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Sistem Perpustakaan</title>

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Segoe UI',sans-serif;
}

body{
height:100vh;
display:flex;
justify-content:center;
align-items:center;
background:linear-gradient(135deg,#6a5cff,#9f8cff,#c6bfff,#7f7bff);
background-size:400% 400%;
animation:bgMove 12s ease infinite;
}

@keyframes bgMove{
0%{background-position:0% 50%;}
50%{background-position:100% 50%;}
100%{background-position:0% 50%;}
}

.login-container{
background:rgba(255,255,255,0.18);
backdrop-filter:blur(18px);
padding:40px;
border-radius:18px;
width:100%;
max-width:380px;
box-shadow:0 20px 45px rgba(0,0,0,0.25);
border:1px solid rgba(255,255,255,0.35);
color:white;
}

.icon{
font-size:42px;
text-align:center;
margin-bottom:10px;
}

.login-container h2{
text-align:center;
margin-bottom:4px;
font-size:24px;
}

.subtitle{
text-align:center;
font-size:13px;
margin-bottom:25px;
opacity:0.9;
}

.input-group{
position:relative;
margin-bottom:15px;
}

.input-group span{
position:absolute;
left:12px;
top:50%;
transform:translateY(-50%);
font-size:14px;
opacity:0.8;
}

.form-control{
width:100%;
padding:12px 12px 12px 35px;
border-radius:10px;
border:none;
font-size:14px;
outline:none;
}

.form-control:focus{
box-shadow:0 0 0 2px rgba(255,255,255,0.5);
}

.btn-login{
width:100%;
padding:12px;
border:none;
border-radius:10px;
background:white;
color:#6a5cff;
font-weight:600;
font-size:15px;
cursor:pointer;
transition:0.3s;
}

.btn-login:hover{
transform:translateY(-2px);
box-shadow:0 6px 15px rgba(0,0,0,0.2);
}

.text-error{
background:#ff4d4d;
padding:8px;
border-radius:8px;
font-size:13px;
margin-bottom:12px;
text-align:center;
}

.footer{
text-align:center;
font-size:12px;
margin-top:15px;
opacity:0.8;
}

</style>

</head>

<body>

<div class="login-container">

<div class="icon">📚</div>

<h2>Perpustakaan Digital</h2>
<p class="subtitle">Login menggunakan Email atau NIS</p>

@if($errors->any())
<div class="text-error">
@foreach ($errors->all() as $error)
<div>{{ $error }}</div>
@endforeach
</div>
@endif

@if(session('error'))
<div class="text-error">{{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('login.process') }}">
@csrf

<div class="input-group">
<span>👤</span>
<input type="text" name="email" class="form-control" placeholder="Email atau NIS" required>
</div>

<div class="input-group">
<span>🔒</span>
<input type="password" name="password" class="form-control" placeholder="Password" required>
</div>

<button type="submit" class="btn-login">Login</button>

</form>

<div class="footer">
Sistem Informasi Perpustakaan
</div>

</div>

</body>
</html>
