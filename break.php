<!-- Learning tool for GD Hosting Version 2.0 Written by 

      :::::::: ::::::::: ::::::::::::::::::        :::::::: 
    :+:    :+::+:    :+::+:      :+:    :+:      :+:    :+: 
   +:+       +:+    +:++:+      +:+             +:+         
  :#:       +#++:++#: +#++:++# :#:             :#:          
 +#+   +#+#+#+    +#++#+      +#+   +#+#      +#+   +#+#    
#+#    #+##+#    #+##+#      #+#    #+#      #+#    #+#     
######## ###    #####################        ########       

-->

<div class="main">
   <div class="header">
      <div class="title"> Break Your Guide's Site
      </div>
   </div>
   <div class="container">
      <div class="row">
         <div class="column">
            <form method="post">
               <input type="submit" name="wpconfig" id="wpconfig" class="box" value="Disables Wp-Config" /><br />
            </form>
         </div>
         <div class="column">
            <form method="post">
               <input type="submit" name="permissions" id="permissions" class="box" value="Change Permissions" /><br />
            </form>
         </div>
         <div class="column">
            <form method="post">
               <input type="submit" name="index" id="index" class="box" value="Changes Index" /><br />
            </form>
         </div>
         <div class="column">
            <form method="post">
               <input type="submit" name="rickroll" id="rickroll" class="box" value="Rick Roll" /><br />
            </form>
         </div>
         <div class="column">
            <form method="post">
               <input type="submit" name="wpadmin" id="wpadmin" class="box" value="Trashes Wp-Admin" /><br />
            </form>
         </div>
      </div>
      <div class="row">
         <div class="column">
            <form method="post">
               <input type="submit" name="database" id="database" class="box" value="Rename Database" /><br />
            </form>
         </div>
         <div class="column">
            <form method="post">
               <input type="submit" name="wpconfig2" id="wpconfig2" class="box" value="Breaks Wp-Config" /><br />
            </form>
         </div>
         <div class="column">
            <form method="post">
               <input type="submit" name="comment" id="comment" class="box" value="Comments Out Wp-Config" /><br />
            </form>
         </div>
         <div class="column">
            <form method="post">
               <input type="submit" name="sandbox" id="sandbox" class="box" value="Sandboxes Hosting" /><br />
            </form>
         </div>
         <div class="column">
            <form method="post">
               <input type="submit" name="coredir" id="coredir" class="box" value="Renames Core Directories" /><br />
            </form>
         </div>
      </div>
      <div class="row">
         <div class="column">
            <form method="post">
               <input type="submit" name="wsod" id="wsod" class="box" value="Fakes WSOD" /><br />
            </form>
         </div>
         <div class="column">
            <form method="post">
               <input type="submit" name="maint" id="maint" class="box" value="Adds Maintence Page" /><br />
            </form>
         </div>
         <div class="column">
            <form method="post">
               <input type="submit" name="php" id="php" class="box" value="Adds PHP Handler" /><br />
            </form>
         </div>
      </div>
   </div>
</div>
<?php

function fun1()
{
   //Rename wp-config
   $oldDir = __DIR__ . '/wp-config.php';
   $newDir = __DIR__ . '/wp-config.php.dis';
   shell_exec("mv '$oldDir' '$newDir'");
   echo "Wp was renamed";
}

function fun2()
{
   //changes permissions for public_html, wp-admin, wp-content, wp-includes
   shell_exec("chmod 644 {wp-admin, wp-content, wp-includes}");

   shell_exec("chmod 644 ~/public_html");
   echo "Permissions changed";
}

function fun3()
{
   //Changes the index file
   $oldIn = __DIR__ . '/index.php';
   $newIn = __DIR__ . '/Index.htm';
   shell_exec("mv '$oldIn' '$newIn'");
   echo "index changed";
}

function fun4()
{

   //rickroll by changing siteurl and home in db
   //These lines get the database connection strings to be used in the following queries

   echo '<script>alert("BE AWARE RICK ROLL MAY REDIRECT ON SUBMIT AND RICK ROLL YOURSELF. I would mute if you choose this option till I fix the code.")</script>';

   $dbName = __DIR__ . '/wp-config.php';
   $database = shell_exec("grep DB_NAME $dbName | cut -d \' -f4");
   $database = trim($database);

   $user = shell_exec("grep DB_USER $dbName | cut -d \' -f4");
   $user = trim($user);

   $password = shell_exec("grep DB_PASSWORD $dbName | cut -d\' -f4;");
   $password = trim($password);

   $host = shell_exec("grep DB_HOST $dbName | cut -d\' -f4;");
   $host = trim($host);

   $tableprefix = '$table_prefix';
   $prefix = shell_exec("grep '$tableprefix' $dbName | cut -d\' -f2;");
   $prefix = trim($prefix);

   //These queries set the home and site url
   $con = mysqli_connect('localhost', $user, $password, $database);

   $options = $prefix . 'options';
   $users = $prefix . 'users';

   $query1 = "UPDATE `$options` SET `option_value` = 'http://youtube.com/watch?v=dQw4w9WgXcQ' WHERE `option_name` ='siteurl';";
   $query2 = "UPDATE `$options` SET `option_value` = 'http://youtube.com/watch?v=dQw4w9WgXcQ' WHERE `option_name` ='home';";

   $result1 = mysqli_query($con, $query1);
   $result2 = mysqli_query($con, $query2);

   mysqli_close($con);

   shell_exec("mv .htaccess .htaccess.dis");
   shell_exec("touch .htaccess");
   $payload = "Redirect 301 / http://youtube.com/watch?v=dQw4w9WgXcQ";
   shell_exec("echo '$payload' > .htaccess");
   echo "Rick Rolled";
}

