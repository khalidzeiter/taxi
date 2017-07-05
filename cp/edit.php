<?php
require '../book.php';
ini_set('date.timezone', 'Africa/Cairo');

$reserve = new Book("", "", "", "", "", "", "", "", "", "", "");
$calledReservation = $reserve->getByID($_GET['id']) ? $reserve->getByID($_GET['id']) : $reserve->getByID($_POST['id']);

if (isset($_POST['update'])) {
    $calledReservation->name = $_POST['name'];
    $calledReservation->email = $_POST['email'];
    $calledReservation->telephone = $_POST['phone'];
    $calledReservation->departureDateTime = date("Y-m-d H:i:s", strtotime($_POST['departure']));
    $calledReservation->returnDateTime = date("Y-m-d H:i:s", strtotime($_POST['return']));
    $calledReservation->pickAddr = $_POST['pickAddr'];
    $calledReservation->distAddr = $_POST['distAddr'];
    $calledReservation->journeyType = $_POST['type'];
    $calledReservation->passengers = $_POST['passengers'];
    $calledReservation->notes = $_POST['notes'];
    $calledReservation->complete = $_POST['complete'];

    if ($calledReservation->update()) {
        echo "Reservation Updated Successfully!<br>";
        echo "<a href='index.php'>Return to Control</a>";
        exit;
    } else {
        echo "Something Wrong!!<br>";
        echo "<a href='edit.php?id=" . $_POST['id'] . "'>Return to Editing</a>";
        exit;
    }
}
if (isset($_GET['done'])) {
    $get = $reserve->getByID($_GET['done']);
    $get->complete = $_GET['state'];
    if ($get->update()) {
        echo "Updated Successfully!<br>";
        header("Location: index.php");
    } else {
        header("Location: index.php");
    }
}
if ($_SESSION['id'] == 1 && (isset($_GET['id']) || isset($_POST['id']))) {
    ?>

    <!doctype html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="../css/style.css">
        <title>Edit Users</title>
    </head>
    <body>
    <div class="editUsers">
        <p>Edit Reservation Data</p>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="field">
                <label>Name</label>
                <input type="text" name="name" value="<?= $calledReservation->name ?>">
            </div>
            <div class="field">
                <label>Email</label>
                <input type="email" name="email" value="<?= $calledReservation->email ?>">
            </div>
            <div class="field">
                <label>Phone Number</label>
                <input type="tel" name="phone" value="<?= $calledReservation->telephone ?>">
            </div>
            <div class="field">
                <label>Departure Date/Time</label>
                <input type="datetime-local" name="departure"
                       value="<?= date("Y-m-d\TH:i:s", strtotime($calledReservation->departureDateTime)) ?>">
            </div>
            <div class="field">
                <label>Return Date/Time</label>
                <input type="datetime-local" name="return"
                       value="<?= date("Y-m-d\TH:i:s", strtotime($calledReservation->returnDateTime)) ?>">
            </div>
            <div class="field">
                <label>PickUp Address</label>
                <input type="text" name="pickAddr" value="<?= $calledReservation->pickAddr ?>">
            </div>
            <div class="field">
                <label>Destination Address</label>
                <input type="text" name="distAddr" value="<?= $calledReservation->distAddr ?>">
            </div>
            <div class="field">
                <label>Journey Type</label>
                <select name="type">
                    <?php
                    if ($calledReservation->journeyType == 1) {
                        echo '<option value="1" selected>One-Way</option>';
                        echo '<option value="2">Return</option>';
                    } else {
                        echo '<option value="1">One-Way</option>';
                        echo '<option value="2" selected>Return</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="field">
                <label>Number of Passengers</label>
                <select name="passengers">
                    <?php
                    for ($i = 1; $i < 11; $i++) {
                        echo "<option value=$i>$i</option>";
                        if ($calledReservation->passengers == $i) {
                            echo "<option value=$i selected>$i</option>";
                        }
                    }
                    ?>
                </select>
            </div>
            <div class="field">
                <label>Notes</label>
                <textarea name="notes"><?= $calledReservation->notes ?></textarea>
            </div>
            <div class="field">
                <label>State</label>
                <select name="complete">
                    <?php
                    if ($calledReservation->complete == 0) {
                        echo '<option value="0" selected>In Progress</option>';
                        echo '<option value="1">Complete</option>';
                    } else {
                        echo '<option value="0">In Progress</option>';
                        echo '<option value="1" selected>Complete</option>';
                    }
                    ?>
                </select>
            </div>
            <input type="hidden" name="update" value="1">
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            <input type="submit">
            <button id="cancel">Cancel</button>
        </form>
    </div>
    </body>
    </html>

    <?php
} else if (isset($_GET['delete'])) {
    $reserve->getByID((int)$_GET['delete'])->delete();
    echo "Deleted Successfully!<br>";

    // Reset AUTO_INCREMENT Value
    $db->exec("SET  @num := 0;");
    $db->exec("UPDATE `reservations` SET id = @num := (@num+1);");
    $db->exec("ALTER TABLE `reservations` AUTO_INCREMENT = 1;");

    header("Location: index.php");
} else {
    echo "Forbidden!";
}

?>


