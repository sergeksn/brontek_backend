(function($) {
    $(window).on('elementor:init', function() {
        var custom_media_uploader_class = elementor.modules.controls.BaseMultiple.extend({ //BaseMultiple для медиа, BaseDataдля обычных элементов
            ui: function ui() {
                var ui = elementor.modules.controls.BaseMultiple.prototype.ui.apply(this, arguments);
                ui.upload_media_fill_blok = '.upload_media_fill'; // родитель верхнего уровня upload_media_fill
                ui.add_button = '.upload_image'; //кнопка выбора upload_image_button
                ui.remove_button = '.remove_image'; //кнопка удаления remove_image_button 
                ui.img_prewiv = '.img_prewiv'; //блок предпросмотра картинки img_prewiv
                ui.input = '.custom_input_wp_media'; //тег input для записи заначения custom_input_wp_media
                return ui;
            },
            events: function events() {
                return _.extend(elementor.modules.controls.BaseMultiple.prototype.events.apply(this, arguments), {
                    'click @ui.add_button': 'openFrame',
                    'click @ui.remove_button': 'deleteImage'
                });
            },
            openFrame: function openFrame() {
                if (!this.frame) {
                    this.initFrame();
                }
                this.frame.open(); // Устанавливаем параметры для запуска дезинфицирующего средства
                var selectedId = this.getControlValue('id');
                if (!selectedId) {
                    return;
                }
                this.frame.state().get('selection').add(wp.media.attachment(selectedId));
            },
            initFrame: function initFrame() {
                var mime_type_mas = $(this.ui.upload_media_fill_blok).attr("data-mime-types").split(" ");
                // Создаем новый медиа-фрейм
                this.frame = wp.media({
                    title: 'Выберете картинку',
                    button: {
                        text: "Выбрать!"
                    },
                    //multiple: 'add',//позволяет выбрать несколько изображений
                    library: {
                        type: mime_type_mas //формат который нужно отобразить в медиатеке
                    }
                });

                this.frame.on('insert select', this.select.bind(this));
            },
            select: function select() {
                var attachment = this.frame.state().get('selection').first().toJSON();

                if (attachment.url) {
                    this.setValue({
                        id: attachment.id,
                        url: attachment.url,
                        alt: attachment.alt,
                        title: attachment.title,
                        original_width: attachment.width,
                        original_height: attachment.height,
                        mime_type: attachment.mime
                    });
                    this.applySavedValue();
                }
            },
            deleteImage: function(event) {
                event.stopPropagation();
                this.setValue({
                    id: '',
                    url: '',
                    alt: '',
                    title: '',
                    original_width: '',
                    original_height: '',
                    mime_type: ''
                });
                // Очистить изображение предварительного просмотра
                this.applySavedValue();
            },
            getMediaType: function getMediaType() {
                return this.model.get('media_type');
            },
            applySavedValue: function() {//функция должна быть имеено applySavedValue послкольку она связана с ctrl+
                var url = this.getControlValue('url');
                mediaType = this.getMediaType();
                img_prewiv = $(this.ui.img_prewiv);
                if ('image' === mediaType) {
                    this.ui.add_button.addClass('media_type_image');
                } else if ('image/svg+xml' === mediaType) {
                    this.ui.add_button.addClass('media_type_svg');
                } else if ('video' === mediaType) {
                    this.ui.add_button.addClass('media_type_video');
                } else{
                    this.ui.add_button.addClass('media_type_image');
                }
                if (url) {
                    img_prewiv.html("");
                    this.ui.add_button.addClass('est_media');
                    if ('image' === mediaType) {
                        img_prewiv.append("<img src=\"" + url + "\" />");
                    } else if ('image/svg+xml' === mediaType) {
                        img_prewiv.append("<img src=\"" + url + "\" />");
                    } else if ('video' === mediaType) {
                        img_prewiv.append("<video><source \"" + url + "\"></video>");
                    } else {
                        img_prewiv.append("<img src=\"" + url + "\" />");
                    }
                } else {
                    this.ui.add_button.removeClass('est_media');
                    img_prewiv.html("");
                }
            },
            onReady: function() {
                this.applySavedValue();
            },
            onBeforeDestroy: function onBeforeDestroy() {
                this.$el.remove();
            }

        });

        elementor.addControlView('custom_media_uploader', custom_media_uploader_class);
        
    });
})(jQuery);