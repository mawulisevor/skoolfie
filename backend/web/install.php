<!DOCTYPE html>
<html>
<head>
<title>Skoolfie Installation </title>
</head>
<?php

$step = (isset($_GET['step']) && $_GET['step'] != '') ? $_GET['step'] : '';
switch($step){
  case '1':
  step_1();
  break;
  case '2':
  step_2();
  break;
  case '3':
  step_3();
  break;
  case '4':
  step_4();
  break;
  default:
  step_1();
}
function executeSQL($file)
{ 
    $sql = file_get_contents($file);
    $sqllines = split("\n",$sql);
    $cmd = '';
    $delim = false;
    foreach($sqllines as $l)
    {
        if(preg_match('/^\s*--/',$l) == 0)
        {
            if(preg_match('/DELIMITER \$\$/',$l) != 0)
            {
                $delim = true;
            }
            else
            {
                if(preg_match('/DELIMITER ;/',$l) != 0)
                {
                    $delim = false;
                }
                else
                {
                    if(preg_match('/END\$\$/',$l) != 0)
                    {
                        $cmd .= ' END';
                    }
                    else
                    {
                        $cmd .= ' ' . $l . "\n";
                    }
                }
                if(preg_match('/.+;/',$l) != 0 && !$delim)
                {
                    $result = mysql_query($cmd) or die(mysql_error());
                    $cmd = '';
                }
            }
        }
    }
}
?>
<body>

<?php
function step_1(){ 
 if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['agree'])){
  header('Location: install.php?step=2');
  exit;
 }
 if($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['agree'])){
  echo "You must agree to the license.";
 }
?>
 <h4>Skoolfie LICENSE AGREEMENT</h4>
=====================================================================
 <p>Skoolfie is provided under MIT License</p>
 <p>Copyright (c) 2016 Mawuli Sevor<br />
Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
<br />
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
</p>

 <form action="install.php?step=1" method="post">
 <p>
  I agree to the license
  <input type="checkbox" name="agree" />
 </p>
  <input type="submit" value="Continue" />
 </form>
<?php 
}


function step_2(){
  if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['pre_error'] ==''){
   header('Location: install.php?step=3');
   exit;
  }
  if($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['pre_error'] != '')
   echo $_POST['pre_error'];
      
  if (phpversion() < '5.0') {
   $pre_error = 'You need to use PHP5 or above for ARMS!<br />';
  }
  if (ini_get('session.auto_start')) {
   $pre_error .= 'ARMS will not work with session.auto_start enabled!<br />';
  }
  if (!extension_loaded('mysql')) {
   $pre_error .= 'MySQL extension needs to be loaded for ARMS to work!<br />';
  }
  if (!extension_loaded('gd')) {
   $pre_error .= 'GD extension needs to be loaded for ARMS to work!<br />';
  }
  if (!is_writable('../../common/config/main-local.php')) {
   $pre_error .= 'main-local.php needs to be writable for ARMS to be installed!';
  }
  ?>
  <table width="100%">
  <tr>
   <td>PHP Version:</td>
   <td><?php echo phpversion(); ?></td>
   <td>5.0+</td>
   <td><?php echo (phpversion() >= '5.0') ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  <tr>
   <td>Session Auto Start:</td>
   <td><?php echo (ini_get('session_auto_start')) ? 'On' : 'Off'; ?></td>
   <td>Off</td>
   <td><?php echo (!ini_get('session_auto_start')) ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  <tr>
   <td>MySQL:</td>
   <td><?php echo extension_loaded('mysql') ? 'On' : 'Off'; ?></td>
   <td>On</td>
   <td><?php echo extension_loaded('mysql') ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  <tr>
   <td>GD:</td>
   <td><?php echo extension_loaded('gd') ? 'On' : 'Off'; ?></td>
   <td>On</td>
   <td><?php echo extension_loaded('gd') ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  <tr>
   <td>main-local.php</td>
   <td><?php echo is_writable('../../common/config/main-local.php') ? 'Writable' : 'Unwritable'; ?></td>
   <td>Writable</td>
   <td><?php echo is_writable('../../common/config/main-local.php') ? 'Ok' : 'Not Ok'; ?></td>
  </tr>
  </table>
  <form action="install.php?step=2" method="post">
   <input type="hidden" name="pre_error" id="pre_error" value="<?php echo $pre_error;?>" />
   <input type="submit" name="continue" value="Continue" />
  </form>
<?php
}


function step_3(){
  if (isset($_POST['submit']) && $_POST['submit']=="Install!") {
   $database_host=isset($_POST['database_host'])?$_POST['database_host']:"";
   $database_name=isset($_POST['database_name'])?$_POST['database_name']:"";
   $database_username=isset($_POST['database_username'])?$_POST['database_username']:"";
   $database_password=isset($_POST['database_password'])?$_POST['database_password']:"";
   
   if (empty($database_host) || empty($database_username) || empty($database_name)) {
   echo "All fields are required! Please re-enter.<br />";
  } else {
   $connection = mysql_connect($database_host, $database_username, $database_password);
   $sql="DROP DATABASE IF EXISTS`".$database_name."`;";
    $result = mysql_query($sql);
    if(!$result)
    {
        echo "<h2>" . mysql_error() . "</h2>\n";
        exit;
    }
    
    $sql="CREATE DATABASE `".$database_name."` CHARACTER SET=utf8;";
    $result = mysql_query($sql);
    if(!$result)
    {
        echo "<h2>" . mysql_error() . "</h2>\n";
        exit;
    }

    $result = mysql_select_db($database_name);
    if(!$result)
    {
        echo "<h2>" . mysql_error() . "</h2>\n";
        exit;
    }
   
   $file ='../../common/config/dd1.sql';
   executeSQL($file); 
   $file ='../../common/config/dd2.sql';
   executeSQL($file); 
   mysql_close($connection);

   $f=fopen("../../common/config/main-local.php","w");
   $database_inf="<?php
     return [
        'components' => [
            'db' => [
                'class' => 'yii\db\Connection',
                'dsn' => 'mysql:host=".$database_host.";dbname=".$database_name."',
                'username' => '".$database_username."',
                'password' => '".$database_password."',
                'charset' => 'utf8',
            ],
            'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@common/mail',
                // send all mails to a file by default. You have to set
                // 'useFileTransport' to false and configure a transport
                // for the mailer to send real emails.
                'useFileTransport' => true,
            ],
        ],
     ];";

  if (fwrite($f,$database_inf)>0){
   fclose($f);
  }
  header("Location: index.php?r=install&step=4");
  }
  }
?>
  <form method="post" action="install.php?step=3">
  <p>
   <input type="text" name="database_host" value='localhost' size="30">
   <label for="database_host">Database Host</label>
 </p>
 <em>If you provide the name of an existing database, any data in it will be overwritten. <br /> 
 Please back up any data in existing database before you install ARMS.</em> <br />
 <p>
   <input type="text" name="database_name" size="30" value="<?php echo $database_name; ?>">
   <label for="database_name">Database Name</label>
 </p>
 <p>
   <input type="text" name="database_username" size="30" value="<?php echo $database_username; ?>">
   <label for="database_username">Database Username</label>
 </p>
 <p>
   <input type="password" name="database_password" size="30" value="<?php echo $database_password; ?>">
   <label for="database_password">Database Password</label>
  </p>
  <br/>
 <p>
   <input type="submit" name="submit" value="Install!">
  </p>
  </form>
<?php
}


function step_4(){
?>
 <p><a href="http://www.aims.oac/">Site home page</a></p>
 <p><a href="http://www.admin.aims.oac/">Admin page</a></p>
<?php 
}
?>