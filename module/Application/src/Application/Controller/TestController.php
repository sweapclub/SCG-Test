<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Application\Models\Users;
use Zend\Json\Json;
use Zend\View\Model\JsonModel;

use Zend\Cache\StorageFactory;
use Zend\Cache\Storage\Adapter\Memcached;
use Zend\Cache\Storage\StorageInterface;
use Zend\Cache\Storage\AvailableSpaceCapableInterface;
use Zend\Cache\Storage\FlushableInterface;
use Zend\Cache\Storage\TotalSpaceCapableInterface;

/*
$this->params()->fromPost('paramname');   // From POST
$this->params()->fromQuery('paramname');  // From GET
$this->params()->fromRoute('paramname');  // From RouteMatch
$this->params()->fromHeader('paramname'); // From header
$this->params()->fromFiles('paramname');
*/

class TestController extends AbstractActionController
{
################################################################################ 
    public function __construct()
    {
        $this->cacheTime = 36000;
        $this->now = date("Y-m-d H:i:s");
        $this->config = include __DIR__ . '../../../../config/module.config.php';
        $this->adapter = new Adapter($this->config['Db']);
    }
################################################################################
    public function basic()
    {
        $view = new ViewModel();
        //Route
        $view->lang = $this->params()->fromRoute('lang', 'th');
        $view->action = $this->params()->fromRoute('action', 'index');
        $view->number = $this->params()->fromRoute('number', '');
        // $view->page = $this->params()->fromQuery('page', 1);

        return $view;       
    } 
################################################################################
    public function indexAction() 
    {
        try
        {
            $view = $this->basic();
            return $view;
        }
        catch( Exception $e )
        {
            print_r($e);
        }
    }
################################################################################

    public function firstFunction($x){
        // echo "first";
        $result = 3 + ($x * ($x-1));
        return $result;
    }

    public function secondFunction(){
        // echo "second";
        $result = 99 - (pow(2,4)) - (10 * 2);
        return $result;
    }

    public function func1Action(){
        try
        {
            // echo "do Function !";
            $view = $this->basic();
            $act = $this->params()->fromQuery('act', '');
            $view->result = "First function ! (you can change number of index at url )";
            $view->value = $this->firstFunction($view->number);
            return $view;
        }
        catch( Exception $e )
        {
            print_r($e);
        }
    }

    public function func2Action() {
        try
        {
            // echo "do Function !";
            $view = $this->basic();
            $act = $this->params()->fromQuery('act', '');
            $view->result = "Second function !";
            $view->value = $this->secondFunction();
            return $view;
        }
        catch( Exception $e )
        {
            print_r($e);
        }
    }

    // public function userAction() 
    // {
    //     try
    //     {
    //         $view = $this->basic();
    //         $act = $this->params()->fromQuery('act', '');
    //         $models = new Users($this->adapter, $view->id, $view->page);
    //         if($act == 'detail')
    //         {
    //             $view->data = $models->getList();
    //             $view->detail = $models->getDetail($view->id);
    //         }
    //         else if($act == 'add')
    //         {
    //             $name = $this->params()->fromPost('name');
    //             if($name) $models->add($name);
    //             $this->redirect()->toRoute('index', ['action'=>'user']);
    //         }
    //         else if($act == 'edit')
    //         {
    //             $name = $this->params()->fromPost('name');
    //             if($name) $models->edit($name);
    //             $this->redirect()->toRoute('index', ['action'=>'user']);
    //         }
    //         else if($act == 'del')
    //         {
    //             $models->del();
    //             $this->redirect()->toRoute('index', ['action'=>'user']);
    //         }
    //         else
    //         {
    //             $view->data = $models->getList();
    //         }
    //         return $view;
    //     }
    //     catch( Exception $e )
    //     {
    //         print_r($e);
    //     }
    // }
################################################################################
}