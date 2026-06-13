<section class="pre-footer contact">
    <div class="contenido container">
        <div class="contacto" itemscope itemtype="https://schema.org/Person">
            <h2 class="titulo"><?php echo $args['titulo'] ?></h2>

            <div class="imagen">
                <img src="<?php echo $args['imagen']['url'] ?>" alt="<?php echo $args['imagen']['alt'] ?>" itemprop="image">
            </div>

            <div class="informacion">
                <h3 class="nombre body-1 body-bold" itemprop="name"><?php echo $args['nombre'] ?></h3>
                <?php
                if (!empty($args['descripcion'])) :
                    $descripcion = str_replace('<p>', '<p class="cargo body-1"  itemprop="jobTitle">', $args['descripcion']);
                    echo $descripcion;
                endif;
                ?>
            </div>

            <div class="acciones">
                <?php
                $buttons = $args['contactos'] ?? [];
                if ( $buttons ) {
                    foreach ($buttons as $item) {

                        get_template_part(
                            'template-parts/components/button',
                            null,
                            [
                                'data' => $item['boton'],
                                'class' => 'gantz-btn secondary-btn white'
                            ]        
                        );
                    }
                }
                ?>
            </div>
        </div>
    </div>
</section>