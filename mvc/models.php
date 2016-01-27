<?php

$mvc->factory   
        
//Input format, variable name in controller. Array of input variables. Function that
//returns the instantiated model.
->factory('$db', array(), function() {
     
    class DB {
        
        private $servername = HOSTNAME;
        private $username = USERNAME;
        private $password = PASSWORD;
        private $dbname = DBNAME;
        
        function logIn($u, $p) {

            if ($u === 'Username' && $p === 'Password') {
                
                $_SESSION['log'] = TRUE;
            }
            
            return $_SESSION['log'];
        }
        
        function logOut() {
            
            $_SESSION['log'] = FALSE;
            
            return $_SESSION['log'];
        }

    }
    
    return new DB;
})
        

->factory('$model', array(), function() {
    
    class Model{
        
        function getInfo() {
            
            return 'This is a model output.';
            
        }
        
    }
    return new Model;
});
//Do not close of <?php with ? > 


