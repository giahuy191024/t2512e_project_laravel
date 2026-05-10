export default class StudioSlider {
    constructor(options = {}) {
        this.options = {
            fromMenu: false,
            ...options
        };
        this.selector = {
            slider: ".home__slider",
            slides: ".home__slider__item",
            inner: ".home__slider__inner",
            media: ".home__slider__item__media",
            title: ".home__slider__title",
            slideIn: ".slide-in"
        };
        this.classes = {
            active: "is-active",
            visible: "is-visible"
        };
        this.dom = {
            slider: document.querySelector(this.selector.slider),
            slides: [...document.querySelectorAll(this.selector.slides)]
        };
        this.state = {
            slider: null,
            currentIndex: 0,
            animating: false,
            direction: null
        };
        
        if (this.dom.slides.length === 0) return;
        
        this.init();
    }

    init() {
        this.initMedia();
        this.setFirstSlide();
        this.setupObserver();
    }

    initMedia() {
        const mediaContainers = document.querySelectorAll(".media");
        mediaContainers.forEach((container) => {
            const video = container.querySelector("video");
            if (video) {
                // If video is already loaded
                if (video.readyState >= 3) {
                    container.classList.add("video-loaded");
                } else {
                    video.addEventListener("loadeddata", () => {
                        container.classList.add("video-loaded");
                    });
                }
            }
        });
    }

    setFirstSlide() {
        // Production exact match: only set the active slide
        // Non-active slides stay at CSS default: transform: translate3d(0, 110vh, 0)
        const firstSlide = this.dom.slides[this.state.currentIndex];
        const firstSlideIn = firstSlide.querySelectorAll(this.selector.slideIn);
        const firstTitles = firstSlide.querySelectorAll(this.selector.title);
        gsap.set(firstSlide, { zIndex: 2, y: 0 });
        firstSlide.classList.add(this.classes.active);
        firstSlide.classList.add(this.classes.visible);

        // When returning from menu, replay slide-1 text reveal immediately.
        if (this.options.fromMenu && firstSlideIn.length) {
            gsap.set(firstSlideIn, { yPercent: 100, opacity: 0 });
            gsap.set(firstTitles, { yPercent: 120, rotateX: "-90deg", opacity: 0 });
            gsap.to(firstSlideIn, {
                yPercent: 0,
                opacity: 1,
                duration: 0.6,
                stagger: 0.08,
                ease: "expo.out",
                overwrite: true
            });
            gsap.to(firstTitles, {
                yPercent: 0,
                rotateX: 0,
                opacity: 1,
                duration: 0.65,
                stagger: 0.12,
                ease: "expo.out",
                overwrite: true
            });
        } else if (firstSlideIn.length) {
            gsap.set(firstSlideIn, { yPercent: 0, opacity: 1 });
            gsap.set(firstTitles, { yPercent: 0, rotateX: 0, opacity: 1 });
        }
    }

    setupObserver() {
        // Production exact match: wheelSpeed:-1, onDown→next, onUp→prev
        this.state.slider = Observer.create({
            type: "wheel,touch,pointer",
            wheelSpeed: -1,
            dragMinimum: 50,
            onDown: () => !this.state.animating && this.next(),
            onUp: () => !this.state.animating && this.prev(),
            tolerance: 10,
            preventDefault: true
        });
    }

    // Production: prev() goes FORWARD in index (counter-intuitive but matches source)
    prev() {
        const nextIndex = this.state.currentIndex < this.dom.slides.length - 1 ? this.state.currentIndex + 1 : 0;
        this.navigate(nextIndex);
    }

    // Production: next() goes BACKWARD in index
    next() {
        const nextIndex = this.state.currentIndex > 0 ? this.state.currentIndex - 1 : this.dom.slides.length - 1;
        this.navigate(nextIndex);
    }

    setDirection(e) {
        if (this.state.currentIndex < e) {
            this.state.direction = (this.state.currentIndex === 0 && e === this.dom.slides.length - 1) ? "prev" : "next";
        } else {
            this.state.direction = (this.state.currentIndex === this.dom.slides.length - 1 && e === 0) ? "next" : "prev";
        }
    }

    navigate(e) {
        if (this.state.animating) return;
        this.state.animating = true;
        this.setDirection(e);

        const currentSlide = this.dom.slides[this.state.currentIndex];
        this.state.currentIndex = e;
        const nextSlide = this.dom.slides[this.state.currentIndex];

        const currentInner = currentSlide.querySelector(this.selector.inner);
        const currentMedia = currentSlide.querySelector(this.selector.media);
        const nextInner = nextSlide.querySelector(this.selector.inner);
        const nextTitle = nextSlide.querySelectorAll(this.selector.title);
        const nextMedia = nextSlide.querySelector(this.selector.media);
        const nextSlideIn = nextSlide.querySelectorAll(this.selector.slideIn);

        currentSlide.classList.remove(this.classes.active);
        nextSlide.classList.add(this.classes.active);
        nextSlide.classList.add(this.classes.visible);

        const isNext = this.state.direction === "next";

        // Production: duration 1.5, ease expo.inOut
        const tl = gsap.timeline({
            defaults: { duration: 1.5, ease: "expo.inOut" },
            onComplete: () => {
                currentSlide.classList.remove(this.classes.visible);
                // Safety: ensure slide-in text ends in final state
                gsap.set(nextSlideIn, { yPercent: 0, opacity: 1 });
                this.state.animating = false;
            }
        });

        // Reset and Prep Next Slide — exact production values
        tl.set(nextSlide, { 
            yPercent: isNext ? 100 : -100, 
            zIndex: 2, 
            y: 0 
        })
        .set(nextMedia, { 
            scale: 1.3, 
            yPercent: isNext ? -90 : 90 
        })
        .set(nextTitle, { 
            yPercent: isNext ? 100 : 200, 
            rotateX: "-100deg" 
        })
        .set(nextSlideIn, { 
            yPercent: isNext ? 100 : 200, 
            opacity: 0
        })
        .set(nextInner, { 
            yPercent: isNext ? -70 : 70 
        })
        .set(currentSlide, { zIndex: 1 });

        // Combined Animation — exact production values
        tl.to(currentSlide, { 
            yPercent: isNext ? -100 : 100, 
            force3D: true 
        }, 0)
        .to([currentMedia, currentInner], { 
            yPercent: isNext ? 90 : -90, 
            force3D: true 
        }, 0)
        .to(nextSlide, { 
            yPercent: 0 
        }, 0)
        .to(nextMedia, { 
            scale: 1, 
            yPercent: 0, 
            force3D: true 
        }, 0)
        .to(nextTitle, { 
            yPercent: 0, 
            stagger: 0.25, 
            rotateX: 0, 
            force3D: true 
        }, 0)
        .to(nextSlideIn, { 
            yPercent: 0, 
            opacity: 1, 
            delay: 0.25, 
            force3D: true 
        }, 0)
        .to(nextInner, { 
            yPercent: 0 
        }, 0);
    }

    destroy() {
        if (this.state.slider) this.state.slider.kill();
    }

    disable() {
        if (this.state.slider) this.state.slider.disable();
    }

    enable() {
        if (this.state.slider) this.state.slider.enable();
    }
}
