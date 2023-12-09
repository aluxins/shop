import './bootstrap';
import './my';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


import {
    Collapse,
    Dropdown,
    Ripple,
    initTE,
} from "tw-elements";

initTE({ Collapse, Dropdown, Ripple });
