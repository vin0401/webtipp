<!DOCTYPE html>
<html lang="en">
<head>
    <title>Webtipp</title>
    <link href="resources/css/app.less" type="text/less" rel="stylesheet">
    <script type="text/javascript" src="resources/bower/jquery/dist/jquery.min.js"></script>
    <script>
        less = {
            env: "development",
            poll: 200
        };
    </script>
    <script type="text/javascript" src="resources/bower/less/dist/less.min.js"></script>

</head>
<body>
<div class="site-wrapper">
    <header class="theme-03 background">
        <div class="content row">
            <div class="col-phone-4">
                <img src="resources/images/logo/logo.png" class="logo">
            </div>
            <div class="col-phone-8">
                <nav>
                    <ul>
                        <li><a href="#">Statistiken</a></li>
                        <li><a href="#">Tipprunden</a></li>
                        <li class="login-item">
                            <a href="#"><div class="login-box">Lg</div></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
    <div class="main">
        <div class="head-image">
            <img src="resources/images/login/head.jpeg"/>
        </div>
        <div class="theme-01 background">

            <div class="content">
                <div class="login">
                    <div class="big-icon">
                        <i class="fa fa-user-circle-o"></i>
                    </div>
                    <form method="post" action="<?= $this->container->get('router')->generate('login'); ?>">
                        <div class="form-element">
                            <label for="user">Benutzername</label>
                            <input type="text" name="user" id="user" value="<?= $data['login'] ?>" />
                        </div>

                        <div class="form-element">
                            <label for="password">Passwort</label>
                            <input type="password" name="password" id="password" value="<?= $data['password'] ?>" />
                        </div>

                        <div class="login-links">
                            <a href="<?= $this->container->get('router')->generate('register'); ?>">Jetzt Registrieren!</a>
                        </div>

                        <div class="form-element align-right">
                            <button type="submit">Einloggen</button>
                        </div>

                        <?php
                        if (!empty($errors)) {
                            var_dump($errors);
                        }
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="theme-02 background">
            <div class="content">
                <nav>
                    <ul>
                        <li><a href="#">Imprint</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </footer>
</div>
</body>
</html>


