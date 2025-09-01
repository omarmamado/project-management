<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Cash Request</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #8e36bf, #401543);
            color: white;
            text-align: center;
            padding: 30px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .content {
            padding: 30px;
            background-color: #ffffff;
        }

        .details {
            background-color: #f9f9f9;
            border-left: 4px solid #8e36bf;
            padding: 15px;
            margin: 20px 0;
        }

        .details ul {
            list-style-type: none;
            padding: 0;
        }

        .details li {
            margin-bottom: 10px;
        }

        .button {
            display: inline-block;
            background-color: #8e36bf;
            color: white;
            text-decoration: none;
            padding: 12px 25px;
            margin-top: 20px;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #8e36bf;
        }

        .footer {
            background-color: #1a0b1b;
            color: #ffffff;
            text-align: center;
            padding: 15px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>New Cash Request</h1>
        </div>
        <div class="content">
            <p>Dear  {{ Auth::user()->name }} ,</p>
            <p>I hope this email finds you well. I am writing to formally request a cash advance of {{ $cashRequest->amount }} EGP for
                {{ $cashRequest->reason }}.</p>
            <div class="details">
                <p><strong>Requester By: {{ $cashRequest->user->name }}</strong></p>
                <ul>
                    <li><strong>Amount Requested:</strong> {{ $cashRequest->amount }} EGP</li>
                    <li><strong>Purpose:</strong> {{ $cashRequest->reason }}</li>
                    <li><strong>Request Date:</strong> {{ $cashRequest->request_date }}</li>
                    <li><strong>Date Needed:</strong> {{ $cashRequest->due_date }}</li>
                </ul>
            </div>
            <p>I would greatly appreciate your consideration of this request. If you need any additional information or
                have any questions, please don't hesitate to contact me.</p>
            <p>Thank you for your time and attention to this matter.</p>
            <p>Best regards,<br>{{ Auth::user()->name }}</p>
            @if($cashRequest->role !== 'gm')
            <a href="{{ route('cash_requests.index') }}" class="button">Approve Request</a>
        @endif        </div>
        <div class="footer">
            <p>This is an automated email. Please do not reply directly to this message.</p>
        </div>
    </div>
</body>

</html>
