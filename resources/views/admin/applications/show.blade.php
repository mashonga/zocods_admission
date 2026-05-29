<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Details | Admin Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4CAF50;
            --primary-dark: #388E3C;
            --secondary: #2196F3;
            --danger: #EF4444;
            --warning: #F59E0B;
            --text-main: #1F2937;
            --text-muted: #6B7280;
            --bg-main: #F3F4F6;
            --bg-card: #FFFFFF;
            --border: #E5E7EB;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--bg-main);
            color: var(--text-main);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        .navbar {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border);
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .navbar h1 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .nav-actions {
            display: flex;
            gap: 16px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border-radius: 8px;
            font-size: 0.875rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s;
            border: 1px solid transparent;
        }

        .btn-outline {
            background: var(--bg-card);
            border-color: var(--border);
            color: var(--text-main);
        }

        .btn-outline:hover {
            background: var(--bg-main);
        }

        .btn-danger {
            background: var(--bg-card);
            border-color: var(--border);
            color: var(--danger);
        }

        .btn-danger:hover {
            background: #FEF2F2;
            border-color: #FCA5A5;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .logout-form {
            margin: 0;
        }

        .page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 24px 60px;
        }

        .header-section {
            margin-bottom: 32px;
        }

        .header-section h2 {
            margin: 0 0 8px;
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--text-main);
        }

        .header-section p {
            margin: 0;
            color: var(--text-muted);
            font-size: 1rem;
        }

        .success-box {
            background: #ECFDF5;
            color: #065F46;
            border: 1px solid #A7F3D0;
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            align-items: start;
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }

        .card-header {
            margin-bottom: 24px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .card-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px 16px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-item.full-width {
            grid-column: 1 / -1;
        }

        .detail-label {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .detail-value {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-main);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-badge.submitted { background: #E0F2FE; color: #0369A1; }
        .status-badge.under-review { background: #FEF3C7; color: #B45309; }
        .status-badge.approved { background: #DCFCE7; color: #15803D; }
        .status-badge.rejected { background: #FEE2E2; color: #B91C1C; }

        .document-link {
            display: flex;
            align-items: center;
            gap: 8px;
            background: var(--bg-main);
            color: var(--text-main);
            padding: 12px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 12px;
            border: 1px solid var(--border);
            transition: all 0.2s;
        }

        .document-link:hover {
            border-color: var(--primary);
            background: #F0FDF4;
            color: var(--primary-dark);
        }

        .document-link svg {
            width: 20px;
            height: 20px;
            color: var(--text-muted);
        }

        .document-link:hover svg {
            color: var(--primary);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 8px;
        }

        .form-select {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 0.875rem;
            color: var(--text-main);
            background-color: var(--bg-card);
            outline: none;
            transition: border-color 0.2s;
            font-family: inherit;
        }

        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        .save-btn {
            width: 100%;
        }

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
            }
            .details-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>Admin Portal</h1>

        <div class="nav-actions">
            <a href="/admin/applications" class="btn btn-outline">Back to Applications</a>

            <form class="logout-form" action="/admin/logout" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    <div class="page">
        <div class="header-section">
            <h2>{{ $application->full_name }}</h2>
            <p>Review the applicant's full details and update the application status.</p>
        </div>

        @if (session('success'))
            <div class="success-box">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid">
            <div class="card">
                <div class="card-header">
                    <h3>Applicant Information</h3>
                </div>

                <div class="details-grid">
                    <div class="detail-item">
                        <div class="detail-label">Full Name</div>
                        <div class="detail-value">{{ $application->full_name }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Program</div>
                        <div class="detail-value">{{ $application->program }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Email</div>
                        <div class="detail-value">{{ $application->email ?: '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Phone</div>
                        <div class="detail-value">{{ $application->phone }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Gender</div>
                        <div class="detail-value">{{ $application->gender ?: '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Date of Birth</div>
                        <div class="detail-value">{{ $application->date_of_birth ? $application->date_of_birth->format('d M Y') : '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Nationality</div>
                        <div class="detail-value">{{ $application->nationality ?: '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">District / Region</div>
                        <div class="detail-value">{{ $application->district ?: '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Marital Status</div>
                        <div class="detail-value">{{ $application->marital_status ?: '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Occupation</div>
                        <div class="detail-value">{{ $application->occupation ?: '—' }}</div>
                    </div>
                    <div class="detail-item full-width">
                        <div class="detail-label">Home Address</div>
                        <div class="detail-value">{{ $application->address ?: '—' }}</div>
                    </div>
                    <div class="detail-item full-width">
                        <div class="detail-label">Postal Address</div>
                        <div class="detail-value">{{ $application->postal_address ?: '—' }}</div>
                    </div>

                    <div class="detail-item full-width" style="margin-top: 16px; border-top: 1px solid var(--border); padding-top: 16px;">
                        <h4 style="font-size: 1rem; color: var(--text-main); margin-bottom: 16px;">Education & Qualifications</h4>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Highest Qualification</div>
                        <div class="detail-value">{{ $application->highest_qualification ?: '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Examination Board</div>
                        <div class="detail-value">{{ $application->exam_board ?: '—' }}</div>
                    </div>
                    <div class="detail-item full-width">
                        <div class="detail-label">Previous School / Institution</div>
                        <div class="detail-value">{{ $application->previous_school ?: '—' }}</div>
                    </div>
                    <div class="detail-item full-width">
                        <div class="detail-label">Other Qualifications</div>
                        <div class="detail-value">{{ $application->other_qualifications ?: '—' }}</div>
                    </div>

                    <div class="detail-item full-width" style="margin-top: 16px; border-top: 1px solid var(--border); padding-top: 16px;">
                        <h4 style="font-size: 1rem; color: var(--text-main); margin-bottom: 16px;">Sponsorship Details</h4>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Sponsor</div>
                        <div class="detail-value">{{ $application->sponsor ?: '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Sponsor Phone</div>
                        <div class="detail-value">{{ $application->sponsor_phone ?: '—' }}</div>
                    </div>
                    <div class="detail-item full-width">
                        <div class="detail-label">Employer</div>
                        <div class="detail-value">{{ $application->employer ?: '—' }}</div>
                    </div>

                    <div class="detail-item full-width" style="margin-top: 16px; border-top: 1px solid var(--border); padding-top: 16px;">
                        <h4 style="font-size: 1rem; color: var(--text-main); margin-bottom: 16px;">Additional Information</h4>
                    </div>

                    <div class="detail-item full-width">
                        <div class="detail-label">Message / Additional Info</div>
                        <div class="detail-value">{{ $application->message ?: '—' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Declaration Accepted</div>
                        <div class="detail-value">{{ $application->agreed ? 'Yes' : 'No' }}</div>
                    </div>
                    <div class="detail-item">
                        <div class="detail-label">Submitted At</div>
                        <div class="detail-value">{{ $application->created_at->format('d M Y, H:i') }}</div>
                    </div>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div class="card">
                    <div class="card-header">
                        <h3>Status Management</h3>
                    </div>

                    <div class="form-group" style="margin-bottom: 24px;">
                        <label>Current Status</label>
                        @php
                            $statusClass = 'submitted';
                            if ($application->status == 'Under Review') $statusClass = 'under-review';
                            if ($application->status == 'Approved') $statusClass = 'approved';
                            if ($application->status == 'Rejected') $statusClass = 'rejected';
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ $application->status }}
                        </span>
                    </div>

                    <form action="/admin/applications/{{ $application->id }}/status" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="status">Update Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="Submitted" {{ $application->status == 'Submitted' ? 'selected' : '' }}>Submitted</option>
                                <option value="Under Review" {{ $application->status == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                                <option value="Approved" {{ $application->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                <option value="Rejected" {{ $application->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary save-btn">Save Status</button>
                    </form>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3>Uploaded Documents</h3>
                    </div>

                    <div style="display: flex; flex-direction: column;">
                        @if ($application->certificate_file)
                            <a class="document-link" href="/storage/{{ $application->certificate_file }}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                Certificate / Results Slip
                            </a>
                        @endif

                        @if ($application->id_file)
                            <a class="document-link" href="/storage/{{ $application->id_file }}" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                ID / Passport Copy
                            </a>
                        @endif

                        @if (!$application->certificate_file && !$application->id_file)
                            <p style="color: var(--text-muted); font-size: 0.875rem; text-align: center; padding: 16px 0;">No documents uploaded</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>