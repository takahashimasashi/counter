<?php
/**
 *
 * 
 * @author M.Katsube <Katsubemakito@gmail.com>
 * @version 1.0.0
 */

 ini_set('display_errors', 'On');

 define('DB_DSN',  'mysql:dbname=access;host=127.0.0.1');  // 接続先
define('DB_USER', 'senpai');    // MySQLのID
define('DB_PW',   'indocurry'); // MySQLのパスワード

 $dbh = connectDB(DB_DSN, DB_USER, DB_PW);

 addCounter($dbh);

 $count = getCounter($dbh);

 header('Countent-type: application/json');
 echo json_encode([
     'status' => true,
     'count' => $count
 ]);

 function connectDB($dsn, $user, $pw){
    $dbh = new PDO($dsn, $user, $pw);   //接続
    return($dbh);
}
 function addCounter($dbh){
    $sql = 'INSERT INTO access_log(accesstime) VALUES(now())';

    $sth = $dbh->prepare($sql);
    $ret = $sth->execute();

    return($ret);
}

 function getCounter($dbh){
    $sql = 'SELECT count(*) as count FROM access_log';

    $sth = $dbh->prepare($sql); 
    $sth->execute();

    $buff = $sth->fetch(PDO::FETCH_ASSOC);
    if( $buff === false){
        return(false);
    }
    else{
        return( $buff['count'] );
    }
}