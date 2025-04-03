import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { confirmDelete } from './confirmDelete';

window.confirmDelete = confirmDelete;
