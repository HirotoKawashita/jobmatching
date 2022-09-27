import Base from '../../module/Base.js'
import app from '../../module/App.js'

export default class App extends Base {

    constructor() {
        super()
        this.app = new app()
        this.dom = {};

        this._init();
    }
    _init() {
        // not allow multiple send on click
        if (document.querySelector('form .btn-submit') != null) {
            try {
                this.dom.submitBtn = document.querySelector('form .btn-submit');
                this._addListener(this.dom.submitBtn, 'click', this.app.rejectMultiSubmit)
            } catch (e) {
                throw new Error(e)
            }
        }
        // delete function
        if (document.querySelectorAll('.companyInformation .delete-btn') != null) {
            this.dom.deleteBtns = document.querySelectorAll('.delete-btn');
            const confirm = (el) => {
                const result = window.confirm('削除しますか');
                if (result) el.target.closest('form').submit();
            }
            try {
                [...this.dom.deleteBtns].map((item) => {
                    this._addListener(item, 'click', confirm)
                })
            } catch (e) {
                throw new Error(e)
            }
        }
    }

}


