<?php
namespace Album\Controller\Plugin;


use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Class HelloWorldPlugin
 * @package Album\Controller\Plugin
 */
class HelloWorldPlugin extends AbstractPlugin
{

    public function showMessage($actionName)
    {
         var_dump('hello world');
    }

}