<?php require_once('Connections/WebCatalogue.php'); ?>
<?php require_once('Helpers/security.php'); ?>
<!doctype html><html><head><script src="Javascript/jquery-2.1.3.min.js" type="text/javascript"></script><link href="CSS/Layout.css" rel="stylesheet" type="text/css"><link href="CSS/Menu.css" rel="stylesheet" type="text/css">
<!-- Add fancyBox -->
<link rel="stylesheet" href="Javascript/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
<script type="text/javascript" src="Javascript/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="Javascript/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="Javascript/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="Javascript/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
<link rel="stylesheet" href="Javascript/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="Javascript/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>
<!-- Pop Up -->
<script type="text/javascript">
  $(document).ready(function() {
    $(".fancybox").fancybox();
  });
</script>
<meta charset="utf-8">
    <title>My Account</title>
</head>
<body>
    <div id="Holder">
        <div id="Header"></div>
        <div id="NavBar">
            <nav>
                <ul>
                    <li>
                        <a href="Index.php">Main</a>
                    </li>
                    <li>
                        <a href="Register.php">Register</a>
                    </li>
                    <li>
                        <a href="ForgotPassword.php">Forgot Password</a>
                    </li>
                </ul>
                <div id="log">
                    <?php include "PHP/Login_Include.php" ?>
                </div>
            </nav>
        </div>
        <div id="Content">
            <?php include "PHP/UseWeb_Include.php" ?>
        </div>
        <div id="Footer">
            <p>
                <a href="Admin.php">Admin</a>
            </p>
        </div>
    </div>
</body>undefined</html>

