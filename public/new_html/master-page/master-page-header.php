<?php
echo 
'<!DOCTYPE html>
<html>
<head>
    <title>NALs</title>
    <link rel="stylesheet" type="text/css" href="./master-page.css">
    <link rel="stylesheet" type="text/css" href="./reset.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>

</head>
<body>
    <header class="header is-flex is-align-item-center is-space-between">
        <a href="#">
            <img src="./images/icon_logo.png">
            <img src="./images/icon_name.png">
        </a>
        <div class="is-flex">
            <div class="dropdown mg-right-10">
                <a href="#" data-toggle="dropdown" aria-labelledby="dropdownMenuLink">
                    <img src="./images/dropdown.png">
                </a>
                <div class="dropdown-menu dropdown-notification">
                    <a class="dropdown-item" href="#"><i class="fas fa-users"></i>&nbsp;5 new members joined today</a>
                    <a class="dropdown-item" href="#"><i class="fas fa-shopping-cart"></i>&nbsp;25 sales made</a>
                    <a class="dropdown-item" href="#"><i class="fas fa-user"></i>&nbsp;You changed your username</a>
                </div>
            </div>
            <div class="dropdown mg-right-50">
                <a class="btn btn-info dropdown-user" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="./images/face.png">
                    User Name
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li></li>
                    <li>
                        <a class="dropdown-item" href="#"><i class="fas fa-info">&nbsp;</i>Update Profile</a>
                        <a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt">&nbsp;</i>Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
</body>
</html>';
?>
