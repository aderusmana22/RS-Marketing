<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tindakan Berhasil!</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            /* Light background */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #495057;
            /* Darker text for readability */
            overflow: hidden;
            /* Prevent scrollbar during animation */
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            /* Softer corners */
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            /* More prominent shadow */
            text-align: center;
            max-width: 550px;
            /* Slightly wider */
            width: 90%;
            border: 1px solid #e9ecef;
            /* Subtle border */
            opacity: 0;
            /* Start invisible for fade-in */
            transform: translateY(20px);
            /* Start slightly below for slide-up */
            animation: fadeInSlideUp 0.6s ease-out forwards;
        }

        /* Animation for container fade-in */
        @keyframes fadeInSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .icon-wrapper {
            margin-bottom: 25px;
            display: inline-block;
            animation: bounceIn 0.8s ease-out forwards;
        }

        /* Animation for icon bounce */
        @keyframes bounceIn {
            0% {
                transform: scale(0.1);
                opacity: 0;
            }

            60% {
                transform: scale(1.1);
                opacity: 1;
            }

            80% {
                transform: scale(0.9);
            }

            100% {
                transform: scale(1);
            }
        }

        .stylish-icon {
            font-size: 70px;
            /* Larger icon */
            line-height: 1;
            color: #28a745;
            /* Success green */
            background-color: #e6ffe6;
            /* Lighter background for icon */
            border-radius: 50%;
            padding: 10px;
            width: 90px;
            /* Fixed width/height for circular icon */
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 10px rgba(40, 167, 69, 0.3);
            font-weight: 300;
            /* Lighter font weight for '✓' if used, or use an SVG/emoji */
        }

        /* Using a checkmark emoji for broader compatibility */
        .stylish-icon::before {
            content: '✅';
            /* Green checkmark emoji */
            font-size: 55px;
            /* Adjust size for emoji */
        }


        h1 {
            color: #28a745;
            font-size: 2.5em;
            /* Larger heading */
            margin-bottom: 10px;
            font-weight: 600;
            /* Semi-bold */
        }

        .main-message {
            font-size: 1.2em;
            /* Larger main message */
            line-height: 1.6;
            margin-bottom: 15px;
            font-weight: 500;
            /* Medium weight */
        }

        .rs-info {
            font-weight: 700;
            /* Bold */
            color: #007bff;
        }

        .detail-message {
            font-size: 1em;
            color: #6c757d;
            /* Muted color for detail */
            margin-bottom: 30px;
        }

        .countdown {
            font-size: 1.2em;
            color: #6c757d;
            margin-top: 20px;
        }

        .countdown strong {
            color: #007bff;
        }

        .back-link {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 28px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .back-link:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="icon-wrapper">
            <div class="stylish-icon"></div>
        </div>
        <h1>Tindakan Berhasil!</h1>
        <p class="main-message">
            Requisition Slip <span class="rs-info">
                @if (isset($rs_no) && $rs_no !== 'N/A')
                    No. {{ $rs_no }}
                @else
                    (Detail RS tidak tersedia)
                @endif
            </span> telah diproses.
        </p>
        <p class="detail-message">{{ $message }}</p>

        <div class="countdown">
            Jendela ini akan menutup secara otomatis dalam <strong id="countdown-timer">5</strong> detik.
        </div>

        <a href="{{ route('rs.index') }}" class="back-link">Kembali ke Dashboard</a>
    </div>

    <script>
        const countdownElement = document.getElementById('countdown-timer');
        let countdown = 5;

        function updateCountdown() {
            countdownElement.textContent = countdown;
            if (countdown === 0) {
                // Try to close the window/tab, or redirect

                window.close();

            } else {
                countdown--;
                setTimeout(updateCountdown, 1000); // Call every 1 second
            }
        }

        // Start the countdown when the page loads
        document.addEventListener('DOMContentLoaded', updateCountdown);
    </script>
</body>

</html>
