/**
 * StudioCursor — Pixel-perfect recreation from chunk 448.js
 * 
 * Key mechanism: Paused timeline approach
 * - TIMELINE.scale: paused timeline that scales inner to 2x
 * - On hover: tween timeline.time → duration (plays forward)
 * - On leave: tween timeline.time → 0 (plays backward)
 * - This gives smooth reversible animation
 */
export default class StudioCursor {
    constructor() {
        // DOM matching 448.js constructor (lines 29-55)
        this.DOM = {
            el: null,
            inner: null,
            text: null,
            targets: null,
            targetsText: null
        };

        this.SELECTORS = {
            text: ".cursor__text",
            targets: "[data-cursor]",
            targetsText: "[data-cursor-text]"
        };

        this.STATE = {
            isText: false
        };

        this.TIMELINE = {
            scale: null,
            text: null,
            reset: null
        };

        this.TWEENS = {
            scale: null,
            text: null
        };

        // Find cursor element
        this.DOM.el = document.querySelector('.cursor');
        if (!this.DOM.el) return;

        this.DOM.inner = this.DOM.el.querySelector('.cursor__inner');
        this.DOM.text = this.DOM.el.querySelector('.cursor__text');

        // Initial opacity = 0 (matching 448.js line 56)
        this.DOM.el.style.opacity = 0;

        const rect = this.DOM.el.getBoundingClientRect();
        this.bounds = {
            height: rect.height || 40 // Fallback to 40px (4rem)
        };

        this.getTargets();
        this.createTimeline();
        this.init();
    }

    /**
     * createTimeline — matching function y() in 448.js (lines 223-232)
     * Creates a PAUSED timeline for the scale hover effect
     */
    createTimeline() {
        this.TIMELINE.scale = gsap.timeline({ paused: true })
            .to(this.DOM.inner, {
                duration: 0.5,
                width: 40,
                ease: "none",
                scale: 2
            });
    }

    /**
     * init — matching function x() in 448.js (lines 194-212)
     * Sets up quickTo for smooth cursor following + show cursor
     */
    init() {
        this.showCursor();

        // quickTo with duration: 0.4, ease: "power4" (matching 448.js lines 196-202)
        const xTo = gsap.quickTo(this.DOM.el, "x", {
            duration: 0.4,
            ease: "power4"
        });
        const yTo = gsap.quickTo(this.DOM.el, "y", {
            duration: 0.4,
            ease: "power4"
        });

        // Initial transform (matching 448.js lines 204-208)
        gsap.set(this.DOM.el, {
            xPercent: -50,
            yPercent: -50,
            scale: 0.5
        });

        window.addEventListener("mousemove", (e) => {
            xTo(e.clientX);
            yTo(e.clientY);
        });
    }

    /**
     * showCursor — matching function _() in 448.js (lines 214-222)
     * delay: 2 (NOT 1)
     */
    showCursor() {
        gsap.to(this.DOM.el, {
            opacity: 1,
            scale: 1,
            duration: 1,
            ease: "expo.out",
            delay: 2
        });
    }

    /**
     * mouseEnter — matching 448.js lines 63-73
     * Uses paused timeline approach: tween timeline.time to play forward
     */
    mouseEnter() {
        if (this.TWEENS.text) {
            this.TWEENS.text.paused(true);
        }

        this.TWEENS.scale = gsap.to(this.TIMELINE.scale, {
            time: this.TIMELINE.scale.duration(),
            ease: "expo.out",
            overwrite: "auto"
        });
    }

    /**
     * mouseLeave — matching 448.js lines 76-83
     * Tween timeline.time back to 0 (plays backward)
     */
    mouseLeave() {
        this.TWEENS.scale = gsap.to(this.TIMELINE.scale, {
            time: 0,
            ease: "expo.out",
            overwrite: "auto"
        });
    }

    /**
     * mouseEnterText — matching 448.js lines 85-122
     * Complex: expands inner width based on text content, fades in text
     */
    mouseEnterText(e) {
        this.DOM.text.innerHTML = e.target.dataset.cursorText;

        if (this.TWEENS.scale) {
            this.TWEENS.scale.paused(true);
        }

        // Calculate target width (matching 448.js line 92)
        const targetWidth = e.target.dataset.cursorText === "" 
            ? 40 
            : this.DOM.text.getBoundingClientRect().width + this.bounds.height / 1.5;

        // Create text timeline (matching 448.js lines 93-116)
        this.TIMELINE.text = gsap.timeline({ paused: true })
            .fromTo(this.DOM.inner, 
                { width: "40px" }, 
                {
                    width: targetWidth,
                    duration: 1,
                    scale: 1,
                    ease: "none",
                    delay: 0.2
                }
            )
            .fromTo(this.DOM.text, 
                { opacity: 0, xPercent: -50 }, 
                {
                    y: 0,
                    duration: 0.5,
                    delay: 0.75,
                    xPercent: -50,
                    startAt: { y: 30 },
                    ease: "none",
                    opacity: 1
                }, 
                0
            );

        // Play text timeline forward (matching 448.js lines 117-121)
        this.TWEENS.text = gsap.to(this.TIMELINE.text, {
            time: this.TIMELINE.text.duration(),
            ease: "expo.out",
            overwrite: "auto"
        });
    }

    /**
     * mouseLeaveText — matching 448.js lines 124-135
     * Reverse text timeline, reset inner width
     */
    mouseLeaveText() {
        this.TWEENS.text = gsap.to(this.TIMELINE.text, {
            time: 0,
            ease: "expo.out",
            overwrite: "auto"
        });

        gsap.set(this.DOM.inner, { width: 40 });
        this.DOM.text.innerHTML = "";
    }

    /**
     * testMethod — matching 448.js lines 137-161
     * Called on route/state changes to reset cursor
     */
    resetCursor() {
        this.getTargets();

        if (this.TWEENS.scale) {
            this.TWEENS.scale.paused(true);
        }
        if (this.TWEENS.text) {
            this.TWEENS.text.paused(true);
        }

        gsap.to(this.DOM.inner, {
            duration: 0.5,
            width: 40,
            ease: "expo.out",
            scale: 1
        });

        gsap.to(this.DOM.text, {
            opacity: 0,
            onComplete: () => {
                this.DOM.text.innerHTML = "";
            }
        });
    }

    /**
     * getTargets — matching 448.js lines 163-190
     * Binds mouseenter/mouseleave to [data-cursor] and [data-cursor-text]
     * Uses dataset.cursorActive guard to prevent double-binding
     */
    getTargets() {
        this.DOM.targets = document.querySelectorAll(this.SELECTORS.targets);
        this.DOM.targetsText = document.querySelectorAll(this.SELECTORS.targetsText);

        this.DOM.targets.forEach((el) => {
            if (!el.dataset.cursorActive) {
                el.dataset.cursorActive = true;
                el.addEventListener("mouseenter", () => this.mouseEnter());
                el.addEventListener("mouseleave", () => this.mouseLeave());
            }
        });

        this.DOM.targetsText.forEach((el) => {
            if (!el.dataset.cursorActive) {
                el.dataset.cursorActive = true;
                el.addEventListener("mouseenter", (e) => this.mouseEnterText(e));
                el.addEventListener("mouseleave", () => this.mouseLeaveText());
            }
        });
    }


    /**
     * rebind — called after SPA page transitions to re-attach cursor
     * to new DOM elements
     */
    rebind() {
        this.resetCursor();
    }
}
