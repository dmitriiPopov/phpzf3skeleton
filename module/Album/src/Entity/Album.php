<?php

namespace Album\Entity;

use Album\Model\BaseEntity;
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Album
 *
 * @ORM\Table(name="album")
 * @ORM\Entity
 */
class Album extends BaseEntity implements InputFilterAwareInterface
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="artist", type="string", length=100, nullable=false)
     */
    private $artist;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=100, nullable=false)
     */
    private $title;

    /**
     * @param $value
     */
    public function setId($value)
    {
        $this->id = $value;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $value
     */
    public function setArtist($value)
    {
        $this->artist = $value;
    }

    /**
     * @return string
     */
    public function getArtist()
    {
        return $this->artist;
    }

    /**
     * @param $value
     */
    public function setTitle($value)
    {
        $this->title = $value;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     * @return void
     */
    public function exchangeArray($data = [])
    {
        $this->id     = isset($data['id']) ? $data['id'] : null;
        $this->artist = isset($data['artist']) ? $data['artist'] : null;
        $this->title  = isset($data['title']) ? $data['title'] : null;
    }


    // Add the following method:
    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'artist' => $this->artist,
            'title'  => $this->title,
        ];
    }

    /*****************************************************************************************************/

    protected $inputFilter;

    /**
     * @param InputFilterInterface $inputFilter
     * @return void
     * @throws \Exception
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        //throw new \Exception("Not used");
    }

    /**
     * @return InputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $inputFilter->add(array(
                'name'     => 'id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            ));

            $inputFilter->add(array(
                //checked attribute
                'name'     => 'artist',
                'required' => true,
                //Filters
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                //Validators
                /**
                 * @link https://olegkrivtsov.github.io/using-zend-framework-3-book/html/ru/%D0%9F%D1%80%D0%BE%D0%B2%D0%B5%D1%80%D0%BA%D0%B0_%D0%B2%D1%85%D0%BE%D0%B4%D0%BD%D1%8B%D1%85_%D0%B4%D0%B0%D0%BD%D0%BD%D1%8B%D1%85_%D1%81_%D0%BF%D0%BE%D0%BC%D0%BE%D1%89%D1%8C%D1%8E_%D0%B2%D0%B0%D0%BB%D0%B8%D0%B4%D0%B0%D1%82%D0%BE%D1%80%D0%BE%D0%B2/%D0%98%D0%BD%D1%81%D1%82%D0%B0%D0%BD%D1%86%D0%B8%D1%80%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5_%D0%B2%D0%B0%D0%BB%D0%B8%D0%B4%D0%B0%D1%82%D0%BE%D1%80%D0%B0.html
                 */
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $inputFilter->add(array(
                'name'     => 'title',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            ));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}

