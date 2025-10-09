<!-- START: MEA et titre/créateur de la recette-->
<div class="row">
    <div class="col">
        <div class="position-relative">
            <?php if(isset($recipe['mea']['file_path'])) : ?>
                <img src="<?= base_url($recipe['mea']['file_path']) ?>" class="img-fluid recipe-img-mea">
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
            <div class="col star-rating">
                <input type="radio" name="star-rating" id="star5" value="5" />
                <label for="star5">
                    <i class="far fa-star"></i>
                </label>
                <input type="radio"  name="star-rating" id="star4" value="4" />
                <label for="star4">
                    <i class="far fa-star"></i>
                </label>
                <input type="radio"  name="star-rating" id="star3" value="3" />
                <label for="star3">
                    <i class="far fa-star"></i>
                </label>
                <input type="radio"  name="star-rating" id="star2" value="2" />
                <label for="star2">
                    <i class="far fa-star"></i>
                </label>
                <input type="radio"  name="star-rating" id="star1" value="1" />
                <label for="star1">
                    <i class="far fa-star"></i>
                </label>
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
<div class="row mb-3">
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
<div class="row mb-3">
<!-- START: IMAGES -->
    <?php if(!empty($recipe['images'])) : ?>
        <div class="col-md-6">
            <div id="main-slider" class="splide mb-3">
                <div class="splide__track">
                    <ul class="splide__list">
                        <?php foreach($recipe['images'] as $image) : ?>
                        <li class="splide__slide">
                            <a href="<?= base_url($image['file_path']); ?>" data-lightbox="mainslider">
                                <img class=img-fluid src="<?= base_url($image['file_path']);?>" >
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
        <div class="card d-flex flex-column justify-content h-100">
            <div class="card-header">
                <h2> Description :</h2>
            </div>
            <div class="card-body">
                <?= $recipe['description'] ?>
            </div>
        </div>
    </div>
    <!-- END: DESCRIPTION -->
</div>
<!-- START: ÉTAPES -->
<div class="row mb-3" >
    <div class="col">
        <div class="card ">
            <div class="card-header">
                <h2>Étapes</h2>
            </div>
            <div class="card-body">
                <?php foreach($steps as $step) { ?>
                <h4 id="list-step-<?= $step['order'] ?>">Étape <?= $step['order'] ?></h4>
                    <p><?= $step['description'] ?> </p>
                <?php } ?>
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
    <!-- START: notation par étoiles -->
        const stars = document.querySelectorAll('.star-rating input');
        console.log(stars);
        stars.forEach(star => {
            star.addEventListener("click",getRating) ;
        });
        function getRating (e) {
            const i = (e.target.value);
            document.querySelector(`label[for="star${i}"] svg`).setAttribute('data-prefix', 'fas');
        }
        /*

input.addEventListener('click', () => {
                // remettre tout en contour
                document.querySelectorAll('.star-rating i').forEach(star => {
                    star.classList.replace('far', 'fas');
                });
            });


                // remplir toutes les étoiles <= valeur cliquée
                for (let i = 1; i <= input.value; i++) {

                }

        */
        <!-- END:  notation par étoiles-->
    });
</script>