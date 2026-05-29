<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Apply | Zomba College of Development Studies</title>
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

        a {
            text-decoration: none;
        }

        .navbar {
            background: #16a34a;
            color: white;
            padding: 14px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand img {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 50%;
            background: white;
            border: 2px solid rgba(255,255,255,0.35);
        }

        .brand-text h1 {
            margin: 0;
            font-size: 18px;
            line-height: 1.2;
        }

        .brand-text p {
            margin: 3px 0 0;
            font-size: 12px;
            color: #dcfce7;
        }

        .nav-links {
            display: flex;
            gap: 18px;
            flex-wrap: wrap;
            align-items: center;
        }

        .nav-links a {
            color: white;
            font-weight: 600;
            font-size: 15px;
        }

        .page-header {
            max-width: 1150px;
            margin: 0 auto;
            padding: 50px 40px 24px;
        }

        .page-header h2 {
            margin: 0 0 12px;
            font-size: 42px;
            color: #16a34a;
        }

        .page-header p {
            margin: 0;
            max-width: 760px;
            line-height: 1.8;
            color: #4b5563;
            font-size: 17px;
        }

        .layout {
            max-width: 1150px;
            margin: 0 auto;
            padding: 10px 40px 80px;
            display: grid;
            grid-template-columns: 0.85fr 1.15fr;
            gap: 24px;
        }

        .panel,
        .form-card {
            background: white;
            border-radius: 18px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.05);
        }

        .panel {
            padding: 28px;
            height: fit-content;
        }

        .panel h3 {
            margin-top: 0;
            color: #16a34a;
            font-size: 24px;
        }

        .panel ul {
            margin: 0;
            padding-left: 20px;
        }

        .panel li {
            margin-bottom: 13px;
            line-height: 1.6;
        }

        .form-card {
            padding: 30px;
        }

        .form-card h3 {
            margin-top: 0;
            margin-bottom: 22px;
            color: #16a34a;
            font-size: 28px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .full-width {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            font-weight: 700;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            font-size: 15px;
            background: white;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        .submit-btn {
            background: #ff7a00;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 15px 24px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }

        .submit-btn:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
            color: #64748b;
        }

        .success-box {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #86efac;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .error-box {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .footer {
            background: #0f172a;
            color: white;
            padding: 34px 40px;
        }

        .footer-inner {
            max-width: 1150px;
            margin: 0 auto;
        }

        @media (max-width: 950px) {
            .layout,
            .form-grid {
                grid-template-columns: 1fr;
            }

            .navbar,
            .page-header,
            .layout,
            .footer {
                padding-left: 20px;
                padding-right: 20px;
            }

            .page-header h2 {
                font-size: 32px;
            }
        }
    </style>
</head>
<body>

    <div class="navbar">
        <div class="brand">
            <img src="/images/logo.png" alt="College Logo">
            <div class="brand-text">
                <h1>Zomba College of Development Studies</h1>
                <p>Transforming your dreams into actions</p>
            </div>
        </div>

        <div class="nav-links">
            <a href="/">Home</a>
            <a href="/apply">Apply</a>
        </div>
    </div>

    <div class="page-header">
        <h2>Online Application Form</h2>
        <p>
            Complete the form below to apply for admission. No account is required.
            Fill in your information correctly and upload the necessary supporting documents.
        </p>
    </div>

    <div class="layout">
        <div class="panel">
            <h3>Application Notes</h3>
            <ul>
                <li>Choose the correct program before submitting the form.</li>
                <li>Use an active phone number for communication.</li>
                <li>Provide accurate academic details.</li>
                <li>Upload clear and readable supporting documents.</li>
                <li>The college administration will review all applications.</li>
            </ul>
        </div>

        <div class="form-card">
            <h3>Applicant Details</h3>

            @if (session('success'))
                <div class="success-box">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-box">
                    <strong>Please fix the following errors:</strong>
                    <ul style="margin: 10px 0 0 18px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="/apply" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-grid">
                    <div>
                        <label for="full_name">Full Name</label>
                        <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" placeholder="Enter full name" required>
                    </div>

                    <div>
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="">Select gender</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>

                    <div>
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                    </div>

                    <div>
                        <label for="marital_status">Marital Status</label>
                        <select id="marital_status" name="marital_status" required>
                            <option value="">Select status</option>
                            <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Divorced" {{ old('marital_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="Widowed" {{ old('marital_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                        </select>
                    </div>

                    <div>
                        <label for="nationality">Nationality</label>
                        <input type="text" id="nationality" name="nationality" value="{{ old('nationality') }}" placeholder="Enter nationality" required>
                    </div>

                    <div>
                        <label for="district">Home District</label>
                        <input type="text" id="district" name="district" value="{{ old('district') }}" placeholder="Enter home district" required>
                    </div>

                    <div>
                        <label for="phone">Phone Number</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" required>
                    </div>

                    <div>
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Enter email address" required>
                    </div>

                    <div>
                        <label for="program">Program Applying For</label>
                        <select id="program" name="program" required>
                            <option value="">Select a program</option>
                            @foreach ($programs as $program)
                                <option value="{{ $program->name }}" {{ old('program') == $program->name ? 'selected' : '' }}>{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="full-width">
                        <label for="address">Home Address</label>
                        <textarea id="address" name="address" placeholder="Enter home address" required>{{ old('address') }}</textarea>
                    </div>

                    <div class="full-width">
                        <label for="postal_address">Postal Address</label>
                        <textarea id="postal_address" name="postal_address" placeholder="Enter postal address" required>{{ old('postal_address') }}</textarea>
                    </div>

                    <div>
                        <label for="occupation">Occupation</label>
                        <input type="text" id="occupation" name="occupation" value="{{ old('occupation') }}" placeholder="Enter your occupation" required>
                    </div>

                    <div>
                        <label for="employer">Employer</label>
                        <input type="text" id="employer" name="employer" value="{{ old('employer') }}" placeholder="Enter employer name (if applicable)">
                    </div>

                    <div>
                        <label for="sponsor">Sponsor</label>
                        <input type="text" id="sponsor" name="sponsor" value="{{ old('sponsor') }}" placeholder="Who is sponsoring your education?" required>
                    </div>

                    <div>
                        <label for="sponsor_phone">Sponsor Phone</label>
                        <input type="text" id="sponsor_phone" name="sponsor_phone" value="{{ old('sponsor_phone') }}" placeholder="Sponsor's phone number" required>
                    </div>

                    <div>
                        <label for="highest_qualification">Highest Qualification</label>
                        <input type="text" id="highest_qualification" name="highest_qualification" value="{{ old('highest_qualification') }}" placeholder="Enter highest qualification" required>
                    </div>

                    <div>
                        <label for="exam_board">Exam Board</label>
                        <select id="exam_board" name="exam_board" required>
                            <option value="">Select an exam board</option>
                            @php
                                $boards = \App\Models\ExamBoard::orderBy('name')->get();
                            @endphp
                            @foreach($boards as $board)
                                <option value="{{ $board->name }}" {{ old('exam_board') == $board->name ? 'selected' : '' }}>{{ $board->name }}</option>
                            @endforeach
                            <option value="Other" {{ old('exam_board') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="full-width">
                        <label for="other_qualifications">Other Qualifications</label>
                        <textarea id="other_qualifications" name="other_qualifications" placeholder="List any other qualifications" required>{{ old('other_qualifications') }}</textarea>
                    </div>

                    <div>
                        <label for="previous_school">Previous School / Institution</label>
                        <input type="text" id="previous_school" name="previous_school" value="{{ old('previous_school') }}" placeholder="Enter previous school or institution" required>
                    </div>

                    <div>
                        <label for="certificate_file">Certificate / Results Slip</label>
                        <input type="file" id="certificate_file" name="certificate_file" required>
                    </div>

                    <div>
                        <label for="id_file">National ID / Passport Copy</label>
                        <input type="file" id="id_file" name="id_file" required>
                    </div>

                    <div class="full-width">
                        <label for="message">Additional Information</label>
                        <textarea id="message" name="message" placeholder="Optional extra details">{{ old('message') }}</textarea>
                    </div>

                    <div class="full-width" style="margin-top: 10px;">
                        <label style="display: flex; align-items: center; gap: 10px; font-weight: normal; cursor: pointer;">
                            <input type="checkbox" id="agreed" name="agreed" value="1" style="width: auto; height: 18px; margin: 0;" required onchange="document.getElementById('submit-btn').disabled = !this.checked;">
                            I declare that the information provided is true and correct.
                        </label>
                    </div>

                    <div class="full-width">
                        <button type="submit" id="submit-btn" class="submit-btn" disabled>Submit Application</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <footer class="footer">
        <div class="footer-inner">
            Zomba College of Development Studies
        </div>
    </footer>

</body>
</html>