<?php

namespace Album\Form;

use Zend\Form\Form;

/**
 * Class AlbumForm
 * @package Album\Form
 *
 * @link https://github.com/xtreamwayz/zf3-album-tutorial/blob/master/module/Album/src/Form/AlbumForm.php
 * @link https://docs.zendframework.com/tutorials/getting-started/forms-and-actions/
 */
class AlbumForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('album');

        //default - POST
        //$this->setAttribute('method', 'GET');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'title',
            'type' => 'text',
            'options' => [
                'label' => 'Title',
            ],
        ]);
        $this->add([
            'name' => 'artist',
            'type' => 'text',
            'options' => [
                'label' => 'Artist',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
    }
}