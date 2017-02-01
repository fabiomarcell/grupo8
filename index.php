<?php include('header.php');?>
	

	  <div id="banner">
	    <div class="centro">
	      <h2>A maneira mais fácil de comprar presentes
		com Bitcoins!</h2>
	    </div>
	  </div>

	</aside>

	<div id="cupons" >
	    <div class="centro res">
	      <h3>Cupons Disponíveis</h3>
	      <!--Stuff-->
	      <div class="clear"></div>
	    </div>
	  </div>



	<div id="sobre" class="fundo-verde">
    <div class="centro">
      <h3>Sobre</h3>
      <p>A Bitgift surgiu com o propósito de facilitar suas compras em e-commerces usando bitcoins. Você pode adquirir um vale presente de e-commerces selecionados em nosso site, pagar em bitcoins e usá-lo normalmente na loja virtual. Sem necessidade de efetuar transação com sua corretora, e pagando menos por isso.</p>
    </div>
  </div>

  <div id="funcionamento">
    <div class="centro">
      <h3>Como Funciona?</h3>
      <div class="explicacao">
	<img src="img/1.png"/>
	<p>Escolha em nosso site o vale presente de um dos e-commerces parceiros</p>
  </div>
      <div class="explicacao">
  <img src="img/3.png"/>
  <p>Selecione o valor ($20, $50 ou $100)</p>
      </div>
      <div class="explicacao">
	<img src="img/3.png"/>
	<p>Efetue o pagamento em bitcoins</p>
      </div>
      <div class="explicacao">
	<img src="img/4.png"/>
	<p>Receba seu vale presente virtual por e-mail</p>
      </div>
       <div class="explicacao">
  <img src="img/5.png"/>
  <p>Use nossa solução e boas compras!</p>
      </div>
      <div class="clear"</div>
      <p id="regras">E como a Bitgift ganha com isso?</p>

      <p id="regras">Nós cobramos uma taxa mínima pela operação, de acordo com o valor do vale presente selecionado:</p>

      <p id="regras">15% para o vale presente de $20</p>
      <p id="regras">10% para o vale presente de $50</p>
      <p id="regras">5% para o vale presente de $100</p>

       <p id="regras">Nós também recebemos uma comissão do site onde você efetuar sua compra, caso você use o link enviado para seu e-mail para acessar o site parceiro. E você não paga nada a mais por isso.</p>
    </div>
  </div>

  <div id="contato" class="fundo-verde">
    <div class="centro">
      <h3>Contato</h3>
      <form id="formContato" action="" method="post" onsubmit="sendMailContato(); return false; ">
		<input type="text" name="nome" id="nome" placeholder="Informe seu nome..." required class="form-control"> 
		<input type="email" name="email" id="email" placeholder="Informe seu Email..." required class="form-control"> 
		<input type="hidden" name="exec" id="exec" value="sendMailContato"> 
		<textarea name="message" id="message" placeholder="Informe sua mensagem..." required class="form-control"></textarea>
		<br>
		<p><button type="submit" class="btn btn-primary btn-outline with-arrow">Enviar!</button></p>
		<span id="resContato"></span>
	</form>
    </div>
  </div>

  <footer>
    <a href="#">facebook</a>
    <a href="#">twitter</a>
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
                                            $("#nextPage").fadeOut();
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
			function checkSession(){
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
	                    	callRegister();
	                    }
	                    else{
	                    	novoPedido();
	                    }
	                }
	            });
			}
		</script>	
		<script>
			function callRegister(){
				bootbox.confirm({
				    message: 	"Olá! Você precisa se identificar para prosseguir.<br>"+
				    			"Assim que o procedimento for finalizado, nós iremos entrar em contato diretamente com você!<br><br>"+
				    			"<input type='text' id='registerName' class='form-control'>"+
				    			"<input type='email' id='registerEmail' class='form-control'>",
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
				                },
				                dataType: 'json',
				                processData: true,
				                success: function (data) {
				                    console.log(data);
				                }
				            });
				    		//console.log('This was logged in the callback: ' + $("#registerName").val());	
				    	}
				    }
				});
			}
		</script>
	</body>
</html>

