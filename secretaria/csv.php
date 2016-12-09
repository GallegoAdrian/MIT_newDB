<?php
require('../functions.php');
$connect = connectDB();

// $select = "SELECT DISTINCT alu.id_alumno, per.nombre, mat.nota
//             FROM asignatura AS asi, matricula AS mat, alumno AS alu, persona AS per
//             WHERE asi.id_asignatura = mat.id_asignatura
//             AND mat.id_alumno = alu.id_alumno
//             AND alu.id_alumno = per.id_persona";

// $export = mysqli_query($connect, $select);

// $fields = mysqli_num_fields ( $export );

// for ( $i = 0; $i < $fields; $i++ )
// {
//     $header .=  mysqli_fetch_field_direct( $export , $i )->name . "\t"; 

// }

// while( $row = mysqli_fetch_field_direct( $export ) )
// {
//     $line = '';
//     foreach( $row as $value )
//     {                                            
//         if ( ( !isset( $value ) ) || ( $value == "" ) )
//         {
//             $value = "\t";
//         }
//         else
//         {
//             $value = str_replace( '"' , '""' , $value );
//             $value = '"' . $value . '"' . "\t";
//         }
//         $line .= $value;
//     }
//     $data .= trim( $line ) . "\n";
// }
// $data = str_replace( "\r" , "" , $data );

// if ( $data == "" )
// {
//     $data = "\n(0) Records Found!\n";
// }

// header("Content-type: application/octet-stream");
// header("Content-Disposition: attachment; filename=your_desired_name.csv");
// header("Pragma: no-cache");
// header("Expires: 0");
// print "$header\n$data";
// mysqli_close($connect);

$select = "SELECT DISTINCT alu.id_alumno, per.nombre, mat.nota
            FROM asignatura AS asi, matricula AS mat, alumno AS alu, persona AS per
            WHERE asi.id_asignatura = mat.id_asignatura
            AND mat.id_alumno = alu.id_alumno
            AND alu.id_alumno = per.id_persona";

$header = "";
$data = "";

$export = mysqli_query($connect, $select);

$fields = mysqli_num_fields ( $export );

for ( $i = 0; $i < $fields; $i++ )
{
    $header .=  mysqli_fetch_field_direct( $export , $i )->name . "\t";
}

while( $row = mysqli_fetch_row( $export ) )
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
header("Content-Disposition: attachment; filename=notas.csv");
header("Pragma: no-cache");
header("Expires: 0");
print "$header\n$data";
mysqli_close($connect);
?>