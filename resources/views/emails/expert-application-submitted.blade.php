<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>New Expert Application Submitted</title>
</head>
<body>
    <h1>New Expert Application Submitted</h1>

    <p>A new expert application has been submitted. Please review the application details below:</p>

    <h2>Applicant Information</h2>
    <ul>
        <li><strong>Name:</strong> {{ $application->first_name }} {{ $application->last_name }}</li>
        <li><strong>Email:</strong> {{ $application->email }}</li>
        <li><strong>Mobile Number:</strong> {{ $application->mobile_number }}</li>
        @if($application->comments)
        <li><strong>Comments:</strong> {{ $application->comments }}</li>
        @endif
        <li><strong>Applied At:</strong> {{ $application->created_at->format('d M Y H:i') }}</li>
    </ul>

    <p>
        <a href="{{ route('admin.expert-applications.show', $application) }}">View Application Details</a>
    </p>

    <p>Thank you,<br>DreamsTour Team</p>
</body>
</html>
