<?php include('header.php');?>
	

	  <div id="banner">
	    <div class="centro">
	      <h2 style="height:450px;">Aqui seus bitcoins viram presentes!</h2>
	    </div>
	  </div>

	</aside>

	<div id="cupons" >
	    <div class="centro res">
	    <h3><strong>Vales-Presente Disponíveis</strong></h3>
	      <!--Stuff-->
	    </div>
	    <div class="centro">
			<p><button type="button" id="nextPage" style="background-color: transparent; border: none;"><img src="img/carregar.png" style="width:150px;"></button></p>
		</div>
		<div class="clearfix">

		</div>

	  </div>

  <div id="funcionamento" class="fundo-verde">
    <div class="centro">
      <h3>Como funciona?</h3>
      <div class="explicacao">
	<img src="img/1b.png"/>
	<p>Escolha o Vale-Presente que você desejar, são diversas opções: Submarino, Americanas, Saraiva.</p>
  </div>
      <div class="explicacao">
  <img src="img/2b.png"/>
  <p>Selecione o Valor de Bitcoin que deseja transformar em Vale-Presente!</p>
      </div>
      <div class="explicacao">
	<img src="img/3b.png"/>
	<p>Efetue sua transferência para nossa carteira de Bitcoin.</p>
      </div>
      <div class="explicacao">
	<img src="img/4b.png"/>
	<p>Receba seu Vale Presente virtual direto no seu e-mail!</p>
      </div>
       <div class="explicacao">
  <img src="img/5b.png"/>
  <p>Agora é só escolher quem presentar, você vai ser "o cara" <strong>/o/</strong></p>
      </div>
      <div id="regras"> 
      	<div class="centro">
            <h4 style="text-align:center;">Taxas, Prazos e  Valores de Vale-presente BITGIFT</h4>
        </div>
      <!--<p>Nós cobramos uma taxa mínima pela operação, de acordo com o valor do vale presente selecionado:</p>-->
  <ul>
      <li> Atualmente cobramos uma taxa de 3% por cada transação realizada e nada mais!</li>
      <li> O processo de recebimento e entrega de seu Vale-Presente pode levar até 24 horas.</li>
      <li> Os valores dos Vale-Presentes estão fixados em valores que variam de R$25 até R$100. Caso você esteja interessado em um valor superior por favor entre em contato com nossa equipe pelo contato@bitgift.com.br ou nosso Whatsapp (11) 983054953  </li>
  </ul>
       <!--<p> Nós também recebemos uma comissão do site onde você efetuar sua compra, caso você use o link enviado para seu e-mail para acessar o site parceiro. E você não paga nada a mais por isso.</p>-->
     </div>
    </div>
  </div>



	<div id="sobre" style="text-align:center;">
	    <div class="centro">
	      <h3>Sobre</h3>
	      <p>A Bitgift surgiu com o propósito de facilitar suas compras em e-commerces usando bitcoins. Você pode adquirir um vale presente de e-commerces selecionados em nosso site, <br> pagar em bitcoins e usá-lo normalmente na loja virtual. <br>Sem necessidade de efetuar transação com sua corretora, e pagando menos por isso.</p>
	    </div>
	  </div>



  <div id="contato" class="fundo-verde" style="margin-top:0;">
    <div class="centro">
      <h3>Contato</h3>
      <form id="formContato" action="" method="post" onsubmit="sendMailContato(); return false; ">
		<input type="text" name="nome" id="nome" placeholder="Informe seu nome..." required class="form-control"> 
		<input type="email" name="email" id="email" placeholder="Informe seu Email..." required class="form-control"> 
		<input type="hidden" name="exec" id="exec" value="sendMailContato"> 
		<textarea name="message" id="message" placeholder="Informe sua mensagem..." required class="form-control"></textarea>
		<br>
		<p><button type="submit" style="background-color: transparent; border: none;"><img src="img/enviar.png" style="width:150px;"></button></p>
		<span id="resContato"></span>
	</form>
    </div>
  </div>



  <!-- Go to www.addthis.com/dashboard to customize your tools --> 
  <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5892947a5dc9c102"></script> 

  <footer>
      	<section style="width:75%; display:block; margin:0 auto;">
      		<h3 style="text-align:center;">Sugestões de presentes</h3>
			<!-- Vitrine Inteligente Lomadee -->
				<script type="text/javascript" class="lomadee-recommender-script" src="//ad.lomadee.com/recommender/script/eyJwdWJsaXNoZXJJZCI6MjI3NDUzNjMsInNpdGVJZCI6MzM4OTQ0NzksInNvdXJjZUlkIjozNTc0NTM2N30%3D.js"></script>
			<!-- Vitrine Inteligente Lomadee -->
		</section>
		<section style="background-color:#333333; text-align:center; color:#FFF;" >
	    	BitGift - Aqui seus Bitcoins viram presentes © - 2017 | contato@bitgift.com.br - (11) 983054953
	    	<section style="text-align:center;">
	    		<a href="https://www.facebook.com/BitGift-177380176081273/?" target="_blank" style="margin-left:25px; color:#FFF;"><strong>facebook</sontrg></a>
	    	</section>
    	</section>
    	
  </footer>
	</div>
	
	
	<!-- jQuery -->
	<script src="js/jquery.min.js"></script>
	<!-- jQuery Easing -->
	<script src="js/jquery.easing.1.3.js"></script>
	<!-- Bootstrap -->
	<script src="js/bootstrap.min.js"></script>
	<!-- Waypoints -->
	<script src="js/jquery.waypoints.min.js"></script>
	<!-- Flexslider -->
	<script src="js/jquery.flexslider-min.js"></script>

	<!-- MAIN JS -->
	<script src="js/main.js"></script>
	<script src="js/bootbox.min.js"></script>
	
	<span id="page" style="display:none">1</span>
    <span id="trigger" style="display:none">true</span>
	<script>
            $(document).ready(function () {
                $("#nextPage").click(function (event) {
                        getPagination($("#page").html());
                });
            });
            function getPagination(pg) {
                if ($("#trigger").html() === "true") {
                    $("#trigger").html("false");
                    $(".res").fadeTo("slow", 0.3);
                    setTimeout(function () {
                        $.ajax({
                            type: "POST",
                            url: "actions.php",
                            data: {
                                exec: 'scroll',
                                pg: pg
                            },
                            dataType: 'json',
                            processData: true,
                            success: function (data) {
                                if (data.results !== "") {
                                	console.log(data);
                                    $(".res").append(data.results);
                                    setTimeout(function () {
                                        if (data.totalItens < 6) {
                                            $("#trigger").html("false");
                                            $("#nextPage").html("Sem Mais Resultados...");
                                        }
                                        else {
                                            $("#trigger").html("true");
                                        }
                                        $("#page").html(data.pg);
                                    }, 500);
                                }
                                else {
                                    $(".res").append('<div class="col-md-12"><h3>Sem Mais Resultados...</h3></div>');
                                }
                                $(".res").fadeTo("slow", 1);
                            }
                        });
                    }, 1000);
                }
            }
            getPagination(1);
        </script>
        <script>
            function sendMailContato(){
                $("#resContato").html("Aguarde...");
            	$.ajax({
	                type: "POST",
	                url: "actions.php",
	                data: $("#formContato").serialize(),
	                dataType: 'json',
	                processData: true,
	                success: function (data) {
	                    console.log(data);
	                    $("#resContato").html(data.msg);
	                    $("#formContato")[0].reset();
	                }
	            });
            }
        </script>
		<script>
			function checkSession(cupom){
				$(".res").fadeTo("slow", 0.3);
				$.ajax({
	                type: "POST",
	                url: "actions.php",
	                data: {
	                	exec: 'checkSession'
	                },
	                dataType: 'json',
	                processData: true,
	                success: function (data) {
	                    console.log(data);
	                    if(!data.status){
	                    	callRegister(cupom);
	                    }
	                    else{
	                    	novoPedido(cupom);
	                    }
	                }
	            });
			}
		</script>	
		<script>
			function callRegister(cupom){
				bootbox.confirm({
				    message: 	"Olá! Você precisa se identificar para prosseguir.<br>"+
				    			"Assim que o procedimento for finalizado, nós iremos entrar em contato diretamente com você!<br><br>"+
				    			"<input type='text' id='registerName' class='form-control' placeholder='Informe seu nome*'>"+
				    			"<input type='email' id='registerEmail' class='form-control' placeholder='Informe seu E-mail*'>"+
				    			"<input type='telefone' id='registerTelefone' class='form-control' placeholder='Informe seu Telefone(não obrigatório)'>",
				    buttons: {
				        confirm: {
				            label: 'Enviar!',
				            className: 'btn-success'
				        },
				        cancel: {
				            label: 'Cancelar...',
				            className: 'btn-danger'
				        }
				    },
				    callback: function (result) {
				    	if(result){
				    		$.ajax({
				                type: "POST",
				                url: "actions.php",
				                data: {
				                	exec: 'verifCliente',
				                	nome: $("#registerName").val(),
				                	email: $("#registerEmail").val(),
				                	telefone: $("#registerTelefone").val(),
				                },
				                dataType: 'json',
				                processData: true,
				                success: function (data) {
				                    console.log(data);
				                }
				            });
				    		//console.log('This was logged in the callback: ' + $("#registerName").val());	
                        	novoPedido(cupom);
				    	}
				    }
				});

			}
		</script>

		<script>
			function novoPedido(cupom){

				bootbox.confirm({
				    message: 	"Confirmar o pedido?",
				    buttons: {
				        confirm: {
				            label: 'Sim',
				            className: 'btn-success'
				        },
				        cancel: {
				            label: 'Não',
				            className: 'btn-danger'
				        }
				    },
				    callback: function (result) {
				    	if(result){
				    		$.ajax({
				                type: "POST",
				                url: "actions.php",
				                data: {
				                	exec: 'novoPedido',
				                	cupom: cupom
				                },
				                dataType: 'json',
				                processData: true,
				                success: function (data) {
			                        $(".res").fadeTo("slow", 1);
				                    console.log(data);
				                    if(data.status){
				                    	bootbox.alert({
										    message: "Obrigado!<br> Seu pedido foi gerado com sucesso!<br>Em breve estaremos entrando em contato com você por E-mail!"
										});
		                                $(".res").fadeTo("slow", 1);
				                    }
				                    else{
				                    	bootbox.alert({
										    message: "Houve um problema na geração do seu pedido, tente novamente mais tarde..."
										});
		                                $(".res").fadeTo("slow", 1);
				                    }
				                }
				            });
				    	}
				    	else{
                            $(".res").fadeTo("slow", 1);
				    	}
				    }
				});
			}

		</script>

	</body>
</html>

