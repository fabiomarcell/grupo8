
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
            //$mail->SMTPDebug = 4;                         
            $mail->isSMTP();                                     
            $mail->Host = 'smtp.zoho.com'; 
            $mail->SMTPAuth = true;                   
            $mail->Username   = "contato@bitgift.com.br"; 
            $mail->Password   = "grupo!@#8!!!";
            $mail->SMTPSecure = 'tls';                          
            $mail->Port = 587;

            $mail->setFrom("contato@bitgift.com.br","Contato .");
            $mail->addAddress('contato@bitgift.com.br');     // Add a recipient              // Name is optional
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Contato via site';
            $mail->Body    = 'Mensagem de '. filter_input(INPUT_POST, 'nome').'<'. filter_input(INPUT_POST, 'email').'>
                                <br>
                                Mensagem: "'.nl2br(filter_input(INPUT_POST, 'mensagem')).'"';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            if(!$mail->send()) {
                //echo 'Message could not be sent.';
                //echo 'Mailer Error: ' . $mail->ErrorInfo;
                die( json_encode( array( "status" => false, "msg" => "Houve um erro, tente novamente mais tarde..." ) ) );

            } else {
                die( json_encode( array( "status" => true, "msg" => "Sua mensagem foi enviada!" ) ) );
            }
    }
?>