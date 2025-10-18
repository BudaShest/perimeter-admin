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

    new TomSelect("#areasSelect",{
        maxItems: 3
    });
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
        this.items = Array.from(container.querySelectorAll('.sortable-item'));
        this.draggedItem = null;
        this.dragStartIndex = null;

        this.init();
    }

    init() {
        this.items.forEach(item => {
            item.addEventListener('dragstart', this.handleDragStart.bind(this));
            item.addEventListener('dragover', this.handleDragOver.bind(this));
            item.addEventListener('dragenter', this.handleDragEnter.bind(this));
            item.addEventListener('dragleave', this.handleDragLeave.bind(this));
            item.addEventListener('drop', this.handleDrop.bind(this));
            item.addEventListener('dragend', this.handleDragEnd.bind(this));
        });
    }

    handleDragStart(e) {
        this.draggedItem = e.target;
        this.dragStartIndex = this.items.indexOf(this.draggedItem);

        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', this.draggedItem.innerHTML);

        // Добавляем класс для визуального эффекта
        setTimeout(() => {
            this.draggedItem.classList.add('dragging');
        }, 0);
    }

    handleDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
        return false;
    }

    handleDragEnter(e) {
        e.preventDefault();
        const target = e.target.closest('.sortable-item');
        if (target && target !== this.draggedItem) {
            target.classList.add('over');
        }
    }

    handleDragLeave(e) {
        const target = e.target.closest('.sortable-item');
        if (target && target !== this.draggedItem) {
            target.classList.remove('over');
        }
    }

    handleDrop(e) {
        e.preventDefault();
        e.stopPropagation();

        const target = e.target.closest('.sortable-item');
        if (target && target !== this.draggedItem) {
            const dragEndIndex = this.items.indexOf(target);

            // Определяем направление перемещения
            if (this.dragStartIndex < dragEndIndex) {
                target.after(this.draggedItem);
            } else {
                target.before(this.draggedItem);
            }

            // Обновляем порядок номеров
            this.updateItemNumbers();

            // Вызываем пользовательское событие
            this.triggerReorderEvent();
        }

        return false;
    }

    handleDragEnd(e) {
        // Убираем все классы
        this.items.forEach(item => {
            item.classList.remove('dragging');
            item.classList.remove('over');
        });

        this.draggedItem = null;
        this.dragStartIndex = null;
    }

    updateItemNumbers() {
        // Обновляем массив элементов
        this.items = Array.from(this.container.querySelectorAll('.sortable-item'));

        // Обновляем номера
        this.items.forEach((item, index) => {
            const numberElement = item.querySelector('.item-number');
            if (numberElement) {
                numberElement.textContent = index + 1;
            }
            // Можно также обновить data-атрибуты если нужно
            item.setAttribute('data-order', index + 1);
        });
    }

    triggerReorderEvent() {
        const event = new CustomEvent('itemsReordered', {
            detail: {
                items: this.items.map(item => ({
                    id: item.getAttribute('data-id'),
                    order: this.items.indexOf(item) + 1,
                    text: item.textContent.trim()
                }))
            }
        });
        this.container.dispatchEvent(event);
    }

    // Метод для получения текущего порядка
    getCurrentOrder() {
        return this.items.map(item => ({
            id: item.getAttribute('data-id'),
            order: this.items.indexOf(item) + 1,
            element: item
        }));
    }

    // Метод для добавления нового элемента
    addItem(text, id = null) {
        const newItem = document.createElement('div');
        newItem.className = 'sortable-item';
        newItem.draggable = true;
        newItem.setAttribute('data-id', id || Date.now());

        const itemNumber = document.createElement('span');
        itemNumber.className = 'item-number';
        itemNumber.textContent = this.items.length + 1;

        newItem.appendChild(itemNumber);
        newItem.appendChild(document.createTextNode(' ' + text));

        // Добавляем обработчики событий
        newItem.addEventListener('dragstart', this.handleDragStart.bind(this));
        newItem.addEventListener('dragover', this.handleDragOver.bind(this));
        newItem.addEventListener('dragenter', this.handleDragEnter.bind(this));
        newItem.addEventListener('dragleave', this.handleDragLeave.bind(this));
        newItem.addEventListener('drop', this.handleDrop.bind(this));
        newItem.addEventListener('dragend', this.handleDragEnd.bind(this));

        this.container.appendChild(newItem);
        this.items.push(newItem);
    }

    // Метод для удаления элемента
    removeItem(item) {
        if (this.items.includes(item)) {
            item.remove();
            this.items = this.items.filter(i => i !== item);
            this.updateItemNumbers();
        }
    }
}

// Инициализация
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('sortableContainer');
    const sortableList = new SortableList(container);

    // Пример использования события переупорядочивания
    container.addEventListener('itemsReordered', function(e) {
        console.log('Порядок изменен:', e.detail.items);

        // Здесь можно отправить данные на сервер
        // saveOrderToServer(e.detail.items);
    });

    // Пример добавления нового элемента
    // sortableList.addItem('Новый элемент', 'new-id');

    // Пример получения текущего порядка
    // console.log(sortableList.getCurrentOrder());
});
