<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{font-family:Arial;margin:0;background:#f5f7fb;}
.nav{background:#0b3d91;color:white;padding:15px;display:flex;justify-content:space-between;}
.container{padding:30px;max-width:1200px;margin:auto;}
.cards{display:grid;grid-template-columns:repeat(5,1fr);gap:15px;margin-bottom:30px;}
.card{background:white;padding:20px;border-radius:10px;text-align:center;box-shadow:0 10px 20px rgba(0,0,0,0.05);}
.card h2{margin:0;font-size:28px;color:#0b3d91;}
.filters{background:white;padding:15px;border-radius:10px;margin-bottom:20px;}
table{width:100%;border-collapse:collapse;background:white;}
th,td{padding:12px;border-bottom:1px solid #eee;text-align:left;}
button{background:#ff3b3b;color:white;border:none;padding:6px 10px;border-radius:6px;cursor:pointer;}
</style>

</head>
<body>

<div class="nav">
Admin Dashboard
<form method="POST" action="/admin/logout">@csrf<button>Logout</button></form>
</div>

<div class="container">

<div class="cards">
<div class="card"><h2>{{ $stats['total'] }}</h2>Total</div>
<div class="card"><h2>{{ $stats['submitted'] }}</h2>Submitted</div>
<div class="card"><h2>{{ $stats['review'] }}</h2>Review</div>
<div class="card"><h2>{{ $stats['approved'] }}</h2>Approved</div>
<div class="card"><h2>{{ $stats['rejected'] }}</h2>Rejected</div>
</div>

<div class="filters">
<form>
<select name="program">
<option value="">All Programs</option>
<option value="Public Health" {{ request('program') == 'Public Health' ? 'selected' : '' }}>Public Health</option>
                <option value="Nutrition and Food Security" {{ request('program') == 'Nutrition and Food Security' ? 'selected' : '' }}>Nutrition and Food Security</option>
                <option value="Professional Diploma in Education" {{ request('program') == 'Professional Diploma in Education' ? 'selected' : '' }}>Professional Diploma in Education</option>
                <option value="Community Development" {{ request('program') == 'Community Development' ? 'selected' : '' }}>Community Development</option>
                <option value="Social Work" {{ request('program') == 'Social Work' ? 'selected' : '' }}>Social Work</option>
                <option value="Business Administration" {{ request('program') == 'Business Administration' ? 'selected' : '' }}>Business Administration</option>
                <option value="Human Resource Management" {{ request('program') == 'Human Resource Management' ? 'selected' : '' }}>Human Resource Management</option>
                <option value="Hotel and Hospitality Management" {{ request('program') == 'Hotel and Hospitality Management' ? 'selected' : '' }}>Hotel and Hospitality Management</option>
                <option value="ICT" {{ request('program') == 'ICT' ? 'selected' : '' }}>ICT</option>
                <option value="Environmental Science" {{ request('program') == 'Environmental Science' ? 'selected' : '' }}>Environmental Science</option>
</select>

<select name="status">
<option value="">All Status</option>
<option>Submitted</option>
<option>Under Review</option>
<option>Approved</option>
<option>Rejected</option>
</select>

<button>Filter</button>
</form>
</div>

<table>
<tr>
<th>ID</th>
<th>Name</th>
<th>Program</th>
<th>Status</th>
<th>Action</th>
</tr>

@foreach($applications as $a)
<tr>
<td>{{ $a->id }}</td>
<td>{{ $a->full_name }}</td>
<td>{{ $a->program }}</td>
<td>{{ $a->status }}</td>
<td>
<a href="/admin/applications/{{ $a->id }}">View</a>

<form method="POST" action="/admin/applications/{{ $a->id }}/delete" style="display:inline;">
@csrf
<button>Delete</button>
</form>

</td>
</tr>
@endforeach

</table>

</div>

</body>
</html>