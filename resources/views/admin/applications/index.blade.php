<!DOCTYPE html>
<html lang="en">
<head>
<title>Admin Dashboard</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.44.0/tabler-icons.min.css">
<style>
:root {
  --color-background-primary: #ffffff;
  --color-background-secondary: #f9fafb;
  --color-background-info: #e0f2fe;
  --color-border-secondary: #e5e7eb;
  --color-border-tertiary: #f3f4f6;
  --color-text-primary: #111827;
  --color-text-secondary: #4b5563;
  --color-text-tertiary: #9ca3af;
  --color-text-info: #0284c7;
  --border-radius-md: 8px;
  --border-radius-lg: 12px;
  --font-mono: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background:#f3f4f6; display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 20px;}
a {text-decoration:none; color:inherit;}
.wrap{display:flex;height:85vh;width:100%;max-width:1200px;border:0.5px solid var(--color-border-tertiary);border-radius:var(--border-radius-lg);overflow:hidden;background:var(--color-background-primary);box-shadow: 0 10px 25px rgba(0,0,0,0.05);}
.sidebar{width:210px;flex-shrink:0;border-right:0.5px solid var(--color-border-tertiary);display:flex;flex-direction:column;background:var(--color-background-primary)}
.logo{display:flex;align-items:center;gap:9px;padding:18px 16px 14px;border-bottom:0.5px solid var(--color-border-tertiary)}
.logo-icon{width:30px;height:30px;border-radius:8px;background:#16a34a;display:flex;align-items:center;justify-content:center;color:#fff;font-size:15px}
.logo-text{font-size:11px;font-weight:500;letter-spacing:.07em;text-transform:uppercase;color:var(--color-text-secondary)}
.nav-sec{padding:14px 10px 6px}
.nav-lbl{font-size:10px;font-weight:500;letter-spacing:.1em;text-transform:uppercase;color:var(--color-text-tertiary);padding:0 7px;margin-bottom:5px}
.nav-item{display:flex;align-items:center;gap:9px;padding:8px 8px;border-radius:var(--border-radius-md);font-size:13px;color:var(--color-text-secondary);cursor:pointer;margin-bottom:1px; background: transparent; border: none; width: 100%; text-align: left; font-family: inherit;}
.nav-item:hover{background:var(--color-background-secondary);}
.nav-item i{font-size:16px;opacity:.7}
.nav-item.active{background:rgba(22,163,74,.1);color:#16a34a;font-weight:500}
.nav-item.active i{opacity:1}
.sidebar-foot{margin-top:auto;padding:12px 10px;border-top:0.5px solid var(--color-border-tertiary)}
.content{flex:1;display:flex;flex-direction:column;overflow:hidden}
.topbar{height:52px;background:#16a34a;display:flex;align-items:center;padding:0 20px;gap:14px;flex-shrink:0}
.search-bar{flex:1;max-width:320px;background:rgba(255,255,255,.18);border:0.5px solid rgba(255,255,255,.3);border-radius:var(--border-radius-md);padding:7px 12px 7px 32px;font-size:13px;color:#fff;position:relative;display:flex;align-items:center}
.search-bar i{position:absolute;left:10px;font-size:14px;color:rgba(255,255,255,.65)}
.search-bar span{color:rgba(255,255,255,.55);font-size:13px}
.topbar-right{display:flex;align-items:center;gap:10px;margin-left:auto}
.status-pill{display:flex;align-items:center;gap:6px;background:rgba(255,255,255,.18);border-radius:20px;padding:4px 11px;font-size:12px;color:#fff;font-weight:500}
.sdot{width:6px;height:6px;border-radius:50%;background:#86efac}
.notif{width:32px;height:32px;background:rgba(255,255,255,.18);border-radius:var(--border-radius-md);display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;position:relative}
.nbadge{position:absolute;top:-3px;right:-3px;background:#ef4444;color:#fff;font-size:8px;font-weight:700;width:14px;height:14px;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid #16a34a}
.user-chip{display:flex;align-items:center;gap:8px;background:rgba(255,255,255,.18);border-radius:var(--border-radius-md);padding:4px 10px 4px 5px}
.uavatar{width:26px;height:26px;border-radius:6px;background:#15803d;border:1.5px solid rgba(255,255,255,.3);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:700;color:#fff}
.uname{font-size:12px;font-weight:500;color:#fff;line-height:1.15}
.urole{font-size:10px;color:rgba(255,255,255,.65)}
.inner{flex:1;overflow-y:auto;padding:20px 22px}
.ph{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:18px}
.ph h1{font-size:18px;font-weight:500;color:var(--color-text-primary);letter-spacing:-.2px}
.ph p{font-size:12px;color:var(--color-text-secondary);margin-top:3px}
.export-btn{display:flex;align-items:center;gap:6px;background:var(--color-background-primary);border:0.5px solid var(--color-border-secondary);border-radius:var(--border-radius-md);padding:7px 13px;font-size:12.5px;font-weight:500;color:var(--color-text-primary);cursor:pointer}
.export-btn i{font-size:14px;color:var(--color-text-secondary)}
.stats{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:16px}
.scard{background:var(--color-background-secondary);border-radius:var(--border-radius-md);padding:13px 14px}
.slbl{font-size:10px;font-weight:500;text-transform:uppercase;letter-spacing:.08em;color:var(--color-text-tertiary);margin-bottom:6px}
.sval{font-size:22px;font-weight:500;color:var(--color-text-primary);line-height:1}
.ssub{font-size:11px;color:var(--color-text-tertiary);margin-top:4px;display:flex;align-items:center;gap:4px}
.idot{width:5px;height:5px;border-radius:50%;display:inline-block}
.toolbar{display:flex;align-items:center;gap:10px;margin-bottom:14px}
.tsearch{flex:1;max-width:280px;border:0.5px solid var(--color-border-tertiary);border-radius:var(--border-radius-md);padding:8px 12px 8px 30px;font-size:13px;background:var(--color-background-primary);color:var(--color-text-primary);position:relative;display:flex;align-items:center}
.tsearch i{position:absolute;left:10px;font-size:14px;color:var(--color-text-tertiary)}
.tsearch span{color:var(--color-text-tertiary);font-size:13px}
.fsel{border:0.5px solid var(--color-border-tertiary);border-radius:var(--border-radius-md);padding:7px 28px 7px 11px;font-size:12.5px;background:var(--color-background-primary);color:var(--color-text-secondary);display:flex;align-items:center;gap:5px; appearance:none; outline:none;}
.fsel i{font-size:13px}
.filter-form{display:flex; gap:10px; align-items:center; flex:1;}
.count-chip{font-size:11.5px;font-weight:500;color:var(--color-text-tertiary);background:var(--color-background-secondary);padding:3px 9px;border-radius:20px;margin-left:auto}
.tbl-wrap{border:0.5px solid var(--color-border-tertiary);border-radius:var(--border-radius-lg);overflow:hidden}
table{width:100%;border-collapse:collapse;table-layout:fixed}
thead tr{background:var(--color-background-secondary);border-bottom:0.5px solid var(--color-border-tertiary)}
th{text-align:left;padding:10px 14px;font-size:10px;font-weight:500;text-transform:uppercase;letter-spacing:.08em;color:var(--color-text-tertiary)}
td{padding:13px 14px;border-bottom:0.5px solid var(--color-border-tertiary);font-size:13px;vertical-align:middle}
tbody tr:last-child td{border-bottom:none}
.appid{font-family:var(--font-mono);font-size:11px;font-weight:500;background:var(--color-background-secondary);padding:3px 7px;border-radius:5px;color:var(--color-text-tertiary)}
.appl{display:flex;align-items:center;gap:10px}
.av{width:32px;height:32px;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:500;color:#fff;flex-shrink:0}
.an{font-size:13px;font-weight:500;color:var(--color-text-primary);line-height:1.2}
.ae{font-size:11px;color:var(--color-text-tertiary)}
.prog{font-size:12px;font-weight:500;background:var(--color-background-info);color:var(--color-text-info);padding:3px 9px;border-radius:5px;display:inline-block;white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:100%;}
.date{font-size:12.5px;color:var(--color-text-secondary)}
.badge{display:inline-flex;align-items:center;gap:5px;font-size:11.5px;font-weight:500;padding:4px 9px;border-radius:20px;white-space:nowrap}
.badge-dot{width:5px;height:5px;border-radius:50%}
.b-pend{background:#fef3c7;color:#92400e}.b-pend .badge-dot{background:#f59e0b}
.b-appr{background:#dcfce7;color:#14532d}.b-appr .badge-dot{background:#16a34a}
.b-rejt{background:#fee2e2;color:#7f1d1d}.b-rejt .badge-dot{background:#ef4444}
.b-revw{background:#dbeafe;color:#1e3a8a}.b-revw .badge-dot{background:#3b82f6}
.acts{display:flex;align-items:center;gap:6px}
.btn-view{display:inline-flex;align-items:center;gap:5px;background:#16a34a;color:#fff;border:none;border-radius:7px;padding:6px 11px;font-size:12px;font-weight:500;cursor:pointer;text-decoration:none;}
.btn-view i{font-size:13px}
.btn-ico{width:28px;height:28px;border:0.5px solid var(--color-border-tertiary);background:var(--color-background-primary);border-radius:7px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--color-text-tertiary);font-size:14px; border:none;}
.btn-ico:hover{background:var(--color-background-secondary); color:var(--color-text-primary);}
.btn-ico.delete:hover{background:#fee2e2; color:#ef4444; border-color:#fca5a5;}
.filter-btn{background:white; border:0.5px solid var(--color-border-tertiary); border-radius:var(--border-radius-md); padding:7px 13px; font-size:12.5px; font-weight:500; cursor:pointer;}
</style>
</head>
<body>
<div class="wrap">
  <aside class="sidebar">
    <div class="logo">
      <div class="logo-icon"><i class="ti ti-school" aria-hidden="true"></i></div>
      <span class="logo-text">Admin Portal</span>
    </div>
    <div class="nav-sec">
      <div class="nav-lbl">Management</div>
      <a href="/admin/programs" class="nav-item"><i class="ti ti-book" aria-hidden="true"></i>Programs</a>
      <a href="/admin/exam-boards" class="nav-item"><i class="ti ti-certificate" aria-hidden="true"></i>Exam Boards</a>
      <a href="/admin/board-fees" class="nav-item"><i class="ti ti-cash" aria-hidden="true"></i>Board Fees</a>
      <div class="nav-item active"><i class="ti ti-file-description" aria-hidden="true"></i>Applications</div>
    </div>
    <div class="sidebar-foot">
      <form method="POST" action="/admin/logout" style="width: 100%;">
          @csrf
          <button type="submit" class="nav-item" style="color: #ef4444;"><i class="ti ti-logout" aria-hidden="true" style="color: #ef4444;"></i>Logout</button>
      </form>
    </div>
  </aside>

  <div class="content">
    <div class="topbar">
      <div class="search-bar" style="position:relative">
        <i class="ti ti-search" aria-hidden="true" style="position:absolute;left:10px;font-size:14px;color:rgba(255,255,255,.6)"></i>
        <span style="padding-left:16px">Global system search…</span>
      </div>
      <div class="topbar-right">
        <div class="status-pill"><span class="sdot"></span>Systems Online</div>
        <div class="user-chip">
          <div class="uavatar">ZA</div>
          <div><div class="uname">Admin</div><div class="urole">Super User</div></div>
        </div>
      </div>
    </div>

    <div class="inner">
      <div class="ph">
        <div>
          <h1>Applications Management</h1>
          <p>Review and process student admissions applications</p>
        </div>
        <button class="export-btn"><i class="ti ti-download" aria-hidden="true"></i>Export Applications</button>
      </div>

      <div class="stats">
        <div class="scard">
          <div class="slbl">Total</div>
          <div class="sval">{{ $stats['total'] }}</div>
          <div class="ssub">All time</div>
        </div>
        <div class="scard">
          <div class="slbl">Submitted</div>
          <div class="sval" style="color:#0284c7">{{ $stats['submitted'] }}</div>
          <div class="ssub"><span class="idot" style="background:#0ea5e9"></span>New</div>
        </div>
        <div class="scard">
          <div class="slbl">Under Review</div>
          <div class="sval" style="color:#f59e0b">{{ $stats['review'] }}</div>
          <div class="ssub"><span class="idot" style="background:#f59e0b"></span>Pending</div>
        </div>
        <div class="scard">
          <div class="slbl">Approved</div>
          <div class="sval" style="color:#16a34a">{{ $stats['approved'] }}</div>
          <div class="ssub"><span class="idot" style="background:#16a34a"></span>Processed</div>
        </div>
        <div class="scard">
          <div class="slbl">Rejected</div>
          <div class="sval" style="color:#ef4444">{{ $stats['rejected'] }}</div>
          <div class="ssub"><span class="idot" style="background:#ef4444"></span>Processed</div>
        </div>
      </div>

      <div class="toolbar">
        <form method="GET" action="/admin/applications" class="filter-form">
            <select name="status" class="fsel" onchange="this.form.submit()">
                <option value="">All Statuses</option>
                <option value="Submitted" {{ request('status') == 'Submitted' ? 'selected' : '' }}>Submitted</option>
                <option value="Under Review" {{ request('status') == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <select name="program" class="fsel" onchange="this.form.submit()">
                <option value="">All Programs</option>
                @foreach($programs as $program)
                    <option value="{{ $program }}" {{ request('program') == $program ? 'selected' : '' }}>
                        {{ Str::limit($program, 30) }}
                    </option>
                @endforeach
            </select>
        </form>
        <span class="count-chip">{{ count($applications) }} applications</span>
      </div>

      <div class="tbl-wrap">
        <table>
          <colgroup>
            <col style="width:90px">
            <col style="width:220px">
            <col style="width:160px">
            <col style="width:120px">
            <col style="width:120px">
            <col style="width:110px">
          </colgroup>
          <thead>
            <tr>
              <th>App ID</th>
              <th>Applicant</th>
              <th>Program</th>
              <th>Date</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($applications as $a)
            <tr>
              <td><span class="appid">APP-{{ str_pad($a->id, 3, '0', STR_PAD_LEFT) }}</span></td>
              <td>
                  <div class="appl">
                      <div class="av" style="background:hsl({{ ($a->id * 45) % 360 }}, 60%, 45%)">
                          {{ strtoupper(substr($a->full_name, 0, 2)) }}
                      </div>
                      <div>
                          <div class="an">{{ $a->full_name }}</div>
                          <div class="ae">{{ $a->email ?: 'No email provided' }}</div>
                      </div>
                  </div>
              </td>
              <td><span class="prog" title="{{ $a->program }}">{{ $a->program }}</span></td>
              <td><span class="date">{{ $a->created_at ? $a->created_at->format('d M Y') : '—' }}</span></td>
              <td>
                  @if($a->status == 'Submitted')
                      <span class="badge" style="background:#e0f2fe; color:#0284c7"><span class="badge-dot" style="background:#0ea5e9"></span>Submitted</span>
                  @elseif($a->status == 'Under Review')
                      <span class="badge b-pend"><span class="badge-dot"></span>Under Review</span>
                  @elseif($a->status == 'Approved')
                      <span class="badge b-appr"><span class="badge-dot"></span>Approved</span>
                  @elseif($a->status == 'Rejected')
                      <span class="badge b-rejt"><span class="badge-dot"></span>Rejected</span>
                  @else
                      <span class="badge" style="background:#f3f4f6; color:#4b5563"><span class="badge-dot" style="background:#9ca3af"></span>{{ $a->status }}</span>
                  @endif
              </td>
              <td>
                  <div class="acts">
                      <a href="/admin/applications/{{ $a->id }}" class="btn-view"><i class="ti ti-eye" aria-hidden="true"></i>View</a>
                      <form method="POST" action="/admin/applications/{{ $a->id }}/delete" style="display:inline; margin:0; padding:0;">
                          @csrf
                          <button type="submit" class="btn-ico delete" title="Delete"><i class="ti ti-trash" aria-hidden="true"></i></button>
                      </form>
                  </div>
              </td>
            </tr>
            @endforeach
            
            @if(count($applications) == 0)
            <tr>
                <td colspan="6" style="text-align: center; padding: 40px; color: var(--color-text-tertiary);">
                    No applications found matching your criteria.
                </td>
            </tr>
            @endif
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
</body>
</html>