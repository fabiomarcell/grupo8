<?php include("header.php");
        ?><!-- BODY START -->
        <div id="page-wrapper">
            <?php
            $id = filter_input( INPUT_GET, "id" );
            $dados = array();
            if ( $id != "" ) {
                $dados = gettblPedido( $id );
            }
            /* var_dump($dados, "P.pedidoID,
                    P.pedidoTitulo,
                    P.pedidoStatus,
                        P.cupomID,
                        P.clienteID"); */
            ?>
            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            <?= $id == "" ? "Cadastrar " : "Alterar " ?>Banner
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
                                <input  type="hidden" class="form-control" name="pedidoID" id="pedidoID" placeholder="" value="<?=$dados['pedidoID']?>">
                              </div><div class="form-group col-lg-6">
                                <label class="sr-only" for="exampleInputEmail3">&nbsp;</label>
                                <input  type="text" class="form-control" name="pedidoTitulo" id="pedidoTitulo" placeholder="Título" value="<?=$dados['pedidoTitulo']?>">
                              </div><div class="form-group col-lg-6">
                                <label class="sr-only" for="exampleInputEmail3">&nbsp;</label>
                                <input  type="text" class="form-control" name="pedidoStatus" id="pedidoStatus" placeholder="Status" value="<?=$dados['pedidoStatus']?>">
                              </div><div class="form-group col-lg-6">
                                <label class="sr-only" for="exampleInputEmail3">&nbsp;</label>
                                <select required class="form-control" name="cupomID" id="cupomID" >
                                    <option value="">Cupom</option>
                                    <?php
                                        unset($dados2);
                                        unset($item);
                                        $dados2 = getAlltblCupons();;
                                        foreach($dados2 as $item){
                                    ?>
                                        <option <?=$dados['cupomID'] == $item["cupomID"] ? "selected" : "" ?> value="<?=$item['cupomID']?>"><?=$item['cupomTitulo']?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                              </div><div class="form-group col-lg-6">
                                <label class="sr-only" for="exampleInputEmail3">&nbsp;</label>
                                <select required class="form-control" name="clienteID" id="clienteID" >
                                    <option value="">Cliente</option>
                                    <?php
                                        unset($dados2);
                                        unset($item);
                                        $dados2 = getAlltblCliente();;
                                        foreach($dados2 as $item){
                                    ?>
                                        <option <?=$dados['clienteID'] == $item["clienteID"] ? "selected" : "" ?> value="<?=$item['clienteID']?>"><?=$item['clienteNome']?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                              </div>
                            <div class="clearfix"></div>
                            <br><br>
                            <div id="message" style="margin-bottom:10px; padding:30px;"></div>
                            <div class="pull-right">
                                <input type="hidden" name="exec" value="gerenciatblPedido">
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