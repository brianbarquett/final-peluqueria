<?php
/* session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Assume a login page exists
    exit();
} */

$servername = "localhost";
$username = "root"; // Change to your DB username
$password = ""; // Change to your DB password
$dbname = "contenedores_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assume tables exist:
// CREATE TABLE users (id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(50), password VARCHAR(255));
// CREATE TABLE appointments (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT, appointment_date DATE, appointment_time TIME, service VARCHAR(100));

// Get logged-in user
$user_id = $_SESSION['user_id'];
$logged_user = $_SESSION['username']; // Assume username is stored in session

// Handle form submission for booking
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['book'])) {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $service = $_POST['service'];

    // Check if slot is available (simple check: no duplicate time on that date)
    $check_sql = "SELECT * FROM appointments WHERE appointment_date = '$date' AND appointment_time = '$time'";
    $result = $conn->query($check_sql);
    if ($result->num_rows == 0) {
        $sql = "INSERT INTO appointments (user_id, appointment_date, appointment_time, service) VALUES ($user_id, '$date', '$time', '$service')";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Turno reservado exitosamente!</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>El horario ya está ocupado.</p>";
    }
}

// Handle deletion
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    $delete_sql = "DELETE FROM appointments WHERE id = $delete_id AND user_id = $user_id";
    if ($conn->query($delete_sql) === TRUE) {
        echo "<p>Turno eliminado.</p>";
    } else {
        echo "<p>Error al eliminar.</p>";
    }
}

// Get selected date from GET or default to today
$selected_date = isset($_GET['date']) ? $_GET['date'] : date('Y-m-d');

// Fetch appointments for selected date
$sql = "SELECT * FROM appointments WHERE appointment_date = '$selected_date' AND user_id = $user_id ORDER BY appointment_time";
$result = $conn->query($sql);

// Generate days for calendar (example: current week)
$days = [];
$start_date = new DateTime($selected_date);
$start_date->modify('monday this week'); // Start from Monday
for ($i = 0; $i < 5; $i++) { // Monday to Friday, adjust as needed
    $day = clone $start_date;
    $day->modify("+$i day");
    $days[] = $day;
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turnos Peluquería</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; background-color: #f4f4f4; }
        .navbar { background-color: #333; color: white; padding: 10px; text-align: right; }
        .navbar span { margin-right: 20px; }
        .calendar { display: flex; justify-content: center; margin: 20px 0; }
        .day { padding: 10px 20px; margin: 0 5px; border: none; cursor: pointer; color: white; }
        .day.selected { background-color: #007bff; }
        .day:not(.selected) { background-color: #6c757d; }
        .appointments { background-color: white; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .appointment { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #ddd; padding: 10px 0; }
        .appointment:last-child { border-bottom: none; }
        .delete { color: red; cursor: pointer; }
        .form { margin-top: 20px; }
        .form input, .form select { margin: 10px 0; padding: 8px; width: 200px; }
        .form button { padding: 10px 20px; background-color: #28a745; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

    <div class="navbar">
        <span>Usuario: <?php echo htmlspecialchars($logged_user); ?></span>
        <!-- Add logout or other links if needed -->
    </div>

    <div class="calendar">
        <?php foreach ($days as $day): ?>
            <?php
            $day_str = $day->format('Y-m-d');
            $day_name = ['lun', 'mar', 'mié', 'jue', 'vie', 'sáb', 'dom'][$day->format('N') - 1];
            $day_num = $day->format('d');
            $selected_class = ($day_str == $selected_date) ? 'selected' : '';
            ?>
            <button class="day <?php echo $selected_class; ?>" onclick="location.href='?date=<?php echo $day_str; ?>'">
                <?php echo $day_name; ?><br><?php echo $day_num; ?>
            </button>
        <?php endforeach; ?>
    </div>

    <div class="appointments">
        <h2>Turnos para <?php echo date('d/m/Y', strtotime($selected_date)); ?> <span>(Ver agenda)</span></h2>
        <?php if ($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <div class="appointment">
                    <div>
                        <strong><?php echo htmlspecialchars($logged_user); ?></strong><br>
                        <?php echo htmlspecialchars($row['service']); ?>
                    </div>
                    <div>
                        <?php echo date('H:i', strtotime($row['appointment_time'])); ?>
                        <span class="delete" onclick="location.href='?date=<?php echo $selected_date; ?>&delete=<?php echo $row['id']; ?>'">🗑️</span>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No hay turnos para este día.</p>
        <?php endif; ?>
        <div>(Anulados)</div> <!-- Placeholder for canceled, implement if needed -->
    </div>

    <div class="form">
        <h3>Reservar nuevo turno</h3>
        <form method="POST">
            <input type="hidden" name="date" value="<?php echo $selected_date; ?>">
            <label>Hora:</label><br>
            <select name="time">
                <?php
                // Generate time slots every 45 min from 09:00 to 18:00
                $start = strtotime('09:00');
                $end = strtotime('18:00');
                while ($start < $end) {
                    $time_str = date('H:i', $start);
                    echo "<option value='$time_str'>$time_str</option>";
                    $start += 45 * 60;
                }
                ?>
            </select><br>
            <label>Servicio:</label><br>
            <select name="service">
                <option value="Corte de pelo (45 min)">Corte de pelo (45 min)</option>
                <!-- Add more services if needed -->
            </select><br>
            <button type="submit" name="book">Reservar</button>
        </form>
    </div>

</body>
</html>