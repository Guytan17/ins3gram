<!-- START: MEA et titre/créateur de la recette-->
<div class="row">
    <div class="col">
        <div class="position-relative">
            <?php if(isset($recipe['mea']['file_path'])) : ?>
                <img src="<?= base_url($recipe['mea']['file_path']) ?>" class="img-fluid img-fluid-mea"  >
            <?php endif; ?>
            <div class="position-absolute top-0 start-0 bg-black w-100 h-100 opacity-25"></div>
            <div class="position-absolute top-50 start-50 translate-middle text-white text-center">
                <h1><?= isset($recipe['name']) ? $recipe ['name'] : '' ; ?></h1>
                Proposé par : <?= isset($recipe['name']) ? $recipe['user']->username : ''; ?>
            </div>
        </div>
    </div>
</div>
<!-- END: MEA et titre/créateur de la recette-->
<!-- START: NOTER, TÉLÉCHARGER, LIKER,PARTAGER-->
<div class="row">
    <div class="col">
        <div class="row row-cols-2 my-2">
            <div class="col">
                <span class="fas fa-star" data-star="1"></span>
                <span class="fas fa-star" data-star="2"></span>
                <span class="fas fa-star" data-star="3"></span>
                <span class="fas fa-star" data-star="4"></span>
                <span class="fas fa-star" data-star="5"></span>
            </div>
        </div>
    </div>
</div>
<!-- END: NOTER, TÉLÉCHARGER, LIKER,PARTAGER-->
<!-- START:TAGS-->
<div class="row mb-3">
    <div class="col text-center">
        <?php foreach($tags as $tag) : ?>
            <span class="bg-warning rounded py-1 px-2 fw-bold"><i class="fas fa-hashtag"></i><?= $tag['name']?></span>
        <?php endforeach; ?>
    </div>
</div>
<!-- END:TAGS-->
<!-- START: INGREDIENTS -->
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h2>Ingrédients</h2>
            </div>
            <div class="card-body ">
                <div class=" row row-cols-2 row-cols-md-4">
                    <?php foreach($ingredients as $ing) : ?>
                        <div class="col">
                            <?= $ing['ingredient']?> - <?= $ing['quantity']?> <?= $ing['unit'] ?>
                        </div>
                    <?php endforeach ; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: INGREDIENTS -->
<div class="row">
<!-- START: IMAGES -->
    <?php if(!empty($recipe['images'])) : ?>
        <div class="col-md-6">
            <div id="main-slider" class="splide mb-3">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php foreach($recipe['images'] as $image) : ?>
                        <li class="splide__slide">
                            <a href="<?= base_url($image['file_path']); ?>" data-lightbox="mainslider">
                                <img  src="<?= base_url($image['file_path']);?>" >
                            </a>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
            <div id="thumbnail-slider" class="splide mb-3">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php foreach($recipe['images'] as $image) : ?>
                            <li class="splide__slide">
                                <img class="img-thumbnail rounded" src="<?= base_url($image['file_path']);?>" >
                            </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>
<!-- END: IMAGES -->
<!-- START: DESCRIPTION -->
    <div class="col">
        <div class="d-flex flex-column justify-content h-100 p-3">
            <div>
                <span class="fw-bold"> Description :</span>
            </div>
            <div>
                <?= $recipe['description'] ?>
            </div>
        </div>
    </div>
    <!-- START: DESCRIPTION -->
</div>
<!-- START: ÉTAPES -->
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h2>Étapes</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div id="list-steps" class="list-group">
                            <?php foreach($steps as $step) :?>
                                <a class="list-group-item list-group-item-action" href="#list-item-<?=$step['order']?>">
                                    Étape <?=$step['order']?>
                                </a>
                            <?php endforeach ; ?>
                        </div>
                    </div>
                    <div class="col-8">
                        <div data-bs-spy="scroll" data-bs-target="#list-steps" data-bs-smooth-scroll="true" data-bs-offset="0" class="scrollspy-steps" tabindex="0">
                            <?php foreach($steps as $step) :?>
                                <h4 id="list-item-<?=$step['order']?>">Étape <?=$step['order']?></h4>
                                <p>
                                    <?=$step['description']?>
                                </p>
                            <?php endforeach ; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: ÉTAPES -->
<script>
    $(document).ready(function(){
    <!-- START: le visionneur d'images -->
        var main = new Splide('#main-slider',{
            type        :'fade',
            heightRatio : 0.5,
            pagination  : false,
            arrows      : false,
            cover       : false,//désactive "cover" pour éviter le crop
        });
        var thumbnails = new Splide('#thumbnail-slider', {
            rewind          : true,
            fixedWidth      : 80,
            fixedHeight     : 80,
            isNavigation    : true,
            gap             : 10,
            focus           : 'center',
            pagination      : false,
            cover           : false,//désactive "cover" pour éviter le crop
            breakpoints     : {
                640 : {
                    fixedWidth  : 60,
                    fixedHeight : 60,
                },
            },
        });
        main.sync(thumbnails);
        main.mount();
        thumbnails.mount();
    <!-- END: le visionneur d'images -->
    <!-- START:  -->

    <!-- END:  -->
    })
</script>
<style>    }
</style>