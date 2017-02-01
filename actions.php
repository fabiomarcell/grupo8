
<?php
    include("grupo8/functions.php");
    $exec = filter_input( INPUT_POST, 'exec' );
    if ( $exec == "scroll" ) {
        $pg = filter_input( INPUT_POST, 'pg' );

        $registros = getCuponsSite( $pg );
                        die( json_encode( array( "results" => $html, "pg" => $pg, "totalItens" => count( $registros ) ) ) );

        $pg += 1;
        $html = "";
        foreach ( $registros as $registro ) {
            $html .= '';
        }
        die( json_encode( array( "results" => $html, "pg" => $pg, "totalItens" => count( $registros ) ) ) );
    }
?>