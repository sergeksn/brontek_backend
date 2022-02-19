//вот всех виджетах скрываем верхнюю панель "Содержимое", так как после отключения расширеной вкладки переопределением виджета она осталась одна и просто занимает место
(function($) {
    $(window).on('elementor:init', function() {
        function custom_img_uploader(panel, model, view) {
            panel.$el.find(".elementor-panel-navigation").hide(); //скрываем панель настроек сверху
        };
        elementor.hooks.addAction('panel/open_editor/widget', custom_img_uploader);
    });
})(jQuery);