<?php include("header.php");
        ?><!-- BODY START -->
        <div id="page-wrapper">
            <?php
            $id = filter_input( INPUT_GET, "id" );
            $dados = array();
            if ( $id != "" ) {
                $dados = gettblPlano( $id );
            }
            /* var_dump($dados, "P.planoID,
                    P.planoTitulo,
                    P.planoDescricao,
                    P.planoValorDia"); */
            ?>
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?= $id == "" ? "Cadastrar " : "Alterar " ?>Planos
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Painel de controle
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <form id="theform" onsubmit="sendForm(); return false;">
                            <div class="form-group ">
                                <label class="sr-only" for="exampleInputEmail3">&nbsp;</label>
                                <input  type="hidden" class="form-control" name="planoID" id="planoID" placeholder="" value="<?=$dados['planoID']?>">
                              </div><div class="form-group col-lg-6">
                                <label class="sr-only" for="exampleInputEmail3">&nbsp;</label>
                                <input  type="text" class="form-control" name="planoTitulo" id="planoTitulo" placeholder="Título" value="<?=$dados['planoTitulo']?>">
                              </div><div class="form-group col-lg-12">
                                <label class="sr-only" for="exampleInputEmail3">&nbsp;</label>
                                <textarea  class="form-control" name="planoDescricao" id="planoDescricao" placeholder="Descrição"><?=$dados['planoDescricao']?></textarea>
                              </div><div class="form-group col-lg-6">
                                <label class="sr-only" for="exampleInputEmail3">&nbsp;</label>
                                <input  type="text" class="form-control" name="planoValorDia" id="planoValorDia" placeholder="Valor por dia" value="<?=$dados['planoValorDia']?>">
                              </div>
                            <div class="clearfix"></div>
                            <br><br>
                            <div id="message" style="margin-bottom:10px; padding:30px;"></div>
                            <div class="pull-right">
                                <input type="hidden" name="exec" value="gerenciatblPlano">
                                <button type="submit" onclick="" class="btn btn-primary "><?= $id == "" ? "Cadastrar " : "Alterar" ?></button>
                                <button type="button" class="btn btn-primary " onclick="history.back(-1);">Cancelar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <script>
                    function sendForm(){
                    $.ajax({
                    type: "POST",
                            url: "actions.php",
                            data: $("#theform").serialize(),
                            dataType: 'json',
                            processData: true,
                            success: function (data) {
                            console.log(data);
                            $("#message").removeClass("alert-danger");
                            $("#message").removeClass("alert-info");
                            $("#message").removeClass("alert-success");
                            $("#message").html("Verificando...");
                            $("#message").addClass("alert-info");
                            $("#message").fadeIn("slow");
                            /*alert-danger alert-success*/
                            setTimeout(function () {
                            if (!data.status){
                            $("#message").removeClass("alert-danger");
                            $("#message").removeClass("alert-info");
                            $("#message").removeClass("alert-success");
                            $("#message").html(data.message);
                            $("#message").addClass("alert-danger");
                            $("#message").fadeIn("slow");
                            }
                            else{
                            $("#message").removeClass("alert-danger");
                            $("#message").removeClass("alert-info");
                            $("#message").removeClass("alert-success");
                            $("#message").html(data.message);
                            $("#message").addClass("alert-success");
                            $("#message").fadeIn("slow");
                            history.back(-1);
                            }
                            }, 1000);
                            }
                    });
                    }

                </script>
                <!-- /.row -->
                <?php include("foot.php"); ?>