function fun5()
{

   // places the wp-admin in the trash
   $wpAdmin = __DIR__ . '/wp-admin';
   shell_exec("mv $wpAdmin ~/.trash/wp-admin");
   echo "wp-admin Trashed";
}

function fun6()
{
   // Changes BD_NAME 
   shell_exec("wp config set DB_NAME notarealdatabase");
   echo "DB_NAME changed";
}

function fun7()
{ // breaks wp-config 
   shell_exec('sed -i "$((grep -nm1 [/**] wp-config.php) | cut -f 1 -d:)d" wp-config.php');
   echo "wp-config broken";
}

function fun8()
{
   // comments out connstring
   shell_exec("sed -i '/define/s/^/#/g' wp-config.php");
   echo "Conn string broken";
}

function fun9()
{
   //disables public_html and adds a new index
   shell_exec("mv ~/public_html ~/public_html.bak");
   shell_exec("mkdir public_html");
   shell_exec("touch index.html");
   $payload2 = "YOU GOT PWND";
   shell_exec("echo '$payload2' > index.html");
   shell_exec("mv ~/public_html.bak/index.html ~/public_html/index.html");
   echo "Removed public_html";
}

function fun10()
{
   //renames wp-admin, wp-includes, and wp-content
   shell_exec("mv wp-includes wpincludes");
   shell_exec("mv wp-content wpcontent");
   shell_exec("mv wp-admin wpadmin");
   echo "core Dir renamed";
}

function fun11()
{
   // Creates a fake WSOD screen 
   shell_exec("mv home.html home.html.bak");
   shell_exec("mv index.php home.html");
   shell_exec("touch index.php");
   $payload3 =
      "<div> 
      </div>
      body {
         background-color: white;
         }";
   shell_exec("echo '$payload3' > index.php");
   echo "Faking WSOD";
}

function fun12()
{
   // Adds a .maintence page to the hosting 
   shell_exec("touch .maintenance");
   $payload4 = '<?php
      $upgrading = time();
      ?>';
   shell_exec("echo '$payload4' > .maintence");
   echo "Maintenance enabled";
}
//function fun13()
//{
//   $payload5 = "AddHandler application/x-hhtpd-php52 .php";
//   $makePhp =    shell_exec("touch php.ini");
//   shell_exec("echo '$payload5' > php.ini");

//   if (isset('php.ini')) {
//      shell_exec("mv php.ini php.ini.bak");
//   } else ($makePhp
//   );
//}

if (array_key_exists('wpconfig', $_POST)) {
   fun1();
}

if (array_key_exists('permissions', $_POST)) {
   fun2();
}

if (array_key_exists('index', $_POST)) {
   fun3();
}

if (array_key_exists('rickroll', $_POST)) {
   fun4();
}

if (array_key_exists('wpadmin', $_POST)) {
   fun5();
}

if (array_key_exists('database', $_POST)) {
   fun6();
}

if (array_key_exists('wpconfig2', $_POST)) {
   fun7();
}

if (array_key_exists('comment', $_POST)) {
   fun8();
}

if (array_key_exists('sandbox', $_POST)) {
   fun9();
}

if (array_key_exists('coredir', $_POST)) {
   fun10();
}

if (array_key_exists('wsod', $_POST)) {
   fun11();
}

if (array_key_exists('maint', $_POST)) {
   fun12();
}

//if (array_key_exists('php', $_POST)) {
// fun13();
//}

?>
<style>
   body {
      background-color: #A6FFF8;
   }

   .header {
      padding-bottom: 100px;
      padding-top: 25px;
      background-color: #2B2B2B;
   }

   .title {
      text-align: center;
      color: #FED317;
      font-size: 40px;
   }

   input[type="submit"] {
      width: 250px;
      height: 100px;

   }

   .container {
      width: 100%;
      text-align: center;
   }

   .row {
      width: 100%;
      border-spacing: 10px;
      display: flex;
      flex-flow: row wrap;
      position: relative;

   }

   .column {
      flex: 1 1 calc(20% - 8px);
      border: 3px;
      padding: 20px 0;

   }

   .box {
      box-shadow: 2px 2px 4px #000000;
      border-radius: 25px;
      background-color: #A6FFF8;
   }
</style>
