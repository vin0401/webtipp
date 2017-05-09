<?php $view->extend('::base.html.php') ?>

<img src="<?php echo $imagePath . '/' . $user->getImage() ?>" />

Dashboard

<a href="<?= $this->container->get('router')->generate('change-profile'); ?>">Profil</a>
<a href="<?= $this->container->get('router')->generate('logout'); ?>">Logout</a>
<a href="<?= $this->container->get('router')->generate('create-group'); ?>">Create Group</a>
<a href="<?= $this->container->get('router')->generate('groups'); ?>">Groups</a>