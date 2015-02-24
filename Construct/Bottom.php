
  </div>
  <div id="Footer"></div>
</div>
</body>
</html>

<?php

if(isset($User)) {
mysql_free_result($User); }

if(isset($Registration)) {
mysql_free_result($Registration); }

if(isset($ManageUsers)) {
mysql_free_result($ManageUsers); }

if(isset($LogOut)) {
mysql_free_result($LogOut); }


?>