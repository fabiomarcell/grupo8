
<?php
    include("grupo8/functions.php");

    $exec = filter_input( INPUT_POST, 'exec' );
    if ( $exec == "scroll" ) {
        $pg = filter_input( INPUT_POST, 'pg' );

        $registros = getCuponsSite( $pg );

        $pg += 1;
        $html = "";
        foreach ( $registros as $registro ) {
            $html .= '<div class="col-md-4">
                    <div class="fh5co-property">
                        <figure>
                            <img src="grupo8/'.$registro['foto'].'" alt="" class="img-responsive">
                            <a href="#" class="tag">'.$registro['cupomOrigem'].'</a>
                        </figure>
                        <div class="fh5co-property-innter">
                            <h3>'.$registro['cupomTitulo'].'</h3>
                            <div class="price-status">
                            <span class="price">R$ '. number_format($registro['cupomValorExibir'], 2, ',', '.').' </span>
                       </div>
                       <p>'.nl2br($registro['cupomDescricao']).'</p>
                    </div>
                    
                    </div>              
                </div>';
        }
        die( json_encode( array( "results" => $html, "pg" => $pg, "totalItens" => count( $registros ) ) ) );
    }
?>