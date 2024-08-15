function _callSuper(t, o, e) { return o = _getPrototypeOf(o), _possibleConstructorReturn(t, _isNativeReflectConstruct() ? Reflect.construct(o, e || [], _getPrototypeOf(t).constructor) : o.apply(t, e)); }
function _possibleConstructorReturn(t, e) { if (e && ("object" == typeof e || "function" == typeof e)) return e; if (void 0 !== e) throw new TypeError("Derived constructors may only return object or undefined"); return _assertThisInitialized(t); }
function _assertThisInitialized(e) { if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); return e; }
function _isNativeReflectConstruct() { try { var t = !Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function () {})); } catch (t) {} return (_isNativeReflectConstruct = function _isNativeReflectConstruct() { return !!t; })(); }
function _getPrototypeOf(t) { return _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function (t) { return t.__proto__ || Object.getPrototypeOf(t); }, _getPrototypeOf(t); }
function _inheritsLoose(t, o) { t.prototype = Object.create(o.prototype), t.prototype.constructor = t, _setPrototypeOf(t, o); }
function _setPrototypeOf(t, e) { return _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function (t, e) { return t.__proto__ = e, t; }, _setPrototypeOf(t, e); }
import { Controller } from "@hotwired/stimulus";
// import { TabulatorFull } from "tabulator-tables"
var TabulatorController = /*#__PURE__*/function (_Controller) {
  function TabulatorController() {
    return _callSuper(this, TabulatorController, arguments);
  }
  _inheritsLoose(TabulatorController, _Controller);
  var _proto = TabulatorController.prototype;
  // private tabulator: TabulatorFull;
  _proto.connect = function connect() {
    /*const options = {
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
     this.tabulator = new TabulatorFull(this.element, options)*/
  };
  _proto.disconnect = function disconnect() {
    // this.tabulator.destroy()
  };
  return TabulatorController;
}(Controller);
TabulatorController.values = {
  options: Object
};
export { TabulatorController as default };