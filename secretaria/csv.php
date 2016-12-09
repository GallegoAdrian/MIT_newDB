<?php
require('../functions.php');
$connect = connectDB();

$select = "SELECT * FROM persona";

$export = mysqli_query($connect, $select);

$fields = mysqli_num_fields ( $export );

for ( $i = 0; $i < $fields; $i++ )
{
    $header .=  mysqli_fetch_field_direct( $export , $i )->name . "\t"; 

}

while( $row = mysqli_fetch_field_direct( $export ) )
{
    $line = '';
    foreach( $row as $value )
    {                                            
        if ( ( !isset( $value ) ) || ( $value == "" ) )
        {
            $value = "\t";
        }
        else
        {
            $value = str_replace( '"' , '""' , $value );
            $value = '"' . $value . '"' . "\t";
        }
        $line .= $value;
    }
    $data .= trim( $line ) . "\n";
}
$data = str_replace( "\r" , "" , $data );

if ( $data == "" )
{
    $data = "\n(0) Records Found!\n";
}

header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=your_desired_name.csv");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
mysqli_close($connect);
?>