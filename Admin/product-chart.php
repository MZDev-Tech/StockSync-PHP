 <?php
    include('../connection.php');

    // Fetch category-wise total quantity from the 'product' table
    $sql = "SELECT category, SUM(quantity) as total_quantity FROM laptops GROUP BY category";
    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }

    // Close connections
    mysqli_stmt_close($stmt);
    mysqli_close($con);

    // Convert PHP data to JavaScript JSON and assign it to a variable
    echo "<script>var chartData = " . json_encode($data) . ";</script>";
    ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>product chart</title>
 </head>

 <body>

         <canvas id="chart"></canvas>

     <script>
         // Ensure chartData is properly defined
         if (!chartData || chartData.length === 0) {
             console.error("No data found for chart.");
         } else {
             let categories = chartData.map(d => d.category);
             let quantities = chartData.map(d => d.total_quantity);

             const ctx = document.getElementById('chart').getContext('2d');

             // Store chart instance in a variable
             const myChart = new Chart(ctx, {
                 type: 'bar',
                 data: {
                     labels: categories,
                     datasets: [{
                         label: 'Total Quantity per Category',
                         data: quantities,
                         backgroundColor: [
                             "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40", "#1ABC9C", "#9966FF", "#2ECC71"
                         ],
                         borderColor: "#333",
                         borderWidth: 0.5,
                         barThickness: "flex",
                     }]
                 },
                 options: {
                     responsive: true,
                     maintainAspectRatio: false,
                     animation: {
                         duration: 2000,
                         easing: "easeOutBounce"
                     },
                     plugins: {
                         title: {
                             display: true,
                             text: "Stock Analysis: Products Overview",
                             font: {
                                 size: 18,
                                 weight: "bold",
                                 style: "italic",
                             },
                             color: "rgb(85, 85, 85)",
                             padding: {
                                 bottom: 28
                             }
                         },
                         legend: {
                             display: true,
                             position: "bottom"
                         }
                     },
                     scales: {
                         y: {
                             beginAtZero: true
                         }
                     }
                 }
             });


         }
     </script>
 </body>

 </html>