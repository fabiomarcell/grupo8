
<?php
    include("grupo8/functions.php");

    $exec = filter_input( INPUT_POST, 'exec' );
    if ( $exec == "scroll" ) {
        $pg = filter_input( INPUT_POST, 'pg' );

        $registros = getCuponsSite( $pg );

        $pg += 1;
        $html = "";
        foreach ( $registros as $registro ) {
            $html .= '<div class="cupom">
                        <img src="grupo8/'.$registro['foto'].'"/>
                        <h4>'.$registro['cupomTitulo'].'</h4>
                        <p>'.nl2br($registro['cupomDescricao']).'</p>
                        <p class="preco">R$ '. number_format($registro['cupomValorExibir'], 2, ',', '.').'</p>
                        <a href="javascript:void(0);" onclick="checkSession('.$registro['cupomID'].')" class="tag">'.$registro['cupomOrigem'].'</a>
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
        $cliente = gettblClienteByNomeEmail(filter_input(INPUT_POST, 'nome'), filter_input(INPUT_POST, 'email'));
        die(json_encode($cliente));
        if(count($cliente) > 0){
            $_SESSION['cliente'] = $cliente;
        }
        else{
            $novoCliente = array( "clienteNome" => filter_input(INPUT_POST, 'nome'),
                                    "clienteEmail" => filter_input(INPUT_POST, 'email'),
                                    "clienteDescrição" => "Cadastrado no site em ".date('d/m/Y H:i:s'),
                                     );
            $returnCliente = inserttblCliente(  $novoCliente);
            $cliente = gettblClienteByNomeEmail(filter_input(INPUT_POST, 'nome'), filter_input(INPUT_POST, 'email'));
            $_SESSION['cliente']= $cliente;
        }
    }
    else if($exec == 'novoPedido'){
        die(json_encode(var_dump($_SESSION, filter_input(INPUT_POST, 'cupom'))));
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