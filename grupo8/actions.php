<?php include('functions.php');
                $exec = filter_input( INPUT_POST, "exec" );
                if ( $exec == "gerencia___usuarios" ) {

                    //die(json_encode(array("status" => bool, "msg" => "mensagem em texto para o usuário", "devMsg" => "Mensagem para o desenvolvedor" )))

                    $id = filter_input(INPUT_POST, "usuario_id");
                    if($id == ""){
                        die(json_encode(insert___usuarios( $_POST )));
                    }
                    else{
                        die(json_encode(update___usuarios( $_POST, filter_input(INPUT_POST, "usuario_id") )));
                    }
                }
                
                else if ( $exec == "paginationBottom___usuarios" ) {
                    $pg = str_replace( "goTo-", "", filter_input( INPUT_POST, "pg" ) );
                    $paginas = get___usuariosPaginacao( $pg, $filtro );
                    $paginaHTML;
                    $x = 0;
                    foreach ( $paginas[ 'pagina' ] as $pagina ) {
                        $paginaHTML .= "
                        <tr>
                            <td>".$pagina["nome"]."</td><td>".$pagina["login"]."</td>
                            <td>
                                <a href=\"alterar-usuarios/".$pagina["usuario_id"]."/\">Alterar</a> || <a href=\"javascript:void(0);\" onclick=\"removerRegistro('".$pagina["usuario_id"]."')\" >Excluir</a><br>
                            </td>
                        </tr>";
                        $x++;
                        /* if ( $x == 3 ) {
                        $x = 0;
                        $paginaHTML .= '<div class="clearfix"></div>';
                        } */
                    }
                    die( json_encode( array( "pagina" => $paginaHTML, "paginacao" => $paginas[ 'paginacao' ] ) ) );
                }
                else if ( $exec == "removerRegistro" ) {
                    $table = filter_input(INPUT_POST, "table");
                    $pk = filter_input(INPUT_POST, "pk");
                    $pkValue = filter_input(INPUT_POST, "pkValue");

                    die(json_encode(removerRegistro($table, $pk, $pkValue)));
                }
                if ( $exec == 'doLogin' ) {
                    if ( !filter_input( INPUT_POST, "email", FILTER_VALIDATE_EMAIL ) ) {
                        die( json_encode( array( 'status' => false, 'message' => 'Informe um e-mail valido...' ) ) );
                    }
                    $email = filter_input( INPUT_POST, "email" );
                    $senha = filter_input( INPUT_POST, "senha" );

                    $login = getLogin( $email, $senha );
                    if ( count( $login ) > 0 ) {
                        $_SESSION[ 'user' ] = $login;
                        die( json_encode( array( 'status' => true, 'message' => 'Acesso permitido, Aguarde o redirecionamento...' ) ) );
                    }
                    else {
                        unset( $_SESSION[ 'user' ] );
                        die( json_encode( array( 'status' => false, 'message' => 'Login Incorreto.' ) ) );
                    }
                }
                if ( $exec == "gerencia___logs" ) {

                    //die(json_encode(array("status" => bool, "msg" => "mensagem em texto para o usuário", "devMsg" => "Mensagem para o desenvolvedor" )))

                    $id = filter_input(INPUT_POST, "log_id");
                    if($id == ""){
                        die(json_encode(insert___logs( $_POST )));
                    }
                    else{
                        die(json_encode(update___logs( $_POST, filter_input(INPUT_POST, "log_id") )));
                    }
                }
                
                else if ( $exec == "paginationBottom___logs" ) {
                    $pg = str_replace( "goTo-", "", filter_input( INPUT_POST, "pg" ) );
                    $paginas = get___logsPaginacao( $pg, $filtro );
                    $paginaHTML;
                    $x = 0;
                    foreach ( $paginas[ 'pagina' ] as $pagina ) {
                        $paginaHTML .= "
                        <tr>
                            <td>".$pagina["nome"]."</td><td>".$pagina["acao"]."</td><td>".$pagina["mensagem"]."</td>
                            <td>
                                <a href=\"alterar-/".$pagina["log_id"]."/\">Alterar</a> || <a href=\"javascript:void(0);\" onclick=\"removerRegistro('".$pagina["log_id"]."')\" >Excluir</a><br>
                            </td>
                        </tr>";
                        $x++;
                        /* if ( $x == 3 ) {
                        $x = 0;
                        $paginaHTML .= '<div class="clearfix"></div>';
                        } */
                    }
                    die( json_encode( array( "pagina" => $paginaHTML, "paginacao" => $paginas[ 'paginacao' ] ) ) );
                }
                else if ( $exec == "removerRegistro" ) {
                    $table = filter_input(INPUT_POST, "table");
                    $pk = filter_input(INPUT_POST, "pk");
                    $pkValue = filter_input(INPUT_POST, "pkValue");

                    die(json_encode(removerRegistro($table, $pk, $pkValue)));
                }
                if ( $exec == 'doLogin' ) {
                    if ( !filter_input( INPUT_POST, "email", FILTER_VALIDATE_EMAIL ) ) {
                        die( json_encode( array( 'status' => false, 'message' => 'Informe um e-mail valido...' ) ) );
                    }
                    $email = filter_input( INPUT_POST, "email" );
                    $senha = filter_input( INPUT_POST, "senha" );

                    $login = getLogin( $email, $senha );
                    if ( count( $login ) > 0 ) {
                        $_SESSION[ 'user' ] = $login;
                        die( json_encode( array( 'status' => true, 'message' => 'Acesso permitido, Aguarde o redirecionamento...' ) ) );
                    }
                    else {
                        unset( $_SESSION[ 'user' ] );
                        die( json_encode( array( 'status' => false, 'message' => 'Login Incorreto.' ) ) );
                    }
                }
                if ( $exec == "gerenciatblPlano" ) {

                    //die(json_encode(array("status" => bool, "msg" => "mensagem em texto para o usuário", "devMsg" => "Mensagem para o desenvolvedor" )))

                    $id = filter_input(INPUT_POST, "planoID");
                    if($id == ""){
                        die(json_encode(inserttblPlano( $_POST )));
                    }
                    else{
                        die(json_encode(updatetblPlano( $_POST, filter_input(INPUT_POST, "planoID") )));
                    }
                }
                
                else if ( $exec == "paginationBottomtblPlano" ) {
                    $pg = str_replace( "goTo-", "", filter_input( INPUT_POST, "pg" ) );
                    $paginas = gettblPlanoPaginacao( $pg, $filtro );
                    $paginaHTML;
                    $x = 0;
                    foreach ( $paginas[ 'pagina' ] as $pagina ) {
                        $paginaHTML .= "
                        <tr>
                            <td>".$pagina["planoTitulo"]."</td><td>".$pagina["planoValorDia"]."</td>
                            <td>
                                <a href=\"alterar-planos/".$pagina["planoID"]."/\">Alterar</a> || <a href=\"javascript:void(0);\" onclick=\"removerRegistro('".$pagina["planoID"]."')\" >Excluir</a><br>
                            </td>
                        </tr>";
                        $x++;
                        /* if ( $x == 3 ) {
                        $x = 0;
                        $paginaHTML .= '<div class="clearfix"></div>';
                        } */
                    }
                    die( json_encode( array( "pagina" => $paginaHTML, "paginacao" => $paginas[ 'paginacao' ] ) ) );
                }
                else if ( $exec == "removerRegistro" ) {
                    $table = filter_input(INPUT_POST, "table");
                    $pk = filter_input(INPUT_POST, "pk");
                    $pkValue = filter_input(INPUT_POST, "pkValue");

                    die(json_encode(removerRegistro($table, $pk, $pkValue)));
                }
                if ( $exec == 'doLogin' ) {
                    if ( !filter_input( INPUT_POST, "email", FILTER_VALIDATE_EMAIL ) ) {
                        die( json_encode( array( 'status' => false, 'message' => 'Informe um e-mail valido...' ) ) );
                    }
                    $email = filter_input( INPUT_POST, "email" );
                    $senha = filter_input( INPUT_POST, "senha" );

                    $login = getLogin( $email, $senha );
                    if ( count( $login ) > 0 ) {
                        $_SESSION[ 'user' ] = $login;
                        die( json_encode( array( 'status' => true, 'message' => 'Acesso permitido, Aguarde o redirecionamento...' ) ) );
                    }
                    else {
                        unset( $_SESSION[ 'user' ] );
                        die( json_encode( array( 'status' => false, 'message' => 'Login Incorreto.' ) ) );
                    }
                }
                if ( $exec == "gerenciatblPedido" ) {

                    //die(json_encode(array("status" => bool, "msg" => "mensagem em texto para o usuário", "devMsg" => "Mensagem para o desenvolvedor" )))

                    $id = filter_input(INPUT_POST, "pedidoID");
                    if($id == ""){
                        die(json_encode(inserttblPedido( $_POST )));
                    }
                    else{
                        die(json_encode(updatetblPedido( $_POST, filter_input(INPUT_POST, "pedidoID") )));
                    }
                }
                
                else if ( $exec == "paginationBottomtblPedido" ) {
                    $pg = str_replace( "goTo-", "", filter_input( INPUT_POST, "pg" ) );
                    $paginas = gettblPedidoPaginacao( $pg, $filtro );
                    $paginaHTML;
                    $x = 0;
                    foreach ( $paginas[ 'pagina' ] as $pagina ) {
                        $paginaHTML .= "
                        <tr>
                            <td>".$pagina["pedidoTitulo"]."</td><td>".$pagina["cupomTitulo"]."</td><td>".$pagina["clienteNome"]."</td>
                            <td>
                                <a href=\"alterar-pedido/".$pagina["pedidoID"]."/\">Alterar</a> || <a href=\"javascript:void(0);\" onclick=\"removerRegistro('".$pagina["pedidoID"]."')\" >Excluir</a><br>
                            </td>
                        </tr>";
                        $x++;
                        /* if ( $x == 3 ) {
                        $x = 0;
                        $paginaHTML .= '<div class="clearfix"></div>';
                        } */
                    }
                    die( json_encode( array( "pagina" => $paginaHTML, "paginacao" => $paginas[ 'paginacao' ] ) ) );
                }
                else if ( $exec == "removerRegistro" ) {
                    $table = filter_input(INPUT_POST, "table");
                    $pk = filter_input(INPUT_POST, "pk");
                    $pkValue = filter_input(INPUT_POST, "pkValue");

                    die(json_encode(removerRegistro($table, $pk, $pkValue)));
                }
                if ( $exec == 'doLogin' ) {
                    if ( !filter_input( INPUT_POST, "email", FILTER_VALIDATE_EMAIL ) ) {
                        die( json_encode( array( 'status' => false, 'message' => 'Informe um e-mail valido...' ) ) );
                    }
                    $email = filter_input( INPUT_POST, "email" );
                    $senha = filter_input( INPUT_POST, "senha" );

                    $login = getLogin( $email, $senha );
                    if ( count( $login ) > 0 ) {
                        $_SESSION[ 'user' ] = $login;
                        die( json_encode( array( 'status' => true, 'message' => 'Acesso permitido, Aguarde o redirecionamento...' ) ) );
                    }
                    else {
                        unset( $_SESSION[ 'user' ] );
                        die( json_encode( array( 'status' => false, 'message' => 'Login Incorreto.' ) ) );
                    }
                }
                if ( $exec == "gerenciatblCupons" ) {

                    //die(json_encode(array("status" => bool, "msg" => "mensagem em texto para o usuário", "devMsg" => "Mensagem para o desenvolvedor" )))

                    $id = filter_input(INPUT_POST, "cupomID");
                    if($id == ""){
                        die(json_encode(inserttblCupons( $_POST )));
                    }
                    else{
                        die(json_encode(updatetblCupons( $_POST, filter_input(INPUT_POST, "cupomID") )));
                    }
                }
                
                else if ( $exec == "paginationBottomtblCupons" ) {
                    $pg = str_replace( "goTo-", "", filter_input( INPUT_POST, "pg" ) );
                    $paginas = gettblCuponsPaginacao( $pg, $filtro );
                    $paginaHTML;
                    $x = 0;
                    foreach ( $paginas[ 'pagina' ] as $pagina ) {
                        $paginaHTML .= "
                        <tr>
                            <td>".$pagina["cupomTitulo"]."</td><td>".$pagina["cupomOrigem"]."</td><td>".$pagina["cupomValorExibir"]."</td><td>".$pagina["cupomValorCobrar"]."</td>
                            <td>
                                <a href=\"alterar-cupons/".$pagina["cupomID"]."/\">Alterar</a> || <a href=\"javascript:void(0);\" onclick=\"removerRegistro('".$pagina["cupomID"]."')\" >Excluir</a><br>
                            </td>
                        </tr>";
                        $x++;
                        /* if ( $x == 3 ) {
                        $x = 0;
                        $paginaHTML .= '<div class="clearfix"></div>';
                        } */
                    }
                    die( json_encode( array( "pagina" => $paginaHTML, "paginacao" => $paginas[ 'paginacao' ] ) ) );
                }
                else if ( $exec == "removerRegistro" ) {
                    $table = filter_input(INPUT_POST, "table");
                    $pk = filter_input(INPUT_POST, "pk");
                    $pkValue = filter_input(INPUT_POST, "pkValue");

                    die(json_encode(removerRegistro($table, $pk, $pkValue)));
                }
                if ( $exec == 'doLogin' ) {
                    if ( !filter_input( INPUT_POST, "email", FILTER_VALIDATE_EMAIL ) ) {
                        die( json_encode( array( 'status' => false, 'message' => 'Informe um e-mail valido...' ) ) );
                    }
                    $email = filter_input( INPUT_POST, "email" );
                    $senha = filter_input( INPUT_POST, "senha" );

                    $login = getLogin( $email, $senha );
                    if ( count( $login ) > 0 ) {
                        $_SESSION[ 'user' ] = $login;
                        die( json_encode( array( 'status' => true, 'message' => 'Acesso permitido, Aguarde o redirecionamento...' ) ) );
                    }
                    else {
                        unset( $_SESSION[ 'user' ] );
                        die( json_encode( array( 'status' => false, 'message' => 'Login Incorreto.' ) ) );
                    }
                }
                if ( $exec == "gerenciatblCliente" ) {

                    //die(json_encode(array("status" => bool, "msg" => "mensagem em texto para o usuário", "devMsg" => "Mensagem para o desenvolvedor" )))

                    $id = filter_input(INPUT_POST, "clienteID");
                    if($id == ""){
                        die(json_encode(inserttblCliente( $_POST )));
                    }
                    else{
                        die(json_encode(updatetblCliente( $_POST, filter_input(INPUT_POST, "clienteID") )));
                    }
                }
                
                else if ( $exec == "paginationBottomtblCliente" ) {
                    $pg = str_replace( "goTo-", "", filter_input( INPUT_POST, "pg" ) );
                    $paginas = gettblClientePaginacao( $pg, $filtro );
                    $paginaHTML;
                    $x = 0;
                    foreach ( $paginas[ 'pagina' ] as $pagina ) {
                        $paginaHTML .= "
                        <tr>
                            <td>".$pagina["clienteNome"]."</td><td>".$pagina["clienteEmail"]."</td><td>".$pagina["clienteValidade"]."</td>
                            <td>
                                <a href=\"alterar-clientes/".$pagina["clienteID"]."/\">Alterar</a> || <a href=\"javascript:void(0);\" onclick=\"removerRegistro('".$pagina["clienteID"]."')\" >Excluir</a><br>
                            </td>
                        </tr>";
                        $x++;
                        /* if ( $x == 3 ) {
                        $x = 0;
                        $paginaHTML .= '<div class="clearfix"></div>';
                        } */
                    }
                    die( json_encode( array( "pagina" => $paginaHTML, "paginacao" => $paginas[ 'paginacao' ] ) ) );
                }
                else if ( $exec == "removerRegistro" ) {
                    $table = filter_input(INPUT_POST, "table");
                    $pk = filter_input(INPUT_POST, "pk");
                    $pkValue = filter_input(INPUT_POST, "pkValue");

                    die(json_encode(removerRegistro($table, $pk, $pkValue)));
                }
                if ( $exec == 'doLogin' ) {
                    if ( !filter_input( INPUT_POST, "email", FILTER_VALIDATE_EMAIL ) ) {
                        die( json_encode( array( 'status' => false, 'message' => 'Informe um e-mail valido...' ) ) );
                    }
                    $email = filter_input( INPUT_POST, "email" );
                    $senha = filter_input( INPUT_POST, "senha" );

                    $login = getLogin( $email, $senha );
                    if ( count( $login ) > 0 ) {
                        $_SESSION[ 'user' ] = $login;
                        die( json_encode( array( 'status' => true, 'message' => 'Acesso permitido, Aguarde o redirecionamento...' ) ) );
                    }
                    else {
                        unset( $_SESSION[ 'user' ] );
                        die( json_encode( array( 'status' => false, 'message' => 'Login Incorreto.' ) ) );
                    }
                } ?>