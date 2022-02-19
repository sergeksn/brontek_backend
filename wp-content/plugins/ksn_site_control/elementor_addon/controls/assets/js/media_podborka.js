(function($) {
    $(window).on('elementor:init', function() {
        var media_podborka_class = elementor.modules.controls.BaseData.extend({ //BaseMultiple для медиа, BaseDataдля обычных элементов
            ui: function ui() {
                var ui = elementor.modules.controls.BaseData.prototype.ui.apply(this, arguments);
                ui.addImages = '.elementor-control-gallery-add';
                ui.clearGallery = '.elementor-control-gallery-clear';
                ui.galleryThumbnails = '.elementor-control-gallery-thumbnails';
                ui.status = '.elementor-control-gallery-status-title';
                return ui;
            },
            events: function events() {
                return _.extend(elementor.modules.controls.BaseData.prototype.events.apply(this, arguments), {
                    'click @ui.addImages': 'onAddImagesClick',
                    'click @ui.clearGallery': 'onClearGalleryClick',
                    'click @ui.galleryThumbnails': 'onGalleryThumbnailsClick'
                });
            },
            onReady: function onReady() {
                this.initRemoveDialog();
            },
            applySavedValue: function applySavedValue() {
                var images = this.getControlValue(),
                    imagesCount = images.length,
                    hasImages = !!imagesCount;
                this.$el.toggleClass('elementor-gallery-has-images', hasImages).toggleClass('elementor-gallery-empty', !hasImages);
                var $galleryThumbnails = this.ui.galleryThumbnails;
                $galleryThumbnails.empty();
                this.ui.status.text(hasImages ? sprintf('Выбрано изображений %s', imagesCount) : 'Изображения не выбраны' );

                if (!hasImages) {
                    return;
                }

                this.getControlValue().forEach(function(image) {
                    var $thumbnail = jQuery('<div>', {
                        class: 'elementor-control-gallery-thumbnail'
                    });
                    $thumbnail.css('background-image', 'url(' + image.url + ')');
                    $galleryThumbnails.append($thumbnail);
                });
            },
            hasImages: function hasImages() {
                return !!this.getControlValue().length;
            },
            openFrame: function openFrame(action) {
                this.initFrame(action);
                this.frame.open();
            },
            initFrame: function initFrame(action) {
                var frameStates = {
                    create: 'gallery',
                    add: 'gallery-library',
                    edit: 'gallery-edit'
                };
                var options = {
                    frame: 'post',
                    multiple: true,
                    state: frameStates[action],
                    button: {
                        text: 'Вставить медиа'
                    }
                };

                if (this.hasImages()) {
                    options.selection = this.fetchSelection();
                }

                this.frame = wp.media(options); // When a file is selected, run a callback.

                this.frame.on({
                    update: this.select,
                    'menu:render:default': this.menuRender,
                    'content:render:browse': this.gallerySettings
                }, this);
            },
            menuRender: function menuRender(view) {
                view.unset('insert');
                view.unset('featured-image');
            },
            gallerySettings: function gallerySettings(browser) {
                browser.sidebar.on('ready', function() {
                    browser.sidebar.unset('gallery');
                });
            },
            fetchSelection: function fetchSelection() {
                var attachments = wp.media.query({
                    orderby: 'post__in',
                    order: 'ASC',
                    type: 'image',
                    perPage: -1,
                    post__in: _.pluck(this.getControlValue(), 'id')
                });
                return new wp.media.model.Selection(attachments.models, {
                    props: attachments.props.toJSON(),
                    multiple: true
                });
            },

            
            /**
             * Обработчик обратного вызова, когда вложение выбрано в модальном окне мультимедиа.
             * Получает информацию о выбранном изображении и устанавливает ее в элементе управления.
            */
            select: function select(selection) {
                var images = [];
                selection.each(function(image) {
                    images.push({
                        id: image.get('id'),
                        url: image.get('url'),
                        alt: image.get('alt'),
                        title: image.get('title'),
                        original_width: image.get('width'),
                        original_height: image.get('height'),
                        mime_type: image.get('mime')
                    });
                });
                this.setValue(images);
                this.applySavedValue();
            },
            onBeforeDestroy: function onBeforeDestroy() {
                if (this.frame) {
                    this.frame.off();
                }

                this.$el.remove();
            },
            resetGallery: function resetGallery() {
                this.setValue([]);
                this.applySavedValue();
            },
            initRemoveDialog: function initRemoveDialog() {
                var removeDialog;

                this.getRemoveDialog = function() {
                    if (!removeDialog) {
                        removeDialog = elementorCommon.dialogsManager.createWidget('confirm', {
                            message: 'Вы уверены, что хотите сбросить настройки этой галереи?',
                            headerMessage: 'Сбросить галерею',
                            strings: {
                                confirm: 'Удалить',
                                cancel: 'Отмена',
                            },
                            defaultOption: 'confirm',
                            onConfirm: this.resetGallery.bind(this)
                        });
                    }

                    return removeDialog;
                };
            },
            onAddImagesClick: function onAddImagesClick() {
                this.openFrame(this.hasImages() ? 'add' : 'create');
            },
            onClearGalleryClick: function onClearGalleryClick() {
                this.getRemoveDialog().show();
            },
            onGalleryThumbnailsClick: function onGalleryThumbnailsClick() {
                this.openFrame('edit');
            }

        });

        elementor.addControlView('media_podborka', media_podborka_class);

    });
})(jQuery);