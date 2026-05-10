/**
 * StudioMenu — Pixel-perfect recreation from chunk 450.js
 * 
 * Key mechanism: Counter-movement technique
 * - .menu slides DOWN from y:-100% → y:0
 * - .menu__inner slides UP from y:100% → y:0
 * - This creates the effect where content appears to "stay in place" 
 *   while the menu shell reveals it
 */
export default class StudioMenu {
    constructor() {
        this.isOpen = false;
        this.toggleBtn = document.getElementById('menu-toggle');
        this.toggleSpan = this.toggleBtn ? this.toggleBtn.querySelector('[data-label]') : null;
        this.app = document.getElementById('app');

        // Selectors matching 20.js (c.a.menu.*)
        this.menuWrap = document.querySelector('.menu-wrap');
        this.menu = document.querySelector('.menu');
        this.menuInner = document.querySelector('.menu__inner');
        this.menuItems = document.querySelectorAll('.menu__item');
        this.menuItemLinks = document.querySelectorAll('.menu__item [data-route]');
        this.menuCta = document.querySelector('.menu__cta');
        this.menuFooter = document.querySelector('.menu__footer');
        
        if (!this.toggleBtn) return;
        
        this.init();
    }

    init() {
        this.toggleBtn.addEventListener('click', () => this.toggle());
        this._hydrateItemMedia();
        window.addEventListener('pagechange', () => this._hydrateItemMedia());
    }

    _getState() {
        return window.app?.pageManager?.content?.state || null;
    }

    _pickHeaderImageUrl(pageKey, state) {
        const base = 'https://www.studiobrusco.com/cms';
        const url =
            state?.pages?.[pageKey]?.data?.attributes?.header?.image?.data?.attributes?.url
            || state?.pages?.[pageKey]?.data?.attributes?.header?.image?.url
            || state?.pages?.[pageKey]?.data?.attributes?.header?.image?.data?.url;
        return url ? `${base}${url}` : '';
    }

    _hydrateItemMedia() {
        const state = this._getState();
        if (!state) return;

        const routeToPageKey = {
            index: 'home',
            team: 'team',
            servizi: 'servizi',
            contatti: 'contatti',
        };

        this.menuItemLinks.forEach((link) => {
            const route = link.getAttribute('data-route') || '';
            const img = link.querySelector('.menu__item__media');
            if (!img) return;

            const pageKey = routeToPageKey[route];
            const src = pageKey ? this._pickHeaderImageUrl(pageKey, state) : '';
            if (src) img.src = src;
        });
    }

    toggle() {
        this.isOpen ? this.close() : this.open();
    }

    /**
     * Open menu — exact match to 450.js lines 62-96
     * 
     * Original code:
     *   gsap.set(c.a.menu.el, { y: "-100%" });
     *   gsap.set(c.a.menu.inner, { y: "100%" });
     *   gsap.set([c.a.menu.item, ".menu__cta", ".menu__footer"], { opacity: 0, y: "30%" });
     *   gsap.set(c.a.menu.wrap, { pointerEvents: "all" });
     *   gsap.to([c.a.menu.item, ".menu__cta", ".menu__footer"], { duration: 1, ease: "power4.out", opacity: 1, y: "0%", stagger: 0.15, delay: 0.25 });
     *   gsap.to(c.a.menu.el, { duration: 1, ease: "power4.out", force3D: true, y: 0 });
     *   gsap.to(c.a.menu.inner, { duration: 1, ease: "power4.out", force3D: true, y: 0 });
     */
    open() {
        this.isOpen = true;
        this.app.classList.add('is-menu-open');

        // Toggle button text: "menu" -> "đóng"
        if (this.toggleSpan) {
            this.toggleSpan.textContent = 'đóng';
            this.toggleSpan.dataset.label = 'đóng';
        }

        // Collect stagger targets (matching original: [menu__item, .menu__cta, .menu__footer])
        const staggerTargets = [...this.menuItems];
        if (this.menuCta) staggerTargets.push(this.menuCta);
        if (this.menuFooter) staggerTargets.push(this.menuFooter);

        // --- Initial state ---
        gsap.set(this.menu, { y: "-100%" });
        gsap.set(this.menuInner, { y: "100%" });
        gsap.set(staggerTargets, { opacity: 0, y: "30%" });
        gsap.set(this.menuWrap, { pointerEvents: "all" });

        // --- Animations (all parallel, matching original) ---
        // Items fade in with stagger
        gsap.to(staggerTargets, {
            duration: 1,
            ease: "power4.out",
            opacity: 1,
            y: "0%",
            stagger: 0.15,
            delay: 0.25
        });

        // Menu shell slides down
        gsap.to(this.menu, {
            duration: 1,
            ease: "power4.out",
            force3D: true,
            y: 0
        });

        // Inner counter-slides up (creates the "content stays" illusion)
        gsap.to(this.menuInner, {
            duration: 1,
            ease: "power4.out",
            force3D: true,
            y: 0
        });
    }

    /**
     * Close menu — exact match to 450.js lines 98-117
     * 
     * Original code:
     *   gsap.to(c.a.menu.el, { duration: 1, ease: "power4.out", y: "-100%", force3D: true, onComplete: () => { gsap.set(c.a.menu.wrap, { pointerEvents: "none" }); } });
     *   gsap.to(c.a.menu.inner, { duration: 1, ease: "power4.out", y: "100%", force3D: true });
     */
    close() {
        this.isOpen = false;
        this.app.classList.remove('is-menu-open');

        // Toggle button text: "đóng" -> "menu"
        if (this.toggleSpan) {
            this.toggleSpan.textContent = 'menu';
            this.toggleSpan.dataset.label = 'menu';
        }

        // Menu shell slides back up
        gsap.to(this.menu, {
            duration: 1,
            ease: "power4.out",
            y: "-100%",
            force3D: true,
            onComplete: () => {
                gsap.set(this.menuWrap, { pointerEvents: "none" });
            }
        });

        // Inner counter-slides back down
        gsap.to(this.menuInner, {
            duration: 1,
            ease: "power4.out",
            y: "100%",
            force3D: true
        });
    }
}
