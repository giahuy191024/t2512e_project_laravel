import BasePage from './base-page.js';

export default class HomePage extends BasePage {
    constructor(content, initialHTML) {
        super(content);
        this.html = initialHTML;
    }

    render() {
        return this.html || '<div class="page-placeholder"><h2>Home</h2></div>';
    }

    init() {
        // App.js handles the initial slider initialization for home
    }
}
