<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <!-- Bootstrap CSS -->
    <link href="../style/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="../style/bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/loginScript.js"></script>
    <style>
        body {
            background: linear-gradient(to bottom right, green, yellow, blue);

        }

        .alert-1{
            z-index :1;
            opacity: 1;
            position: fixed;
            font-size: 150%;
            display : flex;
            top: 18%;
            left: 50%;
            transform: translate(-50%,-50%);
            opacity: 0.9;
        }
    </style>
</head>

<body>
    <?=$content?>

</body>

</html>