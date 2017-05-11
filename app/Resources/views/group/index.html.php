<?php $view->extend('::base.html.php') ?>

<div class="head-image">
    <img src="resources/images/register/head.jpeg"/>
</div>
<div class="theme-01 background">

    <div class="content">
        <div class="groups">
            <h1>Groups</h1>

            <table class="group-listing">
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

            <h2>Public Groups</h2>
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
        </div>

        <a class="button" href="<?= $this->container->get('router')->generate('create-group'); ?>">Create Group</a>
    </div>
</div>