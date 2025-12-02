<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Dashboard</h1>
    <p>You are logged in with JWT.</p>

    <button id="logout-btn">Logout</button>

    <script>
        document.getElementById('logout-btn').addEventListener('click', async function() {
            const refresh = localStorage.getItem('refresh_token');
            await fetch('/auth/logout', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ refresh_token: refresh })
            });
            localStorage.clear();
            window.location.href = '/';
        });
    </script>
</body>
</html>
