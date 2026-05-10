import BasePage from './base-page.js';

export default class ContattiPage extends BasePage {
    render() {
        if (!this.content) return '<p>Đang tải...</p>';

        const res = this.content.state.resources || {};
        const contactPage = this.content.state.pages?.contacts || {};
        const contactData = contactPage.data?.attributes || {};
        const header = contactData.header || {};

        return `
            <section class="contatti__header" data-observe>
                <div class="page__hero">
                    <div class="page__hero__media">
                        <div class="media position-relative has-video">
                            <div class="media__inner has-video">
                                ${header.video ? `<video autoplay preload="auto" playsinline loop muted class="media__video">
                                    <source src="${header.video}" type="video/mp4">
                                </video>` : ''}
                            </div>
                        </div>
                    </div>
                    <h1 class="page__hero__title fs-xlarge uppercase ff-light c-alt">Liên hệ</h1>
                </div>
            </section>

            <section class="contatti__info" data-observe>
                <div class="section__inner">
                    <div class="contatti__grid">
                        <div class="contatti__block" data-observe>
                            <span class="fs-xsmall uppercase ff-base">${res.phone || 'điện thoại'}</span>
                            <a href="tel:${(res.phoneNumber || '').replace(/\s/g, '')}" class="fs-medium ff-light" data-cursor>
                                ${res.phoneNumber || ''}
                            </a>
                        </div>

                        <div class="contatti__block" data-observe>
                            <span class="fs-xsmall uppercase ff-base">${res.emergencyPhone || 'di động'}</span>
                            <a href="tel:${(res.emergencyPhoneNumber || '').replace(/\s/g, '')}" class="fs-medium ff-light" data-cursor>
                                ${res.emergencyPhoneNumber || ''}
                            </a>
                        </div>

                        <div class="contatti__block" data-observe>
                            <span class="fs-xsmall uppercase ff-base">${res.fax || 'fax'}</span>
                            <span class="fs-medium ff-light">${res.faxNumber || ''}</span>
                        </div>

                        <div class="contatti__block" data-observe>
                            <span class="fs-xsmall uppercase ff-base">${res.email || 'e-mail'}</span>
                            <a href="mailto:${res.emailValue || ''}" class="fs-medium ff-light" data-cursor>
                                ${res.emailValue || ''}
                            </a>
                        </div>

                        <div class="contatti__block contatti__block--address" data-observe>
                            <a href="${res.addressLink || '#'}" target="_blank" class="fs-small ff-light uppercase lh-base" data-cursor data-link>
                                <span data-label="${res.address || ''}">${res.address || ''}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            ${this.renderFooterCTA()}
        `;
    }
}
