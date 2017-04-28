<?php
/**
 * Author: Daniel Richardt <d.richardt@dmpr-dev.de>
 * Date: 26.04.2017
 * Time: 22:09
 */
namespace WebtippBundle\Services;

abstract class ServiceAbstract
{
    final public function __construct()
    {
        if (is_callable([$this, 'init'])) {
            $arguments = func_get_args();

            call_user_func_array([$this, 'init'], $arguments);
        }
    }
}
