<?php
namespace Album\Controller;

use Album\Entity\Album;
use Interop\Container\ContainerInterface;
//use Zend\Db\Adapter\AdapterInterface;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;
//use Album\Model\AlbumModel;
use Album\Form\AlbumForm;
use Doctrine\ORM\EntityManager;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as ORMAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;


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
     * Мы переопределяем метод родительского класса onDispatch(),
     * чтобы установить альтернативный лэйаут для всех действий в этом контроллере.
     */
    public function onDispatch(\Zend\MVC\MvcEvent $e)
    {
        // Вызываем метод базового класса onDispatch() и получаем ответ
        $response = parent::onDispatch($e);

        // Устанавливаем альтернативный лэйаут
        $this->layout()->setTemplate('album/layout/layout');

        // Возвращаем ответ
        return $response;
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
    public function indexAction($limit = 10)
    {

        //CALL TEST PLUGIN - /module/Album/config/module.config.php
        //$this->helloworld()->showMessage('index');

        $page = $this->params()->fromQuery('page', 1);

        $dbQueryBuilder = $this->getEntityManager()->createQueryBuilder();

        $dbQueryBuilder->select('album')
            ->from(Album::class, 'album')
            //->orderBy('album.title')
            ->setMaxResults($limit)
            ->setFirstResult($page-1 * $limit);

        $query = $dbQueryBuilder->getQuery();

        // Создаем ZF3 пагинатор.
        $adapter   = new ORMAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);

        // Устанавливаем номер страницы и размер страницы.
        $paginator->setDefaultItemCountPerPage($limit);
        $paginator->setCurrentPageNumber($page);

        $viewModel =  new ViewModel();
        $viewModel->setVariable('albumsPaginator', $paginator);

        return $viewModel;
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
        //$form->setInputFilter($album->getInputFilter());
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

    /**
     * @return JsonModel
     */
    public function getJsonAction()
    {
        return new JsonModel([
            'status' => 'SUCCESS',
            'message'=>'Here is your data',
            'data' => [
                'full_name' => 'John Doe',
                'address' => '51 Middle st.'
            ]
        ]);
    }

    /**
     * Action for custom route class (for example)
     * @return void|ViewModel
     */
    public function staticAction()
    {
        // Получаем путь к шаблону представления от параметров маршрута
        $pageTemplate = $this->params()->fromRoute('page', null);
        if($pageTemplate==null) {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        // Визуализируем страницу
        $viewModel = new ViewModel([
            'page'=>$pageTemplate
        ]);
        $viewModel->setTemplate($pageTemplate);
        return $viewModel;
    }
}