
  </div>
  <div id="Footer"></div>
</div>
</body>
</html>

<?php

if(isset($User)) {
((mysqli_free_result($User) || (is_object($User) && (get_class($User) == "mysqli_result"))) ? true : false); }

if(isset($Registration)) {
((mysqli_free_result($Registration) || (is_object($Registration) && (get_class($Registration) == "mysqli_result"))) ? true : false); }

if(isset($ManageUsers)) {
((mysqli_free_result($ManageUsers) || (is_object($ManageUsers) && (get_class($ManageUsers) == "mysqli_result"))) ? true : false); }

if(isset($LogOut)) {
((mysqli_free_result($LogOut) || (is_object($LogOut) && (get_class($LogOut) == "mysqli_result"))) ? true : false); }


?>