<!-- Learning tool for GD Hosting Version 1.1 Written by Greg G -->
<html>
	<head>
		<title>Break that site yo</title>
		<meta charset="windows-1252">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body style="text-align:center;">
	<h1> Please select an option to break the guides site </h1>
	<h1> BE AWARE RICK ROLL MAY REDIRECT ON SUBMIT AND RICK ROLL YOURSELF. I would mute if you chose this option till I fix the code.</h1>

<?php


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       // collect value of input field
        $name = $_POST['list'];
            if (empty($name)) {

            echo "Please make a selection";
          } else {
                 switch($name){
                    case 1: 
                        //Rename wp-config
						$oldDir = __DIR__. '/wp-config.php' ;
						$newDir = __DIR__. '/wp-config.php.dis';
                        shell_exec("mv '$oldDir' '$newDir'");
                        echo "Wp was renamed";						
                        break;
                    case 2:
                        //changes permissions for public_html, wp-admin, wp-content, wp-includes
						shell_exec("chmod 644 {wp-admin,wp-content,wp-includes}");
						
				        shell_exec("chmod 644 ~/public_html");
				        echo "Permissions changed";
				        break;
				    case 3:
				        //Changes the index file
				        $oldIn = __DIR__. '/index.php' ;
						$newIn = __DIR__. '/Index.htm';
                        shell_exec("mv '$oldIn' '$newIn'");
				        echo "index changed";
				        break;
				    case 4:
				        //rickroll by changing siteurl and home in db
				        //These lines get the database connection strings to be used in the following queries
				        $dbName = __DIR__. '/wp-config.php';
                        $database = shell_exec("grep DB_NAME $dbName | cut -d \' -f4");
                        $database = trim($database);

                        $user = shell_exec("grep DB_USER $dbName | cut -d \' -f4");
                        $user = trim($user);
                    
                        $password=shell_exec("grep DB_PASSWORD $dbName | cut -d\' -f4;");
                        $password=trim($password);
                    
                        $host=shell_exec("grep DB_HOST $dbName | cut -d\' -f4;"); 
                        $host=trim($host);
                    
                        $tableprefix='$table_prefix';
                        $prefix=shell_exec("grep '$tableprefix' $dbName | cut -d\' -f2;");
                        $prefix=trim($prefix);
                        
                        //These queries set the home and site url
                        $con = mysqli_connect('localhost' ,$user ,$password , $database);

                        $options = $prefix.'options';
                        $users = $prefix.'users';

                        $query1 = "UPDATE `$options` SET `option_value` = 'http://youtube.com/watch?v=dQw4w9WgXcQ' WHERE `option_name` ='siteurl';";
                        $query2 = "UPDATE `$options` SET `option_value` = 'http://youtube.com/watch?v=dQw4w9WgXcQ' WHERE `option_name` ='home';";
                       
                        $result1 = mysqli_query($con, $query1);
                        $result2 = mysqli_query($con, $query2);

                        mysqli_close($con);
                        //$htacc = __DIR__. '/.htaccess';
                        //$newHtacc = __DIR__. '/.htaccess.dis';
						shell_exec("mv .htaccess .htaccess.dis");
						shell_exec("touch .htaccess");
						$payload = "Redirect 301 / http://youtube.com/watch?v=dQw4w9WgXcQ";
						print("$payload");
						shell_exec("echo '$payload' > .htaccess");
						echo "Rick Rolled";
				        break;
					case 5:
						// places the wp-admin in the trash
						$wpAdmin = __DIR__. '/wp-admin';
						shell_exec("mv $wpAdmin ~/.trash/wp-admin");
						echo "wp-admin Trashed";
						break;
					case 6:
						// Changes BD_NAME 
						shell_exec("wp config set DB_NAME notarealdatabase");
						echo "DB_NAME changed";
						break;
					case 7:
						// breaks wp-config 
						shell_exec('sed -i "$((grep -nm1 [/**] wp-config.php) | cut -f 1 -d:)d" wp-config.php');
						echo "wp-config broken";
						break;
					case 8:
						// comments out connstring
						shell_exec("sed -i '/define/s/^/#/g' wp-config.php");
						echo "Conn string broken";
						break;
					case 9:
						
						$dbName = __DIR__. '/wp-config.php';
						$user = shell_exec("grep DB_USER $dbName | cut -d \' -f4");
                        $user = trim($user);

						$password=shell_exec("grep DB_PASSWORD $dbName | cut -d\' -f4;");
                        $password=trim($password);
						
						$database = shell_exec("grep DB_NAME $dbName | cut -d \' -f4");
                        $database = trim($database);

						//shell_exec("mysql -u '$user' -p '$password' | REVOKE ALL PRIVLIEGES, GRANT OPTION FROM '$user'@'localhost' ");

						shell_exec("mysql --user='$user' --password='$password' --database='$database' --execute='REVOKE ALL PRIVILEGES, GRANT OPTION FROM $user'");

						break;
                    default:
                        throw new Error("You did something wrong");
                 }
            }
        }
		

    ?>	

		    
	<form id="breakList" 
	    method="post" 
	    action="<?php echo $_SERVER['PHP_SELF'];?>">
                <select name="list">
                <option value="">Select </option>
				<option value="1">Disable wp-config </option>
				<option value="2">Change Perms</option>
				<option value="3">Changes index file  </option>
				<option value="4">Rickroll </option>
				<option value="5">Trash wp-admin folder </option>
				<option value="6">Change DB_NAME </option>
				<option value="7">Breaks wp-config </option>
				<option value="8">Comment out conn string </option>
				<option value="9">Clear DB User perms - TBC </option>
                </select> 
		    <input type="submit" onsubmit="return false" value="Break it">
		</form>	
		<p id="alert"></p>
	</body>
</html>

	



















