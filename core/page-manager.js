/**
 * PageManager — Manages page rendering and transitions
 * 
 * Responsibilities:
 * 1. Load content data
 * 2. Instantiate and render page components
 * 3. Page enter/leave transitions (GSAP)
 * 4. Update app state classes
 */
import HomePage from '../pages/home.js';
import TeamPage from '../pages/team.js';
import ServiziPage from '../pages/servizi.js';
import ServiziDetailPage from '../pages/servizi-detail.js';
import ContattiPage from '../pages/contatti.js';
import { ModulisticaPage, PrivacyPage } from '../pages/static-pages.js';

export default class PageManager {
    constructor() {
        this.container = document.getElementById('page-container');
        this.app = document.getElementById('app');
        this.content = null;
        this.currentPage = null;
        this.currentPageInstance = null;
        this._homeHTML = '';

        this._registerPages();
    }

    /**
     * Register page classes
     */
    _registerPages() {
        this.pageClasses = {
            'index': HomePage,
            'team': TeamPage,
            'servizi': ServiziPage,
            'servizi-uid': ServiziDetailPage,
            'contatti': ContattiPage,
            'modulistica': ModulisticaPage,
            'privacy': PrivacyPage,
        };
    }

    /**
     * Load content.json data
     */
    async loadContent() {
        try {
            const response = await fetch('data/team_data.json');
            this.content = await response.json();
            return this.content;
        } catch (err) {
            console.error('[PageManager] Failed to load content.json:', err);
            return null;
        }
    }

    /**
     * Capture the initial home page HTML from DOM before router takes over
     */
    captureHomePage() {
        const homeMain = document.querySelector('main.page.home');
        if (homeMain) {
            const inner = homeMain.querySelector('.page__inner');
            this._homeHTML = inner ? inner.innerHTML : homeMain.innerHTML;
        }
    }

    /**
     * Navigate to a page with transitions
     */
    async navigateTo(to, from, opts = {}) {
        const PageClass = this.pageClasses[to.name];

        // Router can run before loader finishes; is-loading forces [data-split] opacity:0 and blocks hero/description reveals.
        this.app.classList.remove('is-loading');
        
        // --- Phase 1: Leave transition ---
        if (from && this.container.children.length > 0) {
            // Menu-driven navigation should feel instantaneous; skip leave fade
            // so hero enter can start immediately while menu is collapsing.
            if (opts.fromMenu) {
                if (this.currentPageInstance && this.currentPageInstance.destroy) {
                    this.currentPageInstance.destroy();
                }
                const currentPage = this.container.querySelector('.page');
                if (currentPage) currentPage.remove();
            } else {
            await this._leaveTransition();
            if (this.currentPageInstance && this.currentPageInstance.destroy) {
                this.currentPageInstance.destroy();
            }
            }
        }

        // --- Phase 2: Update DOM ---
        this._updateAppClass(to.name);

        // Render new page content
        let html = '';
        if (PageClass) {
            const instance = to.name === 'index' 
                ? new PageClass(this.content, this._homeHTML)
                : new PageClass(this.content);
            
            this.currentPageInstance = instance;
            html = instance.render(to.params || {});
        } else {
            html = '<div class="page-error"><p>Không tìm thấy trang</p></div>';
        }

        this.container.innerHTML = '';
        const pageEl = document.createElement('main');
        // Production Nuxt keeps <main class="page"> (no route name on main; use #app.is-*)
        pageEl.className = to.name === 'index' ? 'page home' : 'page';
        pageEl.innerHTML = `<div class="page__inner position-relative">${html}</div>`;
        this.container.appendChild(pageEl);

        this.currentPage = to.name;

        // --- Phase 3: Init Page & Transitions ---
        if (this.currentPageInstance && this.currentPageInstance.init) {
            this.currentPageInstance.init();
        }
        
        // When navigation is initiated from the menu, we already waited ~300ms while menu collapses.
        // Adding an extra hero delay makes the transition feel out of sync.
        const heroEnterDelayOffset = from && !opts.fromMenu ? 0.25 : 0;
        await this._enterTransition(to.name, heroEnterDelayOffset, opts);
        if (this.currentPageInstance?.afterPageReveal) {
            this.currentPageInstance.afterPageReveal();
        }
        this._rebindInteractions();
    }

