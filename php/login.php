<?php
include 'header.php';

?>

<script type="text/javascript" src="java.js"></script>

<body class="hero-background">
<div class="spaceup">
        <div class="container">
            <div class="content-login">
                <form action="login.php" method="post">
                    <table>
                        <tr>
                            <td>
                                <h1>Account Login</h1>
                            </td>
                        </tr>
                        <tr>
                            <td><input type="text" name="username" placeholder="Username"></td>
                        </tr>
                        <tr>
                            <td><input type="password" name="password" placeholder="Password"></td>
                        </tr>
                        <tr>
                            <td>
                                <p>Don't have an account? <a href="main.php">Create one!</a></p>
                            </td>
                        </tr>
                        <tr>
                            <td><button class="button2" type="submit" name="submitted">Login</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</body>
<div class="wrapper">
</div>