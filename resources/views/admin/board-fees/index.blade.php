<!DOCTYPE html>
<html>
<head>
<title>Board Fees Management</title>
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
}
.nav-left{
    display:flex;
    gap:15px;
}
.nav-left a{
    color:white;
    text-decoration:none;
    font-weight:700;
}
.container{padding:30px;max-width:1100px;margin:auto;}
.card{background:white;padding:20px;border-radius:10px;margin-bottom:20px;}
input,select{
    width:100%;
    padding:10px;
    margin-bottom:10px;
    border:1px solid #ddd;
    border-radius:6px;
}
button{background:#16a34a;color:white;border:none;padding:8px 12px;border-radius:6px;}
.delete-btn{background:#ff3b3b;}
.success{background:#dcfce7;padding:10px;margin-bottom:10px;}
.error{background:#fee2e2;padding:10px;margin-bottom:10px;}
table{width:100%;border-collapse:collapse;}
td,th{padding:10px;border-bottom:1px solid #eee;}
.badge-active{color:green;}
.badge-inactive{color:red;}
</style>

</head>
<body>

<div class="nav">
    <div class="nav-left">
        <div>Board Fees</div>
        <a href="/admin/applications">Applications</a>
        <a href="/admin/programs">Programs</a>
        <a href="/admin/exam-boards">Exam Boards</a>
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
    @foreach($errors->all() as $error)
        <div>{{ $error }}</div>
    @endforeach
</div>
@endif

<div class="card">
    <h3>Set Board Fee</h3>

    <p>
        Each exam board can have <strong>multiple fees</strong> based on currency (MWK, USD).
        Saving again updates that currency only.
    </p>

    <form method="POST" action="/admin/board-fees">
        @csrf

        <select name="exam_board_id">
            <option value="">Select exam board</option>
            @foreach($examBoards as $examBoard)
                <option value="{{ $examBoard->id }}">
                    {{ $examBoard->name }}
                </option>
            @endforeach
        </select>

        <input type="number" step="0.01" name="amount" placeholder="Amount">

        <select name="currency">
            <option value="MWK">MWK</option>
            <option value="USD">USD</option>
        </select>

        <select name="is_active">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>

        <button>Save Fee</button>
    </form>
</div>

<div class="card">
    <h3>All Board Fees</h3>

    <table>
        <tr>
            <th>Board</th>
            <th>Amount</th>
            <th>Currency</th>
            <th>Status</th>
            <th></th>
        </tr>

        @foreach($boardFees as $fee)
        <tr>
            <td>{{ $fee->examBoard->name }}</td>
            <td>{{ $fee->amount }}</td>
            <td>{{ $fee->currency }}</td>
            <td>
                @if($fee->is_active)
                    <span class="badge-active">Active</span>
                @else
                    <span class="badge-inactive">Inactive</span>
                @endif
            </td>
            <td>
                <form method="POST" action="/admin/board-fees/{{ $fee->id }}/delete">
                    @csrf
                    <button class="delete-btn">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach

    </table>
</div>

</div>

</body>
</html>