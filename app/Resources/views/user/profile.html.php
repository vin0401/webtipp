<?php $view->extend('::base.html.php') ?>
<a href="<?= $this->container->get('router')->generate('dashboard'); ?>">Dashboard</a> <br/>


<img src="<?= $imagePath . '/' . $user->getImage(); ?>">Dashboard</img> <br/>

Login: <br/>
<?= $user->getLogin() ?> <br/> <br/>

Gender: <br/>
<?= $user->getGender() ?> <br/> <br/>

Mail: <br/>
<?= $user->getMail() ?> <br/> <br/>

Vorame: <br/>
<?= $user->getNameFirst() ?> <br/> <br/>

Nachame: <br/>
<?= $user->getNameLast() ?> <br/> <br/>

Birthday: <br/>
<?= date('d.m.Y', $user->getBirthday()) ?> <br/> <br/>

Bei Webtipp seit: <br/>
<?= date('d.m.Y', $user->getDateCreate()) ?> <br/> <br/>

