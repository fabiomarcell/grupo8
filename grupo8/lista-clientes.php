<?php include("header.php"); ?><!-- BODY START -->
                <div id="page-wrapper">

                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <div class="row">
                            <div class="col-lg-12">
                                <h1 class="page-header">
                                    Clientes
                                </h1>
                                <ol class="breadcrumb">
                                    <li class="active">
                                        <i class="fa fa-dashboard"></i> Lista de Clientes
                                    </li>
                                </ol>
                                <div id="message" style="margin-bottom:10px; padding:30px;"></div>
                            </div>
                        </div>
                        <!-- /.row -->

                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-12">
                                    <a href="inserir-clientes" class="btn btn-primary">Cadastrar Novo</a>
                                </div>

                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nome</th><th>Email</th><th>Telefone</th>
                                            <th>Manutenção</th>
                                        </tr>
                                    </thead>
                                    <tbody id="res">
                                        <?php
                                        $itens = gettblClientePaginacao( 1 );
                                        foreach ( $itens[ "pagina" ] as $item ) {
                                            ?>
                                            <tr>
                                                <td><?= $item[ "clienteNome" ] ?></td><td><?= $item[ "clienteEmail" ] ?></td><td><?= $item[ "clienteTelefone" ] ?></td>
                                                <td>
                                                    <a href="alterar-clientes/<?= $item[ "clienteID" ] ?>/">Alterar</a> || <a href="javascript:void(0);" onclick="removerRegistro('<?= $item[ "clienteID" ] ?>')" >Excluir</a><br>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                <div id="resultPaginacao"><?= $itens[ "paginacao" ] ?></div>
                            </div>
                            <script>
                                function preparePagination(obj) {

                                    if ($(obj).attr("class") != "active") {
                                        //alert($(this).attr("id"));
                                        $("#resultPaginacao").fadeTo("slow", 0.5);
                                        $("#res").fadeTo("slow", 0.5);

                                        setTimeout(function () {
                                            $.ajax({
                                            type: "POST",
                                                    url: "actions.php",
                                                    data: {
                                                    exec: "paginationBottomtblCliente",
                                                        pg: $(obj).attr("id")
                                                    },
                                                    dataType: "json",
                                                    processData: true,
                                                    success: function (data) {
                                                        console.log(data);
                                                        $("#resultPaginacao").html(data.paginacao);
                                                        $("#res").html(data.pagina);
                                                        $("html, body").animate({scrollTop: 0}, "slow");
                                                        setTimeout(function () {
                                                        $("#resultPaginacao").fadeTo("slow", 1);
                                                        $("#res").fadeTo("slow", 1);
                                                        }, 1000);
                                                    }
                                            });
                                        }, 1000);
                                    }
                                }
                                function removerRegistro(id){
                                    $("#resultPaginacao").fadeTo("slow", 0.5);
                                    $("#res").fadeTo("slow", 0.5);


                                    $("#message").removeClass("alert-danger");
                                    $("#message").removeClass("alert-info");
                                    $("#message").removeClass("alert-success");
                                    $("#message").html("Verificando...");
                                    $("#message").addClass("alert-info");
                                    $("#message").fadeIn("slow");
                                    setTimeout(function () {
                                        $.ajax({
                                        type: "POST",
                                                url: "actions.php",
                                                data: {
                                                    exec: "removerRegistro",
                                                    table: "tblCliente",
                                                    pk: "clienteID",
                                                    pkValue: id
                                                },
                                                dataType: "json",
                                                processData: true,
                                                success: function (result) {
                                                    console.log(result);
                                                    if(result.status == false){
                                                         $("#message").removeClass("alert-danger");
                                                    }
                                                    else{
                                                         $("#message").removeClass("alert-success");
                                                    }
                                                    $("#message").html(result.message);
                                                    $.ajax({
                                                        type: "POST",
                                                        url: "actions.php",
                                                        data: {
                                                        exec: "paginationBottomtblCliente",
                                                            pg: $("ul > li.active").attr("id"),
                                                        },
                                                        dataType: "json",
                                                        processData: true,
                                                        success: function (data) {
                                                            console.log(data);
                                                            $("#resultPaginacao").html(data.paginacao);
                                                            $("#res").html(data.pagina);
                                                            $("html, body").animate({scrollTop: 0}, "slow");
                                                            setTimeout(function () {
                                                            $("#resultPaginacao").fadeTo("slow", 1);
                                                            $("#res").fadeTo("slow", 1);
                                                            }, 1000);
                                                        }
                                                    });
                                                }
                                        });
                                    }, 1000);
                                }
                            </script>
                        </div>
                        <?php include("foot.php"); ?>