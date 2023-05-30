<?php

include('lib/conexao.php');
include('lib/protect.php');
protect(1);

$sql_ingressos = "SELECT * FROM ingressos";
$sql_query = $mysqli->query($sql_ingressos) or die($mysqli->error);
$num_ingressos = $sql_query->num_rows;

?>
<!-- Page-header start -->
<div class="page-header card">
    <div class="row align-items-end">
        <div class="col-lg-8">
            <div class="page-header-title">
                <div class="d-inline">
                    <h4>Gerenciar Ingresso</h4>
                    <span>Administre os Ingressos cadastrados no sistema</span>
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
                    <li class="breadcrumb-item"><a href="#!">Gerenciar Ingressos</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- Page-header end -->

<div class="page-body">
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5>Todos os Ingressos</h5>
                    <span><a href="index.php?p=cadastrar_ingresso">Clique aqui</a> para cadastrar um ingresso</span>
                </div>
                <div class="card-block table-border-style">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Imagem</th>
                                    <th>Título</th>
                                    <th>Preço</th>
                                    <th>Gerenciar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($num_ingressos == 0) { ?>
                                <tr>
                                    <td colspan="5">Nenhum ingresso foi cadastrado</td>
                                </tr>
                                <?php } else {
                                    
                                    while ($ingressos = $sql_query->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <th scope="row"><?php echo $ingressos['id']; ?></th>
                                            <td><img src="<?php echo $ingressos['imagem']; ?>" height="50" alt=""></td>
                                            <td><?php echo $ingressos['titulo']; ?></td>
                                            <td>R$ <?php echo number_format($ingressos['preco'], 2, ',', '.'); ?></td>
                                            <td><a href="index.php?p=editar_ingresso&id=<?php echo $ingressos['id']; ?>">editar</a> | <a href="index.php?p=deletar_ingresso&id=<?php echo $ingressos['id']; ?>">deletar</a></td>
                                        </tr>
                                        <?php
                                    }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>