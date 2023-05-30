<?php

protect(0);

if(!isset($_SESSION))
    session_start();

$id_usuario = $_SESSION['usuario'];
$ingressos_query = $mysqli->query("SELECT * FROM ingressos WHERE id IN (SELECT id_ingresso FROM relatorio WHERE id_usuario = '$id_usuario')") or die($mysqli->error);

?>
<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Meus Ingressos</h4>
                    <span>Estes são os Ingressos que você já possui</span>
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
                    <li class="breadcrumb-item">Meus Ingressos</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Page-header end -->

<div class="page-body">
    <div class="row">
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
                    <form action="index.php">
                        <input type="hidden" name="p" value="acessar">
                        <input type="hidden" name="id" value="<?php echo $ingresso['id']; ?>">
                        <button type="submit" class="btn form-control btn-out-dashed btn-primary btn-square">Acessar</button> 
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>