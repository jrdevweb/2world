<?php
session_start();
if( isset($_SESSION['uid_user_admin']))
print 'authentified';

?>
