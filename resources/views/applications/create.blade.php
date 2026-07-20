<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .navbar { background: #16a34a; color: white; padding: 14px 40px; display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap; position: sticky; top: 0; z-index: 1000; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .brand { display: flex; align-items: center; gap: 14px; }
        .brand img { width: 56px; height: 56px; object-fit: cover; border-radius: 50%; background: white; border: 2px solid rgba(255,255,255,0.35); }
        .brand-text h1 { margin: 0; font-size: 18px; line-height: 1.2; font-family: Arial, sans-serif; font-weight: bold; }
        .brand-text p { margin: 3px 0 0; font-size: 12px; color: #dcfce7; font-family: Arial, sans-serif; }
        .nav-links { display: flex; gap: 20px; flex-wrap: wrap; align-items: center; font-family: Arial, sans-serif; }
        .nav-links a { color: white; font-weight: 600; font-size: 15px; text-decoration: none; }
        .nav-apply { background: #ff7a00; color: white !important; padding: 10px 18px; border-radius: 8px; box-shadow: 0 4px 12px rgba(255,122,0,0.3); }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
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
        </div>
    </div>
    <div class="container mx-auto max-w-4xl pt-8">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-3xl font-bold mb-2 text-gray-800">Application Form</h1>
            <p class="text-gray-600 mb-6">Please fill in all required fields</p>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('applications.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Program Selection -->
                <div class="mb-6">
                    <label for="program" class="block text-sm font-medium text-gray-700 mb-2">
                        Select Program <span class="text-red-500">*</span>
                    </label>
                    <select 
                        name="program" 
                        id="program" 
                        required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    >
                        <option value="">-- Select a Program --</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->name }}" {{ old('program') == $program->name ? 'selected' : '' }}>
                                {{ $program->name }} - {{ $program->duration }}
                            </option>
                        @endforeach
                    </select>
                    @error('program')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Full Name -->
                <div class="mb-6">
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="full_name" 
                        id="full_name" 
                        value="{{ old('full_name') }}"
                        required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                        placeholder="John Doe"
                    >
                    @error('full_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gender & Marital Status -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Gender <span class="text-red-500">*</span>
                        </label>
                        <select 
                            name="gender" 
                            id="gender" 
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                        >
                            <option value="">-- Select Gender --</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="marital_status" class="block text-sm font-medium text-gray-700 mb-2">
                            Marital Status
                        </label>
                        <select 
                            name="marital_status" 
                            id="marital_status" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                        >
                            <option value="">-- Select --</option>
                            <option value="Single" {{ old('marital_status') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ old('marital_status') == 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Divorced" {{ old('marital_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="Widowed" {{ old('marital_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                        </select>
                        @error('marital_status')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Date of Birth -->
                <div class="mb-6">
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">
                        Date of Birth <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="date_of_birth" 
                        id="date_of_birth" 
                        value="{{ old('date_of_birth') }}"
                        required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    >
                    @error('date_of_birth')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email" 
                            value="{{ old('email') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                            placeholder="john@example.com"
                        >
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="tel" 
                            name="phone" 
                            id="phone" 
                            value="{{ old('phone') }}"
                            required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                            placeholder="+1 234 567 8900"
                        >
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address & Postal Address -->
                <div class="mb-6">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        Physical Address
                    </label>
                    <textarea 
                        name="address" 
                        id="address" 
                        rows="2"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    >{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="postal_address" class="block text-sm font-medium text-gray-700 mb-2">
                        Postal Address
                    </label>
                    <textarea 
                        name="postal_address" 
                        id="postal_address" 
                        rows="2"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    >{{ old('postal_address') }}</textarea>
                    @error('postal_address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- District & Nationality -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                            District
                        </label>
                        <input 
                            type="text" 
                            name="district" 
                            id="district" 
                            value="{{ old('district') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                        >
                        @error('district')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="nationality" class="block text-sm font-medium text-gray-700 mb-2">
                            Nationality
                        </label>
                        <input 
                            type="text" 
                            name="nationality" 
                            id="nationality" 
                            value="{{ old('nationality') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                            placeholder="e.g., Zambian"
                        >
                        @error('nationality')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Education Section -->
                <h3 class="text-xl font-semibold text-gray-800 mb-4 mt-8 border-b pb-2">Education Information</h3>

                <!-- Highest Qualification -->
                <div class="mb-6">
                    <label for="highest_qualification" class="block text-sm font-medium text-gray-700 mb-2">
                        Highest Qualification
                    </label>
                    <select 
                        name="highest_qualification" 
                        id="highest_qualification" 
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    >
                        <option value="">-- Select --</option>
                        <option value="High School" {{ old('highest_qualification') == 'High School' ? 'selected' : '' }}>High School</option>
                        <option value="Diploma" {{ old('highest_qualification') == 'Diploma' ? 'selected' : '' }}>Diploma</option>
                        <option value="Bachelor's Degree" {{ old('highest_qualification') == "Bachelor's Degree" ? 'selected' : '' }}>Bachelor's Degree</option>
                        <option value="Master's Degree" {{ old('highest_qualification') == "Master's Degree" ? 'selected' : '' }}>Master's Degree</option>
                        <option value="PhD" {{ old('highest_qualification') == 'PhD' ? 'selected' : '' }}>PhD</option>
                        <option value="Other" {{ old('highest_qualification') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('highest_qualification')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Other Qualifications -->
                <div class="mb-6">
                    <label for="other_qualifications" class="block text-sm font-medium text-gray-700 mb-2">
                        Other Qualifications
                    </label>
                    <textarea 
                        name="other_qualifications" 
                        id="other_qualifications" 
                        rows="2"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    >{{ old('other_qualifications') }}</textarea>
                    @error('other_qualifications')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Previous School & Exam Board -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="previous_school" class="block text-sm font-medium text-gray-700 mb-2">
                            Previous School
                        </label>
                        <input 
                            type="text" 
                            name="previous_school" 
                            id="previous_school" 
                            value="{{ old('previous_school') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                        >
                        @error('previous_school')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="exam_board" class="block text-sm font-medium text-gray-700 mb-2">
                            Exam Board
                        </label>
                        <input 
                            type="text" 
                            name="exam_board" 
                            id="exam_board" 
                            value="{{ old('exam_board') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                            placeholder="e.g., ECZ"
                        >
                        @error('exam_board')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- File Uploads -->
                <h3 class="text-xl font-semibold text-gray-800 mb-4 mt-8 border-b pb-2">Document Uploads</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="certificate_file" class="block text-sm font-medium text-gray-700 mb-2">
                            Certificate File (PDF, JPG, PNG)
                        </label>
                        <input 
                            type="file" 
                            name="certificate_file" 
                            id="certificate_file" 
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                        >
                        @error('certificate_file')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="id_file" class="block text-sm font-medium text-gray-700 mb-2">
                            ID File (PDF, JPG, PNG)
                        </label>
                        <input 
                            type="file" 
                            name="id_file" 
                            id="id_file" 
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                        >
                        @error('id_file')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Employment & Sponsor Information -->
                <h3 class="text-xl font-semibold text-gray-800 mb-4 mt-8 border-b pb-2">Employment Information</h3>

                <div class="mb-6">
                    <label for="occupation" class="block text-sm font-medium text-gray-700 mb-2">
                        Occupation
                    </label>
                    <input 
                        type="text" 
                        name="occupation" 
                        id="occupation" 
                        value="{{ old('occupation') }}"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    >
                    @error('occupation')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>



                <!-- Message / Additional Info -->
                <div class="mb-6">
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                        Additional Message / Notes
                    </label>
                    <textarea 
                        name="message" 
                        id="message" 
                        rows="3"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-2 border"
                    >{{ old('message') }}</textarea>
                    @error('message')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Agreement Checkbox -->
                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input 
                            type="checkbox" 
                            name="agreed" 
                            id="agreed" 
                            value="1"
                            {{ old('agreed') ? 'checked' : '' }}
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                        >
                        <span class="ml-2 text-sm text-gray-700">
                            I agree that the information provided is true and correct <span class="text-red-500">*</span>
                        </span>
                    </label>
                    @error('agreed')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit -->
                <div class="flex items-center justify-between border-t pt-6">
                    <button 
                        type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-md transition duration-200"
                    >
                        Submit Application
                    </button>
                    <a href="/" class="text-gray-600 hover:text-gray-800">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
