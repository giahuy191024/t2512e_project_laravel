import BasePage from './base-page.js';

export default class ServiziDetailPage extends BasePage {
    render(params) {
        if (!this.content) return '<p>Đang tải...</p>';
        const uid = params.uid;

        const services = this.content.state.services || [];
        const service = services.find(s => s.uid === uid);

        if (!service) {
            return `<section class="page__error"><h2 class="fs-large ff-light">Không tìm thấy dịch vụ</h2></section>`;
        }

        const attr = service.attributes || service;
        const imgUrl = attr.image?.data?.attributes?.url
            ? `https://www.studiobrusco.com/cms${attr.image.data.attributes.url}`
            : '';

        let contentHTML = '';
        (attr.content || []).forEach(block => {
            contentHTML += `
                <div class="service-detail__section" data-observe>
                    <h3 class="fs-small ff-base uppercase">${block.title}</h3>
                    <p class="fs-small lh-base">${block.text}</p>
                </div>`;
        });

        let teamHTML = '';
        const teamMembers = attr.teams?.data || [];
        if (teamMembers.length > 0) {
            let membersHTML = '';
            teamMembers.forEach(member => {
                const mAttr = member.attributes || member;
                const mImgUrl = mAttr.image?.data?.attributes?.url
                    ? `https://www.studiobrusco.com/cms${mAttr.image.data.attributes.url}`
                    : '';

                membersHTML += `
                    <div class="service-detail__member" data-cursor data-cursor-text="cv">
                        <div class="service-detail__member__media">
                            ${mImgUrl ? `<img src="${mImgUrl}" alt="${mAttr.name}" loading="lazy">` : ''}
                        </div>
                        <span class="fs-xsmall ff-base uppercase">${mAttr.name}</span>
                        <span class="fs-xsmall uppercase">${mAttr.jobTitle || ''}</span>
                    </div>`;
            });

            teamHTML = `
                <section class="service-detail__team" data-observe>
                    <h3 class="fs-small ff-base uppercase">${this.content.state.resources?.takesCareOf || 'ai phụ trách'}</h3>
                    <div class="service-detail__team__grid">
                        ${membersHTML}
                    </div>
                </section>`;
        }

        const sortedServices = [...services].sort((a, b) => (a.attributes?.order || 0) - (b.attributes?.order || 0));
        const currentIdx = sortedServices.findIndex(s => s.uid === uid);
        const nextService = sortedServices[(currentIdx + 1) % sortedServices.length];
        const nextAttr = nextService?.attributes || {};

        return `
            <section class="service-detail__header" data-observe>
                <div class="page__hero">
                    <div class="page__hero__media">
                        <div class="media position-relative has-video">
                            <div class="media__inner has-video">
                                ${attr.video ? `<video autoplay preload="auto" playsinline loop muted class="media__video">
                                    <source src="${attr.video}" type="video/mp4">
                                </video>` : ''}
                                ${imgUrl ? `<div class="picture__wrapper media__picture">
                                    <img src="${imgUrl}" alt="${attr.title}" class="picture__image" loading="lazy">
                                </div>` : ''}
                            </div>
                        </div>
                    </div>
                    <h1 class="page__hero__title fs-xlarge uppercase ff-light c-alt">${attr.title}</h1>
                </div>
            </section>

            <section class="service-detail__content">
                ${contentHTML}
            </section>

            ${teamHTML}

            ${nextService ? `
            <section class="service-detail__next" data-observe>
                <a href="#/servizi/${nextService.uid}" class="service-detail__next__link" data-cursor data-cursor-text="${this.content.state.resources?.next || 'tiếp theo'}">
                    <span class="fs-xsmall uppercase">${this.content.state.resources?.nextSection || 'muc tiếp theo'}</span>
                    <h2 class="fs-large ff-light uppercase">${nextAttr.title || ''}</h2>
                </a>
            </section>` : ''}

            ${this.renderFooterCTA()}
        `;
    }
}
