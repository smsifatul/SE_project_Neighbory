<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Neighborly - Emergency Contacts</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f5f5;
        }

        .topbar {
            background-color: #dce5ff;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .topbar .logo {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .topbar-right span {
            font-size: 14px;
            color: #444;
        }

        .topbar-right img {
            width: 24px;
            height: 24px;
            border-radius: 50%;
        }

        .sidebar {
            width: 230px;
            background: white;
            padding: 20px;
            height: 100vh;
            box-shadow: 1px 0 3px rgba(0,0,0,0.1);
            float: left;
        }

        .sidebar a {
            display: block;
            padding: 10px 15px;
            margin-bottom: 8px;
            color: #333;
            text-decoration: none;
            border-radius: 6px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background-color: #8cb6ff;
            color: white;
        }

        .main-content {
            margin-left: 230px;
            padding: 30px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        .contact-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.1);
        }

        .contact-card h3 {
            margin-bottom: 10px;
            color: #1877f2;
        }

        .contact-card p {
            margin: 5px 0;
            font-size: 14px;
            color: #555;
        }

        .contact-card a.call-btn {
            display: inline-block;
            margin-top: 10px;
            background-color: #e91e63;
            color: white;
            padding: 6px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
        }

        .call-btn:hover {
            background-color: #c2185b;
        }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="logo">Neighborly</div>
        <div class="topbar-right">
            <span>ID: 5050</span>
            <img src="img/user_icon.png" alt="Profile">
            <span><strong>Profile sifat</strong></span>
            <img src="img/power_icon.png" alt="Logout">
        </div>
    </div>

    <div class="sidebar">
        <a href="social_events.php">Social Events</a>
        <a href="volunteer.php">Volunteer Opportunities</a>
        <a href="charity.php">Charity</a>
        <hr>
        <a href="groups.php">Groups</a>
        <a href="friends.php">Friends</a>
        <a href="business.php">Local Business</a>
        <a href="emergency_contacts.php" class="active">Emergency Contacts</a>
    </div>

    <div class="main-content">
        <h2>Emergency Contacts</h2>

        <div class="contact-card">
            <h3>Security Center</h3>
            <p>Email: security@neighborly.com</p>
            <p>Phone: +880 1234 567890</p>
            <a href="tel:+8801234567890" class="call-btn">Call Now</a>
        </div>

        <div class="contact-card">
            <h3>Area Supervisor</h3>
            <p>Email: supervisor@neighborly.com</p>
            <p>Phone: +880 1987 654321</p>
            <a href="tel:+8801987654321" class="call-btn">Call Now</a>
        </div>

        <div class="contact-card">
            <h3>Admin Desk</h3>
            <p>Email: admin@neighborly.com</p>
            <p>Phone: +880 1765 432198</p>
            <a href="tel:+8801765432198" class="call-btn">Call Now</a>
        </div>
    </div>
</body>
</html>
