import { Controller } from "@hotwired/stimulus"
import { TabulatorFull } from "tabulator-tables"

export default class TabulatorController extends Controller {

    static values = {
        options: Object
    }

    connect() {
        const options = {
            ...this.optionsValue,
            locale: true,
            langs: {
                "ru": {
                    "pagination": {
                        "page_size": "Выводить по",
                        "first": "В начало",
                        "first_title": "Перейти к первой странице",
                        "last": "В конец",
                        "last_title": "Перейти к последней странице",
                        "prev": "Назад",
                        "prev_title": "Перейти на предыдущую страницу",
                        "next": "Вперед",
                        "next_title": "Перейти на следующую страницу",
                        "all": "Все",
                    },
                },
            },
            paginationCounter: function (pageSize, currentRow, currentPage, totalRows, totalPages) {
                const currentPageTotalRows = totalPages === currentPage ? totalRows : currentPage * pageSize
                return `Просмотр ${currentRow} - ${currentPageTotalRows} из ${totalRows}`
            }
        }

        this.dispatch('pre-connect', {detail: {options}})
        this.tabulator = new TabulatorFull(this.element, options)

        this._beforeMorphElement = (event) => {
            event.preventDefault()
            this.tabulator.setData()
        }

        this.element.addEventListener('turbo:before-morph-element', this._beforeMorphElement)

        this.dispatch('connect', {detail: { options, tabulator: this.tabulator }})
    }

    disconnect() {
        this.tabulator.destroy()
        this.element.removeEventListener('turbo:before-morph-element', this._beforeMorphElement)
    }
}
