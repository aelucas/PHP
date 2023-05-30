<?php

include('lib/protect.php');
protect(0);

if(!isset($_SESSION))
    session_start();

$erro = false;
if(isset($_POST['adquirir'])) {

    // verificar se o usuario possui creditos para compra-lo
    $id_user = $_SESSION['usuario'];
    $sql_query_creditos = $mysqli->query("SELECT creditos FROM usuarios WHERE id = '$id_user'") or die($mysqli->error);
    $usuario = $sql_query_creditos->fetch_assoc();

    $creditos_do_usuario = $usuario['creditos'];

    $id_ingresso = intval($_POST['adquirir']);
    $sql_query_ingresso = $mysqli->query("SELECT preco FROM ingressos WHERE id = '$id_ingresso'") or die($mysqli->error);
    $ingresso = $sql_query_ingresso->fetch_assoc();

    $preco_do_ingresso = $ingresso['preco'];

    if($preco_do_ingresso > $creditos_do_usuario) {
        $erro = "Você não possui créditos para adquirir este ingresso.";
    } else {
        $mysqli->query("INSERT INTO relatorio (id_usuario, id_ingresso, valor, data_compra) VALUES(
            '$id_user',
            '$id_ingresso',
            '$preco_do_ingresso',
            NOW()
        )") or die($mysqli->error);
        $novo_credito = $creditos_do_usuario - $preco_do_ingresso;
        $mysqli->query("UPDATE usuarios SET creditos = '$novo_credito' WHERE id = '$id_user'") or die($mysqli->error);
        die("<script>location.href='index.php?p=meus_ingressos';</script>");
    }

}


$id_usuario = $_SESSION['usuario'];
$ingressos_query = $mysqli->query("SELECT * FROM ingressos WHERE id NOT IN (SELECT id_ingresso FROM relatorio WHERE id_usuario = '$id_usuario')") or die($mysqli->error);

?>
<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Loja de ingressos</h4>
                    <span>Adquira nossos ingressos usando o seu crédito</span>
                </div>  
            </div>
        </div>
        <div class="col-lg-4">
            <div class="page-header-breadcrumb">
                <ul class="breadcrumb-title">
                    <li class="breadcrumb-item">
                        <a href="index.php">
                            <i class="icofont icofont-home"></i>
                        </a>
                    </li>
                    <li class="breadcrumb-item">Loja de ingressos</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Page-header end -->

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
        <?php if($erro !== false) {
                                    ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $erro; ?>
            </div>
            <?php
        }
        ?>
        </div>
        <?php while($ingresso = $ingressos_query->fetch_assoc()) { ?>
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h5><?php echo $ingresso['titulo']; ?></h5>
                </div>
                <div class="card-block">
                    <img src="<?php echo $ingresso['imagem']; ?>" class="img-fluid mb-3" alt="">
                    <p>
                    <?php echo $ingresso['descricao_curta']; ?>
                    </p>
                    <form action="" method="post">
                        <button type="submit" name="adquirir" value="<?php echo $ingresso['id']; ?>" class="btn form-control btn-out-dashed btn-success btn-square">Adquirir por R$ <?php echo number_format($ingresso['preco'], 2, ',', '.'); ?></button>   
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>
        
    </div>
</div>