
<?php
    include("grupo8/functions.php");

    $exec = filter_input( INPUT_POST, 'exec' );
    if ( $exec == "scroll" ) {
        $pg = filter_input( INPUT_POST, 'pg' );

        $registros = getCuponsSite( $pg );

        $pg += 1;
        $html = "";
        foreach ( $registros as $registro ) {
            $html .= '<div class="cupom" style="height:auto;">
                        <a href="javascript:void(0);" onclick="checkSession('.$registro['cupomID'].')"><img src="grupo8/'.$registro['foto'].'"/></a>
                        <h4>'.$registro['cupomTitulo'].'</h4>
                        <p>'.nl2br($registro['cupomDescricao']).'</p>
                        <p class="preco">R$ '. number_format($registro['cupomValorExibir'], 2, ',', '.').'</p>
                        <a href="javascript:void(0);" onclick="checkSession('.$registro['cupomID'].')" class="tag">'.$registro['cupomOrigem'].'</a>
                        <img src="img/comprar.png" onclick="checkSession('.$registro['cupomID'].')" style="width: 80%; cursor: pointer; margin-bottom: 20px;" >
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
                                    "clienteDescricao" => "Cadastrado no site em ".date('d/m/Y H:i:s'),
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

            $message = "Muito obrigado por ter escolhido a BitGift!  É uma grande satisfação ter você como nosso cliente :)<br><br>
            Agora para procedermos com seu pedido e entrega de seu Vale-Presente você precisa completar o pagamento transferindo a quantia de Bitcoins referente ao valor de sua compra, os dados necessários estão logo abaixo:<br>
            <br><br>
            <strong>Resumo do seu pedido:</strong><br>
            Vale-Presente selecionado: ".$cupom['cupomTitulo']."<br>
            Valor Do Cupom: R$ ".$cupom['cupomValorExibir']."<br>
            Valor Total a Pagar: R$ ".$cupom['cupomValorCobrar']."<br><br>

            Endereço da carteira para transfência dos Bitcoins: 1PwYLZHKMMtvkoKB72xy7EFEavQm2Sbq3V <br><br>

            Você também pode usar o leitor de QR Code para pagamento pelo aplicativo no seu celular.<br><br>

            Para ter certeza que você está enviando para a carteira correta, disponibilizados o link dela aqui: <a href='https://blockchain.info/address/1PwYLZHKMMtvkoKB72xy7EFEavQm2Sbq3V '>https://blockchain.info/address/1PwYLZHKMMtvkoKB72xy7EFEavQm2Sbq3V </a><br><br>

            Após realizar sua transfêrencia por favor no envie o comprovante da mesma aqui mesmo por este e-mail para possamos validá-lo e entregar para você seu Vale-Presente. Normalmente este processo de confirmação e entrega de seu Vale-Presente pode levar até 24h mas fique tranquilo pois estamos aqui de prontidão para atendê-lo a qualquer dúvida. Caso ache necessário você também pode entrar em contato conos pelo Whatsapp no (11) 983054953.<br><br>
            Att,<br><br>
            Equipe BitGift";

            auxSendMail('', $_SESSION['cliente']['clienteEmail'], $message, 'BitGift - Complete sua compra!');

        }
        die(json_encode($novoPedido));
    }
    else{

        $cupomID = 13;
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

            $message = "Muito obrigado por ter escolhido a BitGift!  É uma grande satisfação ter você como nosso cliente :)<br><br>
            Agora para procedermos com seu pedido e entrega de seu Vale-Presente você precisa completar o pagamento transferindo a quantia de Bitcoins referente ao valor de sua compra, os dados necessários estão logo abaixo:<br>
            <br><br>
            <strong>Resumo do seu pedido:</strong><br>
            Vale-Presente selecionado: ".$cupom['cupomTitulo']."<br>
            Valor Do Cupom: R$ ".$cupom['cupomValorExibir']."<br>
            Valor Total a Pagar: R$ ".$cupom['cupomValorCobrar']."<br><br>

            Endereço da carteira para transfência dos Bitcoins: 1PwYLZHKMMtvkoKB72xy7EFEavQm2Sbq3V <br><br>

            Você também pode usar o leitor de QR Code para pagamento pelo aplicativo no seu celular.<br><br>

            Para ter certeza que você está enviando para a carteira correta, disponibilizados o link dela aqui: <a href='https://blockchain.info/address/1PwYLZHKMMtvkoKB72xy7EFEavQm2Sbq3V '>https://blockchain.info/address/1PwYLZHKMMtvkoKB72xy7EFEavQm2Sbq3V </a><br><br>

            Após realizar sua transfêrencia por favor no envie o comprovante da mesma aqui mesmo por este e-mail para possamos validá-lo e entregar para você seu Vale-Presente. Normalmente este processo de confirmação e entrega de seu Vale-Presente pode levar até 24h mas fique tranquilo pois estamos aqui de prontidão para atendê-lo a qualquer dúvida. Caso ache necessário você também pode entrar em contato conos pelo Whatsapp no (11) 983054953.<br><br>
            Att,<br><br>
            Equipe BitGift";

            auxSendMail('', $_SESSION['cliente']['clienteEmail'], $message, 'BitGift - Complete sua compra!');

        }
        die(json_encode($novoPedido));

    }
    








    /*********************/

    function auxSendMail($nome, $email, $message, $assunto = "Contato via site"){
        require_once 'includes/phpmailer/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            $mail->CharSet = 'UTF-8';

            $mail->SMTPDebug = 4;                         
            $mail->isSMTP();                                     
            $mail->Host = 'smtp.uhserver.com'; 
            $mail->SMTPAuth = true;                   
            $mail->Username   = "contato@bitgift.com.br"; 
            $mail->Password   = "grupo8!!!";
            $mail->SMTPSecure = 'tls';                          
            $mail->Port = 587;

            $mail->setFrom("contato@bitgift.com.br","Contato");
            $mail->addAddress($email);     // Add a recipient              // Name is optional
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $assunto;
            $mail->Body    = $message;

            return $mail->send();
    }
?>