<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Site Under Maintenance</title>

    <!-- AOS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" />

    <!-- Favicon (Optional) -->
    <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/5948/5948531.png" type="image/png">

    <style>
        :root {
            --bg-light: #f8f9fa;
            --bg-dark: #121212;
            --text-light: #000;
            --text-dark: #fff;
            --primary-color: #ffa600;
            --deep-blue: #0077b6;
            --grey-one: hsl(0, 0%, 85%);
            --grey-two: #b1b2b5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg-light);
            color: var(--text-light);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;
        }

        .container {
            max-width: 700px;
        }

        .icon {
            width: 150px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 2.5rem;
            color: var(--deep-blue);
            margin-bottom: 15px;
        }

        p {
            font-size: 1.2rem;
            color: var(--grey-two);
            margin-bottom: 25px;
        }

        .timer {
            font-size: 1.5rem;
            color: var(--primary-color);
            font-weight: bold;
        }

        @media (max-width: 600px) {
            h1 {
                font-size: 2rem;
            }

            p {
                font-size: 1rem;
            }

            .timer {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>

    <div class="container" data-aos="fade-up">
        <img src="https://cdn-icons-png.flaticon.com/512/5948/5948531.png" alt="Maintenance Icon" class="icon" />
        <h1 data-aos="zoom-in">We're Under Maintenance</h1>
        <p data-aos="fade-in">Our website is currently undergoing scheduled maintenance.<br> We'll be back shortly. Thanks for your patience.</p>
        <div class="timer" id="countdown" data-aos="fade-up"></div>
    </div>

    <!-- AOS & Countdown -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init();

        // Countdown to 4 hours from now
        const countdown = document.getElementById("countdown");
        const targetTime = new Date(new Date().getTime() + 4 * 60 * 60 * 1000);

        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetTime - now;

            if (distance < 0) {
                countdown.innerHTML = "We're back online!";
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            countdown.innerHTML = `Estimated time: ${hours}h ${minutes}m ${seconds}s`;
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    </script>

</body>

</html>