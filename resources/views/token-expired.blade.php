<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Expired</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            color: #333;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .countdown {
            font-size: 24px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Page Expired</h1>
    <p>You will be redirected to the homepage in <span class="countdown" id="countdown">10</span> seconds.</p>
</div>

<script>
    // Set the countdown time in seconds
    let countdownTime = 10;

    // Get the countdown element
    const countdownElement = document.getElementById('countdown');

    // Update the countdown every second
    const countdownInterval = setInterval(() => {
        // Decrease the countdown time
        countdownTime--;

        // Update the displayed countdown time
        countdownElement.textContent = countdownTime;

        // If the countdown reaches 0, redirect to the homepage
        if (countdownTime === 0) {
            clearInterval(countdownInterval);
            window.location.href = '/'; // Redirect to homepage
        }
    }, 1000);
</script>
</body>
</html>
