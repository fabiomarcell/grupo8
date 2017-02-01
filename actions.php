
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
        if(auxSendMail($nome, 'contato@bitgift.com.br', $message)){
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
        //die(json_encode($cliente));
        if(count($cliente) > 0){
            $_SESSION['cliente'] = $cliente;
        }
        else{
            $novoCliente = array( "clienteNome" => filter_input(INPUT_POST, 'nome'),
                                    "clienteEmail" => filter_input(INPUT_POST, 'email'),
                                    "clienteTelefone" => filter_input(INPUT_POST, 'telefone'),
                                    "clienteDescrição" => "Cadastrado no site em ".date('d/m/Y H:i:s'),
                                     );
            $returnCliente = inserttblCliente(  $novoCliente);
            $cliente = gettblClienteByNomeEmail(filter_input(INPUT_POST, 'nome'), filter_input(INPUT_POST, 'email'));
            $_SESSION['cliente']= $cliente;
        }
    }
    else if($exec == 'novoPedido'){
        $cupomID = filter_input(INPUT_POST, 'cupom');
        $cupom = gettblCupons($cupomID);
        $fields = array(
                    "pedidoTitulo" => "Compra do cliente " . $_SESSION['cliente']['clienteNome'] . ": '".$cupom['cupomTitulo']."'",
                    "pedidoStatus" => "0", //pendente
                    "cupomID" => $cupomID,
                    "clienteID" => $_SESSION['cliente']['clienteID'],
            );
        $novoPedido = inserttblPedido( $fields );
        if($novoPedido['status']){
            $message = "Novo pedido gerado pelo cliente ".$_SESSION['cliente']['clienteNome']." - ".$_SESSION['cliente']['clienteEmail'].": '".$cupom['cupomTitulo']."'";
            auxSendMail('', 'contato@bitgift.com.br', $message, 'Novo Pedido!!');

            $message = "Obrigado por ter escolhido a BitGift para trocar seus Bitcoins por cartões de presente. É uma grande satisfação ter você como usuário.<br>
            Abaixo estão os dados da carteira para onde você deverá transferir os Bitcoins. Não digite os caracteres. Corte e cole o link para executar a transferência ou utilize o leitor de QR Code para pagamento pelo aplicativo no seu celular.<br>
            <br><br>
            https://blockchain.info/address/1PwYLZHKMMtvkoKB72xy7EFEavQm2Sbq3V
            <br><br>
            Resumo do seu pedido:<br>
            Cupom selecionado: ".$cupom['cupomTitulo']." <br>
            Valor Do Cupom: R$ ".$cupom['cupomValorExibir']." <br>
            Valor Total da transferência: R$ ".$cupom['cupomValorCobrar']." <br><br>

            O seu cartão de presente selecionado será automaticamente enviado assim que identificarmos o crédito. Entre em contato conosco no telefone 11 99988 8777 ou pelo e-mail <contato@bitgift.com.br> caso tenha qualquer dúvida.<br>
            Grande abraço,<br>
            BitGift";

            auxSendMail('', $_SESSION['cliente']['clienteEmail'], $message, 'Seu pedido BitGift!');

        }
        die(json_encode($novoPedido));
    }
    








    /*********************/

    function auxSendMail($nome, $email, $message, $assunto = "Contato via site"){
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
            $mail->addAddress($email);     // Add a recipient              // Name is optional
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $assunto;
            $mail->Body    = $message;

            return $mail->send();
    }
?>