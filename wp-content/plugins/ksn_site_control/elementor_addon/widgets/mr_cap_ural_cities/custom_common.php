<?php
namespace KSN_Site_Konstruktor\Widget;

use Elementor\Widget_Base;
class Widget_Common extends Widget_Base {


	public function get_name() {
		return 'common';
	}


	public function show_in_panel() {
		return false;
	}

    protected function register_controls() {
        return;
    }
}
