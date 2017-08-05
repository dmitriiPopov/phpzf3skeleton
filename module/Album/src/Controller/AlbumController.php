<?php
namespace Album\Controller;

use Album\Entity\Album;
use Interop\Container\ContainerInterface;
//use Zend\Db\Adapter\AdapterInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
//use Album\Model\AlbumModel;
use Album\Form\AlbumForm;
use Doctrine\ORM\EntityManager;

/**
 * Class AlbumController
 * @package Album\Controller
 *
 * @link http://www.jasongrimes.org/2012/01/using-doctrine-2-in-zend-framework-2/
 */
class AlbumController extends AbstractActionController
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * AlbumController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        if (null === $this->em) {
            // Get Doctrine entity manager
            $this->em = $this->container->get(EntityManager::class);
        }
        return $this->em;
    }

    /**
     * @return ViewModel
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'albums' => $this->getEntityManager()->getRepository(Album::class)->findAll(),
        ));
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function addAction()
    {
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        /**
         * @var $request \Zend\Http\Request
         */
        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $album->exchangeArray($form->getData());

        // Add the entity to entity manager.
        $this->getEntityManager()->persist($album);
        // Apply changes to database.
        $this->getEntityManager()->flush();

        return $this->redirect()->toRoute('album');
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('album', ['action' => 'add']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $album =  $this->getEntityManager()->getRepository(Album::class)->find($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        /**
         * @var $request \Zend\Http\Request
         */
        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        // Add the entity to entity manager.
        $this->getEntityManager()->persist($album);
        // Apply changes to database.
        $this->getEntityManager()->flush();

        // Redirect to album list
        return $this->redirect()->toRoute('album', ['action' => 'index']);
    }

    /**
     * @return array|\Zend\Http\Response
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $album = $this->getEntityManager()->getRepository(Album::class)->find($id);

        /**
         * @var $request \Zend\Http\Request
         */
        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getEntityManager()->remove($album);
                $this->getEntityManager()->flush();
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return [
            'id'    => $id,
            'album' => $this->getEntityManager()->getRepository(Album::class)->find($id),
        ];
    }
}