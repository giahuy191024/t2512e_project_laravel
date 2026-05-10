/**
 * StudioRouter — Hash-based SPA Router
 * 
 * Matches production Nuxt router behavior:
 * - beforeEach: stop Lenis, reset scroll
 * - afterEach: scroll to top, restart Lenis
 * - Page transition: out-in (old leaves, new enters)
 * 
 * Routes: /, /team, /servizi, /servizi/:uid, /contatti, /modulistica, /privacy
 */
export default class StudioRouter {
    constructor() {
        /** @type {{ path: string, name: string, pattern: RegExp, params?: string[] }[]} */
        this.routes = [
            { path: '/',             name: 'index',       pattern: /^#?\/?$/ },
            { path: '/team',         name: 'team',        pattern: /^#\/team\/?$/ },
            { path: '/servizi',      name: 'servizi',     pattern: /^#\/servizi\/?$/ },
            { path: '/servizi/:uid', name: 'servizi-uid', pattern: /^#\/servizi\/([^/]+)\/?$/, params: ['uid'] },
            { path: '/contatti',     name: 'contatti',    pattern: /^#\/contatti\/?$/ },
            { path: '/modulistica',  name: 'modulistica', pattern: /^#\/modulistica\/?$/ },
            { path: '/privacy',      name: 'privacy',     pattern: /^#\/privacy\/?$/ },
        ];

        this.currentRoute = null;
        this.previousRoute = null;
        this.isTransitioning = false;

        /** @type {Function[]} */
        this._beforeEachHooks = [];
        /** @type {Function[]} */
        this._afterEachHooks = [];
        /** @type {Function|null} */
        this._onNavigate = null;

        this._bindEvents();
    }

    /**
     * Register a callback for route changes
     * @param {Function} cb - (to, from) => void
     */
    onNavigate(cb) {
        this._onNavigate = cb;
    }

    /**
     * Register before-each guard (production: Lenis.stop)
     * @param {Function} cb - (to, from, next) => void
     */
    beforeEach(cb) {
        this._beforeEachHooks.push(cb);
    }

    /**
     * Register after-each hook (production: scroll reset, Lenis.start)
     * @param {Function} cb - (to, from) => void
     */
    afterEach(cb) {
        this._afterEachHooks.push(cb);
    }

    /**
     * Resolve a hash string to a route match
     * @param {string} hash
     * @returns {{ route: object, params: object }|null}
     */
    resolve(hash) {
        const normalized = hash || '';
        for (const route of this.routes) {
            const match = normalized.match(route.pattern);
            if (match) {
                const params = {};
                if (route.params) {
                    route.params.forEach((key, i) => {
                        params[key] = match[i + 1];
                    });
                }
                return { route, params };
            }
        }
        return null;
    }

    /**
     * Navigate to a route by path
     * @param {string} path - e.g. '/team' or '/servizi/chirurgia'
     */
    push(path) {
        window.location.hash = path === '/' ? '' : path;
    }

    /**
     * Initialize: read current hash and navigate
     */
    start() {
        this._handleHashChange();
    }

    /** @private */
    _bindEvents() {
        window.addEventListener('hashchange', () => this._handleHashChange());
    }

    /** @private */
    async _handleHashChange() {
        if (this.isTransitioning) return;

        const hash = window.location.hash;
        const resolved = this.resolve(hash);

        if (!resolved) {
            // Fallback to home
            console.warn(`[Router] No match for "${hash}", redirecting to home`);
            this.push('/');
            return;
        }

        const to = { ...resolved.route, params: resolved.params, hash };
        const from = this.currentRoute;

        // Don't re-navigate to same route
        if (from && to.name === from.name && JSON.stringify(to.params) === JSON.stringify(from.params)) {
            return;
        }

        this.isTransitioning = true;

        // --- beforeEach hooks ---
        for (const hook of this._beforeEachHooks) {
            await new Promise(resolve => hook(to, from, resolve));
        }

        // --- Update state ---
        this.previousRoute = from;
        this.currentRoute = to;

        // --- Notify page manager ---
        if (this._onNavigate) {
            await this._onNavigate(to, from);
        }

        // --- afterEach hooks ---
        for (const hook of this._afterEachHooks) {
            hook(to, from);
        }

        this.isTransitioning = false;
    }
}
