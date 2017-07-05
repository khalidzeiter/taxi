<?php
ini_set('date.timezone', 'Africa/Cairo');
require 'book.php';

// Create a New Reservation
if (isset($_POST['create'])) {
    $reservation = new Book("", "", "", "", "", "", "", "", "", "", "");

    $reservation->name = $_POST['name'];
    $reservation->email = $_POST['email'];
    $reservation->telephone = $_POST['phone'];
    $reservation->departureDateTime = date("Y-m-d H:i:s", strtotime($_POST['departure']));
    $reservation->returnDateTime = date("Y-m-d H:i:s", strtotime($_POST['return']));
    $reservation->pickAddr = $_POST['pickAddr'];
    $reservation->distAddr = $_POST['distAddr'];
    $reservation->journeyType = $_POST['type'];
    $reservation->passengers = $_POST['passengers'];
    $reservation->notes = $_POST['notes'];
    $reservation->complete = 0;

    if ($reservation->create()) {
        echo "Reservation Has Been Sent!" . "<br>" . "Thank you!";
        echo "<a href='index.php'>Return to Home</a>";
        exit;
    } else {
        echo "Something Wrong!";
        echo "<a href='index.php'>Return to Home</a>";
        exit;
    }
}
