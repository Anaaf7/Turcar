import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';

window.Alpine = Alpine;

const initLucideIcons = () => {
    createIcons({ icons });
};

document.addEventListener('DOMContentLoaded', () => {
    initLucideIcons();
});

document.addEventListener('alpine:initialized', () => {
    initLucideIcons();
});

window.refreshIcons = initLucideIcons;

Alpine.start();
