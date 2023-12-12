import './bootstrap';
import './my';
import './dropdown-menu';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


import {
    Tab,
    Collapse,
    Dropdown,
    Ripple,
    initTE,
} from "tw-elements";

initTE({ Tab, Collapse, Dropdown, Ripple });

import jQuery from 'jquery';
window.$ = jQuery;

