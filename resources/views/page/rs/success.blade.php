<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Action Successful</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #333;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
            border: 1px solid #e0e0e0;
        }

        .icon {
            font-size: 60px;
            color: #28a745;
            /* Green for success */
            margin-bottom: 20px;
        }

        h1 {
            color: #28a745;
            font-size: 2em;
            margin-bottom: 15px;
        }

        p {
            font-size: 1.1em;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        .rs-info {
            font-weight: bold;
            color: #007bff;
            /* Blue for emphasis */
        }

        .back-link {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="container">
        <p>Your action for Requisition Slip <span class="rs-info">
                @if (isset($rsMaster) && $rsMaster)
                    <div>No RS: {{ $rsMaster->rs_no }}</div>
                @endif
            </span> has been processed successfully.</p>
        <p>{{ $message }}</p>
        <a href="{{ route('rs.index') }}" class="back-link">Go to Dashboard</a>
    </div>
</body>

</html>
