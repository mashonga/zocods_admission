<!DOCTYPE html>
<html>
<head>
<title>Exam Boards Management</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{font-family:Arial;margin:0;background:#f5f7fb;}
.nav{
    background:#16a34a;
    color:white;
    padding:15px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    gap:12px;
    flex-wrap:wrap;
}
.nav-left{
    display:flex;
    gap:15px;
    align-items:center;
    flex-wrap:wrap;
}
.nav-left a{
    color:white;
    text-decoration:none;
    font-weight:700;
}
.container{padding:30px;max-width:1000px;margin:auto;}
.card{background:white;padding:20px;border-radius:10px;margin-bottom:20px;box-shadow:0 10px 20px rgba(0,0,0,0.05);}
input{width:100%;padding:10px;margin-bottom:10px;border:1px solid #ddd;border-radius:6px;}
button{background:#16a34a;color:white;border:none;padding:8px 12px;border-radius:6px;cursor:pointer;}
.delete-btn{background:#ff3b3b;}
.success{background:#dcfce7;padding:10px;border-radius:6px;margin-bottom:10px;color:#166534;}
.error{background:#fee2e2;padding:10px;border-radius:6px;margin-bottom:10px;color:#991b1b;}
table{width:100%;border-collapse:collapse;}
td,th{padding:10px;border-bottom:1px solid #eee;text-align:left;}
</style>

</head>
<body>

<div class="nav">
    <div class="nav-left">
        <div>Exam Boards Management</div>
        <a href="/admin/applications">Applications</a>
        <a href="/admin/programs">Programs</a>
        <a href="/admin/board-fees">Board Fees</a>
    </div>

    <form method="POST" action="/admin/logout">
        @csrf
        <button>Logout</button>
    </form>
</div>

<div class="container">

@if(session('success'))
<div class="success">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="error">
    <strong>Please fix the following:</strong>
    <ul style="margin:10px 0 0 18px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
<h3>Add Exam Board</h3>

<form method="POST" action="/admin/exam-boards">
@csrf

<input name="name" value="{{ old('name') }}" placeholder="Board name (e.g. ABMA)">
<input name="code" value="{{ old('code') }}" placeholder="Board code (e.g. ABMA)">

<button type="submit">Add Exam Board</button>

</form>
</div>

<div class="card">
<h3>All Exam Boards</h3>

<table>
<tr>
<th>Name</th>
<th>Code</th>
<th>Action</th>
</tr>

@foreach($examBoards as $examBoard)
<tr>
<td>{{ $examBoard->name }}</td>
<td>{{ $examBoard->code }}</td>
<td>
<form method="POST" action="/admin/exam-boards/{{ $examBoard->id }}/delete">
@csrf
<button type="submit" class="delete-btn">Delete</button>
</form>
</td>
</tr>
@endforeach

</table>

</div>

</div>

</body>
</html>