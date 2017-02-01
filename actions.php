
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
                            <a href="javascript:void(0);" onclick="checkSession()" class="tag">'.$registro['cupomOrigem'].'</a>
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
        $nome = filter_input(INPUT_POST, 'nome');
        $email = filter_input(INPUT_POST, 'email');
        $message = 'Mensagem de '. $nome .' - '. $email.'
                                <br>
                                Mensagem: "'.nl2br(filter_input(INPUT_POST, 'message')).'"';
        if(auxSendMail($nome, $email, $message)){
            die( json_encode( array( "status" => true, "msg" => "Sua mensagem foi enviada!" ) ) );
        }
        else{
            die( json_encode( array( "status" => false, "msg" => "Houve um erro, tente novamente mais tarde..." ) ) );
        }
    }
    else if($exec == 'checkSession'){
        if($_SESSION['cliente']['clienteNome'] != ''){
            die( json_encode( array( "status" => true ) ) );

            //return true;
        }
        else{
            die( json_encode( array( "status" => false ) ) );
            //return false;
        }
    }
    else if($exec == 'verifCliente'){
        die(json_encode(gettblClienteByNomeEmail(filter_input(INPUT_POST, 'nome'), filter_input(INPUT_POST, 'email'))));
    }
    








    /*********************/

    function auxSendMail($nome, $email, $message){
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
            $mail->Body    = $message;

            return $mail->send();
    }
?>