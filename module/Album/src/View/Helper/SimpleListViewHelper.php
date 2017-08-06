<?php
namespace Album\View\Helper;

use Zend\View\Helper\AbstractHelper;

/**
 * Class SimpleListViewHelper
 * @package Album\View\Helper
 *
 *
 *
 * @link https://olegkrivtsov.github.io/using-zend-framework-3-book/html/ru/%D0%92%D0%BD%D0%B5%D1%88%D0%BD%D0%B8%D0%B9_%D0%B2%D0%B8%D0%B4_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D1%8B_%D0%B8_%D0%BB%D1%8D%D0%B9%D0%B0%D1%83%D1%82/%D0%9D%D0%B0%D0%BF%D0%B8%D1%81%D0%B0%D0%BD%D0%B8%D0%B5_%D1%81%D0%BE%D0%B1%D1%81%D1%82%D0%B2%D0%B5%D0%BD%D0%BD%D1%8B%D1%85_%D0%BF%D0%BE%D0%BC%D0%BE%D1%89%D0%BD%D0%B8%D0%BA%D0%BE%D0%B2_%D0%B2%D0%B8%D0%B4%D0%BE%D0%B2.html
 */
class SimpleListViewHelper extends AbstractHelper
{
    // Массив пунктов меню.
    protected $items = [];

    // ID активного пункта.
    protected $activeItemId = '';

    /**
     * @var string
     */
    protected $header;

    // Конструктор.
    public function __construct($items=[])
    {
        $this->items = $items;
    }

    // Задаем пункты меню.
    /**
     * @param $items
     * @return $this
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

    /**
     * @param $header
     * @return $this
     */
    public function setHeader($header)
    {
        $this->header = $header;

        return $this;
    }

    // Задаем ID активных пунктов.
    public function setActiveItemId($activeItemId)
    {
        $this->activeItemId = $activeItemId;
    }

    // Визуализация меню.
    public function render()
    {
        if (count($this->items)==0)
            return ''; // Do nothing if there are no items.

        $result = '<div>';

        if ($this->header) {
            $result .= sprintf('<h3>%s</h3>', $this->header);
        }

        $result .= '<ul>';

        // Визуализация элементов
        foreach ($this->items as $item) {
            $result .= $this->renderItem($item);
        }

        $result .= '</ul>';
        $result .= '</div>';

        return $result;
    }

    // Визуализирует элемент.
    protected function renderItem($item)
    {
        $result = '<li>';
        $result .= (string)$item;
        $result .= '</li>';

        return $result;
    }
}