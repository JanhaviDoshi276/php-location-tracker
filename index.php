<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Location Tracker</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            margin: 0;
            height: 100vh;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4f46e5, #3b82f6);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #111;
        }

        .card {
            background: #fff;
            width: 340px;
            padding: 24px;
            border-radius: 14px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .icon {
            font-size: 48px;
            margin-bottom: 10px;
        }

        h2 {
            margin: 10px 0;
        }

        p {
            font-size: 14px;
            color: #555;
        }

        .status {
            margin-top: 16px;
            font-weight: bold;
            color: #2563eb;
        }

        .error {
            color: #dc2626;
        }

        .success {
            color: #16a34a;
        }
    </style>
</head>

<body>

    <div class="card">
        <div class="icon">📍</div>
        <h2>Location Access</h2>
        <p>
            We are detecting your current location to improve analytics.
        </p>

        <div id="status" class="status">Detecting location…</div>
    </div>

    <script>
        const statusEl = document.getElementById("status");

        navigator.geolocation.getCurrentPosition(
            function (pos) {
                statusEl.textContent = "Location detected successfully ✔";
                statusEl.classList.add("success");

                fetch("save_location.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify({
                        latitude: pos.coords.latitude,
                        longitude: pos.coords.longitude,
                        accuracy: pos.coords.accuracy
                    })
                });
            },
            function (err) {
                statusEl.textContent = "Location permission denied ❌";
                statusEl.classList.add("error");

                fetch("save_location.php");
            }
        );
    </script>

</body>

</html>