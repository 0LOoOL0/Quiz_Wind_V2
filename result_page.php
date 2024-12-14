<?php
include 'header.php';
include 'Includes/auth.php';
include 'Includes/Answer_handler.php';

if (isset($_SESSION['user_id'])) {
    echo "User ID: " . htmlspecialchars($_SESSION['user_id']);
    echo " Username: " . htmlspecialchars($_SESSION['username']);
} else {
    echo "Session variable not set.";
}

?>

<body class="page11">
    <div class="wrapper">
        <div class="container">
            <div class="spaceup">
                <form action="Includes/Answer_handler.php">
                    <div class="results">
                        <h1>Final Result</h1>
                        <p>100%</p>
                        <h2>Congrats!</h2>
                    </div>
                    <div class="attempt-table">

<?php
    
?>

                        <table>
                            <tr>
                                <th>Date attempt</th>
                                <th>Score</th>
                            </tr>
                            <tr>
                                <td>Date attempt</td>
                                <td>Score</td>
                            </tr>
                            <tr>
                                <td>Date attempt</td>
                                <td>Score</td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>