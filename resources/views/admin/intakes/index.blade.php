<!DOCTYPE html>
<html>
<head>
<title>Intakes Management</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<style>
body{font-family:Arial;margin:0;background:#f5f7fb;}
.nav{background:#16a34a;color:white;padding:15px;display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;}
.nav-left{display:flex;gap:15px;align-items:center;flex-wrap:wrap;}
.nav-left a{color:white;text-decoration:none;font-weight:700;}
.container{padding:30px;max-width:1200px;margin:auto;}
.card{background:white;padding:20px;border-radius:10px;margin-bottom:20px;box-shadow:0 10px 20px rgba(0,0,0,0.05);}
input,select,textarea{width:100%;padding:10px;margin-bottom:10px;border:1px solid #ddd;border-radius:6px;background:white;}
textarea{min-height:90px;resize:vertical;}
button{background:#16a34a;color:white;border:none;padding:8px 12px;border-radius:6px;cursor:pointer;}
.delete-btn{background:#ff3b3b;}
.success{background:#dcfce7;padding:10px;border-radius:6px;margin-bottom:10px;color:#166534;}
.error{background:#fee2e2;padding:10px;border-radius:6px;margin-bottom:10px;color:#991b1b;}
table{width:100%;border-collapse:collapse;}
td,th{padding:10px;border-bottom:1px solid #eee;text-align:left;vertical-align:top;}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:12px;}
.program-box{border:1px solid #e5e7eb;border-radius:8px;padding:14px;margin-bottom:12px;}
.program-title{font-weight:700;color:#16a34a;margin-bottom:10px;}
.badge-active{color:green;font-weight:700;}
.badge-inactive{color:red;font-weight:700;}
.note{background:#eff6ff;color:#1d4ed8;padding:12px;border-radius:8px;margin-bottom:15px;line-height:1.6;}
.small-label{font-size:13px;font-weight:700;margin-bottom:6px;display:block;}
@media (max-width: 700px){.grid{grid-template-columns:1fr;}}
</style>

</head>
<body>

<div class="nav">
    <div class="nav-left">
        <div>Intakes Management</div>
        <a href="/admin/applications">Applications</a>
        <a href="/admin/programs">Programs</a>
        <a href="/admin/exam-boards">Exam Boards</a>
        <a href="/admin/board-fees">Board Fees</a>
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
    <h3>Create Intake</h3>

    <div class="note">
        Create one intake and choose the programs that belong to it. For each selected program,
        provide the required subject count and the public tuition / fee note that applicants should see.
        Board examination fees remain managed separately in the Board Fees section.
    </div>

    <form method="POST" action="/admin/intakes">
        @csrf

        <div class="grid">
            <div>
                <label class="small-label">Intake Name</label>
                <input name="name" value="{{ old('name') }}" placeholder="e.g. January - June 2026">
            </div>

            <div>
                <label class="small-label">Study Mode</label>
                <input name="study_mode" value="{{ old('study_mode', 'Online') }}" placeholder="e.g. Online">
            </div>

            <div>
                <label class="small-label">Start Month</label>
                <input name="start_month" value="{{ old('start_month') }}" placeholder="e.g. January">
            </div>

            <div>
                <label class="small-label">End Month</label>
                <input name="end_month" value="{{ old('end_month') }}" placeholder="e.g. June">
            </div>

            <div>
                <label class="small-label">Status</label>
                <select name="is_active">
                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
        </div>

        <h3 style="margin-top:24px;">Programs for this Intake</h3>

        @foreach($programs as $program)
            <div class="program-box">
                <div class="program-title">{{ $program->name }}</div>

                <div style="margin-bottom:10px;">
                    <label style="display:flex;align-items:center;gap:10px;font-weight:700;">
                        <input
                            type="checkbox"
                            name="selected_programs[]"
                            value="{{ $program->id }}"
                            {{ is_array(old('selected_programs')) && in_array($program->id, old('selected_programs')) ? 'checked' : '' }}
                            style="width:auto;margin:0;"
                        >
                        Include this program in this intake
                    </label>
                </div>

                <div class="grid">
                    <div>
                        <label class="small-label">Required Subject Count</label>
                        <input
                            type="number"
                            min="1"
                            max="20"
                            name="program_settings[{{ $program->id }}][required_subject_count]"
                            value="{{ old('program_settings.' . $program->id . '.required_subject_count') }}"
                            placeholder="e.g. 6"
                        >
                    </div>

                    <div>
                        <label class="small-label">Program Status in this Intake</label>
                        <select name="program_settings[{{ $program->id }}][is_active]">
                            <option value="1" {{ old('program_settings.' . $program->id . '.is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('program_settings.' . $program->id . '.is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="small-label">Public Tuition / Fee Note</label>
                    <textarea
                        name="program_settings[{{ $program->id }}][tuition_fee_notes]"
                        placeholder="e.g. Tuition: MWK 240,000. Installments allowed."
                    >{{ old('program_settings.' . $program->id . '.tuition_fee_notes') }}</textarea>
                </div>
            </div>
        @endforeach

        <button type="submit">Create Intake</button>
    </form>
</div>

<div class="card">
    <h3>All Intakes</h3>

    <table>
        <tr>
            <th>Name</th>
            <th>Period</th>
            <th>Study Mode</th>
            <th>Status</th>
            <th>Programs</th>
            <th>Action</th>
        </tr>

        @foreach($intakes as $intake)
        <tr>
            <td>{{ $intake->name }}</td>
            <td>{{ $intake->start_month ?: '—' }} - {{ $intake->end_month ?: '—' }}</td>
            <td>{{ $intake->study_mode }}</td>
            <td>
                @if($intake->is_active)
                    <span class="badge-active">Active</span>
                @else
                    <span class="badge-inactive">Inactive</span>
                @endif
            </td>
            <td>
                @if($intake->intakePrograms->count())
                    @foreach($intake->intakePrograms as $item)
                        <div style="margin-bottom:10px;">
                            <strong>{{ $item->program?->name ?? '—' }}</strong><br>
                            Subjects Required: {{ $item->required_subject_count ?? '—' }}<br>
                            Fee Note: {{ $item->tuition_fee_notes ?: '—' }}<br>
                            Status:
                            @if($item->is_active)
                                <span class="badge-active">Active</span>
                            @else
                                <span class="badge-inactive">Inactive</span>
                            @endif
                        </div>
                    @endforeach
                @else
                    —
                @endif
            </td>
            <td>
                <form method="POST" action="/admin/intakes/{{ $intake->id }}/delete">
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