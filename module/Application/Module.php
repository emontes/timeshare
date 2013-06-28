<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Application\InputFilter\RegisterFilter;
use Application\Mapper\UserMapper;
use Application\Hydrator\UserHydrator;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    
    public function getServiceConfig() {
        
         return array(
            
            
            'invokables'=>array(
                'zfcuser_user_service'=>'Application\Service\UserService',
                ),
      
        

             'factories'=>array(
             
                 'zfcuser_register_form' => function ($sm) {
                     $options = $sm->get('zfcuser_module_options');
                     $form = new Form\RegisterForm(null, $options);
                     //$form->setCaptchaElement($sm->get('zfcuser_captcha_element'));
                     $form->setInputFilter(new RegisterFilter(
                         new \ZfcUser\Validator\NoRecordExists(array(
                             'mapper' => $sm->get('zfcuser_user_mapper'),
                             'key'    => 'email'
                         )),
                         new \ZfcUser\Validator\NoRecordExists(array(
                             'mapper' => $sm->get('zfcuser_user_mapper'),
                             'key'    => 'username'
                         )),
                         $options
                     ));
                     return $form;
                 },
             
             
                 'zfcuser_user_hydrator' => function ($sm) {
                     $hydrator = new \Zend\Stdlib\Hydrator\ClassMethods();
                     return $hydrator;
                 },
                  
                 
                 'zfcuser_user_mapper' => function ($sm) {
                     $options = $sm->get('zfcuser_module_options');
                     $mapper = new UserMapper();
                     $mapper->setDbAdapter($sm->get('zfcuser_zend_db_adapter'));
                     $entityClass = $options->getUserEntityClass();
                     $mapper->setEntityPrototype(new $entityClass);
                     $mapper->setHydrator(new UserHydrator());
                     $mapper->setTableName($options->getTableName());
                     return $mapper;
                 },
             
             ),
             
            
            
        );
    }
    
}
