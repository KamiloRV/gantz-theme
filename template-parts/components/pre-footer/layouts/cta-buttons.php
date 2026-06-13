<section class="pre-footer buttons">
    <div class="contenido container">
        <div class="contenido">
            <div class="text-container">
                <h2 class="titulo"><?php echo $args['titulo'] ?></h2>

                <?php
                if (!empty($args['descripcion'])) :
                    $descripcion = str_replace('<p>', '<p class="descripcion body-1 body-bold">', $args['descripcion']);
                    echo $descripcion;
                endif;
                ?>
            </div>

            <div class="acciones">
                <?php
                $buttons = $args['botones'] ?? [];
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