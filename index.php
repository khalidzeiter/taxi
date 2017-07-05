<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
    <title>TAXI Booking System</title>
</head>
<body>
<form action="create.php" method="post">
    <div class="field">
        <label>Name</label>
        <input type="text" name="name">
    </div>
    <div class="field">
        <label>Email</label>
        <input type="email" name="email">
    </div>
    <div class="field">
        <label>Phone Number</label>
        <input type="tel" name="phone">
    </div>
    <div class="field">
        <label>Departure Date/Time</label>
        <input type="datetime-local" name="departure">
    </div>
    <div class="field">
        <label>Return Date/Time</label>
        <input type="datetime-local" name="return">
    </div>
    <div class="field">
        <label>PickUp Address</label>
        <input type="text" name="pickAddr">
    </div>
    <div class="field">
        <label>Destination Address</label>
        <input type="text" name="distAddr">
    </div>
    <div class="field">
        <label>Journey Type</label>
        <select name="type">
            <option value="1">One-Way</option>
            <option value="2">Return</option>
        </select>
    </div>
    <div class="field">
        <label>Number of Passengers</label>
        <select name="passengers">
            <?php
            for ($i = 1; $i < 11; $i++) {
                echo "<option value=$i>$i</option>";
            }
            ?>
        </select>
    </div>
    <div class="field">
        <label>Notes</label>
        <textarea name="notes"></textarea>
    </div>
    <input type="hidden" name="create">
    <input type="submit">

</form>
</body>
</html>