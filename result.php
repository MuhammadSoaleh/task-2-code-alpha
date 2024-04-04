<?php
session_start();

// Function to fetch latitude and longitude of a city using HERE Geocoding API
function getCoordinates($city) {
    $apiKey = "3VFewXIRgieH4zIzrL3-Fb6x19dZH_3G0i4dKUQwfxY";
    $url = "https://geocode.search.hereapi.com/v1/geocode?q=" . urlencode($city) . "&apiKey=" . $apiKey;

    // Fetching data
    $response = file_get_contents($url);

    // Check for errors
    if ($response === false) {
        die('Error fetching data from HERE Geocoding API');
    }

    // Decode JSON response
    $data = json_decode($response, true);

    // Check if the response is valid
    if (!$data || !isset($data['items'][0]['position'])) {
        die('Invalid data received from HERE Geocoding API');
    }

    // Extracting latitude and longitude
    $latitude = $data['items'][0]['position']['lat'];
    $longitude = $data['items'][0]['position']['lng'];

    return array($latitude, $longitude);
}

if (isset($_POST['submitted'])) {
    $conn = mysqli_connect("localhost", "root", "", "city");

    if (!empty($_POST['city'])) {
        $city = $_POST['city'];
        $_SESSION['city'] = $city;

        // Fetch weather data from OpenWeatherMap API
        $weather_url = 'https://api.openweathermap.org/data/2.5/weather?q=' . urlencode($city) . '&appid=210eeeeafdb8e3d257cce72366d78b96';
        $weather_response = file_get_contents($weather_url);

        // Check for errors
        if ($weather_response === false) {
            die('Error fetching data from OpenWeatherMap API');
        }

        // Decode JSON response
        $weather_data = json_decode($weather_response, true);

        // Check if the response is valid
        if (!$weather_data || !isset($weather_data['main'])) {
            die('Invalid data received from OpenWeatherMap API');
        }

        // Extract weather information
        $temperature = $weather_data['main']['temp'];
        $description = $weather_data['weather'][0]['description'];
        $feels_like = $weather_data[ 'main']['feels_like'];

        // Output weather information
        echo "<p>Current temperature in $city: " . round($temperature - 273.15) . "°C</p>";
        echo "<p>Feels_Like temperature in $city: " . round($feels_like - 273.15) . "°C</p>";
        echo "<p>Weather description: " . ucfirst($description) . "</p>";

        // Fetch coordinates of the city
        list($latitude, $longitude) = getCoordinates($city);

        // Display map
        echo "<iframe class='center' src='https://www.google.com/maps/embed/v1/place?key=AIzaSyAYeMg6dTWCHbWfKr2rVu_-T78yOC8DEms&q=$latitude,$longitude' width='600' height='450' style='border:0;' allowfullscreen='' loading='lazy' referrerpolicy='no-referrer-when-downgrade'></iframe>";
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
<style>
    body{
        background-image: url("rainbow-4047523_1920.jpg");
        background-repeat: no-repeat;
        background-size: cover;
    }
    p{
        color: white;
    }
    label{
        color: white;
    }
</style>
</head>
<body>
<div class="container-fluid col-10">
    <form action="" method="post">
        <label for="inputPassword5" class="form-label">City</label>
        <input type="text" id="inputPassword5" name="city" class="form-control" aria-describedby="passwordHelpBlock">
        <div id="passwordHelpBlock" class="form-text text-white">
            Enter a city name to check weather information
        </div>
        <button type="submit" class="btn btn-primary" name="submitted">Submit</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