    _updateAppClass(routeName) {
        const pageClasses = [
            'is-home', 'is-team', 'is-servizi', 'is-servizi-detail', 
            'is-contatti', 'is-modulistica', 'is-privacy'
        ];
        pageClasses.forEach(cls => this.app.classList.remove(cls));

        const pageClassMap = {
            'index': 'is-home',
            'team': 'is-team',
            'servizi': 'is-servizi',
            'servizi-uid': 'is-servizi-detail',
            'contatti': 'is-contatti',
            'modulistica': 'is-modulistica',
            'privacy': 'is-privacy',
        };
        if (pageClassMap[routeName]) {
            this.app.classList.add(pageClassMap[routeName]);
        }
    }

    /**
     * Leave transition
     */
    _leaveTransition() {
        return new Promise(async resolve => {
            if (this.currentPageInstance && typeof this.currentPageInstance.leaveTransition === 'function') {
                await new Promise(r => this.currentPageInstance.leaveTransition(r));
            } else {
                const page = this.container.querySelector('.page');
                if (page) {
                    // Production parity (team/_nuxt/9c5a40e.js module 475): hide hero blocks before leaving.
                    const heroTargets = page.querySelectorAll(
                        '.hero__counter, .hero__paragraph:not([data-split]), .hero__title:not([data-split])'
                    );
                    if (heroTargets.length) {
                        gsap.set(heroTargets, { opacity: 0, yPercent: 20 });
                    }
                    await new Promise(r => {
                        gsap.to(page, {
                            opacity: 0,
                            duration: 0.5,
                            ease: 'expo.out',
                            onComplete: r
                        });
                    });
                }
            }
            
            // Clean up DOM after transition
            const page = this.container.querySelector('.page');
            if (page) page.remove();
            resolve();
        });
    }

    /**
     * Enter transition
     */
    _enterTransition(pageName, heroDelayOffset = 0, opts = {}) {
        return new Promise(resolve => {
            const page = this.container.querySelector('.page');
            if (!page) { resolve(); return; }
            const isMenuToHome = opts.fromMenu && pageName === 'index';

            // Clear portal hero after transition completes
            const clearPortal = () => {
                const portalHero = document.querySelector('.portal__hero');
                if (portalHero) {
                    portalHero.innerHTML = '';
                    portalHero.classList.remove('is-active');
                }
                resolve();
            };

            gsap.set(page, {
                opacity: 0,
                scale: isMenuToHome ? 1 : 0.8,
                transformOrigin: 'top center'
            });
            const heroBaseDelay = opts.fromMenu ? 0 : 0.1;
            const pageBaseDelay = opts.fromMenu ? 0 : 0.2;
            const pageEnterDuration = isMenuToHome ? 0.15 : (opts.fromMenu ? 0.22 : 1);

            // Production parity (team/_nuxt/9c5a40e.js module 475): hero blocks fade/slide in.
            const heroTargets = page.querySelectorAll(
                '.hero__counter, .hero__paragraph:not([data-split]), .hero__title:not([data-split])'
            );
            if (heroTargets.length) {
                gsap.set(heroTargets, { opacity: 0, yPercent: 20 });
                gsap.to(heroTargets, {
                    opacity: 1,
                    yPercent: 0,
                    duration: 1,
                    delay: heroBaseDelay + heroDelayOffset,
                    stagger: 0.1,
                    ease: 'expo.out',
                });
            }

            gsap.to(page, {
                opacity: 1,
                scale: 1,
                duration: pageEnterDuration,
                delay: pageBaseDelay,
                ease: 'expo.out',
                onComplete: clearPortal
            });
        });
    }

    /**
     * Re-bind interactions after page change
     */
    _rebindInteractions() {
        window.dispatchEvent(new CustomEvent('pagechange'));
    }
}
