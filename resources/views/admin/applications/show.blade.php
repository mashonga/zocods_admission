<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Details | Zomba College of Development Studies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f7fb;
            color: #1f2937;
        }

        .navbar {
            background: #0b3d91;
            color: white;
            padding: 16px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .navbar h1 {
            margin: 0;
            font-size: 20px;
        }

        .nav-actions {
            display: flex;
            gap: 14px;
            align-items: center;
            flex-wrap: wrap;
        }

        .nav-actions a {
            color: white;
            text-decoration: none;
            font-weight: 700;
        }

        .logout-form {
            margin: 0;
        }

        .logout-btn {
            background: #ff7a00;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }

        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 40px 24px 60px;
        }

        .page h2 {
            margin: 0 0 10px;
            color: #0b3d91;
            font-size: 34px;
        }

        .page p {
            margin: 0 0 24px;
            color: #4b5563;
            line-height: 1.7;
        }

        .success-box {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.05);
        }

        .card h3 {
            margin-top: 0;
            margin-bottom: 18px;
            color: #0b3d91;
            font-size: 24px;
        }

        .detail-row {
            margin-bottom: 16px;
        }

        .detail-label {
            font-size: 13px;
            font-weight: 700;
            color: #6b7280;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .detail-value {
            font-size: 16px;
            line-height: 1.6;
        }

        .status-badge {
            display: inline-block;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
        }

        .document-link {
            display: inline-block;
            background: #0b3d91;
            color: white;
            padding: 10px 14px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            margin-right: 10px;
            margin-bottom: 10px;
        }

        .status-form {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .status-form select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            background: white;
        }

        .save-btn {
            background: #ff7a00;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        @media (max-width: 900px) {
            .grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <h1>Application Details</h1>

        <div class="nav-actions">
            <a href="/admin/applications">Back to Applications</a>

            <form class="logout-form" action="/admin/logout" method="POST">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="page">
        <h2>{{ $application->full_name }}</h2>
        <p>
            Review the applicant's full details and update the application status.
        </p>

        @if (session('success'))
            <div class="success-box">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid">
            <div class="card">
                <h3>Applicant Information</h3>

                <div class="detail-row">
                    <div class="detail-label">Full Name</div>
                    <div class="detail-value">{{ $application->full_name }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Gender</div>
                    <div class="detail-value">{{ $application->gender ?: '—' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Date of Birth</div>
                    <div class="detail-value">{{ $application->date_of_birth ?: '—' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Phone</div>
                    <div class="detail-value">{{ $application->phone }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Email</div>
                    <div class="detail-value">{{ $application->email ?: '—' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Program</div>
                    <div class="detail-value">{{ $application->program }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Address</div>
                    <div class="detail-value">{{ $application->address ?: '—' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Highest Qualification</div>
                    <div class="detail-value">{{ $application->highest_qualification ?: '—' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Previous School / Institution</div>
                    <div class="detail-value">{{ $application->previous_school ?: '—' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Additional Information</div>
                    <div class="detail-value">{{ $application->message ?: '—' }}</div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Submitted At</div>
                    <div class="detail-value">{{ $application->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>

            <div class="card">
                <h3>Application Management</h3>

                <div class="detail-row">
                    <div class="detail-label">Current Status</div>
                    <div class="detail-value">
                        <span class="status-badge">{{ $application->status }}</span>
                    </div>
                </div>

                <div class="detail-row">
                    <div class="detail-label">Uploaded Documents</div>
                    <div class="detail-value">
                        @if ($application->certificate_file)
                            <a class="document-link" href="/storage/{{ $application->certificate_file }}" target="_blank">Open Certificate / Results Slip</a>
                        @endif

                        @if ($application->id_file)
                            <a class="document-link" href="/storage/{{ $application->id_file }}" target="_blank">Open ID / Passport Copy</a>
                        @endif

                        @if (!$application->certificate_file && !$application->id_file)
                            —
                        @endif
                    </div>
                </div>

                <form class="status-form" action="/admin/applications/{{ $application->id }}/status" method="POST">
                    @csrf

                    <div class="detail-row">
                        <div class="detail-label">Update Status</div>
                        <select name="status">
                            <option value="Submitted" {{ $application->status == 'Submitted' ? 'selected' : '' }}>Submitted</option>
                            <option value="Under Review" {{ $application->status == 'Under Review' ? 'selected' : '' }}>Under Review</option>
                            <option value="Approved" {{ $application->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                            <option value="Rejected" {{ $application->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <button type="submit" class="save-btn">Save Status</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>