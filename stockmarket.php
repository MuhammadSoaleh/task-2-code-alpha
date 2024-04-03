<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Market News and Data</title>
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
            background-image: url("entrepreneur-1340649_1280.jpg");
        }
        p{
            color: white;
        }
        h1,h2,h3,h4,h5,h6{
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
                $news_url = "https://www.alphavantage.co/query?function=MARKET_STATUS&apikey=37G0CRVXKAUHHZ4B";
                $news_json = file_get_contents($news_url);
                $news_data = json_decode($news_json, true);

                if ($news_data && isset($news_data['status']) && $news_data['status'] == 'ok' && isset($news_data['articles'])) {
                    foreach ($news_data['articles'] as $article) {
                        echo "<div class='news-item'>";
                        echo "<h3>" . $article['title'] . "</h3>";
                        echo "<p>" . $article['description'] . "</p>";
                        echo "<a href='" . $article['url'] . "' target='_blank'>Read more</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>Unable to fetch news. Please try again later.</p>";
                }
            ?>
        </div>

        <!-- PHP code to fetch stock market data -->
        <div class="stock-data-container">
            <h2>Stock Market Data</h2>
            <?php
                $stock_url = "https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=IBM&interval=5min&apikey=37G0CRVXKAUHHZ4B";
                $stock_json = file_get_contents($stock_url);
                $stock_data = json_decode($stock_json, true);

                if ($stock_data && isset($stock_data['Time Series (5min)'])) {
                    $latest_data = current($stock_data['Time Series (5min)']);
                    echo "<p>Latest Close Price for IBM: " . $latest_data['4. close'] . "</p>";
                } else {
                    echo "<p>Unable to fetch stock data. Please try again later.</p>";
                }
            ?>
        </div>
    </div>
</body>
</html>
