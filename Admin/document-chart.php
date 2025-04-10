<?php

include('../connection.php');
// Prepare SQL statement
$id = $_SESSION['id'];

$sql = "SELECT dt.status, COUNT(*) as total 
        FROM document_tracking dt
        JOIN (
            SELECT document_id, MAX(date) AS latest_date
            FROM document_tracking
            GROUP BY document_id
        ) latest ON dt.document_id = latest.document_id AND dt.date= latest.latest_date
        WHERE dt.from_user = ? OR dt.to_user = ?
        GROUP BY dt.status";

$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id, $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);


$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Close connections
mysqli_stmt_close($stmt);
mysqli_close($con);

// Convert PHP data to JavaScript JSON
echo "<script>var chartData = " . json_encode($data) . ";</script>";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chart</title>
</head>
<canvas id="statusChart"></canvas>

<body>
    <script>
        if (!chartData || chartData.length === 0) {
            console.error("No data found for chart.");
        } else {
            // Extract status labels and total count
            let statuses = chartData.map(d => d.status);
            let counts = chartData.map(d => d.total);

            // Render Pie Chart
            const ctx = document.getElementById("statusChart").getContext("2d");
            const statusChart = new Chart(ctx, {
                type: 'polarArea',
                data: {
                    labels: statuses,
                    datasets: [{
                        label: "File Status Count",
                        data: counts,
                        backgroundColor: [
                            "rgba(250, 187, 201, 0.6)",
                            "rgba(175, 215, 241, 0.6)",
                            "rgba(248, 183, 157, 0.6)",
                            "rgba(150, 156, 233, 0.6)",
                            "rgba(193, 169, 241, 0.6)",
                            "rgba(240, 211, 132, 0.6)",
                            "rgba(142, 187, 146, 0.6)"
                        ],
                        borderColor: "#fff",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    animation: {
                        duration: 2000,
                        easing: "easeInOutBounce"
                    },
                    plugins: {
                        title: {
                            display: true,
                            text: "Document Progress Summary",
                            font: {
                                size: 18,
                                weight: "bold",
                                style: 'italic',
                            },
                            color: "#3f3f3f",
                            padding: 20
                        },
                        legend: {
                            display: true,
                            position: "bottom"
                        }
                    }
                }
            });
        }
    </script>

</body>

</html>