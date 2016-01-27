<?php

    include 'configuration.php';

    class Router {

        private $defaultUrl;
        private $views;
        private $ctrls;
        
        
        public function route($url, $view, $ctrl) {

            $this->views[$url] = $view;
            $this->ctrls[$url] = $ctrl;

        }

        public function goDefault() {
            header('Location: ' . $this->defaultUrl);
        }
        
        public function getDefaultUrl() {
            return $this->defaultUrl;
        }   

        public function setDefaultUrl($url) {
            $this->defaultUrl = $url;
        }   

        public function go($url) {
            //echo $url;
            //echo '<br>|'.$this->views[$url].'|';
            
            return $this->views[$url];
        }

        public function getCtrl($url) {
            //echo $url;
            //echo '<br>|'.$this->ctrls[$url].'|';
            
            return $this->ctrls[$url];
        }
    }

    class Scope {
        // property declaration
        //private $functions;
        public $fn;
        
        function __construct() {
            $this->fn = array();
        }
//        public function fn($fnName, $params, $fn) {
//            //$this->functions[$fnName] = $fn;
//            $this->add($fnName, $params, $fn);
//            
//        }
//        public function runScopeFn($fnName, $scope, $factory) {
//            echo "the start message";
//            $this->run($fnName, $scope, $factory);
//            echo "the final message";
//        }
        
        public function getFn($fnName) {

            return $this->getFunction($fnName);
        }

    }

    class Controller extends Module {
        
        public function controller($ctrlName, $params, $ctrlFn) {
            
            $this->add($ctrlName, $params, $ctrlFn);
            
            return $this;
        }

        public function runController($ctrlName, $scope, $factory) {
            
            $this->run($ctrlName, $scope, $factory);
            
        }
    }

    class Factory extends Module {

        public function factory($factoryName, $params, $factoryFn) {
            
            //$this->factories[$factoryName] = $factoryFn;
            $this->add($factoryName, $params, $factoryFn);
            
            //echo var_dump($this) . '<br>';
//            echo var_dump($factoryFn);
            //echo "test " . $factoryName . ' ' . var_dump($this->functions[$factoryName]);
            //echo var_dump($this->functions[$factoryName]);
            return $this;
        }

        public function getInstance($objectName) {
            //echo 'getinstance ' . $objectName . '<br>';
            
            
            $fn = $this->getFunction($objectName);
            //echo var_dump($objectName);    
            //echo "last ". var_dump($fn);
            $object = $fn();
             
            return $object;
        }
        
    }
    
    class Module {
        public $functions;        
        public $parameters;
        public $moduleName;
        
        function __construct($name) {
            $this->moduleName = $name;
        }
        
        function getModuleName() {
            return $this->moduleName;
            
        }
        
        function getFunction($fnName) {
            
            return $this->functions[$fnName];
        }
        
        function add($fnName, $params, $function) {
            
            $this->functions[$fnName] = $function;
            $this->parameters[$fnName] = $params;
            
            return $this;
        }

        function run($fnName, $scope, $factory) {
            $fn = $this->functions[$fnName];
            
            $params = $this->parameters[$fnName];

            $objects = array();
            
            //echo 'last ' . count($params);
            for ($i=0; $i<count($params); $i++){
                //echo var_dump($params[$i]);
                $objects[$i] = $factory->getInstance($params[$i]);
                
            }
            
            switch (count($params)) {
                case 1:     
                    
                    $fn($scope, $objects[0]);
                    
                    break;
                case 2:
                    
                    $fn($scope, $objects[0], $objects[1]);
                    
                    break;
                default:
                    
                    $fn($scope);
                    
                    break;
            }
            //echo "pre final";
            
        }        
    }
    
    class Mvc {
        
        public $controller; 
        public $factory;
        //private $scope;
        //public $rootScope;
        //private $router;
        
        
        function __construct() {
            $this->controller = new Controller; //Extends to Module
            $this->factory = new Factory; //
//            $this->scope = new Scope; //Defines Scope
//            $this->rootScope = new Scope;
//            $this->router = new Router; //Defines Router Unique  
        }
        
        public function controller($ctrlName, $params, $ctrlFn) {
            
            $controller->controller($ctrlName, $params, $ctrlFn);
            
            return $this;
        }
    }
    
    $mvc = new Mvc;
    
    $scope = new Scope(); //Defines Scope
    $rootScope = new Scope;
    $router = new Router; //Defines Router Unique  
    
    //$factory->factory('$scope', array(), function(){});
    
    session_start(); //Starts the session.
    
    
    //Ed business logic.
    define('ROOT', dirname(dirname(__FILE__)));
    define('CWD', getcwd());

    $scopeFnName = $_GET['fn'];    
    
    $refreshView = $_GET['rv']; //Some times a controller function will add to the pre
                                //existing code. Other times it will require a reload.
                                //Also some functions e.g. add to db and delete db are too 
                                //dangerous to leave in someones url bar.
    
    
    $uri = explode("index.php/", $_SERVER['REQUEST_URI'])[1];
    //$_SESSION['oldUri'] = $uri;
    $url = explode("?", $uri)[0];
    //echo $url;
    for ($i=0; $i<count($ROUTERS); $i++)
        include $ROUTERS[$i]; //Gets the router object.

    if ($url == "") {
        //echo "empty";
        //echo $router->getDefaultUrl();
        $redirect = $router->getDefaultUrl();
        //echo $redirect;
        header("Location: " . $redirect); //Needs to be before includes.
        //echo "end";
    }    
 
    for ($i=0; $i<count($MODELS); $i++)
        include $MODELS[$i]; //Gets the controller file.    
   
    for ($i=0; $i<count($CONTROLLERS); $i++)
        include $CONTROLLERS[$i]; //Gets the models.
    
    $ctrlName = $router->getCtrl($url); //Assigns the controller name.
    //echo $ctrlName . ' ' . $url;
         
    $mvc->controller->runController($ctrlName, $scope, $mvc->factory); 

    $mvc->controller->runController('rootScopeCtrl', $rootScope, $mvc->factory); //Runs before main controller.
        
    if ($scopeFnName != "") { 
        //echo $scopeName;
        $scopeFn = $scope->fn[$scopeFnName];
        //echo "1 " . $scopeName;
        $scopeFn($scope);
        
        if ($refreshView == "y") {
            header("Location: " . $url); //Relocates after a con has run
        }
           
    } 


