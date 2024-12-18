<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sample Graph</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        canvas {
            max-width: 600px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
<h2>Sample Graph: Lowest, Mid, and Height</h2>
<canvas id="myChart"></canvas>
<script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar', // You can change 'bar' to 'line', 'pie', etc.
            data: {
                labels: ['Sample 1', 'Sample 2', 'Sample 3'], // Replace with your categories
                datasets: [{
                    label: 'Lowest',
                    data: [12, 19, 3], // Data for Lowest
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }, {
                    label: 'Mid',
                    data: [5, 10, 9], // Data for Mid
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }, {
                    label: 'Height',
                    data: [15, 25, 18], // Data for Height
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true // Starts y-axis from 0
                    }
                }
            }
        });
    </script>
</body>
</html>