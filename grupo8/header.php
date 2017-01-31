<?php include("functions.php");?><!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <base href="/grupo8/" />

    <title>grupo8</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index">grupo8</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> <b class="caret"></b></a>
                    <ul class="dropdown-menu alert-dropdown">
                    <!--
                      insert - success
                      update - warning
                      delete - danger
                    -->
                      <?php
                        $logs = getLogs();
                        $arrTipoAcao = array(
                          "insert" => "success",
                          "update" => "warning",
                          "delete" => "danger"
                        );
                        foreach($logs as $log){
                      ?>
                          <li>
                              <a href="javascript:void(0);"><span class="label label-<?=$arrTipoAcao[$log["acao"]]?>"> <?=$log["acao"]?> Por <?=$log["nome"]?></span> &nbsp; <?=$log["mensagem"]?></a>
                          </li>
                      <?php
                        }
                      ?>

                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?=$_SESSION["user"]["nome"]?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="alterar-usuarios/<?=$_SESSION['user']['usuario_id']?>"><i class="fa fa-fw fa-user"></i>Perfil</a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="logout"><i class="fa fa-fw fa-power-off"></i> Logout</a>
                        </li>
                    </ul>
                </li>
            </ul><div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav"><li> <a href='lista-'></a> </li><li> <a href='lista-usuarios'>Usuários</a> </li><li> <a href='lista-clientes'>Clientes</a> </li><li> <a href='lista-cupons'>Cupons</a> </li><li> <a href='lista-pedido'>Pedido</a> </li><li> <a href='lista-planos'>Planos</a> </li></ul></div>
            <!-- /.navbar-collapse -->
        </nav>
        <!-- END HEADER.php -->