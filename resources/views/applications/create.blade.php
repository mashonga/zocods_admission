<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply - ZOCADS Admissions</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f3f4f6;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 30px;
        }
        h1 {
            color: #1e40af;
            margin-bottom: 20px;
            font-size: 24px;
        }
        .fee-box {
            background: #f0fdf4;
            border-left: 4px solid #22c55e;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .fee-amount {
            font-size: 28px;
            font-weight: bold;
            color: #16a34a;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: 600;
            margin-bottom: 5px;
            color: #374151;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 14px;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }
        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }
        .alert {
            padding: 12px 16px;
            border-radius: 6px;
            margin-bottom: 15px;
        }
        .alert-error {
            background: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        .alert-success {
            background: #dcfce7;
            border: 1px solid #bbf7d0;
            color: #166534;
        }
        .row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #22c55e;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        .btn-submit:hover {
            background: #16a34a;
        }
        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
        .checkbox-group {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin: 15px 0;
        }
        .checkbox-group input {
            width: auto;
            margin-top: 3px;
        }
        .checkbox-group label {
            font-weight: normal;
            font-size: 14px;
        }
        @media (max-width: 640px) {
            .row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎓 Apply for Admission</h1>

        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <ul style="list-style: none; padding: 0;">
                    @foreach($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Fee Summary -->
        <div class="fee-box">
            <p style="font-weight: 600; color: #166534;">💳 Application Fee</p>
            <p class="fee-amount">{{ $currency ?? 'MWK' }} {{ number_format($applicationFee ?? 500, 2) }}</p>
            <p style="color: #6b7280; font-size: 14px;">Pay this fee to submit your application</p>
        </div>

        <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data" id="applicationForm">
            @csrf

            <!-- Personal Information -->
            <h2 style="color: #1f2937; font-size: 18px; margin: 20px 0 15px; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">Personal Information</h2>

            <div class="row">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" required>
                    @error('full_name')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender">
                        <option value="">Select</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Date of Birth</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
                </div>
                <div class="form-group">
                    <label>Marital Status</label>
                    <select name="marital_status">
                        <option value="">Select</option>
                        <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Divorced" {{ old('marital_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                        <option value="Widowed" {{ old('marital_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                    </select>
                </div>
            </div>

            <!-- Contact Information -->
            <h2 style="color: #1f2937; font-size: 18px; margin: 20px 0 15px; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">Contact Information</h2>

            <div class="row">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email') }}">
                    @error('email')<div class="error">{{ $message }}</div>@enderror
                </div>
                <div class="form-group">
                    <label>Phone Number *</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required>
                    @error('phone')<div class="error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Nationality</label>
                    <input type="text" name="nationality" value="{{ old('nationality') }}">
                </div>
                <div class="form-group">
                    <label>District</label>
                    <input type="text" name="district" value="{{ old('district') }}">
                </div>
            </div>

            <div class="form-group">
                <label>Address</label>
                <textarea name="address" rows="2">{{ old('address') }}</textarea>
            </div>

            <!-- Program Selection -->
            <h2 style="color: #1f2937; font-size: 18px; margin: 20px 0 15px; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">Program Selection</h2>

            <div class="form-group">
                <label>Select Program *</label>
                <select name="program" required>
                    <option value="">Choose a program...</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->name }}" {{ old('program') == $program->name ? 'selected' : '' }}>
                            {{ $program->name }}
                        </option>
                    @endforeach
                </select>
                @error('program')<div class="error">{{ $message }}</div>@enderror
            </div>

            <!-- Academic Information -->
            <h2 style="color: #1f2937; font-size: 18px; margin: 20px 0 15px; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">Academic Information</h2>

            <div class="row">
                <div class="form-group">
                    <label>Highest Qualification</label>
                    <input type="text" name="highest_qualification" value="{{ old('highest_qualification') }}">
                </div>
                <div class="form-group">
                    <label>Previous School</label>
                    <input type="text" name="previous_school" value="{{ old('previous_school') }}">
                </div>
            </div>

            <div class="row">
                <div class="form-group">
                    <label>Exam Board</label>
                    <input type="text" name="exam_board" value="{{ old('exam_board') }}">
                </div>
                <div class="form-group">
                    <label>Other Qualifications</label>
                    <input type="text" name="other_qualifications" value="{{ old('other_qualifications') }}">
                </div>
            </div>

            <!-- Documents -->
            <h2 style="color: #1f2937; font-size: 18px; margin: 20px 0 15px; border-bottom: 2px solid #e5e7eb; padding-bottom: 8px;">Documents</h2>

            <div class="row">
                <div class="form-group">
                    <label>Certificate (PDF/JPG/PNG)</label>
                    <input type="file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png">
                    @error('certificate_file')<div class="error">{{ $message }}</div>@enderror
                    <small style="color: #6b7280;">Max 5MB</small>
                </div>
                <div class="form-group">
                    <label>ID/Passport (PDF/JPG/PNG)</label>
                    <input type="file" name="id_file" accept=".pdf,.jpg,.jpeg,.png">
                    @error('id_file')<div class="error">{{ $message }}</div>@enderror
                    <small style="color: #6b7280;">Max 5MB</small>
                </div>
            </div>

            <!-- Terms -->
            <div class="checkbox-group">
                <input type="checkbox" name="agreed" value="1" {{ old('agreed') ? 'checked' : '' }} required>
                <label>
                    I agree to the terms and conditions and confirm that all information provided is accurate
                </label>
            </div>
            @error('agreed')<div class="error">{{ $message }}</div>@enderror

            <!-- Submit Button -->
            <button type="submit" class="btn-submit" id="submitBtn">
                💳 Pay {{ $currency ?? 'MWK' }} {{ number_format($applicationFee ?? 500, 2) }} & Submit Application
            </button>
        </form>
    </div>

    <script>
        document.getElementById('applicationForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            btn.disabled = true;
            btn.innerHTML = '⏳ Processing... Please wait';
        });
    </script>
</body>
</html>
