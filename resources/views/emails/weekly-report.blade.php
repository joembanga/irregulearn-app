<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>Weekly Report</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h2 style="color: #4F46E5;">Hi {{ $data['user']->username }}!</h2>
        <p>Here is your progress for the week of {{ $data['weekStart'] }} - {{ $data['weekEnd'] }}:</p>
        
        <div style="background-color: #F3F4F6; padding: 15px; border-radius: 8px; margin: 20px 0;">
            <p style="margin: 5px 0;"><strong>XP Earned:</strong> {{ $data['xp'] }}</p>
            <p style="margin: 5px 0;"><strong>Verbs Learned:</strong> {{ $data['verbsLearned'] }}</p>
        </div>

        <p>Keep up the great work! Consistent practice is the key to mastery.</p>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/dashboard') }}" style="background-color: #4F46E5; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Go to Dashboard</a>
        </div>
    </div>
</body>
</html>
