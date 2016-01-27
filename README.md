# Lightweight PHP MVC

Simple and lightweight PHP MVC. Currently only supports controllers, models and views. There are
four developer files router.php, models.php controllers.php and index.php. As well as the required
views. mvc.php must be included at the top of the index.php and the $router->go($url) can be where
you like.

## Documentation
### Scope
Object is $scope. 
Variables are set with $scope-><variable name>
Functions are set with $scope->fn(<function name, <array of factory obs>, <function with $scope(required)
as input>).
Currently, factory objects in the $scope functions does not work. Instead just set the desired object
on to the $scope in the controller.

#### Using $scope functions in the view.
A function can be called by using a hyperlink GET on the state name. 
There are two function types. Add on and Refresh. 
Add on - e.g. href="index.php/index?fn=controllerFunction"

Refresh - e.g. href="index.php/index?fn=controllerFunction&rv=y"



### Controllers
Object is $contoller and has a
$controller->controller(<controller name>, <array of factory obs>, <function with $scope(required)
as input>) 
Returns the $controller object so that controllers can be concatenated. 