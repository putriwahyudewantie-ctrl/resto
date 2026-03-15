<!DOCTYPE html>
<html>
<head>

<title>Sistem Booking Restoran</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

<style>

body{
margin:0;
font-family: 'Segoe UI', sans-serif;
background:#f5f1ea;
}

/* SIDEBAR */

.sidebar{
position:fixed;
width:230px;
height:100vh;
background:#3e2723;
padding:25px;
color:white;
}

.sidebar h4{
margin-bottom:30px;
font-weight:bold;
}

.sidebar a{
display:block;
color:#f5f5f5;
text-decoration:none;
padding:10px;
border-radius:8px;
margin-bottom:10px;
transition:0.3s;
}

.sidebar a:hover{
background:#6d4c41;
}

/* CONTENT */

.content{
margin-left:250px;
padding:30px;
}

/* CARD */

.card{
border:none;
border-radius:15px;
box-shadow:0 6px 15px rgba(0,0,0,0.08);
}

/* TABLE */

table{
background:white;
border-radius:10px;
overflow:hidden;
}

/* BUTTON */

.btn-primary{
background:#6d4c41;
border:none;
}

.btn-primary:hover{
background:#4e342e;
}

</style>

</head>

<body>

<div class="sidebar">

<h4>🍽️ Resto App</h4>

<a href="/dashboard">🏠 Dashboard</a>
<a href="/booking">📅 Booking</a>
<a href="/menu">🍔 Menu</a>

</div>

<div class="content">

@yield('content')

</div>

</body>
</html>
