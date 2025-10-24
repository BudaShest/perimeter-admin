import './bootstrap';

import 'bootstrap';
import TomSelect from "tom-select";

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

    let dragged = null;

    let dragElements = document.getElementsByClassName('draggable')

    Array.from(dragElements).forEach(item => {
        item.addEventListener('dragstart', function (e) {
            dragged = e.target
            item.classList.add("dragged")
        })

        item.addEventListener('dragend', function (e) {
            const x = e.clientX;
            const y = e.clientY

            let targetDiv = document.elementFromPoint(x, y).closest('.draggable');

            console.log(targetDiv)

            targetDiv.after(dragged)
        })

    });

    const areasSelectEl = document.getElementById('areasSelect');
    const usersSelectEl = document.getElementById('usersSelect');

    console.log('areasSelect element:', areasSelectEl);
    console.log('usersSelect element:', usersSelectEl);

    if (areasSelectEl) {
        let areasSelect = new TomSelect("#areasSelect", {
            maxItems: 3
        });
    } else {
        console.error('Element #areasSelect not found');
    }

    if (usersSelectEl) {
        let userSelect = new TomSelect("#usersSelect", {
            maxItems: 3
        });
    } else {
        console.error('Element #usersSelect not found');
    }

});

// Обработчики для Livewire (если используется)
document.addEventListener('livewire:load', function() {
    // Переинициализация Bootstrap компонентов после обновления Livewire
    Livewire.hook('message.processed', () => {
        bootstrap.Tooltip.getInstance?.()?.dispose();
        bootstrap.Popover.getInstance?.()?.dispose();
    });
});


class SortableList {
    constructor(container) {
        this.container = container;
        this.items = container.querySelectorAll('.sortable-item');
        this.draggedItem = null;
        this.init();
    }

    init() {
        this.items.forEach(item => {
            // Используем стрелочные функции или bind для сохранения контекста
            item.addEventListener('dragstart', (e) => this.handleDragStart(e));
            item.addEventListener('dragend', (e) => this.handleDragEnd(e));
            item.addEventListener('dragover', (e) => this.handleDragOver(e));
            item.addEventListener('dragenter', (e) => this.handleDragEnter(e));
            item.addEventListener('dragleave', (e) => this.handleDragLeave(e));
            item.addEventListener('drop', (e) => this.handleDrop(e));
        });
    }

    handleDragStart(e) {
        this.draggedItem = e.target;
        setTimeout(() => this.draggedItem.style.opacity = '0.4', 0);
    }

    handleDragEnd(e) {
        this.draggedItem.style.opacity = '1';
        this.items.forEach(item => item.classList.remove('over'));
    }

    handleDragOver(e) {
        e.preventDefault();
    }

    handleDragEnter(e) {
        e.preventDefault();
        e.target.classList.add('over');
    }

    handleDragLeave(e) {
        e.target.classList.remove('over');
    }

    handleDrop(e) {
        e.preventDefault();
        e.target.classList.remove('over');

        if (e.target !== this.draggedItem) {
            const allItems = Array.from(this.container.querySelectorAll('.sortable-item'));
            const thisIndex = allItems.indexOf(e.target);
            const draggedIndex = allItems.indexOf(this.draggedItem);

            if (draggedIndex < thisIndex) {
                e.target.after(this.draggedItem);
            } else {
                e.target.before(this.draggedItem);
            }
        }
    }

    // Получить текущий порядок точек
    getPointOrder() {
        const items = this.container.querySelectorAll('.sortable-item');
        return Array.from(items).map(item => item.dataset.pointId);
    }

    // Обновить скрытые inputs
    updateHiddenInputs() {
        const pointOrder = this.getPointOrder();
        const hiddenInputs = document.querySelectorAll('input[name="point_order[]"]');

        hiddenInputs.forEach((input, index) => {
            input.value = pointOrder[index];
        });
    }
}

// Использование
document.addEventListener('DOMContentLoaded', function() {
    const sortableContainer = document.querySelector('.sortable-list');

    if (sortableContainer) {
        const sortableList = new SortableList(sortableContainer);
        const saveButton = document.getElementById('saveRoute');
        const saveStatus = document.getElementById('saveStatus');

        // Обработчик сохранения
        if (saveButton) {
            saveButton.addEventListener('click', function() {
                // Обновляем скрытые inputs перед отправкой
                sortableList.updateHiddenInputs();
                savePointOrder();
            });
        }

        function savePointOrder() {
            if (!saveStatus) return;

            saveStatus.textContent = 'Сохранение...';
            saveStatus.className = 'ms-2 text-warning';

            const formData = new FormData(document.getElementById('sortableContainer'));

            fetch('/route/save-order', {  // Замените на ваш URL
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                },
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        saveStatus.textContent = '✓ Сохранено';
                        saveStatus.className = 'ms-2 text-success';
                        setTimeout(() => saveStatus.textContent = '', 3000);
                    } else {
                        throw new Error(data.message);
                    }
                })
                .catch(error => {
                    saveStatus.textContent = '✗ Ошибка: ' + error.message;
                    saveStatus.className = 'ms-2 text-danger';
                });
        }
    }
});
