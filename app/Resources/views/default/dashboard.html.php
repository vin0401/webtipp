<?php $view->extend('::base.html.php') ?>

Dashboard

<a href="<?= $this->container->get('router')->generate('profile'); ?>">Profil</a>
<a href="<?= $this->container->get('router')->generate('logout'); ?>">Logout</a>