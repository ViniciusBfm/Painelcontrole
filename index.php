<?php 
    ob_start(); // Inicia o buffer de saída

    $pdo=new PDO('mysql:host=localhost;dbname=bootstrap_projeto','root','');
    $sobre = $pdo->prepare("SELECT * FROM  `tb_sobre`");
    $sobre->execute();
    $sobre = $sobre->fetch()['sobre'];
    

?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Painel de controle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-default">
        <div class="container-fluid">
            <a class="navbar-brand text-light fs-5 text-black fw-bold text-white" href="#">Painel CMS</a>
            <button class="navbar-toggler bg-white" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <ul id="menuprincipal" class=" navbar-nav mb-2 mb-lg-0 ">
                    <li class="nav-item">
                    <li class=" nav-item">
                        <a class="nav-link active fw-medium" ref_sys="sobre" aria-current="page"
                            href="home">Confugurações do site
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  fw-medium" ref_sys="cadastrar_equipe" href="sobre">Cadastrar
                            equipe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" ref_sys="lista_equipe" href="contato">Lista equipe </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 ">
                    <li class="nav-item">
                        <a class="nav-link active fw-medium" aria-current="page" href="home">Sair
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <header id="header" class="w-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <img src="images/configuracao.png" alt="">
                        <h2 class="fs-3 mb-0">Painel de controle</h2>
                    </div>
                    <div class="d-flex align-items-center gap-1">
                        <img src="images/relogio.png" alt="">
                        <p class="letrap mb-0">Último login: <?=date("d/m/Y")?> </p>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <div class="conteudo">
        <section class="principal">
            <div class="container remover">
                <div class="row mb-0">
                    <div class="col-md-3">
                        <div class="list-group ">
                            <a href="#" class="list-group-item list-group-item-action custom-active"
                                ref_sys="sobre">Confugurações do site</a>
                            <a href="#" class="list-group-item list-group-item-action "
                                ref_sys="cadastrar_equipe">Cadastrar
                                equipe</a>
                            <a href="#" class="list-group-item list-group-item-action" ref_sys="lista_equipe">Lista
                                equipe</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <?php


                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            if (isset($_POST['editar_sobre'])) {
                                $sobre = $_POST['sobre'];
                                $pdo->exec("DELETE FROM `tb_sobre`");
                                $sql = $pdo->prepare("INSERT INTO `tb_sobre` VALUES (null,?)");
                                $sql->execute(array($sobre));
                                echo '<div class="msg">O código HTML <b>sobre</b> foi editado com sucesso!</div>';
                            } else if (isset($_POST['cadastrar_equipe'])) {
                                $nome = $_POST['nome_membro'];
                                $descricao = $_POST['descricao'];
                                $sql = $pdo->prepare("INSERT INTO `tb_equipe` VALUES (null,?,?)");
                                $sql->execute(array($nome, $descricao));
                                echo '<div class="msg">Membro da equipe cadastrado com sucesso!</div>';
                            }

                            // Redirecionar para a mesma página para evitar reenvio de formulário
                            header("Location: " . $_SERVER['REQUEST_URI']);
                            exit();
                        }
                            $sobre = $pdo->prepare("SELECT * FROM `tb_sobre`");
                            $sobre->execute();
                            $sobre = $sobre->fetch()['sobre'];
                        ?>

                        <div id="sobre_section" class="card">
                            <div class="card-header cor-padrao">
                                Confugurações do site
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    <div class="mb-3">
                                        <label for="codigohtml" class="form-label">Codigo HTML 3° section:</label>
                                        <textarea name='sobre' placeholder="Digite seu codigo HTML" name="codigohtml"
                                            id="" class="form-control"><?=$sobre?></textarea>

                                    </div>
                                    <input type="hidden" name="editar_sobre" value="">
                                    <button type=" submit" name='acao'
                                        class="btn btn-primary cor-padrao">Enviar</button>
                                </form>
                            </div>
                        </div>
                        <div id="cadastrar_equipe_section" class="card">
                            <div class="card-header cor-padrao">
                                Cadastrar equipe:
                            </div>
                            <div class="card-body">
                                <form method="post">
                                    <div class="mb-3">
                                        <label for="nomedomembro" class="form-label">Nome do membro:</label>
                                        <input placeholder="Nome do membro" name='nome_membro' type="text"
                                            class="form-control">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nomedomembro" class="form-label">Descrição do membro:</label>
                                        <textarea name="descricao" placeholder="Descrição do membro" name="codigohtml"
                                            id="" class="form-control"></textarea>

                                    </div>
                                    <input type="hidden" name="cadastrar_equipe">
                                    <button type=" submit" class="btn btn-primary cor-padrao">Cadastrar</button>
                                </form>
                            </div>
                        </div>
                        <div id="lista_equipe_section" class="card">
                            <div class="card-header cor-padrao">
                                Membros da equipe:
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">ID</th>
                                            <th scope="col">Nome</th>
                                            <th scope="col">Excluir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $selecionarMembros = $pdo->prepare("SELECT `id`,`nome` FROM `tb_equipe`");
                                        $selecionarMembros->execute();
                                        $membros = $selecionarMembros->fetchAll();
                                        foreach ($membros as $key => $value) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?=$value['id']?></th>
                                            <td><?=$value['nome']?></td>
                                            <td>
                                                <button type=" submit" class="btn btn-primary cor-padrao deletar-membro"
                                                    id_membro="<?=$value['id']?>">Excluir</button>
                                            </td>

                                        </tr>
                                        <?php 
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Script personalizado -->
    <script>
    $(function() {
        cliqueMenu();
        scrollItem();

        function cliqueMenu() {
            $('#menuprincipal a, .list-group a').click(function() {
                $('.list-group a').removeClass('custom-active');
                $('#menuprincipal a').parent().remove('active');
                $('.list-group a[ref_sys = ' + $(this).attr('ref_sys') + ']').addClass(
                    'custom-active')
                return false;
            })
        }

        function scrollItem() {
            $('#menuprincipal a, .list-group a').click(function() {
                var ref = '#' + $(this).attr('ref_sys') + '_section';
                var offset = $(ref).offset().top;
                $('html,body').animate({
                    'scrollTop': offset - 60
                })
            })
        }
        $('.deletar-membro').click(function() {
            var id_membro = $(this).attr('id_membro');
            var $button = $(this);
            $.ajax({
                method: 'post',
                data: {
                    'id_membro': id_membro
                },
                url: 'deletar.php'
            }).done(function() {
                $button.parent().parent().remove();
            });
        });


    });
    </script>
</body>

</html>