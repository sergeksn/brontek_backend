(function( $ ) {
    'use strict';

    $(function() {
        var json_file = '/wp-content/plugins/ksn_site_konstruktor/js/device_width.json',
            cv_apply = function( row, device ) {
                $.each(device, function(key, value){
                    key = new RegExp('[$]{2}' + key + '[$]{2}', 'g');
                    row = row.replace(key,value);
                });

                return row;
            };

        if (typeof elementor === 'undefined') {
            return;
        }
        elementor.on('panel:init', function(){
            var resonsive = $('#elementor-panel-footer-responsive .elementor-panel-footer-sub-menu');
            if (!resonsive.length) {
                console.log("не нашёл((");
                return;
            }
            $.getJSON(json_file + '?ver=' + Date.now(), function( devices ){
                var itemHtml = '';
                $.each(devices, function(idx, device){
                    var panel = [
                        '<div class="elementor-panel-footer-sub-menu-item" data-device-mode="$$slug$$">',
                        '    <i class="elementor-icon $$icon_type$$ custom-breakpoint-device eicon-device-$$slug$$" aria-hidden="true"></i>',
                        '    <span class="elementor-title">$$name$$</span>',
                        '    <span class="elementor-description">$$description$$</span>',
                        '</div>'
                    ], 
                    /*items = [
                        '<a class="elementor-responsive-switcher tooltip-target elementor-responsive-switcher-$$slug$$" data-device="$$slug$$" data-tooltip="$$name$$" data-tooltip-pos="w" original-title="">',
                        '    <i class="$$icon_type$$ custom-breakpoint-device-$$slug$$" aria-hidden="true"></i>',
                        '</a>'
                    ],*/
                    deviceHtml = '';

                    $.each(panel, function(){
                        deviceHtml += cv_apply(this, device);
                    });

                    /*$.each(items, function(){
                        itemHtml += cv_apply(this, device);
                    });*/

                    var panel = $(deviceHtml);

                    resonsive.append(panel);
                });

                /*elementor.hooks.addAction( 'panel/open_editor/widget', function( panel, model, view ) {

                    var fn = function(){
                        var item = $(itemHtml),
                            widgetHolder = $('.elementor-control-responsive-switchers__holder');

                        widgetHolder.append(item);
                    };

                    $('.elementor-component-tab.elementor-panel-navigation-tab.elementor-tab-control-style').off('click', fn).on('click', fn);

                });*/

            });

        });
        /////elementor.on('document:loaded', function () {
        /////elementor.on('globals:loaded', function () {
        //$(window).on('elementor:loaded', function () {
        //elementor.on('preview:init', function () {
        //elementor.on('preview:loaded', function () {
        //добавляем кастомные размеры эрана для прдпросмотра
        elementor.on('document:loaded', function () {
            var item_size = $(".elementor-panel-footer-sub-menu .elementor-panel-footer-sub-menu-item"),
                footer_panel = $('#elementor-panel-footer-responsive .elementor-panel-footer-sub-menu');
                function style_blok_devise(){
                    var win_h = $(window).height(),
                        blok_h = Math.round(win_h/2)+"px";
                    footer_panel.css({"overflow-y":"auto","height":blok_h});
                };
                style_blok_devise();
                item_size.on("click touchend", function() {
                    item_size.each(function() {
                        $(this).removeClass("active");
                    });
                    var devise = $(this),
                        data_devise = devise.attr("data-device-mode"),
                        body = $("body"),
                        div = $('[class^="elementor-device"]');
                    devise.addClass("active");
                    function poisk_el_devise(item){
                        item.classList.forEach(className => {
                            if (className.startsWith('elementor-device-')) {
                                item.classList.remove(className);
                            }
                        });
                    };
                    poisk_el_devise(body[0]);
                    poisk_el_devise(div[0]);

                    div.addClass("elementor-device-rotate-portrait elementor-device-"+data_devise);
                    body.addClass("elementor-device-"+data_devise);
                });

                $(window).resize(function() {
                    style_blok_devise();
                });
        });
        //добавляем кастомные размеры эрана для прдпросмотра
    });

})( jQuery );