<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Market News and Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        /* CSS styling for the page */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .news-container {
            margin-bottom: 20px;
        }
        .news-item {
            margin-bottom: 10px;
        }
        body{
            background-image: url("nick-chong-N__BnvQ_w18-unsplash.jpg");
        }
        p{
            color: white;
        }
        h1,h2,h3,h4,h5,h6{
            color: white;
        }
        li{
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Stock Market News and Data</h1>

        <!-- PHP code to fetch stock market news -->
        <div class="news-container">
            <h2>Stock Market News</h2>
            <?php
$url = 'https://api.iex.cloud/v1/data/core/news?range=1m&limit=30&token=pk_248947ab442d4bf8a3d7d7aaa4959e44';
$json_data = file_get_contents($url);
$data_array = json_decode($json_data, true);

if ($data_array !== null && !isset($data_array['error'])) {
    foreach ($data_array as $article) {
        $datetime = $article['datetime'];
        $headline = $article['headline'];
        $image = $article['image'];
        $imageUrl = $article['imageUrl'];
        $summary = $article['summary'];
        echo "<li>datetime: $datetime</li>";
        echo "<li>Headline: $headline</li>";
        echo "<li>image: $image</li>";
        echo "<li>imageUrl: $imageUrl</li>";
        echo "<li>summary: $summary</li>";
        echo '<hr>';
    }
} else {
    echo "Failed to fetch or decode JSON data.";
}
?>




        </div>

        <!-- PHP code to fetch stock market data -->
        <div class="stock-data-container">
            <h2>Stock Market Data</h2>
            <?php

// API endpoint
$url = 'https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=IBM&interval=5min&apikey=WB23VT7P192TX6SU';

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute cURL request
$response = curl_exec($ch);

// Check for errors
if(curl_errno($ch)){
    echo 'Error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Decode JSON response
$data = json_decode($response, true);

// Print fetched data
print_r($data);

?>




        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>