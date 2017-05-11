<?php $view->extend('::base.html.php') ?>

<div class="head-image">
    <img src="resources/images/login/head.jpeg"/>
</div>
<div class="theme-01 background">

    <div class="content">
        <div class="dash-board">

            <h1>Dashboard</h1>

            <div class="row">
                <div class="col-phone-6">
                    <img src="<?php echo $imagePath . '/' . $user->getImage() ?>" />
                </div>
                <div class="col-phone-6">
                    <div class="dash-links">
                        <ul>
                            <li><a href="<?= $this->container->get('router')->generate('change-profile'); ?>">Profil</a></li>
                            <li><a href="<?= $this->container->get('router')->generate('logout'); ?>">Logout</a></li>
                            <li><a href="<?= $this->container->get('router')->generate('create-group'); ?>">Create Group</a></li>
                            <li><a href="<?= $this->container->get('router')->generate('groups'); ?>">Groups</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

