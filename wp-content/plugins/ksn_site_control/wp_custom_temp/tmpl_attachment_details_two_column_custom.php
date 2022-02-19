<?php // Template for the Attachment Details two columns layout. ?>
        <script type="text/html" id="tmpl-attachment-details-two-column-custom">
            <style>
                @-webkit-keyframes loader {
                    0% {
                        -webkit-transform: rotate(0);
                                transform: rotate(0)
                    }

                    100% {
                        -webkit-transform: rotate(360deg);
                                transform: rotate(360deg)
                    }
                }
                @-moz-keyframes loader {
                    0% {
                        -moz-transform: rotate(0);
                             transform: rotate(0)
                    }

                    100% {
                        -moz-transform: rotate(360deg);
                             transform: rotate(360deg)
                    }
                }
                @-o-keyframes loader {
                    0% {
                        -o-transform: rotate(0);
                           transform: rotate(0)
                    }

                    100% {
                        -o-transform: rotate(360deg);
                           transform: rotate(360deg)
                    }
                }
                @keyframes loader {
                    0% {
                        -webkit-transform: rotate(0);
                           -moz-transform: rotate(0);
                             -o-transform: rotate(0);
                                transform: rotate(0)
                    }

                    100% {
                        -webkit-transform: rotate(360deg);
                           -moz-transform: rotate(360deg);
                             -o-transform: rotate(360deg);
                                transform: rotate(360deg)
                    }
                }
                .preduprezdenie{
                    font-size: 18px;
                    font-weight: 600;
                    color: green;
                }
                .compat-field-regenerate_thumbnails th.label{
                    display: none;
                }
                .compat-field-regenerate_thumbnails td.field{
                    float: left;
                }
                .compat-field-wio th.label{
                    width: 100%;
                }
                .compat-field-wio th.label span{
                    text-align: left;
                }
                .compat-field-wio td.field{
                    width: 100%;
                }
                .compat-field-wio td.field li.wio-data-item{
                    border-bottom: 1px solid green;
                    padding-left: 5px;
                }
                .compat-field-wio td.field li.wio-data-item span.data{
                    font-size: 14px;
                    width: 50%;
                }
                .compat-field-wio td.field li.wio-data-item strong{
                    font-size: 14px;
                }
                .compat-field-wio td.field ul.wio-datas-list .big{
                    color: black;
                }
                .compat-field-wio .wio-datas-actions-links{
                    display: block !important;
                    margin-top: 5px;
                }
                .compat-field-wio .wio-datas-actions-links a{
                    width: auto;
                    font-size: 14px;
                    -webkit-transition: color 0.5s linear;
                    -o-transition: color 0.5s linear;
                    -moz-transition: color 0.5s linear;
                    transition: color 0.5s linear;
                }
                .compat-field-wio .wio-datas-actions-links .dashicons{
                    top: 5px;
                }
                .compat-field-wio .wio-datas-actions-links a:hover{
                    color: green;
                }
                .compat-field-wio td.field p:after{
                    content: "";
                    color: rgb(168 179 208 / 85%);
                    position: absolute;
                    margin-left: 20px;
                    -webkit-border-radius: 50%;
                       -moz-border-radius: 50%;
                            border-radius: 50%;
                    border-style: solid;
                    border-top-color: #41457e;
                    -webkit-animation: loader 1s infinite linear;
                       -moz-animation: loader 1s infinite linear;
                         -o-animation: loader 1s infinite linear;
                            animation: loader 1s infinite linear;
                    border-width: 11px;
                }
            </style>
                <div class="attachment-media-view {{ data.orientation }}">
                        <h2 class="screen-reader-text"><?php _e( 'Attachment Preview' ); ?></h2>
                        <div class="thumbnail thumbnail-{{ data.type }}">
                                <# if ( data.uploading ) { #>
                                        <div class="media-progress-bar"><div></div></div>
                                <# } else if ( data.sizes && data.sizes.large ) { #>
                                        <img class="details-image" src="{{ data.sizes.large.url }}" draggable="false" alt="" />
                                <# } else if ( data.sizes && data.sizes.full ) { #>
                                        <img class="details-image" src="{{ data.sizes.full.url }}" draggable="false" alt="" />
                                <# } else if ( -1 === jQuery.inArray( data.type, [ 'audio', 'video' ] ) ) { #>
                                        <img class="details-image icon" src="{{ data.icon }}" draggable="false" alt="" />
                                <# } #>

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
                                <# } #>

                                <div class="attachment-actions">
                                        <# if ( 'image' === data.type && ! data.uploading && data.sizes && data.can.save ) { #>
                                        <button type="button" class="button edit-attachment"><?php _e( 'Edit Image' ); ?></button>
                                        <# } else if ( 'pdf' === data.subtype && data.sizes ) { #>
                                        <p><?php _e( 'Document Preview' ); ?></p>
                                        <# } #>
                                </div>
                        </div>
                </div>
                <div class="attachment-info">
                        <span class="settings-save-status" role="status">
                                <span class="spinner"></span>
                                <span class="saved"><?php esc_html_e( 'Saved.' ); ?></span>
                        </span>
                        <div class="details">
                                <h2 class="screen-reader-text"><?php _e( 'Details' ); ?></h2>
                                <div class="uploaded"><strong><?php _e( 'Uploaded on:' ); ?></strong> {{ data.dateFormatted }}</div>
                                <div class="uploaded-by">
                                        <strong><?php _e( 'Uploaded by:' ); ?></strong>
                                                <# if ( data.authorLink ) { #>
                                                        <a href="{{ data.authorLink }}">{{ data.authorName }}</a>
                                                <# } else { #>
                                                        {{ data.authorName }}
                                                <# } #>
                                </div>
                                <div class="filename"><strong><?php _e( 'File name:' ); ?></strong> {{ data.filename }}</div>
                                <div class="file-type"><strong><?php _e( 'File type:' ); ?></strong> {{ data.mime }}</div>
                                <div class="file-size"><strong><?php _e( 'File size:' ); ?></strong> {{ data.filesizeHumanReadable }}</div>
                                <# if ( 'image' === data.type && ! data.uploading ) { #>
                                        <# if ( data.width && data.height ) { #>
                                                <div class="dimensions"><strong><?php _e( 'Dimensions:' ); ?></strong>
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
                                <# } #>

                                <# if ( data.fileLength && data.fileLengthHumanReadable ) { #>
                                        <div class="file-length"><strong><?php _e( 'Length:' ); ?></strong>
                                                <span aria-hidden="true">{{ data.fileLength }}</span>
                                                <span class="screen-reader-text">{{ data.fileLengthHumanReadable }}</span>
                                        </div>
                                <# } #>

                                <# if ( 'audio' === data.type && data.meta.bitrate ) { #>
                                        <div class="bitrate">
                                                <strong><?php _e( 'Bitrate:' ); ?></strong> {{ Math.round( data.meta.bitrate / 1000 ) }}kb/s
                                                <# if ( data.meta.bitrate_mode ) { #>
                                                {{ ' ' + data.meta.bitrate_mode.toUpperCase() }}
                                                <# } #>
                                        </div>
                                <# } #>

                                <# if ( data.mediaStates ) { #>
                                        <div class="media-states"><strong><?php _e( 'Used as:' ); ?></strong> {{ data.mediaStates }}</div>
                                <# } #>

                                <div class="compat-meta">
                                        <# if ( data.compat && data.compat.meta ) { #>
                                                {{{ data.compat.meta }}}
                                        <# } #>
                                </div>
                        </div>

                        <div class="settings">
                                <# var maybeReadOnly = data.can.save || data.allowLocalEdits ? '' : 'readonly'; #>
                                <# if ( 'image' === data.type ) { #>
                                        <span class="setting has-description" data-setting="alt">
                                                <label style="text-align: left; max-width: 99%; width: 99%; margin-right: 0;" for="attachment-details-two-column-alt-text" class="name">Атрибут <b style="font-weight: 700;">alt</b></label>
                                                <textarea style="width: 99%;float: left;" id="attachment-details-two-column-alt-text" rows="3" aria-describedby="alt-text-description" {{ maybeReadOnly }} >{{ data.alt }}</textarea>
                                        </span>
                                        <p style="width: 99%;float: left;" class="description" id="alt-text-description">Заполнить альтернативный текст изображения, этот текст будет показываться когда картинка не загрузилась, так же этот тег важен для поисковиков. Если изображение является элементом дизайна то заполнять не обязательно, но это не точно))</p>
                                <# } #>
                                <?php if ( post_type_supports( 'attachment', 'title' ) ) : ?>
                                <span class="setting" data-setting="title">
                                        <label style="text-align: left; max-width: 99%; width: 99%; margin-right: 0;" for="attachment-details-two-column-title" class="name">Заголовк <b style="font-weight: 700;">title</b></label>
                                        <textarea style="width: 99%;float: left;" id="attachment-details-two-column-title" rows="3" {{ maybeReadOnly }} >{{ data.title }}</textarea>
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
                                        <label for="attachment-details-two-column-<?php echo esc_attr( $key ); ?>" class="name"><?php echo $label; ?></label>
                                        <input type="text" id="attachment-details-two-column-<?php echo esc_attr( $key ); ?>" value="{{ data.<?php echo $key; ?> || data.meta.<?php echo $key; ?> || '' }}" />
                                </span>
                                <?php endforeach; ?>
                                <# } #>
                                <span class="setting" data-setting="url">
                                        <label style="max-width: 99%;text-align: left;" for="attachment-details-two-column-copy-link" class="name"><?php _e( 'File URL:' ); ?></label>
                                        <input style="width: 99%; max-width: 99%; float: left;" type="text" class="attachment-details-copy-link" id="attachment-details-two-column-copy-link" value="{{ data.url }}" readonly />
                                        <span style="width: 99%; margin-left: 1px;" class="copy-to-clipboard-container">
                                                <button type="button" class="button button-small copy-attachment-url" data-clipboard-target="#attachment-details-two-column-copy-link"><?php _e( 'Copy URL to clipboard' ); ?></button>
                                                <span class="success hidden" aria-hidden="true"><?php _e( 'Copied!' ); ?></span>
                                        </span>
                                </span>
                                <div class="preduprezdenie">Всё что идёт ниже Вам трогать не стоит =)</div>
                                <div class="attachment-compat"></div>
                        </div>

                        <div class="actions">
                                <# if ( data.link ) { #>
                                        <a class="view-attachment" href="{{ data.link }}"><?php _e( 'View attachment page' ); ?></a>
                                <# } #>
                                <# if ( data.can.save ) { #>
                                        <# if ( data.link ) { #>
                                                <span class="links-separator">|</span>
                                        <# } #>
                                        <a href="{{ data.editLink }}"><?php _e( 'Edit more details' ); ?></a>
                                <# } #>
                                <# if ( ! data.uploading && data.can.remove ) { #>
                                        <# if ( data.link || data.can.save ) { #>
                                                <span class="links-separator">|</span>
                                        <# } #>
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
                        </div>
                </div>
        </script>
<script>
    jQuery(document).ready( function($) {
        if( typeof wp.media.view.Attachment.Details.TwoColumn != 'undefined' ){
            wp.media.view.Attachment.Details.TwoColumn.prototype.template = wp.template( 'attachment-details-two-column-custom' );
        }
    });
</script>