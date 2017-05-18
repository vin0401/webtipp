<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php $view['slots']->output('title', 'Webtipp') ?></title>
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
                                <a href="#"><a href="#"><div class="login-box">DA</div></a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </header>
        <div class="main">
        <?php $view['slots']->output('_content') ?>
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