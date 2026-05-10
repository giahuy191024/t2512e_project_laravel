/**
 * BasePage — Parent class for all page modules
 */
export default class BasePage {
    constructor(content) {
        this.content = content;
        this.container = document.getElementById('page-container');
        this.app = document.getElementById('app');
    }

    /**
     * Return the HTML content for the page
     * @returns {string}
     */
    render() {
        return '';
    }

    /**
     * Handle post-render initialization (events, local logic)
     */
    init() {
        // To be overridden by child classes
    }

    /**
     * Called after the page enter transition (opacity/scale) finishes.
     * IntersectionObserver often misses above-the-fold nodes if they were measured while the page was still invisible.
     */
    afterPageReveal() {
        // Wait for GSAP enter (scale/opacity) to commit to layout before measuring in-view.
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                const root = document.querySelector('#page-container > main');
                if (!root) return;
                const vh = window.innerHeight || 0;
                const margin = 80;
                root.querySelectorAll('[data-observe]').forEach((el) => {
                    const r = el.getBoundingClientRect();
                    if (r.bottom > -margin && r.top < vh + margin) {
                        el.classList.add('is-inview');
                    }
                });
                if (typeof ScrollTrigger !== 'undefined') {
                    ScrollTrigger.refresh();
                }
            });
        });
    }

    /**
     * Handle cleanup when leaving the page
     */
    destroy() {
        // To be overridden by child classes
    }

    /**
     * Helper to render common footer CTA
     */
    renderFooterCTA() {
        if (!this.content || !this.content.state) return '';
        const res = this.content.state.resources || {};
        
        return `
            <section class="footer-cta sp-medium" data-observe>
                <div class="container footer-cta__container small">
                    <div class="footer-cta__inner ta-c position-relative">
                        <div class="footer-cta__content">
                            <span class="fs-xsmall uppercase sp-base display-block">${res.ctaTitle || 'hai bisogno di un consulto?'}</span>
                            <h2 class="fs-large ff-light uppercase sp-small">${res.ctaHeading || 'prenota un appuntamento'}</h2>
                            <a href="#/contatti" class="button button--primary" data-cursor data-route="contatti">
                                <div class="button__inner"><span data-label="${res.ctaButton || 'contatti'}" class="button__label">${res.ctaButton || 'contatti'}</span></div>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        `;
    }
}
