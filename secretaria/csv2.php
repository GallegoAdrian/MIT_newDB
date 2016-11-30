<?php

require('../functions.php');
$connect = connectDB();

// $select = 'SELECT nombre,apellidos,id_persona FROM `persona`';

// $result = mysqli_query($connect, $select);

// if (!$result) die('Couldn\'t fetch records');

// $num_fields = mysqli_num_fields($result);
// echo $num_fields;
// $headers = array();

// for ($i = 0; $i < $num_fields; $i++) {
//     $headers[] = mysqli_fetch_field_direct($result , $i)->name;
//     var_dump($headers);
// }
// //$fp = fopen('php://output', 'w');

// // if ($result) {
//     header('Content-Type: text/csv');
//     header('Content-Disposition: attachment; filename="export.csv"');
//     header('Pragma: no-cache');
//     header('Expires: 0');
//     //fputcsv( $headers);
//     // while ($row = $result->fetch_array(MYSQLI_NUM)) {
//     //     fputcsv( _,array_values($row));
//     // }
//     die;
// // }

    $select = 'SELECT nombre,apellidos,id_persona FROM `persona`';

    $query = mysqli_query($connect, $select);

    $number_rows = mysqli_num_rows($query);

    if ($number_rows >= 1)
    {
        $filename = "exported_db_" . date("m-d-Y_hia") . ".csv"; // filenme with date appended
        $fp = fopen($filename, "w"); // open file

        $row = mysqli_fetch_assoc($query);

        $seperator = "";
        $comma = "";

        foreach ($row as $name => $value)
        {
            $seperator .= $comma . $name; // write first value without a comma
            $comma = ","; // add comma in front of each following value
        }
        $seperator .= "\n";

        echo "Database has been exported to $filename";

        fputs($fp, $seperator);

        mysqli_data_seek($query, 0); // use previous query leaving out first row

        while($row = mysqli_fetch_assoc($query))
        {
            $seperator = "";
            $comma = "";

            foreach ($row as $name => $value)
            {
                $seperator .= $comma . $value; // write first value without a comma
                $comma = ","; // add comma in front of each following value 
            }

            $seperator .= "\n";

            fputs($fp, $seperator);
            
        } 

        fclose($fp);
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");
         mysqli_close($connect);   

        

    }else
        echo "There are no records in the database to export.";

   

?>