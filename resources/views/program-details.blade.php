<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $program->name }} | Zomba College of Development Studies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        :root{
            --primary:#16a34a;
            --primary-dark:#15803d;
            --accent:#ff7a00;
            --accent-dark:#e66f00;
            --bg:#f5f7fb;
            --card:#ffffff;
            --text:#1f2937;
            --muted:#6b7280;
            --line:#e5e7eb;
            --shadow:0 16px 40px rgba(15,23,42,0.08);
            --soft-shadow:0 10px 28px rgba(15,23,42,0.05);
        }

        *{box-sizing:border-box;}
        body{
            margin:0;
            font-family:Arial, Helvetica, sans-serif;
            background:
                radial-gradient(circle at top left, rgba(22,163,74,0.06), transparent 28%),
                radial-gradient(circle at top right, rgba(255,122,0,0.05), transparent 24%),
                var(--bg);
            color:var(--text);
        }
        a{text-decoration:none;}



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

        .brand{
            display:flex;
            align-items:center;
            gap:14px;
        }

        .brand img{
            width:56px;
            height:56px;
            object-fit:cover;
            border-radius:50%;
            background:white;
            border:2px solid rgba(255,255,255,0.28);
        }

        .brand-text h1{
            margin:0;
            font-size:18px;
            line-height:1.2;
        }

        .brand-text p{
            margin:3px 0 0;
            font-size:12px;
            color:#dcfce7;
        }

        .nav-links{
            display:flex;
            gap:18px;
            flex-wrap:wrap;
            align-items:center;
        }

        .nav-links a{
            color:white;
            font-weight:600;
            font-size:15px;
        }

        .nav-apply{
            background:linear-gradient(135deg, var(--accent), var(--accent-dark));
            color:white !important;
            padding:10px 18px;
            border-radius:10px;
            box-shadow:0 10px 22px rgba(255,122,0,0.22);
        }

        .hero{
            background:
                linear-gradient(135deg, rgba(22,163,74,0.94), rgba(21,128,61,0.86)),
                url('/images/hero.jpg') center/cover no-repeat;
            color:white;
        }

        .hero-inner{
            max-width:1180px;
            margin:0 auto;
            padding:52px 40px 48px;
        }

        .badge{
            display:inline-flex;
            align-items:center;
            background:rgba(255,255,255,0.14);
            border:1px solid rgba(255,255,255,0.18);
            color:#eff6ff;
            border-radius:999px;
            padding:8px 14px;
            font-size:13px;
            font-weight:700;
            margin-bottom:16px;
        }

        .hero h2{
            margin:0 0 10px;
            font-size:46px;
            line-height:1.08;
            max-width:760px;
        }

        .hero p{
            margin:0;
            max-width:780px;
            font-size:17px;
            line-height:1.85;
            color:rgba(255,255,255,0.92);
        }

        .page{
            max-width:1180px;
            margin:-22px auto 0;
            padding:0 40px 80px;
            position:relative;
            z-index:2;
        }

        .top-card{
            background:var(--card);
            border:1px solid rgba(229,231,235,0.85);
            border-radius:22px;
            box-shadow:var(--shadow);
            padding:28px;
            margin-bottom:24px;
        }

        .top-card h3{
            margin:0 0 18px;
            font-size:28px;
            color:var(--primary);
        }

        .lead{
            color:var(--muted);
            line-height:1.85;
            font-size:16px;
            margin:0;
        }

        .grid{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:24px;
        }

        .card{
            background:var(--card);
            border:1px solid rgba(229,231,235,0.85);
            border-radius:22px;
            box-shadow:var(--soft-shadow);
            padding:26px;
        }

        .card h3{
            margin:0 0 16px;
            color:var(--primary);
            font-size:24px;
        }

        .detail{
            margin-bottom:14px;
            line-height:1.8;
            color:#374151;
        }

        .detail strong{
            color:#111827;
        }

        .text-block{
            line-height:1.85;
            color:#374151;
            white-space:pre-line;
        }

        .cta-row{
            margin-top:28px;
            display:flex;
            gap:14px;
            flex-wrap:wrap;
        }

        .btn-primary,
        .btn-secondary{
            display:inline-block;
            padding:14px 24px;
            border-radius:12px;
            font-weight:700;
            font-size:15px;
        }

        .btn-primary{
            background:linear-gradient(135deg, var(--accent), var(--accent-dark));
            color:white;
            box-shadow:0 12px 24px rgba(255,122,0,0.22);
        }

        .btn-secondary{
            background:var(--primary);
            color:white;
        }

        @media (max-width: 920px){
            .grid{grid-template-columns:1fr;}
            .hero h2{font-size:36px;}
        }

        @media (max-width: 700px){
            .navbar,
            .hero-inner,
            .page{
                padding-left:20px;
                padding-right:20px;
            }

            .hero h2{
                font-size:31px;
            }

            .top-card,
            .card{
                padding:22px 20px;
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
            <a href="/#programs">Programs</a>
            <a href="/#contact">Contact</a>
            <a href="/apply" class="nav-apply">Apply Now</a>
        </div>
    </div>

    <section class="hero">
        <div class="hero-inner">
            <div class="badge">Programme Overview</div>
            <h2>{{ $program->name }}</h2>
            <p>
                Review the programme details below before proceeding with your application.
            </p>
        </div>
    </section>

    <div class="page">

        <div class="top-card">
            <h3>Programme Information</h3>

            @if($program->introduction)
                <p class="lead">{{ $program->introduction }}</p>
            @else
                <p class="lead">
                    This programme is available for application through the college admissions system.
                    Review the details below and proceed when ready.
                </p>
            @endif
        </div>

        <div class="grid">
            <div class="card">
                <h3>Core Details</h3>

                <div class="detail"><strong>Programme Name:</strong> {{ $program->name }}</div>
                <div class="detail"><strong>Duration:</strong> {{ $program->duration ?: 'To be confirmed by administration' }}</div>
                <div class="detail"><strong>School Fees:</strong> {{ $program->fees ?: 'To be confirmed by administration' }}</div>
                <div class="detail"><strong>Duration Details:</strong> {{ $program->duration_details ?: '—' }}</div>
                <div class="detail"><strong>Qualification Levels:</strong> {{ $program->qualification_levels ?: '—' }}</div>
            </div>

            <div class="card">
                <h3>Entry Requirements</h3>
                <div class="text-block">{{ $program->entry_requirements ?: 'Entry requirements will be updated by the administration.' }}</div>
            </div>

            <div class="card">
                <h3>Modules / Course Structure</h3>
                <div class="text-block">{{ $program->module_summary ?: 'Programme modules and structure will be updated by the administration.' }}</div>
            </div>

            <div class="card">
                <h3>Assessment & Grading</h3>
                <div class="detail"><strong>Assessment Details:</strong></div>
                <div class="text-block" style="margin-bottom:16px;">{{ $program->assessment_details ?: 'Assessment details will be updated by the administration.' }}</div>

                <div class="detail"><strong>Grading System:</strong></div>
                <div class="text-block">{{ $program->grading_system ?: 'Grading system details will be updated by the administration.' }}</div>
            </div>

            <div class="card">
                <h3>Progression</h3>
                <div class="text-block">{{ $program->progression_details ?: 'Progression details will be updated by the administration.' }}</div>
            </div>

            <div class="card">
                <h3>Field Practicals / Attachments</h3>
                <div class="text-block">{{ $program->field_practicals ?: 'Field practicals or attachment details will be updated by the administration.' }}</div>
            </div>
        </div>

        <div class="cta-row">
            <a href="/apply?program={{ urlencode($program->name) }}" class="btn-primary">Apply for this Program</a>
            <a href="/#programs" class="btn-secondary">Back to Programs</a>
        </div>
    </div>

</body>
</html>