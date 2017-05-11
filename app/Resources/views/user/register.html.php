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
            <img src="resources/images/register/head.jpeg"/>
        </div>
        <div class="theme-01 background">

            <div class="content">
                <div class="register">
                    <div class="big-icon">
                        <i class="fa fa-address-card"></i>
                    </div>
                    <h1>Du bist bei uns Willkommen!</h1>


                    <?php echo $view['form']->form($form, array(
                        'attr' => array('novalidate' => 'novalidate'),
                    )) ?>
                    <?php echo $view['form']->start($form) ?>
                    <?php // echo $view['form']->widget($form) ?>
                                <?php echo $view['form']->widget($form['login']) ?>
                    <?php echo $view['form']->end($form) ?>

                    <a href="<?= $this->container->get('router')->generate('login'); ?>">Login</a>

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