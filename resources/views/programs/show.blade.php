<!DOCTYPE html>
<html>
<head>
<title>{{ $program->name }}</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{font-family:Arial;margin:0;background:#f5f7fb;}
.container{max-width:900px;margin:auto;padding:40px;}
.card{
    background:white;
    padding:30px;
    border-radius:12px;
}
h1{color:#16a34a;}
</style>

</head>
<body>

<div class="container">

<div class="card">

<h1>{{ $program->name }}</h1>

<p><strong>Duration:</strong> {{ $program->duration ?? 'To be confirmed' }}</p>

<p>
Examination boards and fees are determined by the administration.
Fees may vary depending on currency (MWK / USD).
</p>

<a href="/apply">Apply Now</a>

</div>

</div>

</body>
</html>