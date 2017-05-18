<?php $view->extend('::base.html.php'); ?>
<div class="head-image">
    <img src="resources/images/register/head.jpeg"/>
</div>
<div class="theme-01 background">

    <div class="content">
        <div class="groups">
    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Season</th>
            <th>PointsFull</th>
            <th>PointsPart</th>
            <th>Created</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?= $group->getName() ?></td>
            <td><?= $group->getSeason()->getLeague()->getIdApi() ?></td>
            <td><?= $group->getPointsFull() ?></td>
            <td><?= $group->getPointsPart() ?></td>
            <td><?= date('d.m.Y H:i', $group->getDateCreate()) ?></td>
        </tr>
        </tbody>
    </table>
    <div style="overflow-x: scroll">
    <p>Benutzer</p>
    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Login</th>
            <?php for ($i = 1; $i <= count($group->getSeason()->getMatchdays()); $i++) { ?>
                <th><?= $i ?></th>
            <?php } ?>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $key => $user) { ?>
            <tr>
                <td><?= $key + 1  ?></td>

                <td><?= $user->getLogin() ?></td>
                <?php foreach ($group->getSeason()->getMatchdays() as $matchday) { ?>
                    <td><?= $user->getMatchdayScore($group, $matchday) ?></td>
                <?php } ?>

                <td><?= $user->getTotalScore($group) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    </div>

<?php if (count($group->getSeason()->getMatchdays()) > 0) { ?>
    <p>Matchdays</p>
    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Start</th>
            <th>End</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($group->getSeason()->getMatchdays() as $matchday) { ?>
            <tr>
                <td><?= $matchday->getOrder() ?></td>
                <td><?= $matchday->getName() ?></td>
                <td><?= date('d.m.Y H:i', $matchday->getDateStart()) ?></td>
                <td><?= date('d.m.Y H:i', $matchday->getDateEnd()) ?></td>
                <td>
                    <a href="<?= $this->container->get('router')->generate('matchday', ['groupSlug' => $group->getId(), 'matchdaySlug' => $matchday->getId()]); ?>">Details</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php } ?>
<a href="<?= $this->container->get('router')->generate('groups'); ?>">Groups</a>
            </div>
        </div>
