<?php include('header.php');?>
	

	  <div id="banner">
	    <div class="centro">
	      <h2 style="height:450px;">Aqui seus Bitcoins viram presentes!</h2>
	    </div>
	  </div>

	</aside>

	<div id="cupons" >
	    <div class="centro res">
	    <h3><strong>Vale Presentes Disponíveis</strong></h3>
	      <!--Stuff-->
	    </div>
	    <div class="centro">
			<p><button type="button" id="nextPage" style="background-color: transparent; border: none;"><img src="img/carregar.png" style="width:150px;"></button></p>
		</div>
		<div class="clearfix">

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
      <h3>Como funciona?</h3>
      <div class="explicacao">
	<img src="img/1.png"/>
	<p>Escolha o Vale Presente que você desejar, são diversas opções: Submarino, Americanas, Saraiva.</p>
  </div>
      <div class="explicacao">
  <img src="img/2.png"/>
  <p>Selecione o Valor de Bitcoin que deseja transformar em Vale-Presente!</p>
      </div>
      <div class="explicacao">
	<img src="img/3.png"/>
	<p>Efetue sua transferência para nossa carteira de Bitcoin.</p>
      </div>
      <div class="explicacao">
	<img src="img/4.png"/>
	<p>Receba seu Vale Presente virtual direto no seu e-mail!</p>
      </div>
       <div class="explicacao">
  <img src="img/5.png"/>
  <p>Agora é só escolher quem presentar, você vai ser "o cara" <strong>/o/</strong></p>
      </div>
      <div id="regras"> 
      	<div class="centro">
            <h3 style="text-align:center;">Taxas, Prazos e  Valores de Vale-presente BITGIFT</h3>
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

  <div id="contato" class="fundo-verde">
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

	<script src="js/mainFunctions.js"></script>
	<script>
		getPagination(1); 
	</script>
	

	</body>
</html>

