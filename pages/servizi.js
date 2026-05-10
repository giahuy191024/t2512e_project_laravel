import BasePage from './base-page.js';

export default class ServiziPage extends BasePage {
    render() {
        if (!this.content) return '<p>Đang tải...</p>';

        const services = this.content.state.services || [];
        const sortedServices = [...services].sort((a, b) => (a.attributes?.order || 0) - (b.attributes?.order || 0));

        let listHTML = '';
        sortedServices.forEach((service, i) => {
            const attr = service.attributes || service;
            const uid = service.uid || '';
            const imgUrl = attr.image?.data?.attributes?.url
                ? `https://www.studiobrusco.com/cms${attr.image.data.attributes.url}`
                : '';

            listHTML += `
                <a href="#/servizi/${uid}" class="servizi__item" data-cursor data-cursor-text="khám phá" data-observe data-index="${i}">
                    <div class="servizi__item__inner">
                        <span class="servizi__item__index fs-small ff-serif">${String(i + 1).padStart(2, '0')}</span>
                        <div class="servizi__item__content">
                            <h3 class="servizi__item__title fs-large ff-light uppercase">${attr.title}</h3>
                            <p class="servizi__item__desc fs-xsmall uppercase lh-base">${attr.description || ''}</p>
                        </div>
                        <div class="servizi__item__media">
                            ${imgUrl ? `<img src="${imgUrl}" alt="${attr.title}" loading="lazy">` : ''}
                        </div>
                    </div>
                </a>`;
        });

        return `
            <section class="servizi__header" data-observe>
                <div class="page__hero">
                    <h1 class="page__hero__title fs-xlarge uppercase ff-light">Dịch vụ</h1>
                </div>
            </section>

            <section class="servizi__list" data-observe>
                ${listHTML}
            </section>

            ${this.renderFooterCTA()}
        `;
    }
}
