<?php $view->extend('::base.html.php') ?>

<a href="<?= $this->container->get('router')->generate('change-profile'); ?>">Profil</a>
<a href="<?= $this->container->get('router')->generate('logout'); ?>">Logout</a>
Groups

<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Saison</th>
        <th>Erstellt am</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($groups as $key => $group) { ?>
        <tr>
            <td><?= $group->getName() ?></td>
            <td><?= $group->getSeason()->getLeague()->getName() ?></td>
            <td><?= date('d.m.Y H:i', $group->getDateCreate()) ?></td>
            <td><a href="<?= $this->container->get('router')->generate('group', ['slug' => $group->getId()]); ?>">Details</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

Public Groups
<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Saison</th>
        <th>Erstellt am</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($publicGroups as $key => $group) { ?>
        <tr>
            <td><?= $group->getName() ?></td>
            <td><?= $group->getSeason()->getLeague()->getName() ?></td>
            <td><?= date('d.m.Y H:i', $group->getDateCreate()) ?></td>
            <td><a href="<?= $this->container->get('router')->generate('join-group', ['slug' => $group->getId()]); ?>">Join</a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>

<a href="<?= $this->container->get('router')->generate('create-group'); ?>">Create Group</a>