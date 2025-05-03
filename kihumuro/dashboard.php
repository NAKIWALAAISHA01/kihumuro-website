<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include_once 'config/database.php';
$database = new Database();
$db = $database->getConnection();

// Get user information
$query = "SELECT name, email, role FROM users WHERE id = :id";
$stmt = $db->prepare($query);
$stmt->bindParam(":id", $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Get user's appointments
$query = "SELECT * FROM appointments WHERE email = :email ORDER BY appointment_date DESC";
$stmt = $db->prepare($query);
$stmt->bindParam(":email", $user['email']);
$stmt->execute();
$appointments = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Kihumuro Hospital</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .dashboard-container {
            max-width: 1200px;
            margin: 100px auto 50px;
            padding: 0 20px;
        }
        
        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .welcome-message h1 {
            color: var(--primary-color);
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        
        .dashboard-card {
            background-color: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .appointments-list {
            margin-top: 1rem;
        }
        
        .appointment-item {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        
        .appointment-item:last-child {
            border-bottom: none;
        }
        
        .appointment-date {
            font-weight: bold;
            color: var(--secondary-color);
        }
        
        .appointment-department {
            color: var(--primary-color);
        }
        
        .btn-logout {
            background-color: var(--accent-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }
        
        .btn-logout:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <header class="header">
        <nav class="navbar">
            <div class="logo">
                <h1>Kihumuro Hospital</h1>
            </div>
            <div class="nav-links">
                <a href="index.php">Home</a>
                <a href="#appointments">Appointments</a>
                <a href="#profile">Profile</a>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </nav>
    </header>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <div class="welcome-message">
                <h1>Welcome, <?php echo htmlspecialchars($user['name']); ?>!</h1>
                <p>Here's your dashboard overview</p>
            </div>
            <a href="#new-appointment" class="btn-primary">Book New Appointment</a>
        </div>

        <div class="dashboard-grid">
            <div class="dashboard-card">
                <h2>Upcoming Appointments</h2>
                <div class="appointments-list">
                    <?php if (count($appointments) > 0): ?>
                        <?php foreach ($appointments as $appointment): ?>
                            <div class="appointment-item">
                                <div class="appointment-date">
                                    <?php echo date('F j, Y', strtotime($appointment['appointment_date'])); ?>
                                </div>
                                <div class="appointment-department">
                                    <?php echo htmlspecialchars($appointment['department']); ?>
                                </div>
                                <div class="appointment-status">
                                    Status: <?php echo htmlspecialchars($appointment['status']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No upcoming appointments</p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="dashboard-card">
                <h2>Your Profile</h2>
                <div class="profile-info">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Role:</strong> <?php echo ucfirst(htmlspecialchars($user['role'])); ?></p>
                </div>
                <a href="#edit-profile" class="btn-secondary" style="margin-top: 1rem;">Edit Profile</a>
            </div>

            <?php if ($user['role'] === 'admin'): ?>
                <div class="dashboard-card">
                    <h2>Admin Panel</h2>
                    <div class="admin-links">
                        <a href="#manage-users" class="btn-secondary">Manage Users</a>
                        <a href="#manage-appointments" class="btn-secondary">Manage Appointments</a>
                        <a href="#reports" class="btn-secondary">View Reports</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html> 