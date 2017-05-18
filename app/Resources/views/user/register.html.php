<?php $view->extend('::base.html.php') ?>


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
