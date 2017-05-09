<?php $view->extend('::base.html.php') ?>
    <form method="post" action="<?= $this->container->get('router')->generate('login'); ?>">
        <label for="user">Username</label>
        <input type="text" name="user" id="user" value="<?= $data['login'] ?>" />
        <label for="password">Password</label>
        <input type="text" name="password" id="password" value="<?= $data['password'] ?>" />
        <button type="submit">Einloggen</button>
    </form>
    <a href="<?= $this->container->get('router')->generate('register'); ?>">Register</a>
<?php
if (!empty($errors)) {
    var_dump($errors);
}
