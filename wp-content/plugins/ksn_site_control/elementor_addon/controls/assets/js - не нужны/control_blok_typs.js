jQuery(function($) {
    console.log("!");
    $(window).on( 'load', function() { //elementor:init
            console.log("!!");      
        var control_blok_typsItemView = elementor.modules.controls.BaseData.extend({
            onReady: function () {
                console.log("!!!");
                var block_control = this.el;
                    img_bloks = block_control.querySelectorAll('.img_select_block_type');
                    colorArray = document.getElementById("elementor-controls");
                    img_select_block_type = $(".img_select_block_type");

                [].forEach.call(img_bloks, function(item) {
                    item.addEventListener('click', click_blok);
                });

                    console.log(this);

                block_control.style.color = 'red';
                function click_blok() {
                    var active_img_block = this;
                    [].forEach.call(img_bloks, function(item) {
                        //item.classList.remove("active");
                    });
                    //active_img_block.classList.add("active");
                    console.log(this);
                };
            },

            onChange: function () {
                console.log("Что-то поменяли!"); 
            },

            onBeforeDestroy: function () {
                console.log("Сняли фокус с этого виджета"); 
                var colorArray = document.getElementById("elementor-controls");
                    img_select_block_type = $(".img_select_block_type");
            }
        });

        elementor.addControlView('control_blok_typs', control_blok_typsItemView);
    } );
});