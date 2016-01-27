<?php
$mvc->controller->
        
        
controller('rootScopeCtrl', array(), function($rootScope) {

    //Runs on every page.
    $rootScope->message = 'Hello world!';
})

->controller('indexCtrl', array('$db', '$model'), function($scope, $db, $model) {   
    
    $scope->logMessage = '';
    $scope->log = $_SESSION['log'];
    
    //Scope functions specified using the $scope->fn[<name of function>] = fucntion() {}
    //Again scope must be parsed to the scope functions. Using 'use'
    $scope->fn['show'] = function($scope) {
        
        $scope->logMessage = 'Showing';
            
    };

    $scope->fn['hide'] = function($scope) {
        
        
        $scope->logMessage = '';
    };
    
    $scope->fn['login'] = function($scope) use ($db) {
     
         $db->logIn('Username', 'Password');
        //echo $scope->log;
    };

    $scope->fn['logout'] = function($scope) use ($db) {
     
        $scope->log = $db->logOut();
    };
})
// $scope must always be parsed to the controller function. Extra models must be 
//specified via the object array. These strings must match the model string names.
->controller('anotherCtrl', array('$db', '$model'), function($scope, $db, $model) use ($router) {


 
    
});
 
//Do not close of <?php with ? > 
