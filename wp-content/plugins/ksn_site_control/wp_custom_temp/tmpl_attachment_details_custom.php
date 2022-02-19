<?php // Template for the Attachment details, used for example in the sidebar. ?>
    <script type="text/html" id="tmpl-attachment-details-custom">
            <style>
                .attachment-details{
                    overflow: hidden;
                }
                form.compat-item{
                    display: none;
                }
                .attachment-info .thumbnail{
                    max-width: none;
                    max-height: none;
                }
                .attachment-info .thumbnail img{
                    width: 100%;
                    max-width: none;
                    max-height: none;
                }
            </style>
        <h2>
            <?php _e( 'Attachment Details' ); ?>
            <span class="settings-save-status" role="status">
                <span class="spinner"></span>
                <span class="saved"><?php esc_html_e( 'Saved.' ); ?></span>
            </span>
        </h2>
        <div class="attachment-info">

            <# if ( 'audio' === data.type ) { #>
                <div class="wp-media-wrapper wp-audio">
                    <audio style="visibility: hidden" controls class="wp-audio-shortcode" width="100%" preload="none">
                        <source type="{{ data.mime }}" src="{{ data.url }}" />
                    </audio>
                </div>
            <# } else if ( 'video' === data.type ) {
                var w_rule = '';
                if ( data.width ) {
                    w_rule = 'width: ' + data.width + 'px;';
                } else if ( wp.media.view.settings.contentWidth ) {
                    w_rule = 'width: ' + wp.media.view.settings.contentWidth + 'px;';
                }
            #>
                <div style="{{ w_rule }}" class="wp-media-wrapper wp-video">
                    <video controls="controls" class="wp-video-shortcode" preload="metadata"
                        <# if ( data.width ) { #>width="{{ data.width }}"<# } #>
                        <# if ( data.height ) { #>height="{{ data.height }}"<# } #>
                        <# if ( data.image && data.image.src !== data.icon ) { #>poster="{{ data.image.src }}"<# } #>>
                        <source type="{{ data.mime }}" src="{{ data.url }}" />
                    </video>
                </div>
            <# } else { #>
                <div class="thumbnail thumbnail-{{ data.type }}">
                    <# if ( data.uploading ) { #>
                        <div class="media-progress-bar"><div></div></div>
                    <# } else if ( 'image' === data.type && data.size && data.size.url ) { #>
                        <img src="{{ data.size.url }}" draggable="false" alt="" />
                    <# } else { #>
                        <img src="{{ data.icon }}" class="icon" draggable="false" alt="" />
                    <# } #>
                </div>
            <# } #>

            <div class="details">
                <div class="filename">{{ data.filename }}</div>
                <div class="uploaded">{{ data.dateFormatted }}</div>

                <div class="file-size">{{ data.filesizeHumanReadable }}</div>
                <# if ( 'image' === data.type && ! data.uploading ) { #>
                    <# if ( data.width && data.height ) { #>
                        <div class="dimensions">
                            <?php
                            /* translators: 1: A number of pixels wide, 2: A number of pixels tall. */
                            printf( __( '%1$s by %2$s pixels' ), '{{ data.width }}', '{{ data.height }}' );
                            ?>
                        </div>
                    <# } #>

                    <# if ( data.originalImageURL && data.originalImageName ) { #>
                        <?php _e( 'Original image:' ); ?>
                        <a href="{{ data.originalImageURL }}">{{data.originalImageName}}</a>
                    <# } #>

                    <# if ( data.can.save && data.sizes ) { #>
                        <a class="edit-attachment" href="{{ data.editLink }}&amp;image-editor" target="_blank"><?php _e( 'Edit Image' ); ?></a>
                    <# } #>
                <# } #>

                <# if ( data.fileLength && data.fileLengthHumanReadable ) { #>
                    <div class="file-length"><?php _e( 'Length:' ); ?>
                        <span aria-hidden="true">{{ data.fileLength }}</span>
                        <span class="screen-reader-text">{{ data.fileLengthHumanReadable }}</span>
                    </div>
                <# } #>

                <# if ( data.mediaStates ) { #>
                    <div class="media-states"><strong><?php _e( 'Used as:' ); ?></strong> {{ data.mediaStates }}</div>
                <# } #>

                <# if ( ! data.uploading && data.can.remove ) { #>
                    <?php if ( MEDIA_TRASH ) : ?>
                    <# if ( 'trash' === data.status ) { #>
                        <button type="button" class="button-link untrash-attachment"><?php _e( 'Restore from Trash' ); ?></button>
                    <# } else { #>
                        <button type="button" class="button-link trash-attachment"><?php _e( 'Move to Trash' ); ?></button>
                    <# } #>
                    <?php else : ?>
                        <button type="button" class="button-link delete-attachment"><?php _e( 'Delete permanently' ); ?></button>
                    <?php endif; ?>
                <# } #>

                <div class="compat-meta">
                    <# if ( data.compat && data.compat.meta ) { #>
                        {{{ data.compat.meta }}}
                    <# } #>
                </div>
            </div>
        </div>
        <# var maybeReadOnly = data.can.save || data.allowLocalEdits ? '' : 'readonly'; #>
        <# if ( 'image' === data.type ) { #>
            <span class="setting has-description" data-setting="alt">
                <label style="text-align: left; max-width: 99%; width: 99%; margin-right: 0;" for="attachment-details-alt-text" class="name">Атрибут <b style="font-weight: 700;">alt</b></label>
                <textarea style="width: 99%;float: left;" id="attachment-details-alt-text" rows="3" aria-describedby="alt-text-description" {{ maybeReadOnly }} >{{ data.alt }}</textarea>
            </span>
            <p style="width: 99%;float: left;" class="description" id="alt-text-description">Заполнить альтернативный текст изображения, этот текст будет показываться когда картинка не загрузилась, так же этот тег важен для поисковиков. Если изображение является элементом дизайна то заполнять не обязательно, но это не точно))</p>
        <# } #>
        <?php if ( post_type_supports( 'attachment', 'title' ) ) : ?>
        <span class="setting" data-setting="title">
            <label style="text-align: left; max-width: 99%; width: 99%; margin-right: 0;" for="attachment-details-title" class="name">Заголовк <b style="font-weight: 700;">title</b></label>
            <textarea style="width: 99%;float: left;" id="attachment-details-title" rows="3" {{ maybeReadOnly }} >{{ data.title }}</textarea>
        </span>
        <p style="width: 99%;float: left;" class="description" id="alt-text-description">Заполните title картинки, этот текст будет отображаться при наведении на картинку. Если изображение является элементом дизайна то заполнять не обязательно, но это не точно))</p>
        <?php endif; ?>
        <# if ( 'audio' === data.type ) { #>
        <?php
        foreach ( array(
            'artist' => __( 'Artist' ),
            'album'  => __( 'Album' ),
        ) as $key => $label ) :
            ?>
        <span class="setting" data-setting="<?php echo esc_attr( $key ); ?>">
            <label for="attachment-details-<?php echo esc_attr( $key ); ?>" class="name"><?php echo $label; ?></label>
            <input type="text" id="attachment-details-<?php echo esc_attr( $key ); ?>" value="{{ data.<?php echo $key; ?> || data.meta.<?php echo $key; ?> || '' }}" />
        </span>
        <?php endforeach; ?>
        <# } #>
        <span class="setting" data-setting="url">
            <label style="max-width: 99%;" for="attachment-details-copy-link" class="name"><?php _e( 'File URL:' ); ?></label>
            <input style="width: 99%; max-width: 99%; float: left;" type="text" class="attachment-details-copy-link" id="attachment-details-copy-link" value="{{ data.url }}" readonly />
            <div style="width: 99%; margin-left: 1px;" class="copy-to-clipboard-container">
                <button style="width: 99%;" type="button" class="button button-small copy-attachment-url" data-clipboard-target="#attachment-details-copy-link"><?php _e( 'Copy URL to clipboard' ); ?></button>
                <span class="success hidden" aria-hidden="true"><?php _e( 'Copied!' ); ?></span>
            </div>
        </span>
    </script>
<script>
    jQuery(document).ready( function($) {
        if( typeof wp.media.view.Attachment.Details != 'undefined' ){
            wp.media.view.Attachment.Details.prototype.template = wp.template( 'attachment-details-custom' );
        }
    });
</script>