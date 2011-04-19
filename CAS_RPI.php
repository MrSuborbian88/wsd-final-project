<?php

include('CAS-1.2.1/CAS.php');

phpCAS::client(CAS_VERSION_2_0,'login.rpi.edu',443,'/cas');

phpCAS::setNoCasServerValidation();

phpCAS::forceAuthentication();

if (phpCAS::getUser() != '')
{
  header('Location: final_project.php');
}

?>
