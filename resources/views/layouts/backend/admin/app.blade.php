<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>E-Library SMKN 3 Banjar</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
    background:#f5f5f5;
    margin:0;
}

/* layout */
.wrapper{
    display:flex;
    min-height:100vh;
}

/* sidebar */
.sidebar{
    width:270px;
    background:white;
    box-shadow:0 0 10px rgba(0,0,0,0.05);
}

/* main content */
.main-content{
    flex:1;
    display:flex;
    flex-direction:column;
    padding:30px;
}

/* isi halaman */
.page-content{
    flex:1;
}

/* header */
.header{
    background:white;
    padding:20px;
    border-radius:10px;
    margin-bottom:25px;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

</style>

</head>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


<body>

@include('layouts.backend.admin.navbar')

<div class="wrapper">

@include('layouts.backend.admin.sidebar')

<div class="main-content">

<div class="page-content">
@yield('content')
</div>

@include('layouts.backend.admin.footer')

</div>

</div>

</body>
</html>