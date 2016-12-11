<?php

require('../functions.php');
$connect = connectDB();

$asignaturaid = $_POST['asignaturaID'];
$codigo = $_POST['codigo'];
$concat = "";

        $consultaNotas = "SELECT mat.curso_esc, mat.convoc FROM matricula AS mat, asignatura AS asi WHERE asi.id_asignatura = mat.id_asignatura AND asi.id_asignatura = '$asignaturaid'";

        $resultNotas = mysqli_query($connect, $consultaNotas);
       
        $dataNotas = mysqli_fetch_array($resultNotas);

        $curso_esc = $dataNotas["curso_esc"];
        $convoc = $dataNotas["convoc"];

if(isset($asignaturaid)){

        $select = "SELECT DISTINCT alu.id_alumno AS '$codigo', per.nombre AS '$curso_esc', mat.nota AS '$convoc'
                    FROM asignatura AS asi, matricula AS mat, alumno AS alu, persona AS per
                    WHERE asi.id_asignatura = mat.id_asignatura
                    AND mat.id_alumno = alu.id_alumno
                    AND alu.id_alumno = per.id_persona AND asi.id_asignatura = '$asignaturaid'";

        $header = "";
        $data = "";
        $export = mysqli_query($connect, $select);
        $fields = mysqli_num_fields ( $export );

        for ( $i = 0; $i < $fields; $i++ )
        {
            $header .=  mysqli_fetch_field_direct( $export , $i )->name .",";
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
                    $value = str_replace( '' , '' , $value );
                    $value = '' . $value . ',' . "\t";
                }
                $line .= $value;
            }
            $data .= trim( $line ) . "\n";
        }

        $data = str_replace( "\r" , "," , $data );
        if ( $data == "" )
        {
            $data = "\nNo hay Alumnos en esta asignatura\n";
        }

        print "$header\n$data";
}

        mysqli_close($connect);
?>