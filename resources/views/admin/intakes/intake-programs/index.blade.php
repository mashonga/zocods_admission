<!DOCTYPE html>
<html>
<head>
<title>Intake Programs Management</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{font-family:Arial;margin:0;background:#f5f7fb;}
.nav{background:#16a34a;color:white;padding:15px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;}
.nav-left{display:flex;gap:15px;align-items:center;flex-wrap:wrap;}
.nav-left a{color:white;text-decoration:none;font-weight:700;}
.container{padding:30px;max-width:1200px;margin:auto;}
.card{background:white;padding:20px;border-radius:10px;margin-bottom:20px;box-shadow:0 10px 20px rgba(0,0,0,0.05);}
input,select{width:100%;padding:10px;margin-bottom:10px;border:1px solid #ddd;border-radius:6px;background:white;}
button{background:#16a34a;color:white;border:none;padding:8px 12px;border-radius:6px;cursor:pointer;}
.delete-btn{background:#ff3b3b;}
.success{background:#dcfce7;padding:10px;border-radius:6px;margin-bottom:10px;color:#166534;}
.error{background:#fee2e2;padding:10px;border-radius:6px;margin-bottom:10px;color:#991b1b;}
table{width:100%;border-collapse:collapse;}
td,th{padding:10px;border-bottom:1px solid #eee;text-align:left;}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.badge-active{color:green;font-weight:700;}
.badge-inactive{color:red;font-weight:700;}
@media (max-width: 700px){.grid{grid-template-columns:1fr;}}
</style>

</head>
<body>

<div class="nav">
    <div class="nav-left">
        <div>Intake Programs</div>
        <a href="/admin/applications">Applications</a>
        <a href="/admin/programs">Programs</a>
        <a href="/admin/intakes">Intakes</a>
    </div>

    <form method="POST" action="/admin/logout">
        @csrf
        <button type="submit">Logout</button>
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
    <h3>Assign Program to Intake</h3>

    <form method="POST" action="/admin/intake-programs">
        @csrf

        <div class="grid">
            <div>
                <select name="intake_id">
                    <option value="">Select intake</option>
                    @foreach($intakes as $intake)
                        <option value="{{ $intake->id }}" {{ old('intake_id') == $intake->id ? 'selected' : '' }}>
                            {{ $intake->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="program_id">
                    <option value="">Select program</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                            {{ $program->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <input type="number" min="1" max="20" name="required_subject_count" value="{{ old('required_subject_count') }}" placeholder="Required subject count">
            </div>

            <div>
                <select name="is_active">
                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <button type="submit">Save Intake Program</button>
    </form>
</div>

<div class="card">
    <h3>All Intake Program Assignments</h3>

    <table>
        <tr>
            <th>Intake</th>
            <th>Program</th>
            <th>Required Subjects</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        @foreach($intakePrograms as $item)
        <tr>
            <td>{{ $item->intake?->name ?? '—' }}</td>
            <td>{{ $item->program?->name ?? '—' }}</td>
            <td>{{ $item->required_subject_count ?? '—' }}</td>
            <td>
                @if($item->is_active)
                    <span class="badge-active">Active</span>
                @else
                    <span class="badge-inactive">Inactive</span>
                @endif
            </td>
            <td>
                <form method="POST" action="/admin/intake-programs/{{ $item->id }}/delete">
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