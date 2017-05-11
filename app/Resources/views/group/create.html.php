<?php $view->extend('::base.html.php') ?>
    <form method="post" action="<?= $this->container->get('router')->generate('create-group'); ?>">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" value="<?= $group->getName() ?>"/>
        <label for="points-full">Points full</label>
        <input type="text" name="points-full" id="points-full" value="<?= $group->getPointsFull() ?>"/>
        <label for="points-part">Points part</label>
        <input type="text" name="points-part" id="points-part" value="<?= $group->getPointsPart() ?>"/>
        <label for="league">League</label>
        <select name="league" id="league">
            <?php foreach ($leagues as $value => $option) { ?>
                <option value="<?= $value ?>" <?php if ($value === $league) echo "selected"; ?>><?= $option ?></option>
            <?php } ?>
        </select>
        <label for="season">Season</label>
        <select name="season" id="season">
            <?php foreach ($seasons as $option) { ?>
                <option value="<?= $option ?>" <?php if ($option === (string) $season) echo "selected"; ?>><?= $option ?></option>
            <?php } ?>
        </select>
        <label for="type">Type</label>
        <select name="type" id="type">
            <?php foreach ($types as $value => $option) { ?>
                <option value="<?= $value ?>" <?php if ($value === (string) $group->getType()) echo "selected"; ?>><?= $option ?></option>
            <?php } ?>
        </select>
        <button type="submit">Submit</button>
    </form>
    <a href="<?= $this->container->get('router')->generate('groups'); ?>">Overview</a>
<?php
if (!empty($errors)) {
    var_dump($errors);
}