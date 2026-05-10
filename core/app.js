import StudioCursor from '../components/cursor.js';
import StudioMenu from '../components/menu.js';
import StudioSlider from '../components/slider.js';
import StudioRouter from './router.js';
import PageManager from './page-manager.js';

class App {
    constructor() {
        this.modules = {};
        this.router = null;
        this.pageManager = null;
        this.isFirstLoad = true;
        this.init();
    }

    async init() {
        try {
            // 1. Initialize page manager and load content
            this.pageManager = new PageManager();
            await this.pageManager.loadContent();

            // 2. Capture initial home page HTML before router takes over
            this.pageManager.captureHomePage();

            // 3. Initialize Lenis Smooth Scroll
            this.initLenis();

            // 4. Initialize Modules
            this.modules.cursor = new StudioCursor();
            this.modules.menu = new StudioMenu();
            this.modules.slider = new StudioSlider();

            // 4. Initialize Router
            this.router = new StudioRouter();
            this._setupRouter();

            // 5. Play entry animation on first load (home page)
            setTimeout(() => {
                this.playEntryAnimation();
            }, 1500);

            // 6. Start router (reads current hash)
            // Delay router start until after entry animation
            setTimeout(() => {
                this.router.start();
            }, 4000);

        } catch (error) {
            console.error('Initialization failed:', error);
        }
    }

    /**
     * Setup router hooks and navigation handler
     */
    _setupRouter() {
        // beforeEach: matching production (deobfuscated.js line 6816)
        this.router.beforeEach((to, from, next) => {
            // Close menu if open
            if (this.modules.menu && this.modules.menu.isOpen) {
                // When navigating from menu, start page transition immediately so hero enter
                // begins before/at the same moment menu collapse starts.
                this._navigatingFromMenu = true;
                next();
                setTimeout(() => this.modules.menu?.close(), 0);
            } else {
                next();
            }
        });

        // afterEach: matching production (deobfuscated.js line 6820)
        this.router.afterEach((to, from) => {
            // Scroll to top
            if (window.lenis) {
                window.lenis.scrollTo(0, { immediate: true });
            } else {
                window.scrollTo(0, 0);
            }

            // Update active menu item
            this._updateActiveMenuItem(to.name);
        });

        // Navigation handler
        this.router.onNavigate(async (to, from) => {
            // Skip page manager render on first load (home is already in DOM)
            if (this.isFirstLoad && to.name === 'index') {
                this.isFirstLoad = false;
                return;
            }
            this.isFirstLoad = false;

            // Destroy slider if leaving home
            if (from && from.name === 'index' && this.modules.slider) {
                this.modules.slider.destroy?.();
            }

            // Let page manager handle the transition
            const opts = { fromMenu: !!this._navigatingFromMenu };
            this._navigatingFromMenu = false;
            await this.pageManager.navigateTo(to, from, opts);

            // Re-init slider if navigating to home
            if (to.name === 'index') {
                this.modules.slider = new StudioSlider({ fromMenu: opts.fromMenu });
            }

            // Re-bind cursor interactions
            if (this.modules.cursor) {
                this.modules.cursor.rebind?.();
            }
        });
    }

    /**
     * Update active state on menu items
     * @param {string} routeName
     */
    _updateActiveMenuItem(routeName) {
        const menuItems = document.querySelectorAll('.menu__item');
        const routeMap = ['index', 'team', 'servizi', 'contatti'];

        menuItems.forEach((item, i) => {
            const itemRoute = routeMap[i] || '';
            if (itemRoute === routeName || (routeName === 'servizi-uid' && itemRoute === 'servizi')) {
                item.classList.add('is-active');
            } else {
                item.classList.remove('is-active');
            }
        });
    }

    playEntryAnimation() {
        const loader = document.querySelector('.loader');
        
        // --- 1. Master Timeline ---
        const tl = gsap.timeline();

        // --- 2. Initial State Setup ---
        gsap.set(loader, { y: "0%" });
        gsap.set(".loader__logo", { opacity: 1 });
        
        // Home page elements initial state
        gsap.set(".home__slider__intro__top", { y: "-150%" });
        gsap.set(".home__slider__intro__bottom", { y: "150%" });
        gsap.set(".home__slider__item--first .home__slider__item__media", { scale: 1.2 });
        gsap.set(".nav", { opacity: 0, y: -20 });

        // --- 3. Loader Entrance Sequence ---
        tl.from(".logo-wheel", {
            scale: 0,
            duration: 1,
            ease: "expo.out",
            delay: 0.3
        });

        tl.from(".logo", {
            x: "37%",
            duration: 1.5,
            ease: "expo.out",
            force3D: true
        });

        tl.from(".logo-line", {
            x: "-100%",
            duration: 1,
            ease: "expo.out",
            stagger: 0.15,
            force3D: true,
            immediateRender: true,
            onComplete: () => {
                this.playExitAnimation();
            }
        }, "-=1.4");

        return tl;
    }

    playExitAnimation() {
        const loader = document.querySelector('.loader');
        
        gsap.to(".logo", {
            y: "-20vh",
            duration: 1.5,
            ease: "expo.inOut",
            force3D: true
        });

        gsap.to(loader, {
            yPercent: -100,
            duration: 1.25,
            ease: "expo.inOut",
            force3D: true
        });

        setTimeout(() => {
            this.triggerHomeTransitions();
        }, 500);
    }

    initLenis() {
        if (typeof Lenis === 'undefined') return;

        window.lenis = new Lenis({
            duration: 1.2,
            easing: (t) => Math.min(1, 1.001 - Math.pow(2, -10 * t)),
            orientation: 'vertical',
            gestureOrientation: 'vertical',
            smoothWheel: true,
            wheelMultiplier: 1,
            smoothTouch: false,
            touchMultiplier: 2,
            infinite: false,
        });
        // Keep a single RAF source for Lenis to avoid double updates per frame.
        if (typeof ScrollTrigger !== 'undefined' && typeof gsap !== 'undefined') {
            window.lenis.on('scroll', ScrollTrigger.update);
            gsap.ticker.add((time) => {
                window.lenis.raf(time * 1000);
            });
            gsap.ticker.lagSmoothing(0);
            return;
        }

        const raf = (time) => {
            window.lenis.raf(time);
            requestAnimationFrame(raf);
        };
        requestAnimationFrame(raf);
    }

    triggerHomeTransitions() {
        const homeTl = gsap.timeline({
            onStart: () => {
                document.getElementById('app').classList.remove('is-loading');
            }
        });

        homeTl.addLabel("start");

        homeTl.to(".nav", { 
            opacity: 1, 
            y: 0, 
            duration: 1, 
            ease: "expo.out" 
        }, "start");

        gsap.to(".home__slider__intro__top", {
            y: 0,
            duration: 1,
            ease: "expo.out"
        });
        gsap.to(".home__slider__intro__bottom", {
            y: 0,
            duration: 1,
            ease: "expo.out"
        });

        gsap.to(".home__slider__item--first .home__slider__item__media", {
            scale: 1,
            duration: 2,
            ease: "expo.out",
            overwrite: "true"
        });

        // Home slider uses GSAP to animate `.slide-in` elements; no CSS class toggle needed here.
    }
}

// Start the app
window.addEventListener('DOMContentLoaded', () => {
    window.app = new App();
});
