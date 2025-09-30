import './bootstrap';

import 'bootstrap';

// Инициализация компонентов Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    // Инициализация всплывающих подсказок
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Инициализация popover
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })

    // Инициализация toast
    var toastElList = [].slice.call(document.querySelectorAll('.toast'))
    var toastList = toastElList.map(function (toastEl) {
        return new bootstrap.Toast(toastEl)
    })
});

// Обработчики для Livewire (если используется)
document.addEventListener('livewire:load', function() {
    // Переинициализация Bootstrap компонентов после обновления Livewire
    Livewire.hook('message.processed', () => {
        bootstrap.Tooltip.getInstance?.()?.dispose();
        bootstrap.Popover.getInstance?.()?.dispose();
    });
});
