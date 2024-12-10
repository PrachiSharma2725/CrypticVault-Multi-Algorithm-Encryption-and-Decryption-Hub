<?php
session_start();
if (!isset($_SESSION['email'])) {
    // Redirect to login if the user is not logged in
    header("Location: login.php");
    exit;
}

// Database configuration
$server = "localhost";
$username = "root";
$password = "";
$database = "crypticvault";

// Create connection
$conn = new mysqli($server, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch the logged-in user's ID and username
$user_email = $_SESSION['email'];
$user_query = "SELECT id, name FROM user WHERE email = '$user_email'";
$user_result = $conn->query($user_query);

if ($user_result->num_rows > 0) {
    $user_row = $user_result->fetch_assoc();
    $user_id = $user_row['id'];
    $username = $user_row['name'];
} else {
    die("User not found.");
}

// Handle form submission for adding a key
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_key'])) {
    $key_value = mysqli_real_escape_string($conn, $_POST['key_value']);
    $key_label = mysqli_real_escape_string($conn, $_POST['key_label']);

    $add_key_query = "INSERT INTO user_keys (user_id, key_value, key_label) VALUES ('$user_id', '$key_value', '$key_label')";
    if ($conn->query($add_key_query)) {
        echo "<script>alert('Key added successfully.');</script>";
    } else {
        echo "<script>alert('Error adding key: " . $conn->error . "');</script>";
    }
}

// Handle key deletion
if (isset($_GET['delete_key'])) {
    $key_id = intval($_GET['delete_key']);
    $delete_key_query = "DELETE FROM user_keys WHERE id = '$key_id' AND user_id = '$user_id'";
    if ($conn->query($delete_key_query)) {
        echo "<script>alert('Key deleted successfully.');</script>";
    } else {
        echo "<script>alert('Error deleting key: " . $conn->error . "');</script>";
    }
}

// Fetch user's keys
$keys_query = "SELECT * FROM user_keys WHERE user_id = '$user_id'";
$keys_result = $conn->query($keys_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="profile_style.css"> 
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oxanium:wght@200..800&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="container">
        <div class="logo">
            <a href="#">CrypticVault</a>
        </div>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="multi_layer_tool.php">Multi-Layer Encryption</a></li>
                <li><a href="algorithms.php">Algorithms</a></li>
                <li><a href="image_tool.php">Image Encryption</a></li>
            </ul>
            <?php if (isset($_SESSION['name'])): ?>
                <div class="user-menu">
                    <span class="user-email">Hi, <?php echo htmlspecialchars($username); ?>!</span>
                    <ul class="dropdown">
                    <li><a href="profile.php">Profile</a></li>
                    <li><a href="login/logout.php">Logout</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <a href="login.php" class="cta-btn">Login</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<section class="profile">
    <div class="glass-container">
        <h2>Your Profile</h2>
        <p>Welcome, <?php echo htmlspecialchars($username); ?>!</p>
        <p>Your email: <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        

        <h3>Your Encryption Keys</h3>
        <form method="POST">
            <label for="key_value">Key Value:</label>
            <input type="text" id="key_value" name="key_value" maxlength="24" required>
            <label for="key_label">Key Label (optional):</label>
            <input type="text" id="key_label" name="key_label">
            <button type="submit" name="add_key">Add Key</button>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Key Value</th>
                    <th>Key Label</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($keys_result->num_rows > 0): ?>
                    <?php while ($row = $keys_result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['key_value']); ?></td>
                            <td><?php echo htmlspecialchars($row['key_label'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td>
                                <a href="?delete_key=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this key?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No keys found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>
</body>
</html>

<?php
$conn->close();
?>
