<?php $view->extend('::base.html.php') ?>

<form method="post" action="<?= $this->container->get('router')->generate('profile'); ?>">
    <label for="user">Username</label>
    <input type="text" name="user" id="user" value="<?= $data['login'] ?>"/>
    <label for="name-first">Vorname</label>
    <input type="text" name="name-first" id="name-first"  value="<?= $data['name-first'] ?>"/>
    <label for="name-last">Nachname</label>
    <input type="text" name="name-last" id="name-last"  value="<?= $data['name-last'] ?>"/>
    <label for="gender">Geschlecht</label>
    <input type="radio" name="gender" value="male" <?php if ($data['gender'] === 'male') { echo 'checked'; } ?>> Male<br>
    <input type="radio" name="gender" value="female" <?php if ($data['gender'] === 'female') { echo 'checked'; } ?>> Female<br>
    <label for="mail">Mail</label>
    <input type="text" name="mail" id="mail"  value="<?= $data['mail'] ?>"/>
    <label for="password1">Password1</label>
    <input type="text" name="password1" id="password1"  value="<?= $data['password1'] ?>"/>
    <label for="password2">Password2</label>
    <input type="text" name="password2" id="password2"  value="<?= $data['password2'] ?>"/>
    <button type="submit">Einloggen</button>
</form>
<a href="<?= $this->container->get('router')->generate('login'); ?>">Login</a>
<?php
if (!empty($errors)) {
    var_dump($errors);
}