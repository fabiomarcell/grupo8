
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
                    <div class="fh5co-property" style="margin-bottom: 50px;">
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
    else if( $exec == 'sendMailContato'){
        require_once 'includes/phpmailer/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            $mail->SMTPDebug = 4;                         
            $mail->isSMTP();                                     
            $mail->Host = 'smtp.zoho.com'; 
            $mail->SMTPAuth = true;                   
            $mail->Username   = "contato@bitgift.com.br"; 
            $mail->Password   = "grupo!@#8!!!";
            $mail->SMTPSecure = 'ssl';                          
            $mail->Port = 465;

            $mail->From = filter_input(INPUT_POST, 'nome');
            $mail->FromName = filter_input(INPUT_POST, 'nome');
            $mail->addAddress('fabio.marcell@outlook.com');     // Add a recipient              // Name is optional
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if(!$mail->send()) {
                echo 'Message could not be sent.';
                echo 'Mailer Error: ' . $mail->ErrorInfo;
                die( json_encode( array( "status" => false, "msg" => $mail->ErrorInfo ) ) );

            } else {
                die( json_encode( array( "status" => true, "msg" => "OK" ) ) );
            }
    }
?>