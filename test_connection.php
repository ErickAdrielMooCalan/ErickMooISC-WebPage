<?php
    $host = "aws-0-us-west-1.pooler.supabase.com";
    $port = "6543";
    $dbname = "postgres";
    $user = "postgres.wwbjmorkfpbpnlmrcyas";
    $password = "9@A!4z$3#pK1B?8&2*Q7";

    // Connection string
    $conn_str = "host=$host port=$port dbname=$dbname user=$user password=$password";

    // Connection to PostgreSQL
    $conn = pg_connect($conn_str);

    if ($conn) {
        echo "Successful connection";
    } else {
        echo "Connection error";
    }

    // Close connection
    pg_close($conn);
?>
