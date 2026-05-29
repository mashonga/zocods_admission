<!DOCTYPE html>
<html>
<head>
<title>Programs Management</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{font-family:Arial;margin:0;background:#f5f7fb;color:#1f2937;}
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
.container{padding:30px;max-width:1200px;margin:auto;}
.card{
    background:white;
    padding:20px;
    border-radius:12px;
    margin-bottom:20px;
    box-shadow:0 10px 20px rgba(0,0,0,0.05);
}
.grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:14px;
}
.full-width{
    grid-column:1 / -1;
}
input,textarea{
    width:100%;
    padding:12px;
    margin-bottom:10px;
    border:1px solid #ddd;
    border-radius:8px;
    background:white;
    font-family:inherit;
    font-size:14px;
}
textarea{
    min-height:110px;
    resize:vertical;
}
button{
    background:#16a34a;
    color:white;
    border:none;
    padding:10px 14px;
    border-radius:8px;
    cursor:pointer;
    font-weight:700;
}
.delete-btn{background:#ff3b3b;}
.success{
    background:#dcfce7;
    padding:12px;
    border-radius:8px;
    margin-bottom:14px;
    color:#166534;
}
.error{
    background:#fee2e2;
    padding:12px;
    border-radius:8px;
    margin-bottom:14px;
    color:#991b1b;
}
table{
    width:100%;
    border-collapse:collapse;
}
td,th{
    padding:12px 10px;
    border-bottom:1px solid #eee;
    text-align:left;
    vertical-align:top;
}
.small{
    color:#6b7280;
    font-size:13px;
    line-height:1.6;
}
@media (max-width: 800px){
    .grid{grid-template-columns:1fr;}
}
</style>
</head>
<body>

<div class="nav">
    <div class="nav-left">
        <div>Programs Management</div>
        <a href="/admin/applications">Applications</a>
        <a href="/admin/exam-boards">Exam Boards</a>
        <a href="/admin/board-fees">Board Fees</a>
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
    <h3 style="margin-top:0;color:#16a34a;">Add Program</h3>

    <form method="POST" action="/admin/programs">
        @csrf

        <div class="grid">
            <div>
                <input name="name" value="{{ old('name') }}" placeholder="Program name">
            </div>

            <div>
                <input name="duration" value="{{ old('duration') }}" placeholder="Duration (e.g. 2 Years)">
            </div>

            <div class="full-width">
                <textarea name="introduction" placeholder="Program introduction">{{ old('introduction') }}</textarea>
            </div>

            <div class="full-width">
                <textarea name="entry_requirements" placeholder="Entry requirements">{{ old('entry_requirements') }}</textarea>
            </div>

            <div>
                <textarea name="mode_of_delivery" placeholder="Mode of delivery">{{ old('mode_of_delivery') }}</textarea>
            </div>

            <div>
                <textarea name="duration_details" placeholder="Duration details">{{ old('duration_details') }}</textarea>
            </div>

            <div class="full-width">
                <textarea name="module_summary" placeholder="Module summary">{{ old('module_summary') }}</textarea>
            </div>

            <div>
                <textarea name="qualification_levels" placeholder="Qualification levels">{{ old('qualification_levels') }}</textarea>
            </div>

            <div>
                <textarea name="assessment_details" placeholder="Assessment details">{{ old('assessment_details') }}</textarea>
            </div>

            <div>
                <textarea name="grading_system" placeholder="Grading system">{{ old('grading_system') }}</textarea>
            </div>

            <div>
                <textarea name="progression_details" placeholder="Progression details">{{ old('progression_details') }}</textarea>
            </div>

            <div class="full-width">
                <textarea name="field_practicals" placeholder="Field practicals / attachments / internship details">{{ old('field_practicals') }}</textarea>
            </div>
        </div>

        <button type="submit">Add Program</button>
    </form>
</div>

<div class="card">
    <h3 style="margin-top:0;color:#16a34a;">All Programs</h3>

    <table>
        <tr>
            <th>Name</th>
            <th>Duration</th>
            <th>Details</th>
            <th>Action</th>
        </tr>

        @foreach($programs as $program)
        <tr>
            <td>{{ $program->name }}</td>
            <td>{{ $program->duration ?? '—' }}</td>
            <td>
                <div class="small">
                    <strong>Introduction:</strong> {{ $program->introduction ? \Illuminate\Support\Str::limit($program->introduction, 80) : '—' }}<br>
                    <strong>Entry Requirements:</strong> {{ $program->entry_requirements ? \Illuminate\Support\Str::limit($program->entry_requirements, 80) : '—' }}<br>
                    <strong>Mode:</strong> {{ $program->mode_of_delivery ? \Illuminate\Support\Str::limit($program->mode_of_delivery, 60) : '—' }}
                </div>
            </td>
            <td>
                <form method="POST" action="/admin/programs/{{ $program->id }}/delete">
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