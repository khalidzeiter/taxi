<?php require '../book.php'; ?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/font-awesome.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Control Panel</title>
</head>
<body>
<?php
$reserve = new Book("", "", "", "", "", "", "", "", "", "", "");

// Login Function
if (isset($_POST['login'])) {
    $get = $db->query("SELECT * FROM users WHERE `username` = '" . $_POST['username'] . "' AND `password` = '" . md5($_POST['password']) . "'");
    if ($get->fetchAll(PDO::FETCH_ASSOC)) {
        $_SESSION['id'] = 1;
        echo "Logged in Successfully!<br>";
        echo "<a href='index.php'>Return to Control</a>";
        exit;
    } else {
        $_SESSION['id'] = 0;
        echo "Wrong Username Or Password!<br>";
    }
}
// Login Form
if ($_SESSION['id'] == 0) {
    ?>
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
        <div class="field">
            <label>Username</label>
            <input type="text" name="username">
        </div>
        <div class="field">
            <label>Password</label>
            <input type="password" name="password">
        </div>
        <input type="hidden" name="login">
        <input type="submit" value="Login">
    </form>
    <?php
} // Reservation Data Table
else {
    ?>
    <table>
        <tr>
            <th>id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Telephone</th>
            <th>Departure Date/Time</th>
            <th>Return Date/Time</th>
            <th>PickUp Address</th>
            <th>Distention Address</th>
            <th>Journey Type</th>
            <th>Number of Passengers</th>
            <th>Notes</th>
            <th>State</th>
            <th>Control</th>
        </tr>
        <?php
        $reservations = $reserve->getAll();
        foreach ($reservations as $reservation) {
            echo "<tr>";
            echo '<td>' . $reservation->id . '</td>';
            echo '<td>' . $reservation->name . '</td>';
            echo '<td>' . $reservation->email . '</td>';
            echo '<td>' . $reservation->telephone . '</td>';
            echo '<td>' . $reservation->departureDateTime . '</td>';
            echo '<td>' . $reservation->returnDateTime . '</td>';
            echo '<td>' . $reservation->pickAddr . '</td>';
            echo '<td>' . $reservation->distAddr . '</td>';
            echo '<td>' . $reservation->journeyType . '</td>';
            echo '<td>' . $reservation->passengers . '</td>';
            echo '<td>' . $reservation->notes . '</td>';
            if ($reservation->complete == 0) {
                echo '<td style="color:#C33; text-align: center">In Progress</td>';
            } else {
                echo '<td style="color:#393; text-align: center">Complete</td>';
            }

            echo '<td class="control">';
            echo '<a href="edit.php?delete=' . $reservation->id . '"><i style="margin: 0 1px; color:#c33;" class="fa fa-trash" id="delete"></i></a>';
            echo '<a href="edit.php?id=' . $reservation->id . '"><i style="margin: 0 1px; color:#393;" class="fa fa-pencil" id="edit"></i></a>';
            echo '<a href="edit.php?done=' . $reservation->id . '&state=' . ($reservation->complete == 0 ? 1 : 0) . '"><i class="fa fa-check"></i></a>';

            echo '</td>';
        }
        ?>
    </table>

    <?php
}
?>
</body>
</html>
