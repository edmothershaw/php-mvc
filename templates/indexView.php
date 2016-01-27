

<h1>MVC - PHP <?php echo ($scope->log ? '(logged in)' : '(Not logged in)') ?></h1>

<a href="index?fn=login&rv=y">Log In!</a>
<a href="index?fn=logout&rv=y">Log Out!</a> Note: url redirects some functions like inserts<br/>
into databases as multiple inserts could be dangerous.

<p><?php echo $scope->logMessage ?></p>     

<a href="index?fn=show">Show</a> Note: The URL function stays in the URL bar<br/>
<a href="index?fn=hide">Hide</a>

<br/><br/>
<a href="another">To Another View</a> 