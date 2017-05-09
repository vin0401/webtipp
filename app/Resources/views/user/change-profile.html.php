<?php $view->extend('::base.html.php') ?>

<?php echo $view['form']->start($form) ?>
<?php echo $view['form']->errors($form) ?>

<div>
    <?php echo $view['form']->label($form['login']) ?>
    <?php echo $view['form']->errors($form['login']) ?>
    <?php echo $view['form']->widget($form['login']) ?>
</div>

<div>
    <?php echo $view['form']->label($form['mail']) ?>
    <?php echo $view['form']->errors($form['mail']) ?>
    <?php echo $view['form']->widget($form['mail']) ?>
</div>

<div>
    <?php echo $view['form']->errors($form['password']) ?>
    <?php echo $view['form']->widget($form['password']) ?>
</div>

<div>
    <?php echo $view['form']->label($form['gender']) ?>
    <?php echo $view['form']->errors($form['gender']) ?>
    <?php echo $view['form']->widget($form['gender']) ?>
</div>

<div>
    <?php echo $view['form']->label($form['nameFirst']) ?>
    <?php echo $view['form']->errors($form['nameFirst']) ?>
    <?php echo $view['form']->widget($form['nameFirst']) ?>
</div>

<div>
    <?php echo $view['form']->label($form['nameLast']) ?>
    <?php echo $view['form']->errors($form['nameLast']) ?>
    <?php echo $view['form']->widget($form['nameLast']) ?>
</div>

<div>
    <?php echo $view['form']->label($form['birthday']) ?>
    <?php echo $view['form']->errors($form['birthday']) ?>
    <?php echo $view['form']->widget($form['birthday']) ?>
</div>

<div>
    <img src="<?php echo $imagePath . '/' . $user->getImage() ?>" />
    <?php echo $view['form']->label($form['image']) ?>
    <?php echo $view['form']->errors($form['image']) ?>
    <?php echo $view['form']->widget($form['image']) ?>
</div>

<div>
    <?php echo $view['form']->widget($form['save']) ?>
</div>
<?php echo $view['form']->end($form) ?>

<a href="<?= $this->container->get('router')->generate('dashboard'); ?>">Login</a>
