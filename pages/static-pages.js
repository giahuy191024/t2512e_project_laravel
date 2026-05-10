import BasePage from './base-page.js';

export class ModulisticaPage extends BasePage {
    render() {
        return `
            <section class="modulistica__header" data-observe>
                <div class="page__hero">
                    <h1 class="page__hero__title fs-xlarge uppercase ff-light">Biểu mẫu</h1>
                </div>
            </section>

            <section class="modulistica__content" data-observe>
                <div class="section__inner">
                    <p class="fs-small lh-base">Mục biểu mẫu đang được cập nhật.</p>
                </div>
            </section>
        `;
    }
}

export class PrivacyPage extends BasePage {
    render() {
        return `
            <section class="privacy__header" data-observe>
                <div class="page__hero">
                    <h1 class="page__hero__title fs-xlarge uppercase ff-light">Quyền riêng tư & Chính sách</h1>
                </div>
            </section>

            <section class="privacy__content" data-observe>
                <div class="section__inner">
                    <p class="fs-small lh-base">Thông tin quyền riêng tư đang được cập nhật.</p>
                </div>
            </section>
        `;
    }
}
