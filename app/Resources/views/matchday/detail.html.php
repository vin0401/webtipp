<?php
$view->extend('::base.html.php');
?>
<?php
if ($submit) {
    ?>
    <form method="post"
    action="<?= $this->container->get('router')->generate('place-bet', ['groupSlug' => $group->getId(), 'matchdaySlug' => $matchday->getId()]); ?>">
    <?php
}
?>
    <p>Informations:</p>
    <p>Matches:</p>

    <table style="text-align: left">
        <thead>
        <tr>
            <th>No</th>
            <th>Team Home</th>
            <th>Team Away</th>
            <th>Half time result</th>
            <th>Result</th>
            <th>Date</th>
            <th>Start</th>
            <th>End</th>
            <th>Bet Home</th>
            <th>Bet Away</th>
        </tr>
        </thead>
        <tbody>
        <?php $others = []; ?>
        <?php foreach ($matchday->getMatches() as $match) { ?>
            <?php
            $results = [
                'half' => '-:-',
                'end' => '-:-',
            ];

            foreach (['half', 'end'] as $type) {
                $result = $match->getResult($type);
                if ($result !== false) {
                    $results[$type] = $result->format();
                }
            }

            ?>
            <tr>
                <td><?= $match->getOrder() ?></td>
                <td><img src="<?= $match->getTeamHome()->getTeamIconUrl() ?>"
                         style="display: inline-block; height: 14px; width: auto;"/><?= $match->getTeamHome()->getName() ?>
                </td>
                <td><img src="<?= $match->getTeamAway()->getTeamIconUrl() ?>"
                         style="display: inline-block; height: 14px; width: auto;"/><?= $match->getTeamAway()->getName() ?>
                </td>
                <td><?= $results['half'] ?></td>
                <td><?= $results['end'] ?></td>
                <td><?= date('d.m.Y', $match->getDateStart()) ?></td>
                <td><?= date('H:i', $match->getDateStart()) ?></td>
                <td><?= date('H:i', $match->getDateEnd()) ?></td>
                <?php if ($match->getState() === 'pending') { ?>
                    <td><input type="text" name="bets[<?= $match->getOrder() ?>][home]" id="home"
                               value="<?php if (isset($bets[$match->getOrder()])) {
                                   echo $bets[$match->getOrder()]->getGoalsTeamHome();
                               } ?>"/></td>
                    <td><input type="text" name="bets[<?= $match->getOrder() ?>][away]" id="away"
                               value="<?php if (isset($bets[$match->getOrder()])) {
                                   echo $bets[$match->getOrder()]->getGoalsTeamAway();
                               } ?>"/></td>
                <?php } else { ?>
                    <td><?php if (isset($bets[$match->getOrder()])) {
                            echo $bets[$match->getOrder()]->getGoalsTeamHome();
                        } else {
                            echo '-';
                        } ?></td>
                    <td><?php if (isset($bets[$match->getOrder()])) {
                            echo $bets[$match->getOrder()]->getGoalsTeamAway();
                        } else {
                            echo '-';
                        } ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
<?php
if ($submit) {
    ?>
    <button type="submit">Submit</button>
    </form>
    <?php
}
?>

    <p>Matches:</p>

    <table>
        <thead>
        <tr>
            <th>No</th>
            <th>User</th>
            <?php foreach ($matchday->getMatches() as $match) { ?>
                <th><?= $match->getOrder(); ?></th>
            <?php } ?>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($users as $key => $user) { ?>
            <tr>
                <td><?= $key + 1 ?></td>
                <td><a target="_blank" href="<?= $this->container->get('router')->generate('user-profile', ['userSlug' => $user->getId()]); ?>"><?= $user->getLogin() ?></a></td>
                <?php
                foreach ($matchday->getMatches() as $match) {
                    $bet = $match->getUserBet($group, $user);
                    if (!empty($bet)) { ?>
                        <?php
                        $style = '';
                        switch ($bet->getState()) {
                            case 'won':
                                $style = 'style= "color: green"';
                                break;

                            case 'part':
                                $style = 'style= "color: yellow"';
                                break;

                            case 'lost':
                                $style = 'style= "color: red"';
                                break;
                        }
                        ?>
                        <td <?= $style; ?>><?php if (empty($errors['bets'][$match->getOrder()])) {
                                echo $bet->format() . ' (' . $bet->getScore() . ')';
                            } else {
                                echo '-.-';
                            } ?></td>
                    <?php } else { ?>
                        <td><?= '-:- (0)' ?></td>
                    <?php } ?>
                <?php } ?>
                <td><?= $user->getMatchdayScore($group, $matchday) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <a  href="<?= $this->container->get('router')->generate('group', ['slug' => $group->getId()]); ?>">Back to group</a>

<?php
var_dump($others);