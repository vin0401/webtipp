<?php echo $view['form']->form($form, array(
    'attr' => array('novalidate' => 'novalidate'),
)) ?>
<?php echo $view['form']->start($form) ?>
<?php echo $view['form']->widget($form) ?>
<?php echo $view['form']->end($form) ?>

<a href="<?= $this->container->get('router')->generate('login'); ?>">Login</a>
