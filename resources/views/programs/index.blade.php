<!DOCTYPE html>
<html>
<head>
<title>Programs Offered</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{font-family:Arial;margin:0;background:#f5f7fb;}
.nav{background:#16a34a;color:white;padding:15px 40px;}
.container{max-width:1100px;margin:auto;padding:40px;}
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}
.card{
    background:white;
    padding:20px;
    border-radius:12px;
    text-align:center;
    transition:0.2s;
    border:1px solid #eee;
}
.card:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 20px rgba(0,0,0,0.05);
}
a{text-decoration:none;color:#111;}
</style>

</head>
<body>

<div class="nav">
    Programs Offered
</div>

<div class="container">

<h2>Programs Offered</h2>

<div class="grid">

@foreach($programs as $program)
<a href="/programs/{{ $program->slug }}">
    <div class="card">
        <h3>{{ $program->name }}</h3>
    </div>
</a>
@endforeach

</div>

</div>

</body>
</html>