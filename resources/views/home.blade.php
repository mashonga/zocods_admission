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

        .navbar {
            background: #0b3d91;
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
            color: #dbeafe;
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
        }

        .hero {
            background: linear-gradient(rgba(11, 61, 145, 0.78), rgba(11, 61, 145, 0.78)),
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
            color: #0b3d91;
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
            color: #0b3d91;
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
            color: #0b3d91;
            font-size: 24px;
        }

        .program-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
        }

        .program-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 22px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, 0.05);
        }

        .program-card h4 {
            margin: 0;
            color: #111827;
            font-size: 18px;
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
            background: #0b3d91;
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
            color: #0b3d91;
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
            color: #0b3d91;
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
            background: linear-gradient(135deg, #0b3d91, #0f4db6);
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

                <div class="hero-actions">
                    <a href="/apply" class="btn-primary">Start Application</a>
                    <a href="#programs" class="btn-secondary">Explore Programs</a>
                </div>
            </div>

            <div class="hero-image-box">
                <img src="/images/students.jpg" alt="Students">
            </div>
        </div>
    </section>

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
            <div class="program-card"><h4>Public Health</h4></div>
            <div class="program-card"><h4>Nutrition and Food Security</h4></div>
            <div class="program-card"><h4>Professional Diploma in Education</h4></div>
            <div class="program-card"><h4>Community Development</h4></div>
            <div class="program-card"><h4>Social Work</h4></div>
            <div class="program-card"><h4>Business Administration</h4></div>
            <div class="program-card"><h4>Human Resource Management</h4></div>
            <div class="program-card"><h4>Hotel and Hospitality Management</h4></div>
            <div class="program-card"><h4>ICT</h4></div>
            <div class="program-card"><h4>Environmental Science</h4></div>
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
                <p>Choose the course you want to apply for from the listed programs.</p>
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

    <section class="section">
        <div class="highlight-grid">
            <div class="highlight-image">
                <img src="/images/hero.jpg" alt="College learning">
            </div>

            <div class="highlight-text">
                <h3>Start your application with confidence</h3>
                <p>
                    This website gives applicants a more organized and professional experience than
                    sending messages and files through WhatsApp.
                </p>
                <p>
                    Everything important is presented in one place: programs, application steps,
                    and the online form for submitting details.
                </p>
                <a href="/apply" class="btn-primary">Apply Now</a>
            </div>
        </div>
    </section>

    <section class="cta">
        <div class="cta-box">
            <div>
                <h3>Ready to apply?</h3>
                <p>
                    Begin your application today through the official online admissions form.
                </p>
            </div>

            <div>
                <a href="/apply" class="btn-secondary">Go to Application Form</a>
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
                <p>Online application form available</p>
                <p>Apply through the website</p>
            </div>
        </div>
    </footer>

</body>
</html>