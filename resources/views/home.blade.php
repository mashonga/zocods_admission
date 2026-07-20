<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Zomba College of Development Studies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
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



        .portal-pill {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 28px;
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 999px;
            color: #16a34a;
            font-weight: 700;
            font-size: 16px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.08);
            cursor: pointer;
        }

        .portal-pill:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(22, 163, 74, 0.15);
            border-color: #16a34a;
            background: #f0fdf4;
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
            gap: 20px;
            flex-wrap: wrap;
            align-items: center;
        }

        .nav-links a {
            color: white;
            font-weight: 600;
            font-size: 15px;
        }

        .nav-apply {
            background: #ff7a00;
            color: white !important;
            padding: 10px 18px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(255,122,0,0.3);
        }

        .hero {
            background: linear-gradient(rgba(22, 163, 74, 0.82), rgba(21, 128, 61, 0.88)),
                        url('/images/hero.jpg') center/cover no-repeat;
            color: white;
        }

        .hero-inner {
            max-width: 1150px;
            margin: 0 auto;
            padding: 100px 40px 90px;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 40px;
            align-items: center;
        }

        .hero h2 {
            margin: 0 0 20px;
            font-size: 54px;
            line-height: 1.08;
            max-width: 700px;
        }

        .hero p {
            margin: 0 0 30px;
            font-size: 18px;
            line-height: 1.8;
            max-width: 700px;
        }

        .hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-primary,
        .btn-secondary {
            display: inline-block;
            padding: 14px 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 15px;
        }

        .btn-primary {
            background: #ff7a00;
            color: white;
        }

        .btn-secondary {
            background: white;
            color: #16a34a;
        }

        .hero-image-box img {
            width: 100%;
            display: block;
            border-radius: 20px;
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.2);
            border: 4px solid rgba(255,255,255,0.18);
        }

        .section {
            max-width: 1150px;
            margin: 0 auto;
            padding: 80px 40px;
        }

        .section-title {
            margin: 0 0 12px;
            font-size: 38px;
            color: #16a34a;
        }

        .section-subtitle {
            margin: 0 0 32px;
            line-height: 1.8;
            color: #4b5563;
            max-width: 780px;
            font-size: 17px;
        }

        .about-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .panel {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 28px;
            box-shadow: 0 10px 28px rgba(15, 23, 42, 0.05);
        }

        .panel h3 {
            margin-top: 0;
            color: #16a34a;
            font-size: 24px;
        }

        .program-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .program-link {
            display: block;
        }

        .program-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
            transition: transform 0.18s ease, box-shadow 0.18s ease, border-color 0.18s ease;
            min-height: 86px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .program-link:hover .program-card {
            transform: translateY(-3px);
            box-shadow: 0 16px 30px rgba(15, 23, 42, 0.1);
            border-color: #bfd3f5;
        }

        .program-card h4 {
            margin: 0;
            color: #111827;
            font-size: 18px;
        }

        .program-card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .program-card-badge {
            font-size: 12px;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 999px;
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        .steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 20px;
        }

        .step {
            background: white;
            border-radius: 16px;
            padding: 26px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        }

        .step-number {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #16a34a;
            color: white;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-bottom: 14px;
        }

        .step h3 {
            margin-top: 0;
            margin-bottom: 10px;
            color: #16a34a;
        }

        .highlight-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            align-items: center;
        }

        .highlight-image img {
            width: 100%;
            display: block;
            border-radius: 20px;
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
        }

        .highlight-text h3 {
            margin-top: 0;
            font-size: 34px;
            color: #16a34a;
        }

        .highlight-text p {
            line-height: 1.8;
            color: #4b5563;
            font-size: 17px;
        }

        .cta {
            max-width: 1150px;
            margin: 0 auto 80px;
            padding: 0 40px;
        }

        .cta-box {
            background: linear-gradient(135deg, #16a34a, #22c55e);
            color: white;
            border-radius: 18px;
            padding: 36px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .cta-box h3 {
            margin: 0 0 10px;
            font-size: 30px;
        }

        .cta-box p {
            margin: 0;
            line-height: 1.7;
            max-width: 700px;
        }

        .footer {
            background: #0f172a;
            color: white;
            padding: 34px 40px;
        }

        .footer-inner {
            max-width: 1150px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1.2fr 1fr 1fr;
            gap: 20px;
        }

        .footer h4 {
            margin-top: 0;
            margin-bottom: 12px;
        }

        .footer p {
            margin: 0 0 8px;
            line-height: 1.7;
            color: #cbd5e1;
        }

        @media (max-width: 950px) {
            .hero-inner,
            .about-grid,
            .highlight-grid,
            .footer-inner {
                grid-template-columns: 1fr;
            }

            .hero h2 {
                font-size: 38px;
            }

            .navbar,
            .hero-inner,
            .section,
            .cta,
            .footer {
                padding-left: 20px;
                padding-right: 20px;
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
                <a href="#about">About</a>
                <a href="#programs">Programs</a>
                <a href="#how-to-apply">How to Apply</a>
                <a href="#contact">Contact</a>
                <a href="/apply" class="nav-apply">Apply Now</a>
            </div>
        </div>

    <section class="hero">
        <div class="hero-inner">
            <div>
                <h2>Apply to Zomba College of Development Studies</h2>
                <p>
                    Submit your application online through a clear and professional process.
                    Explore the available programs, complete the application form, and send
                    your details directly to the college for review.
                </p>


            </div>

            <div class="hero-image-box">
                <img src="/images/students.jpg" alt="Students">
            </div>
        </div>
    </section>

    <div style="background: #f8fafc; padding: 40px 20px; border-bottom: 1px solid #e5e7eb;">
        <div style="max-width: 1150px; margin: 0 auto; display: flex; gap: 24px; align-items: center; justify-content: center; flex-wrap: wrap;">
            <a href="https://students.zocods.com" target="_blank" class="portal-pill">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 10v6M2 10l10-5 10 5-10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                Student Portal
            </a>
            <a href="https://lecturers.zocods.com" target="_blank" class="portal-pill">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Staff Portal
            </a>
        </div>
    </div>

    <section class="section" id="about">
        <h2 class="section-title">About the College</h2>
        <p class="section-subtitle">
            Zomba College of Development Studies is committed to providing accessible and structured
            learning opportunities that equip learners with practical knowledge and relevant skills.
        </p>

        <div class="about-grid">
            <div class="panel">
                <h3>Our Mission</h3>
                <p>
                    To transform dreams into actions through quality education, practical knowledge,
                    and learner-centered programs that support academic and professional growth.
                </p>
            </div>

            <div class="panel">
                <h3>Learning Approach</h3>
                <p>
                    The college supports online studies, making it easier for applicants to begin
                    their academic journey through a flexible and professional admissions process.
                </p>
            </div>
        </div>
    </section>

    <section class="section" id="programs">
        <h2 class="section-title">Programs Offered</h2>
        <p class="section-subtitle">
            Review the available programs before starting your application.
        </p>

        <div class="program-grid">
            @foreach ($programs as $program)
                <a class="program-link" href="/programs/{{ $program->slug }}">
                    <div class="program-card">
                        <h4>{{ $program->name }}</h4>
                        <div class="program-card-meta">
                            @if($program->duration)
                                <span class="program-card-badge">⏱ {{ $program->duration }}</span>
                            @endif
                            @if($program->fees)
                                <span class="program-card-badge">💳 {{ $program->fees }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    <section class="section" id="how-to-apply">
        <h2 class="section-title">How to Apply</h2>
        <p class="section-subtitle">
            The application process is simple, public, and does not require an account.
        </p>

        <div class="steps">
            <div class="step">
                <div class="step-number">1</div>
                <h3>Select a Program</h3>
                <p>Review the program cards and open one to view more details before applying.</p>
            </div>

            <div class="step">
                <div class="step-number">2</div>
                <h3>Fill in Your Details</h3>
                <p>Enter your personal, contact, and academic information correctly.</p>
            </div>

            <div class="step">
                <div class="step-number">3</div>
                <h3>Upload Documents</h3>
                <p>Attach the required supporting documents such as results slip or ID copy.</p>
            </div>

            <div class="step">
                <div class="step-number">4</div>
                <h3>Submit Application</h3>
                <p>Send your completed form directly to the college for review.</p>
            </div>
        </div>
    </section>

    <footer class="footer" id="contact">
        <div class="footer-inner">
            <div>
                <h4>Zomba College of Development Studies</h4>
                <p>Transforming your dreams into actions</p>
            </div>

            <div>
                <h4>Contact</h4>
                <p>+265 987 342 149</p>
                <p>+265 888 124 485</p>
            </div>

            <div>
                <h4>Admissions</h4>
                <p>Online application available anytime</p>
                <p><a href="/apply" style="color: white;">Apply Now</a></p>
            </div>
        </div>
    </footer>

</body>
</html>