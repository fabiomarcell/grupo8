
<?php
    include("grupo8/functions.php");
    $exec = filter_input( INPUT_POST, 'exec' );
    if ( $exec == "scroll" ) {
        $pg = filter_input( INPUT_POST, 'pg' );
                die( json_encode( array( "results" => $html, "pg" => $pg, "totalItens" => count( $registros ) ) ) );

        $registros = getCuponsSite( $pg );
        $pg += 1;
        $html = "";
        foreach ( $registros as $registro ) {
            $html .= '<div class="col-md-4 item-block animate-box" data-animate-effect="fadeIn">
                    <div class="fh5co-property">
                        <figure>
                            <img src="images/slide_3.jpg" alt="Free Website Templates FreeHTML5.co" class="img-responsive">
                            <a href="#" class="tag">For Sale</a>
                        </figure>
                        <div class="fh5co-property-innter">
                            <h3><a href="#">Villa In Hialeah, Dade County</a></h3>
                            <div class="price-status">
                            <span class="price">$540,000 </span>
                       </div>
                       <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque dicta magni amet atque doloremque velit unde adipisci omnis hic quaerat.</p>
                    </div>
                    <p class="fh5co-property-specification">
                        <span><strong>3500</strong> Sq Ft</span>  <span><strong>3</strong> Beds</span>  <span><strong>3.5</strong> Baths</span>  <span><strong>2</strong> Garages</span>
                    </p>
                    </div>              
                </div>';
        }
        die( json_encode( array( "results" => $html, "pg" => $pg, "totalItens" => count( $registros ) ) ) );
    }
?>