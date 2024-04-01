<?php
session_start();

if (isset($_POST['submitted'])) {
    $conn = mysqli_connect("localhost", "root", "", "city");

    if (!empty($_POST['city'])) {
        $city = $_POST['city'];
        $_SESSION['city'] = $city;
        
        // API URL
        $url = 'https://api.openweathermap.org/data/2.5/weather?q=' . urlencode($city) . '&appid=210eeeeafdb8e3d257cce72366d78b96';

        // Fetching data
        $response = file_get_contents($url);

        // Check for errors
        if ($response === false) {
            die('Error fetching data from OpenWeatherMap API');
        }

        // Decode JSON response
        $data = json_decode($response, true);

        // Check if the response is valid
        if (!$data || !isset($data['main'])) {
            die('Invalid data received from OpenWeatherMap API');
        }

        // Extracting required information
        $temperature = $data['main']['temp'];
        $description = $data['weather'][0]['description'];

        // Output
        echo "Current temperature in $city: " . round($temperature - 273.15) . "°C\n";
        echo "Weather description: " . ucfirst($description) . "\n";
    } else {
        echo '<script>alert("Please enter a city name.");</script>';
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Weather API</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid col-10">
    <form action="" method="post">
        <label for="inputPassword5" class="form-label">City</label>
        <input type="text" id="inputPassword5" name="city" class="form-control" aria-describedby="passwordHelpBlock">
        <div id="passwordHelpBlock" class="form-text">
            Enter a city name to check weather information
        </div>
        <button type="submit" class="btn btn-primary" name="submitted">Submit</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
