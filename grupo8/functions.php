<?php session_start();
            header( 'Content-Type: text/html; charset=utf-8' );
                    $db = "grupo8";

                    $dsn = "mysql:host=localhost;dbname=" . $db;
                    $usuario = "root";
                    $senha = "grupo!@#8!!!";
                    $opcoes = array(
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                    );

                    global $pdo, $img;
                    $img = "upload/img/";

                    try {
                        $pdo = new PDO( $dsn, $usuario, $senha, $opcoes );
                    }
                    catch ( PDOException $e ) {
                        Echo "Ocorreu um erro, veja o log para maiores informações";
                        exit;
                    }

                    /*usado na paginação*/
                    function getQuery( $sql ) {
                        global $pdo, $img;

                        $results = array();
                        foreach ( $pdo->query( $sql ) as $row ) {
                            $results[] = $row;
                        }
                        //die(json_encode($sql));
                        return $results;
                    }

                    function getPaginacao( $sql, $pgSolicitada = 1, $qtd = 20 ) {
                            global $pdo, $img;

                            $qtdPaginas = 9;
                            $itensPagina = $qtd;
                            $itensFim = $itensPagina * $pgSolicitada;
                            $itensInicio = $itensFim - $itensPagina;
                            $totalPaginas;
                            $totalItens;
                            //echo $sql;
                            foreach ( $pdo->query( $sql ) as $row ) {
                                $totalItens = $row[ 0 ];
                            }


                            $totalPaginas = intval( $totalItens / $itensPagina );
                            $decimal = gmp_div_r( $totalItens, $itensPagina );
                            if ( $decimal != 0 ) {
                                $totalPaginas++;
                            }



                            $x = 1;
                            $pgs;
                            if ( $pgSolicitada >= $qtdPaginas ) {
                                $x = $pgSolicitada - 4;
                                $qtdPaginas += $pgSolicitada - 5;

                                if ( $qtdPaginas > $totalPaginas ) {
                                    $x += $totalPaginas - $qtdPaginas;
                                    $qtdPaginas = $totalPaginas;
                                    //$x = $pgSolicitada-5;
                                }

                                if ( $pgSolicitada == $totalPaginas ) {
                                    $x = $pgSolicitada - 9;
                                }
                            }

                            $qtdPaginas = ($qtdPaginas > $totalPaginas ? $totalPaginas : $qtdPaginas);

                            if ( $x <= 0 ) {
                                $x = 1;
                            }

                            while ( $x <= $qtdPaginas ) {
                                $active = ( $x == $pgSolicitada ? "class='active'" : "" );
                                $pgs .= '<li onclick="preparePagination(this)" ' . $active . ' id="goTo-' . $x . '"><a>' . $x . '</a></li>';
                                $x++;
                            }

                            $btnFirst;
                            $btnLast;

                            if ( $pgSolicitada != 1 ) {
                                $btnFirst = '<li onclick="preparePagination(this)" id="goTo-' . ($pgSolicitada - 1) . '"><a aria-label="Previous"><span aria-hidden="true">«</span></a></li>';
                            }
                            if ( $pgSolicitada != $qtdPaginas && $qtdPaginas != 0 ) {
                                $btnLast = '<li onclick="preparePagination(this)" id="goTo-' . ($pgSolicitada + 1) . '"><a aria-label="Next"><span aria-hidden="true">»</span></a></li>';
                            }

                            //var_dump($totalPaginas, $itensPagina, $itensInicio, $itensFim);
                            return '<nav class="text-right" style="margin-right: 15px;"><ul class="pagination">' . $btnFirst . $pgs . $btnLast . '</ul></nav>';
                        }
                        function updateImg( $field, $name, $dir, $fieldPK, $table, $id = 0 ) {
                            global $pdo, $img;
                            try {
                                $sql = "update " . $table . " set
                                                            " . $field . " = '" . $name . "'
                                                            where " . $fieldPK . " = " . $id;
                                $stmt = $pdo->prepare( $sql );
                                $stmt->execute();
                                $erro = $stmt->errorInfo();
                                $valErro = $erro[ 0 ];
                                if ( $valErro !== "00000" ) {
                                    return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                                }
                            }
                            catch ( PDOException $e ) {
                                return array( "status" => false, "message" => $e->getMessage() );
                            }
                            return array( "status" => true, "message" => "Registro efetuado com sucesso!", "img" => $img.$dir.$name);
                        }
                        function removerRegistro($table, $pk, $pkValue){
                            global $pdo, $img;
                            try {
                                $sql = "Delete from ".$table."
                                        where " . $pk . " = " . $pkValue;
                                $stmt = $pdo->prepare( $sql );
                                $stmt->execute();
                                $erro = $stmt->errorInfo();
                                $valErro = $erro[ 0 ];
                                if ( $valErro !== "00000" ) {
                                    return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                                }
                            }
                            catch ( PDOException $e ) {
                                return array( "status" => false, "message" => $e->getMessage() );
                            }
                            return array( "status" => true, "message" => "Registro removido com sucesso!");
                        }
                        function getLogin( $email, $senha ) {
                            global $pdo, $img;

                            $results = array();
                            $sql = "SELECT usuario_id,
                                            nome,
                                            login,
                                            senha
                                    FROM ___usuarios where login = :email and senha = :senha";
                            $stmt = $pdo->prepare( $sql );
                            $stmt->execute(
                                    array(
                                        ':email' => $email,
                                        ':senha' => $senha
                                    )
                            );

                            foreach ( $stmt->fetchAll() as $row ) {
                                return $row;
                            }
                        }

                        function getLogs( ) {
                            global $pdo, $img;

                            $results = array();
                            $sql = "SELECT
                                    usuario_id,
                                    log_id,
                                    usuario_id,
                                    (select nome from ___usuarios where usuario_id = l.usuario_id limit 1) as nome,
                                    acao,
                                    mensagem
                                    FROM ___logs l  LIMIT 10";
                            $stmt = $pdo->prepare( $sql );
                            $stmt->execute( );

                            foreach ( $stmt->fetchAll() as $row ) {
                                $results[] = $row;
                            }
                            return $results;
                        }
                        function insertLogs($acao, $mensagem){
                          global $pdo, $img;
                          $pdo->query("insert into ___logs values('', '".$_SESSION[ 'user' ]['usuario_id']."', '".$acao."', '".$mensagem."')");
                        }


            //___usuarios
                function getAll___usuarios(){
                    global $pdo, $img;
                    $sql = "select u.usuario_id,
                    u.nome,
                    u.login,
                    u.senha from ___usuarios u
                    ";

                    $results = array();
                    foreach ( $pdo->query( $sql ) as $row ) {
                        $results[] = $row;
                    }
                    return $results;
                }

                function get___usuarios( $id ) {
                    global $pdo, $img;
                    try {
                        $sql = "select u.usuario_id,
                    u.nome,
                    u.login,
                    u.senha from ___usuarios u
                            where usuario_id = :id";
                        $query = $pdo->prepare( $sql );

                        $query->bindParam( ":id", $id );
                        $query->execute();

                        foreach ( $query->fetchAll() as $row ) {
                            return $row;
                        }
                    }
                    catch ( PDOException $e ) {
                        return false;;
                        exit;
                    }
                }
                function get___usuariosPaginacao( $pg = 1, $filtro = NULL, $qtd = 20 ) {
                    global $img;

                    $finish = ($pg - 1) * $qtd;
                    $start = $finish - $qtd;
                    $where = "";
                    $and;

                    $sql = "select u.usuario_id,
                    u.nome,
                    u.login,
                    u.senha from ___usuarios u
                    
                            " . $where . "
                            LIMIT " . $qtd . " OFFSET " . $finish;
                    //die(json_encode($sql));

                    $pagina = getQuery( $sql );

                    $sql = "select count(*) from ___usuarios u
                    
                            " . $where;

                    $paginacao = getPaginacao( $sql, $pg, $qtd );
                    $arrRetorno = array( "pagina" => $pagina, "paginacao" => $paginacao );
                    return $arrRetorno;
                }

                function insert___usuarios( $fields ) {
                    global $pdo, $img;
                    try {

                        $stmt = $pdo->prepare( "insert into ___usuarios
                    (nome,
                        login,
                        senha)
                    values
                    (:nome,
                        :login,
                        :senha)" );
                        $stmt->execute(
                                array(
                                    ":nome" => $fields["nome"],
                        ":login" => $fields["login"],
                        ":senha" => $fields["senha"]
                                )
                        );
                        $erro = $stmt->errorInfo();
                        $valErro = $erro[ 0 ];
                        if ( $valErro !== "00000" ) {
                            insertLogs("insert", "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco. (___usuarios)");
                            return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                        }
                    }
                    catch ( PDOException $e ) {
                        insertLogs("insert", $e->getMessage()." (___usuarios) ");
                        return array( "status" => false, "message" => $e->getMessage() );
                    }
                    $id = $pdo->lastInsertId();
                    insertLogs("insert", "Registro efetuado com sucesso! (___usuarios)");
                    return array( "status" => true, "message" => "Registro efetuado com sucesso!", "ID" => $id);
                }

                function update___usuarios( $fields, $pk ) {
                    global $pdo, $img;
                    try {

                        $stmt = $pdo->prepare( "update ___usuarios set
                    nome = :nome,
                        login = :login,
                        senha = :senha
                    Where usuario_id = :usuario_id" );
                        $stmt->execute(
                                array(
                                    ":usuario_id" => $pk,":nome" => $fields["nome"],
                        ":login" => $fields["login"],
                        ":senha" => $fields["senha"]
                                )
                        );
                        $erro = $stmt->errorInfo();
                        $valErro = $erro[ 0 ];
                        if ( $valErro !== "00000" ) {
                            insertLogs("update", "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco. (___usuarios)");
                            return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                        }
                    }
                    catch ( PDOException $e ) {
                        insertLogs("update", $e->getMessage()." (___usuarios)");
                        return array( "status" => false, "message" => $e->getMessage() );
                    }
                    insertLogs("update", "Registro alterado com sucesso! (___usuarios)");
                    return array( "status" => true, "message" => "Registro alterado com sucesso!", "ID" => $pk);
                }
            //___logs
                function getAll___logs(){
                    global $pdo, $img;
                    $sql = "select l.log_id,
                    u.nome,
                        l.usuario_id,
                    l.acao,
                    l.mensagem from ___logs l
                    inner join ___usuarios u on u.usuario_id = l.usuario_id
                                ";

                    $results = array();
                    foreach ( $pdo->query( $sql ) as $row ) {
                        $results[] = $row;
                    }
                    return $results;
                }

                function get___logs( $id ) {
                    global $pdo, $img;
                    try {
                        $sql = "select l.log_id,
                        l.usuario_id,
                    l.acao,
                    l.mensagem from ___logs l
                            where log_id = :id";
                        $query = $pdo->prepare( $sql );

                        $query->bindParam( ":id", $id );
                        $query->execute();

                        foreach ( $query->fetchAll() as $row ) {
                            return $row;
                        }
                    }
                    catch ( PDOException $e ) {
                        return false;;
                        exit;
                    }
                }
                function get___logsPaginacao( $pg = 1, $filtro = NULL, $qtd = 20 ) {
                    global $img;

                    $finish = ($pg - 1) * $qtd;
                    $start = $finish - $qtd;
                    $where = "";
                    $and;

                    $sql = "select l.log_id,
                    u.nome,
                        l.usuario_id,
                    l.acao,
                    l.mensagem from ___logs l
                    inner join ___usuarios u on u.usuario_id = l.usuario_id
                                
                            " . $where . "
                            LIMIT " . $qtd . " OFFSET " . $finish;
                    //die(json_encode($sql));

                    $pagina = getQuery( $sql );

                    $sql = "select count(*) from ___logs l
                    inner join ___usuarios u on u.usuario_id = l.usuario_id
                                
                            " . $where;

                    $paginacao = getPaginacao( $sql, $pg, $qtd );
                    $arrRetorno = array( "pagina" => $pagina, "paginacao" => $paginacao );
                    return $arrRetorno;
                }

                function insert___logs( $fields ) {
                    global $pdo, $img;
                    try {

                        $stmt = $pdo->prepare( "insert into ___logs
                    (usuario_id,
                        acao,
                        mensagem)
                    values
                    (:usuario_id,
                        :acao,
                        :mensagem)" );
                        $stmt->execute(
                                array(
                                    ":usuario_id" => $fields["usuario_id"],
                        ":acao" => $fields["acao"],
                        ":mensagem" => $fields["mensagem"]
                                )
                        );
                        $erro = $stmt->errorInfo();
                        $valErro = $erro[ 0 ];
                        if ( $valErro !== "00000" ) {
                            insertLogs("insert", "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco. (___logs)");
                            return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                        }
                    }
                    catch ( PDOException $e ) {
                        insertLogs("insert", $e->getMessage()." (___logs) ");
                        return array( "status" => false, "message" => $e->getMessage() );
                    }
                    $id = $pdo->lastInsertId();
                    insertLogs("insert", "Registro efetuado com sucesso! (___logs)");
                    return array( "status" => true, "message" => "Registro efetuado com sucesso!", "ID" => $id);
                }

                function update___logs( $fields, $pk ) {
                    global $pdo, $img;
                    try {

                        $stmt = $pdo->prepare( "update ___logs set
                    usuario_id = :usuario_id,
                        acao = :acao,
                        mensagem = :mensagem
                    Where log_id = :log_id" );
                        $stmt->execute(
                                array(
                                    ":log_id" => $pk,":usuario_id" => $fields["usuario_id"],
                        ":acao" => $fields["acao"],
                        ":mensagem" => $fields["mensagem"]
                                )
                        );
                        $erro = $stmt->errorInfo();
                        $valErro = $erro[ 0 ];
                        if ( $valErro !== "00000" ) {
                            insertLogs("update", "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco. (___logs)");
                            return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                        }
                    }
                    catch ( PDOException $e ) {
                        insertLogs("update", $e->getMessage()." (___logs)");
                        return array( "status" => false, "message" => $e->getMessage() );
                    }
                    insertLogs("update", "Registro alterado com sucesso! (___logs)");
                    return array( "status" => true, "message" => "Registro alterado com sucesso!", "ID" => $pk);
                }
            //tblPlano
                function getAlltblPlano(){
                    global $pdo, $img;
                    $sql = "select P.planoID,
                    P.planoTitulo,
                    P.planoDescricao,
                    P.planoValorDia from tblPlano P
                    ";

                    $results = array();
                    foreach ( $pdo->query( $sql ) as $row ) {
                        $results[] = $row;
                    }
                    return $results;
                }

                function gettblPlano( $id ) {
                    global $pdo, $img;
                    try {
                        $sql = "select P.planoID,
                    P.planoTitulo,
                    P.planoDescricao,
                    P.planoValorDia from tblPlano P
                            where planoID = :id";
                        $query = $pdo->prepare( $sql );

                        $query->bindParam( ":id", $id );
                        $query->execute();

                        foreach ( $query->fetchAll() as $row ) {
                            return $row;
                        }
                    }
                    catch ( PDOException $e ) {
                        return false;;
                        exit;
                    }
                }
                function gettblPlanoPaginacao( $pg = 1, $filtro = NULL, $qtd = 20 ) {
                    global $img;

                    $finish = ($pg - 1) * $qtd;
                    $start = $finish - $qtd;
                    $where = "";
                    $and;

                    $sql = "select P.planoID,
                    P.planoTitulo,
                    P.planoDescricao,
                    P.planoValorDia from tblPlano P
                    
                            " . $where . "
                            LIMIT " . $qtd . " OFFSET " . $finish;
                    //die(json_encode($sql));

                    $pagina = getQuery( $sql );

                    $sql = "select count(*) from tblPlano P
                    
                            " . $where;

                    $paginacao = getPaginacao( $sql, $pg, $qtd );
                    $arrRetorno = array( "pagina" => $pagina, "paginacao" => $paginacao );
                    return $arrRetorno;
                }

                function inserttblPlano( $fields ) {
                    global $pdo, $img;
                    try {

                        $stmt = $pdo->prepare( "insert into tblPlano
                    (planoTitulo,
                        planoDescricao,
                        planoValorDia)
                    values
                    (:planoTitulo,
                        :planoDescricao,
                        :planoValorDia)" );
                        $stmt->execute(
                                array(
                                    ":planoTitulo" => $fields["planoTitulo"],
                        ":planoDescricao" => $fields["planoDescricao"],
                        ":planoValorDia" => $fields["planoValorDia"]
                                )
                        );
                        $erro = $stmt->errorInfo();
                        $valErro = $erro[ 0 ];
                        if ( $valErro !== "00000" ) {
                            insertLogs("insert", "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco. (tblPlano)");
                            return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                        }
                    }
                    catch ( PDOException $e ) {
                        insertLogs("insert", $e->getMessage()." (tblPlano) ");
                        return array( "status" => false, "message" => $e->getMessage() );
                    }
                    $id = $pdo->lastInsertId();
                    insertLogs("insert", "Registro efetuado com sucesso! (tblPlano)");
                    return array( "status" => true, "message" => "Registro efetuado com sucesso!", "ID" => $id);
                }

                function updatetblPlano( $fields, $pk ) {
                    global $pdo, $img;
                    try {

                        $stmt = $pdo->prepare( "update tblPlano set
                    planoTitulo = :planoTitulo,
                        planoDescricao = :planoDescricao,
                        planoValorDia = :planoValorDia
                    Where planoID = :planoID" );
                        $stmt->execute(
                                array(
                                    ":planoID" => $pk,":planoTitulo" => $fields["planoTitulo"],
                        ":planoDescricao" => $fields["planoDescricao"],
                        ":planoValorDia" => $fields["planoValorDia"]
                                )
                        );
                        $erro = $stmt->errorInfo();
                        $valErro = $erro[ 0 ];
                        if ( $valErro !== "00000" ) {
                            insertLogs("update", "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco. (tblPlano)");
                            return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                        }
                    }
                    catch ( PDOException $e ) {
                        insertLogs("update", $e->getMessage()." (tblPlano)");
                        return array( "status" => false, "message" => $e->getMessage() );
                    }
                    insertLogs("update", "Registro alterado com sucesso! (tblPlano)");
                    return array( "status" => true, "message" => "Registro alterado com sucesso!", "ID" => $pk);
                }
            //tblPedido
                function getAlltblPedido(){
                    global $pdo, $img;
                    $sql = "select P.pedidoID,
                    P.pedidoTitulo,
                    P.pedidoStatus,
                    C.cupomTitulo,
                        P.cupomID,
                    C.clienteNome,
                        P.clienteID from tblPedido P
                    inner join tblCupons C on C.cupomID = P.cupomID
                                inner join tblCliente C on C.clienteID = P.clienteID
                                ";

                    $results = array();
                    foreach ( $pdo->query( $sql ) as $row ) {
                        $results[] = $row;
                    }
                    return $results;
                }

                function gettblPedido( $id ) {
                    global $pdo, $img;
                    try {
                        $sql = "select P.pedidoID,
                    P.pedidoTitulo,
                    P.pedidoStatus,
                        P.cupomID,
                        P.clienteID from tblPedido P
                            where pedidoID = :id";
                        $query = $pdo->prepare( $sql );

                        $query->bindParam( ":id", $id );
                        $query->execute();

                        foreach ( $query->fetchAll() as $row ) {
                            return $row;
                        }
                    }
                    catch ( PDOException $e ) {
                        return false;;
                        exit;
                    }
                }
                function gettblPedidoPaginacao( $pg = 1, $filtro = NULL, $qtd = 20 ) {
                    global $img;

                    $finish = ($pg - 1) * $qtd;
                    $start = $finish - $qtd;
                    $where = "";
                    $and;

                    $sql = "select P.pedidoID,
                    P.pedidoTitulo,
                    P.pedidoStatus,
                    C.cupomTitulo,
                        P.cupomID,
                    C.clienteNome,
                        P.clienteID from tblPedido P
                    inner join tblCupons C on C.cupomID = P.cupomID
                                inner join tblCliente C on C.clienteID = P.clienteID
                                
                            " . $where . "
                            LIMIT " . $qtd . " OFFSET " . $finish;
                    //die(json_encode($sql));

                    $pagina = getQuery( $sql );

                    $sql = "select count(*) from tblPedido P
                    inner join tblCupons C on C.cupomID = P.cupomID
                                inner join tblCliente C on C.clienteID = P.clienteID
                                
                            " . $where;

                    $paginacao = getPaginacao( $sql, $pg, $qtd );
                    $arrRetorno = array( "pagina" => $pagina, "paginacao" => $paginacao );
                    return $arrRetorno;
                }

                function inserttblPedido( $fields ) {
                    global $pdo, $img;
                    try {

                        $stmt = $pdo->prepare( "insert into tblPedido
                    (pedidoTitulo,
                        pedidoStatus,
                        cupomID,
                        clienteID)
                    values
                    (:pedidoTitulo,
                        :pedidoStatus,
                        :cupomID,
                        :clienteID)" );
                        $stmt->execute(
                                array(
                                    ":pedidoTitulo" => $fields["pedidoTitulo"],
                        ":pedidoStatus" => $fields["pedidoStatus"],
                        ":cupomID" => $fields["cupomID"],
                        ":clienteID" => $fields["clienteID"]
                                )
                        );
                        $erro = $stmt->errorInfo();
                        $valErro = $erro[ 0 ];
                        if ( $valErro !== "00000" ) {
                            insertLogs("insert", "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco. (tblPedido)");
                            return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                        }
                    }
                    catch ( PDOException $e ) {
                        insertLogs("insert", $e->getMessage()." (tblPedido) ");
                        return array( "status" => false, "message" => $e->getMessage() );
                    }
                    $id = $pdo->lastInsertId();
                    insertLogs("insert", "Registro efetuado com sucesso! (tblPedido)");
                    return array( "status" => true, "message" => "Registro efetuado com sucesso!", "ID" => $id);
                }

                function updatetblPedido( $fields, $pk ) {
                    global $pdo, $img;
                    try {

                        $stmt = $pdo->prepare( "update tblPedido set
                    pedidoTitulo = :pedidoTitulo,
                        pedidoStatus = :pedidoStatus,
                        cupomID = :cupomID,
                        clienteID = :clienteID
                    Where pedidoID = :pedidoID" );
                        $stmt->execute(
                                array(
                                    ":pedidoID" => $pk,":pedidoTitulo" => $fields["pedidoTitulo"],
                        ":pedidoStatus" => $fields["pedidoStatus"],
                        ":cupomID" => $fields["cupomID"],
                        ":clienteID" => $fields["clienteID"]
                                )
                        );
                        $erro = $stmt->errorInfo();
                        $valErro = $erro[ 0 ];
                        if ( $valErro !== "00000" ) {
                            insertLogs("update", "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco. (tblPedido)");
                            return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                        }
                    }
                    catch ( PDOException $e ) {
                        insertLogs("update", $e->getMessage()." (tblPedido)");
                        return array( "status" => false, "message" => $e->getMessage() );
                    }
                    insertLogs("update", "Registro alterado com sucesso! (tblPedido)");
                    return array( "status" => true, "message" => "Registro alterado com sucesso!", "ID" => $pk);
                }
            //tblCupons
                function getAlltblCupons(){
                    global $pdo, $img;
                    $sql = "select C.cupomID,
                    C.cupomTitulo,
                    C.cupomOrigem,
                    C.cupomDescricao,
                    C.cupomValorExibir,
                    C.cupomValorCobrar,
                    (concat('".$img."tblCupons/',C.cupomImagem)) as foto,
                    C.cupomImagem from tblCupons C
                    ";

                    $results = array();
                    foreach ( $pdo->query( $sql ) as $row ) {
                        $results[] = $row;
                    }
                    return $results;
                }

                function gettblCupons( $id ) {
                    global $pdo, $img;
                    try {
                        $sql = "select C.cupomID,
                    C.cupomTitulo,
                    C.cupomOrigem,
                    C.cupomDescricao,
                    C.cupomValorExibir,
                    C.cupomValorCobrar,
                    (concat('".$img."tblCupons/',C.cupomImagem)) as foto,
                    C.cupomImagem from tblCupons C
                            where cupomID = :id";
                        $query = $pdo->prepare( $sql );

                        $query->bindParam( ":id", $id );
                        $query->execute();

                        foreach ( $query->fetchAll() as $row ) {
                            return $row;
                        }
                    }
                    catch ( PDOException $e ) {
                        return false;;
                        exit;
                    }
                }
                function gettblCuponsPaginacao( $pg = 1, $filtro = NULL, $qtd = 20 ) {
                    global $img;

                    $finish = ($pg - 1) * $qtd;
                    $start = $finish - $qtd;
                    $where = "";
                    $and;

                    $sql = "select C.cupomID,
                    C.cupomTitulo,
                    C.cupomOrigem,
                    C.cupomDescricao,
                    C.cupomValorExibir,
                    C.cupomValorCobrar,
                    (concat('".$img."tblCupons/',C.cupomImagem)) as foto,
                    C.cupomImagem from tblCupons C
                    
                            " . $where . "
                            LIMIT " . $qtd . " OFFSET " . $finish;
                    //die(json_encode($sql));

                    $pagina = getQuery( $sql );

                    $sql = "select count(*) from tblCupons C
                    
                            " . $where;

                    $paginacao = getPaginacao( $sql, $pg, $qtd );
                    $arrRetorno = array( "pagina" => $pagina, "paginacao" => $paginacao );
                    return $arrRetorno;
                }

                function inserttblCupons( $fields ) {
                    global $pdo, $img;
                    try {

                        $stmt = $pdo->prepare( "insert into tblCupons
                    (cupomTitulo,
                        cupomOrigem,
                        cupomDescricao,
                        cupomValorExibir,
                        cupomValorCobrar,
                        cupomImagem)
                    values
                    (:cupomTitulo,
                        :cupomOrigem,
                        :cupomDescricao,
                        :cupomValorExibir,
                        :cupomValorCobrar,
                        :cupomImagem)" );
                        $stmt->execute(
                                array(
                                    ":cupomTitulo" => $fields["cupomTitulo"],
                        ":cupomOrigem" => $fields["cupomOrigem"],
                        ":cupomDescricao" => $fields["cupomDescricao"],
                        ":cupomValorExibir" => $fields["cupomValorExibir"],
                        ":cupomValorCobrar" => $fields["cupomValorCobrar"],
                        ":cupomImagem" => $fields["cupomImagem"]
                                )
                        );
                        $erro = $stmt->errorInfo();
                        $valErro = $erro[ 0 ];
                        if ( $valErro !== "00000" ) {
                            insertLogs("insert", "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco. (tblCupons)");
                            return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                        }
                    }
                    catch ( PDOException $e ) {
                        insertLogs("insert", $e->getMessage()." (tblCupons) ");
                        return array( "status" => false, "message" => $e->getMessage() );
                    }
                    $id = $pdo->lastInsertId();
                    insertLogs("insert", "Registro efetuado com sucesso! (tblCupons)");
                    return array( "status" => true, "message" => "Registro efetuado com sucesso!", "ID" => $id);
                }

                function updatetblCupons( $fields, $pk ) {
                    global $pdo, $img;
                    try {

                        $stmt = $pdo->prepare( "update tblCupons set
                    cupomTitulo = :cupomTitulo,
                        cupomOrigem = :cupomOrigem,
                        cupomDescricao = :cupomDescricao,
                        cupomValorExibir = :cupomValorExibir,
                        cupomValorCobrar = :cupomValorCobrar
                    Where cupomID = :cupomID" );
                        $stmt->execute(
                                array(
                                    ":cupomID" => $pk,":cupomTitulo" => $fields["cupomTitulo"],
                        ":cupomOrigem" => $fields["cupomOrigem"],
                        ":cupomDescricao" => $fields["cupomDescricao"],
                        ":cupomValorExibir" => $fields["cupomValorExibir"],
                        ":cupomValorCobrar" => $fields["cupomValorCobrar"]
                                )
                        );
                        $erro = $stmt->errorInfo();
                        $valErro = $erro[ 0 ];
                        if ( $valErro !== "00000" ) {
                            insertLogs("update", "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco. (tblCupons)");
                            return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                        }
                    }
                    catch ( PDOException $e ) {
                        insertLogs("update", $e->getMessage()." (tblCupons)");
                        return array( "status" => false, "message" => $e->getMessage() );
                    }
                    insertLogs("update", "Registro alterado com sucesso! (tblCupons)");
                    return array( "status" => true, "message" => "Registro alterado com sucesso!", "ID" => $pk);
                }
            //tblCliente
                function getAlltblCliente(){
                    global $pdo, $img;
                    $sql = "select C.clienteID,
                    C.clienteNome,
                    C.clienteEmail,
                    C.clienteDescricao,
                    C.clienteValidade from tblCliente C
                    ";

                    $results = array();
                    foreach ( $pdo->query( $sql ) as $row ) {
                        $results[] = $row;
                    }
                    return $results;
                }

                function gettblCliente( $id ) {
                    global $pdo, $img;
                    try {
                        $sql = "select C.clienteID,
                    C.clienteNome,
                    C.clienteEmail,
                    C.clienteDescricao,
                    C.clienteValidade from tblCliente C
                            where clienteID = :id";
                        $query = $pdo->prepare( $sql );

                        $query->bindParam( ":id", $id );
                        $query->execute();

                        foreach ( $query->fetchAll() as $row ) {
                            return $row;
                        }
                    }
                    catch ( PDOException $e ) {
                        return false;;
                        exit;
                    }
                }
                function gettblClientePaginacao( $pg = 1, $filtro = NULL, $qtd = 20 ) {
                    global $img;

                    $finish = ($pg - 1) * $qtd;
                    $start = $finish - $qtd;
                    $where = "";
                    $and;

                    $sql = "select C.clienteID,
                    C.clienteNome,
                    C.clienteEmail,
                    C.clienteDescricao,
                    C.clienteValidade from tblCliente C
                    
                            " . $where . "
                            LIMIT " . $qtd . " OFFSET " . $finish;
                    //die(json_encode($sql));

                    $pagina = getQuery( $sql );

                    $sql = "select count(*) from tblCliente C
                    
                            " . $where;

                    $paginacao = getPaginacao( $sql, $pg, $qtd );
                    $arrRetorno = array( "pagina" => $pagina, "paginacao" => $paginacao );
                    return $arrRetorno;
                }

                function inserttblCliente( $fields ) {
                    global $pdo, $img;
                    try {

                        $stmt = $pdo->prepare( "insert into tblCliente
                    (clienteNome,
                        clienteEmail,
                        clienteDescricao,
                        clienteValidade)
                    values
                    (:clienteNome,
                        :clienteEmail,
                        :clienteDescricao,
                        :clienteValidade)" );
                        $stmt->execute(
                                array(
                                    ":clienteNome" => $fields["clienteNome"],
                        ":clienteEmail" => $fields["clienteEmail"],
                        ":clienteDescricao" => $fields["clienteDescricao"],
                        ":clienteValidade" => $fields["clienteValidade"]
                                )
                        );
                        $erro = $stmt->errorInfo();
                        $valErro = $erro[ 0 ];
                        if ( $valErro !== "00000" ) {
                            insertLogs("insert", "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco. (tblCliente)");
                            return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                        }
                    }
                    catch ( PDOException $e ) {
                        insertLogs("insert", $e->getMessage()." (tblCliente) ");
                        return array( "status" => false, "message" => $e->getMessage() );
                    }
                    $id = $pdo->lastInsertId();
                    insertLogs("insert", "Registro efetuado com sucesso! (tblCliente)");
                    return array( "status" => true, "message" => "Registro efetuado com sucesso!", "ID" => $id);
                }

                function updatetblCliente( $fields, $pk ) {
                    global $pdo, $img;
                    try {

                        $stmt = $pdo->prepare( "update tblCliente set
                    clienteNome = :clienteNome,
                        clienteEmail = :clienteEmail,
                        clienteDescricao = :clienteDescricao,
                        clienteValidade = :clienteValidade
                    Where clienteID = :clienteID" );
                        $stmt->execute(
                                array(
                                    ":clienteID" => $pk,":clienteNome" => $fields["clienteNome"],
                        ":clienteEmail" => $fields["clienteEmail"],
                        ":clienteDescricao" => $fields["clienteDescricao"],
                        ":clienteValidade" => $fields["clienteValidade"]
                                )
                        );
                        $erro = $stmt->errorInfo();
                        $valErro = $erro[ 0 ];
                        if ( $valErro !== "00000" ) {
                            insertLogs("update", "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco. (tblCliente)");
                            return array( "status" => false, "message" => "Houve um erro em nosso servidor, tente novamente mais tarde, ou entre em contato conosco.", "devMessage" => $erro );
                        }
                    }
                    catch ( PDOException $e ) {
                        insertLogs("update", $e->getMessage()." (tblCliente)");
                        return array( "status" => false, "message" => $e->getMessage() );
                    }
                    insertLogs("update", "Registro alterado com sucesso! (tblCliente)");
                    return array( "status" => true, "message" => "Registro alterado com sucesso!", "ID" => $pk);
                } 

                function getCuponsSite($pg, $itens = 6){
                    $pg -=1;
                    $sql = "select C.cupomID,
                            C.cupomTitulo,
                            C.cupomOrigem,
                            C.cupomDescricao,
                            C.cupomValorExibir,
                            C.cupomValorCobrar,
                            (concat('".$img."tblCupons/',C.cupomImagem)) as foto,
                            C.cupomImagem from tblCupons C
                            limit " . $itens . " offset " . $pg * $itens;
                    $results = array();
                    foreach ( $pdo->query( $sql ) as $row ) {
                        $results[] = $row; 
                    }
                    return $results;

                }


                ?>