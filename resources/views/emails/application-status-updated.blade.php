<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Application Status Update</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif; background: #f5f7fb; margin: 0; padding: 30px;">
    <div style="max-width: 700px; margin: 0 auto; background: #ffffff; border: 1px solid #e5e7eb; border-radius: 14px; overflow: hidden;">
        <div style="background: #0b3d91; color: white; padding: 24px 28px;">
            <h1 style="margin: 0; font-size: 24px;">Zomba College of Development Studies</h1>
            <p style="margin: 8px 0 0;">Application Status Update</p>
        </div>

        <div style="padding: 28px;">
            <p>Dear {{ $application->full_name }},</p>

            <p>
                Your application for <strong>{{ $application->program }}</strong> has been updated.
            </p>

            <p>
                <strong>Current Status:</strong>
                <span style="display: inline-block; background: #dbeafe; color: #1d4ed8; padding: 6px 10px; border-radius: 999px; font-weight: bold;">
                    {{ $application->status }}
                </span>
            </p>

            <p>
                We encourage you to keep your phone and email available for any further communication from the college.
            </p>

            <p>
                Thank you for applying to Zomba College of Development Studies.
            </p>

            <p style="margin-top: 30px;">
                Regards,<br>
                Zomba College of Development Studies
            </p>
        </div>
    </div>
</body>
</html>