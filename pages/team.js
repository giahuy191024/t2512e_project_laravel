import BasePage from './base-page.js';
import { initSplitText, debounce } from '../utils/text-utils.js';
import { escapeHtml, formatPlainBio } from '../utils/cms-text.js';

const CMS_BASE = 'https://www.studiobrusco.com/cms';

/** Production-style Strapi image URLs (`?&w=` when no query). */
function cmsSizedUrl(baseUrl, w) {
    if (!baseUrl) return '';
    const joiner = baseUrl.includes('?') ? '&' : '?&';
    return `${baseUrl}${joiner}w=${w}`;
}

/**
 * `<picture>` block matching Nuxt output (webp + jpeg sources, picture__wrapper + media__picture).
 */
function cmsPictureBlock(baseUrl, alt, w, opts = {}) {
    if (!baseUrl) return '';
    const {
        loading = 'lazy',
        fetchpriority = '',
        className = 'picture__image wc-t',
        dataParallax = false,
    } = opts;
    const webp = `${escapeHtml(baseUrl)}${baseUrl.includes('?') ? '&' : '?&'}w=${w}&format=webp`;
    const jpeg = escapeHtml(cmsSizedUrl(baseUrl, w));
    const fp = fetchpriority ? ` fetchpriority="${fetchpriority}"` : '';
    const lm = loading ? ` loading="${loading}"` : '';
    const parallax = dataParallax ? ' data-parallax="true"' : '';
    return `<div class="picture__wrapper media__picture">
    <picture class="picture">
      <source srcset="${webp}" type="image/webp" />
      <source srcset="${jpeg}" type="image/jpeg" />
      <img src="${jpeg}" alt="${escapeHtml(alt)}"${fp}${lm}${parallax} class="${className}" />
    </picture>
  </div>`;
}

/**
 * Content cards + next-section image: Nuxt uses `?&format=webp` and trailing `?` for JPEG (no `w=`).
 */
function cmsCardPictureBlock(baseUrl, alt) {
    if (!baseUrl) return '';
    const hasQ = baseUrl.includes('?');
    const webp = escapeHtml(baseUrl) + (hasQ ? '&' : '?&') + 'format=webp';
    const jpegRef = escapeHtml(baseUrl) + (hasQ ? '&' : '?');
    return `<div class="picture__wrapper media__picture">
    <picture class="picture">
      <source srcset="${webp}" type="image/webp" />
      <source srcset="${jpegRef}" type="image/jpeg" />
      <img src="${jpegRef}" alt="${escapeHtml(alt)}" fetchpriority="auto" class="picture__image wc-t" />
    </picture>
  </div>`;
}

const WHEEL_NAV_SVG_LEFT = `<svg width="26" height="18" viewBox="0 0 26 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M25.4404 10.0402V7.9602H7.20043C8.48043 7.0002 9.41376 5.93353 10.0004 4.76019C10.5338 3.53353 10.8538 2.49353 10.9604 1.6402C11.0671 0.733528 11.1204 0.253528 11.1204 0.200195H9.12043C9.12043 0.253528 9.0671 0.680195 8.96043 1.4802C8.80043 2.28019 8.45376 3.18686 7.92043 4.20019C7.33376 5.21353 6.42709 6.09353 5.20043 6.8402C3.97376 7.58686 2.24043 7.9602 0.000429153 7.9602V10.0402C2.24043 10.0402 3.97376 10.4135 5.20043 11.1602C6.42709 11.9069 7.33376 12.7869 7.92043 13.8002C8.45376 14.8135 8.80043 15.7202 8.96043 16.5202C9.0671 17.2669 9.12043 17.6935 9.12043 17.8002H11.1204C11.1204 17.8002 11.0671 17.3469 10.9604 16.4402C10.8004 15.5335 10.4538 14.4935 9.92043 13.3202C9.3871 12.0935 8.48043 11.0002 7.20043 10.0402H25.4404Z" fill="currentColor"/></svg>`;

const WHEEL_NAV_SVG_RIGHT = `<svg width="27" height="18" viewBox="0 0 27 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0.799805 10.0402V7.9602H19.0398C17.7598 7.0002 16.8265 5.93353 16.2398 4.76019C15.7065 3.53353 15.3865 2.49353 15.2798 1.6402C15.1731 0.733528 15.1198 0.253528 15.1198 0.200195H17.1198C17.1198 0.253528 17.1731 0.680195 17.2798 1.4802C17.4398 2.28019 17.7865 3.18686 18.3198 4.20019C18.9065 5.21353 19.8131 6.09353 21.0398 6.8402C22.2665 7.58686 23.9998 7.9602 26.2398 7.9602V10.0402C23.9998 10.0402 22.2665 10.4135 21.0398 11.1602C19.8131 11.9069 18.9065 12.7869 18.3198 13.8002C17.7865 14.8135 17.4398 15.7202 17.2798 16.5202C17.1731 17.2669 17.1198 17.6935 17.1198 17.8002H15.1198C15.1198 17.8002 15.1731 17.3469 15.2798 16.4402C15.4398 15.5335 15.7865 14.4935 16.3198 13.3202C16.8531 12.0935 17.7598 11.0002 19.0398 10.0402H0.799805Z" fill="currentColor"/></svg>`;

/** Prefer Strapi pages.teams ordering; fallback dedupe across services */
function resolveTeamsList(state) {
    const pageTeams = state.pages?.teams?.data;
    if (Array.isArray(pageTeams) && pageTeams.length > 0) {
        return [...pageTeams]
            .filter((entry) => (entry.attributes || entry).active !== false)
            .sort((a, b) => {
                const ao = (a.attributes || a).order ?? 999;
                const bo = (b.attributes || b).order ?? 999;
                return ao - bo;
            });
    }
    const services = state.services || [];
    const teams = [];
    const seenIds = new Set();
    services.forEach((service) => {
        const serviceTeams = service.attributes?.teams?.data || [];
        serviceTeams.forEach((member) => {
            if (!seenIds.has(member.id)) {
                teams.push(member);
                seenIds.add(member.id);
            }
        });
    });
    teams.sort((a, b) => {
        const ao = (a.attributes || a).order ?? 999;
        const bo = (b.attributes || b).order ?? 999;
        return ao - bo;
    });
    return teams;
}

function hasVietnameseText(text) {
    // Use Vietnamese-specific letters only to avoid matching Italian/French accents.
    return /[ăâđêôơưĂÂĐÊÔƠƯ]/.test(String(text || ''));
}

function getTeamViProfile(attr = {}) {
    const key = String(attr.name || '')
        .trim()
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '');
    const profiles = {
        'matteo brusco': {
            jobTitle: 'Bác sĩ nha khoa - Phẫu thuật',
            description: 'Bác sĩ Matteo Brusco phụ trách mảng phẫu thuật nha khoa và cấy ghép. Bác sĩ có nhiều năm kinh nghiệm lâm sàng, tập trung vào các ca điều trị phức tạp với định hướng an toàn, chính xác và cá nhân hóa cho từng bệnh nhân.',
        },
        'silvia pilloni': {
            jobTitle: 'Bác sĩ nha khoa - Phục hình',
            description: 'Bác sĩ Silvia Pilloni phụ trách phục hình nha khoa. Định hướng điều trị là phục hồi chức năng ăn nhai, thẩm mỹ và độ bền lâu dài, dựa trên chẩn đoán toàn diện và kế hoạch điều trị rõ ràng.',
        },
        'giovanni marzari': {
            jobTitle: 'Bác sĩ nha khoa - Nội nha',
            description: 'Bác sĩ Giovanni Marzari chuyên sâu nội nha (điều trị tủy). Bác sĩ chú trọng bảo tồn răng thật, kiểm soát nhiễm khuẩn và theo dõi kết quả điều trị nhằm đảm bảo hiệu quả bền vững.',
        },
        'marcella cascone': {
            jobTitle: 'Bác sĩ nha khoa - Chỉnh nha',
            description: 'Bác sĩ Marcella Cascone phụ trách chỉnh nha. Bác sĩ xây dựng lộ trình điều trị phù hợp từng độ tuổi, tối ưu cả chức năng khớp cắn và thẩm mỹ khuôn mặt.',
        },
        'anna salandini': {
            jobTitle: 'Bác sĩ nha khoa - Nha khoa trẻ em',
            description: 'Bác sĩ Anna Salandini chuyên điều trị nha khoa trẻ em, tập trung tạo trải nghiệm nhẹ nhàng, hợp tác tốt và xây dựng thói quen chăm sóc răng miệng đúng cách từ sớm.',
        },
        'davide zampieri': {
            jobTitle: 'Bác sĩ nha khoa - Nha khoa bảo tồn',
            description: 'Bác sĩ Davide Zampieri phụ trách nha khoa bảo tồn, ưu tiên các phương pháp ít xâm lấn, phục hồi mô răng tối đa và duy trì sức khỏe răng miệng lâu dài.',
        },
        'lorenzo trevisiol': {
            jobTitle: 'Phẫu thuật hàm mặt',
            description: 'Bác sĩ Lorenzo Trevisiol phụ trách các chỉ định phẫu thuật hàm mặt, phối hợp liên chuyên khoa để xử lý các ca cần can thiệp chuyên sâu.',
        },
        'elena campanaro': {
            jobTitle: 'Chuyên viên vệ sinh răng miệng',
            description: 'Elena Campanaro phụ trách chăm sóc và vệ sinh răng miệng chuyên sâu, hỗ trợ dự phòng bệnh nha chu và hướng dẫn chăm sóc tại nhà.',
        },
        'mario gabaldo': {
            jobTitle: 'Chuyên viên vệ sinh răng miệng',
            description: 'Mario Gabaldo thực hiện vệ sinh răng miệng chuyên nghiệp, theo dõi sức khỏe nướu và đồng hành cùng bệnh nhân trong chương trình chăm sóc định kỳ.',
        },
        'camilla brunelli': {
            jobTitle: 'Chuyên viên vệ sinh răng miệng',
            description: 'Camilla Brunelli tập trung chăm sóc dự phòng, làm sạch chuyên sâu và tư vấn duy trì sức khỏe răng miệng phù hợp từng tình trạng lâm sàng.',
        },
        'nicolo ambrosi': {
            jobTitle: 'Chuyên viên vệ sinh răng miệng',
            description: 'Nicolò Ambrosi thực hiện các dịch vụ vệ sinh răng miệng và dự phòng, hỗ trợ bệnh nhân duy trì kết quả điều trị ổn định.',
        },
        'romina brusco': {
            jobTitle: 'Lễ tân - Chăm sóc khách hàng',
            description: 'Romina Brusco phụ trách tiếp đón, hướng dẫn quy trình khám và hỗ trợ bệnh nhân trong các nhu cầu hành chính hằng ngày.',
        },
        'laura regazzin': {
            jobTitle: 'Lễ tân - Chăm sóc khách hàng',
            description: 'Laura Regazzin hỗ trợ đặt lịch, điều phối thông tin và chăm sóc trải nghiệm bệnh nhân trước, trong và sau điều trị.',
        },
        'valeria zampieri': {
            jobTitle: 'Lễ tân - Chăm sóc khách hàng',
            description: 'Valeria Zampieri đồng hành cùng bệnh nhân trong quá trình tiếp nhận thông tin, sắp xếp lịch hẹn và hỗ trợ thủ tục cần thiết.',
        },
        'irene zenari': {
            jobTitle: 'Trợ lý nha khoa',
            description: 'Irene Zenari hỗ trợ bác sĩ trong quá trình điều trị, chuẩn bị dụng cụ và đảm bảo quy trình vận hành phòng khám diễn ra an toàn, hiệu quả.',
        },
        'selena faccio': {
            jobTitle: 'Trợ lý nha khoa',
            description: 'Selena Faccio tham gia hỗ trợ lâm sàng, kiểm soát vô khuẩn và phối hợp với đội ngũ để tối ưu trải nghiệm điều trị cho bệnh nhân.',
        },
        'natascia marconcini': {
            jobTitle: 'Trợ lý nha khoa',
            description: 'Natascia Marconcini phụ trách hỗ trợ kỹ thuật trong phòng điều trị và phối hợp chăm sóc bệnh nhân theo đúng quy trình chuyên môn.',
        },
        'andrea gazzi': {
            jobTitle: 'Trợ lý nha khoa',
            description: 'Andrea Gazzi hỗ trợ bác sĩ trong các thủ thuật nha khoa, chuẩn bị thiết bị và đảm bảo quy trình điều trị diễn ra liên tục, an toàn.',
        },
        'katiuscia cossu': {
            jobTitle: 'Trợ lý nha khoa',
            description: 'Katiuscia Cossu đồng hành cùng đội ngũ điều trị, hỗ trợ thao tác lâm sàng và chăm sóc bệnh nhân trong suốt buổi khám.',
        },
        'ivana paiola': {
            jobTitle: 'Trợ lý nha khoa',
            description: 'Ivana Paiola hỗ trợ công tác chuẩn bị điều trị, phối hợp vô khuẩn và chăm sóc người bệnh theo tiêu chuẩn của phòng khám.',
        },
        'ezio chiaramonte': {
            jobTitle: 'Kỹ thuật viên nha khoa',
            description: 'Ezio Chiaramonte phụ trách kỹ thuật phục hình, phối hợp cùng bác sĩ để hoàn thiện các giải pháp phục hồi chức năng và thẩm mỹ.',
        },
        'nicola chiaramonte': {
            jobTitle: 'Kỹ thuật viên nha khoa',
            description: 'Nicola Chiaramonte tham gia thiết kế và hoàn thiện phục hình nha khoa với tiêu chí chính xác, phù hợp và ổn định lâu dài.',
        },
    };
    return profiles[key] || null;
}

class TeamDetailSlider {
    constructor(root) {
        this.root = root;
        this.selector = {
            slides: '.teams-detail__media',
            content: '.teams-detail__content__item',
        };
        this.classes = { active: 'is-active' };
        this.dom = { slides: [], content: [] };
        this.state = {
            currentIndex: 1,
            animating: false,
            duration: 1,
            isFirstLoad: true,
        };
        this._listeners = [];
        this._initTimer = null;
    }

    _cacheDom() {
        this.dom.slides = Array.from(this.root.querySelectorAll(this.selector.slides));
        this.dom.content = Array.from(this.root.querySelectorAll(this.selector.content));
    }

    _wrap(index) {
        return gsap.utils.wrap(0, this.dom.slides.length, index);
    }

    _slideTo(slide, index, immediate = false) {
        const isTablet = window.matchMedia('(min-width: 960px) and (max-width: 1279.8px)').matches;
        const current = this.state.currentIndex;
        const offset = index < current ? 80 : (isTablet ? 120 : 138);
        const translateY = `${index * offset - offset * current}%`;
        const deltaScale = index < current ? 0.3 : (isTablet ? 0.35 : 0.6);
        const currentBias = index === current ? 0.4 : 0;
        const scale = 1 - (current - index - currentBias) * deltaScale;

        slide.dataset.cursorText = index === current ? '' : (index > current ? 'tiếp theo' : 'trước');
        gsap.to(slide, {
            zIndex: index,
            translateY,
            scale,
            duration: immediate ? 0 : this.state.duration,
            ease: 'power4.inOut',
            delay: (index + 1 - current) * 0.025,
            force3D: true,
            onComplete: () => {
                this.state.animating = false;
            },
        });

        const content = this.dom.content[index];
        if (content) {
            content.dataset.cursorText = index === current ? '' : (index > current ? 'tiếp theo' : 'trước');
            gsap.to(content, {
                translateY: `${(index - current) * (index < current ? 110 : 82)}vh`,
                ease: 'power4.inOut',
                force3D: true,
                duration: immediate ? 0 : this.state.duration,
            });
        }
    }

    _navigate(targetIndex, immediate = false) {
        if (this.state.animating || !this.dom.slides.length) return;

        const nextIndex = this._wrap(Number(targetIndex));
        this.state.animating = true;
        this.state.currentIndex = nextIndex;

        const prevSlide = this.dom.slides[nextIndex - 1];
        const currSlide = this.dom.slides[nextIndex];
        const nextSlide = this.dom.slides[nextIndex + 1];
        const prevContent = this.dom.content[nextIndex - 1];
        const currContent = this.dom.content[nextIndex];
        const nextContent = this.dom.content[nextIndex + 1];

        prevSlide?.classList.remove(this.classes.active);
        currSlide?.classList.add(this.classes.active);
        nextSlide?.classList.remove(this.classes.active);
        prevContent?.classList.remove(this.classes.active);
        currContent?.classList.add(this.classes.active);
        nextContent?.classList.remove(this.classes.active);

        // Production behavior: animate all slides (the original `canBeAnimated` guard isn't applied here).
        this.dom.slides.forEach((slide, index) => {
            this._slideTo(slide, index, immediate);
        });
    }

    navigateTo(index) {
        this._navigate(index, true);
    }

    init() {
        this.destroy();
        this._cacheDom();
        if (!this.dom.slides.length) return;

        this.dom.slides.forEach((slide) => {
            const handler = () => this._navigate(slide.dataset.index);
            slide.addEventListener('click', handler);
            this._listeners.push(() => slide.removeEventListener('click', handler));
        });

        this.dom.content.forEach((content) => {
            const handler = () => this._navigate(content.dataset.index);
            content.addEventListener('click', handler);
            this._listeners.push(() => content.removeEventListener('click', handler));
        });

        this.dom.slides.forEach((slide, index) => this._slideTo(slide, index, true));
        this._initTimer = window.setTimeout(() => {
            this._navigate(0, true);
            this.state.isFirstLoad = false;
        }, 1000);
    }

    destroy() {
        this._listeners.forEach((off) => off());
        this._listeners = [];
        if (this._initTimer) {
            window.clearTimeout(this._initTimer);
            this._initTimer = null;
        }
    }
}

export default class TeamPage extends BasePage {
    constructor(content) {
        super(content);
        this.wheelRotation = 0;
        this.currentIndex = 0;
        this.isDetailOpen = false;
        this.wheelCarousel = null;
        this.observer = null;
        this._resizeHandler = null;
        this._backTrigger = null;
        this._teams = [];
        this._mountedOverlayRoot = null;
        this._overlayMarkup = '';
        this._observerInitTimer = null;
        this._deferredInitTimer = null;
        this._detailSlider = null;
    }

    render() {
        if (!this.content) return '<p>Đang tải...</p>';

        const data = this.content.state;
        const teams = resolveTeamsList(data);
        this._teams = teams;

        const teamPage = data.pages?.team || data.team || {};
        const teamData = teamPage.data?.attributes || teamPage.attributes || {};

        const header = teamData.header || {};
        const description = teamData.description || {};
        const contentBlocks = teamData.content || [];

        const getImgUrl = (attr) => {
            const url = attr?.image?.data?.attributes?.url || attr?.url;
            return url ? `${CMS_BASE}${url}` : '';
        };

        // ── 1. Wheel Cards — static word-mask / .word (production Nuxt; no per-word SplitText)
        // Desktop clones all cards ×2 for seamless loop (production: ~22 × 2 = 44 DOM nodes).
        let wheelCardsHTML = '';
        teams.forEach((member, i) => {
            const attr = member.attributes || member;
            const imgUrl = getImgUrl(attr);
            const fetchPr = i < 3 ? 'high' : '';

            wheelCardsHTML += `
                <div class="wheel__card fs-large" data-index="${i}" data-cursor>
                    <div class="media position-relative wc-t wheel__card__media">
                        <div class="media__inner wc-t">
                            ${imgUrl ? cmsPictureBlock(imgUrl, attr.name || '', 600, { fetchpriority: fetchPr, loading: 'lazy' }) : ''}
                        </div>
                    </div>
                    <div class="wheel__card__description display-flex">
                        <div class="word-mask fs-xsmall uppercase">
                            <span class="word lh-base" style="--delay:1">${escapeHtml(attr.name || '')}</span>
                        </div>
                        <div class="word-mask fs-xsmall uppercase">
                            <span class="word lh-base" style="--delay:2">${escapeHtml(attr.jobTitle || '')}</span>
                        </div>
                    </div>
                </div>`;
        });

        // ── 2. Content Cards (Technology, Security) ──
        let contentCardsHTML = '';
        contentBlocks.forEach((block) => {
            const imgUrl = getImgUrl(block);
            const vid = block.video ? String(block.video) : '';
            contentCardsHTML += `
                <div class="container card-wrapper sp-small small">
                    <div>
                    <div data-observe class="card">
                        <div class="card__content">
                            <h3 class="card__title wc-t sp-small fs-medium ff-light uppercase no-h">
                                <span class="card__title__label">${escapeHtml(block.title)}</span>
                                <span class="card__title__label">${escapeHtml(block.title)}</span>
                            </h3>
                            <p class="card__paragraph ta-c fs-xsmall uppercase lh-base">${escapeHtml(block.description || '')}</p>
                        </div>
                        <div class="card__picture">
                            <div class="media position-relative wc-t has-video">
                                <div data-parallax="true" class="media__inner wc-t has-video">
                                    ${vid ? `<video autoplay preload="auto" playsinline loop muted class="media__video"><source src="${escapeHtml(vid)}" type="video/mp4"></video>` : ''}
                                    ${imgUrl ? cmsCardPictureBlock(imgUrl, block.title || '') : ''}
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>`;
        });

        // ── 3. Detail Overlay Items ──
        let detailImagesHTML = '';
        let detailContentHTML = '';
        teams.forEach((member, i) => {
            const attr = member.attributes || member;
            const imgUrl = getImgUrl(attr);
            const cvUrl = attr.cv?.data?.attributes?.url ? `${CMS_BASE}${attr.cv.data.attributes.url}` : '';
            const viProfile = getTeamViProfile(attr);
            const localizedJob = viProfile?.jobTitle
                || (hasVietnameseText(attr.jobTitle) ? attr.jobTitle : (attr.jobTitle || 'Chuyên gia nha khoa'));
            const localizedBio = viProfile?.description || attr.description || '';

            detailImagesHTML += `
                <div class="media teams-detail__media" data-index="${i}" data-cursor-text="">
                    <div class="media__inner">
                        ${imgUrl ? cmsPictureBlock(imgUrl, attr.name || '', 800, { loading: 'lazy' }) : ''}
                    </div>
                </div>`;

            detailContentHTML += `
                <div class="teams-detail__content__item" data-index="${i}" data-cursor-text="">
                    <div class="teams-detail__next sp-base uppercase fs-xsmall">
                        <span data-link=""><span style="display:inline-block" data-label="tiếp theo">tiếp theo</span></span>
                    </div>
                    <h3 class="teams-detail__name fs-base sp-small uppercase">${escapeHtml(attr.name || '')}</h3>
                    <div class="teams-detail__data teams-detail__info sp-small ${!cvUrl ? 'no-cv' : ''}">
                        <span class="teams-detail__job fs-xsmall uppercase">${escapeHtml(localizedJob)}</span>
                        ${cvUrl ? `
                        <div class="teams-detail__download">
                            <a class="fs-xsmall uppercase" href="${escapeHtml(cvUrl)}" data-link="" target="_blank" data-cursor="">
                                <span style="display:inline-block" data-label="hồ sơ">hồ sơ</span>
                            </a>
                        </div>` : ''}
                    </div>
                    <div class="teams-detail__overflow">
                        <div class="teams-detail__description teams-detail__paragraph lh-base ff-serif fs-paragraph f" data-lenis-prevent data-observe data-split="line">
                            ${formatPlainBio(localizedBio)}
                        </div>
                    </div>
                </div>`;
        });

        /** Mounted after `#global-back-wrap` on init (parity with production #app sibling order). */
        this._overlayMarkup = `
            <div class="teams-detail">
                <div class="teams-detail__inner">
                    <button class="uppercase fs-xsmall teams-detail__close" data-link="" data-cursor="">
                        <span data-label="đóng">đóng</span>
                    </button>
                    <div class="container teams-detail__container">
                        <div class="teams-detail__images">
                            <div class="teams-detail__images__inner" id="detail-images">
                                ${detailImagesHTML}
                            </div>
                        </div>
                        <div class="teams-detail__content">
                            <div class="teams-detail__content__inner" id="detail-content">
                                ${detailContentHTML}
                            </div>
                        </div>
                    </div>
                </div>
            </div>`;

        const resources = data.resources || {};
        const rf = resources.footer || {};
        const footerTitle =
            rf.title || resources.footerTitle || 'Bạn cần tư vấn?';
        const footerTextPlain = rf.description || resources.footerDescription || '';
        const ctaLabel = rf.cta || 'liên hệ';
        const rawCta = rf.ctaLink || '';
        const footerCtaHref =
            !rawCta || rawCta === '#' ? '#/contatti'
            : /^#/.test(rawCta) ? rawCta
                : '#/contatti';
        const footerDataRoute =
            (/^#\/([^/#'?]+)/.exec(String(footerCtaHref || '')) || [])[1] || 'contatti';

        const phone = resources.phoneNumber || resources.phone || '';
        const cell = resources.emergencyPhoneNumber || resources.cell || '';
        const address = resources.address || '';
        let addressLink =
            resources.addressLink ||
            (address ? `https://maps.google.com/?q=${encodeURIComponent(address)}` : '#');
        if (!address.trim()) addressLink = '#';

        const nextSectionLabelRaw =
            typeof resources.nextSection === 'string' && resources.nextSection.trim()
                ? resources.nextSection.trim()
                : 'mục tiếp theo';

        const phoneLabel = typeof resources.phone === 'string' ? resources.phone.trim() : '';
        const cellLabel = typeof resources.emergencyPhone === 'string' ? resources.emergencyPhone.trim() : '';
        const phoneDisp = phone.trim()
            ? (phoneLabel ? `${phoneLabel} . ${phone}` : phone)
            : '';
        const cellDisp = cell.trim()
            ? (cellLabel ? `${cellLabel} . ${cell}` : cell)
            : '';

        // Next section hero = Servizi *page* (menu 03), not first service item
        const serviziHeader = data.pages?.servizi?.data?.attributes?.header;
        const nextImgUrl = getImgUrl(serviziHeader || {});
        const nextVideo = serviziHeader?.video ? String(serviziHeader.video) : '';

        return `
            <!-- HERO (no data-observe on section — production observes split nodes only, avoids double reveal) -->
            <section class="page__hero">
                <div class="container sp-medium small">
                    <div class="hero">
                        <div class="hero__content position-relative">
                            <div class="hero__counter">
                                <span class="ff-serif slide-in is-slide-pending">02</span>
                                <span class="ff-serif slide-in is-slide-pending">04</span>
                            </div>
                            <h2 class="hero__paragraph ta-c fs-xsmall uppercase lh-base is-split-pending" data-split="line" data-observe data-observe-once>
                                ${escapeHtml(header.abstract || 'Đội ngũ chuyên môn vững vàng, luôn cập nhật kiến thức')}
                            </h2>
                        </div>
                        <h1 class="hero__title sp-small fs-large ff-light uppercase is-split-pending" data-split="line" data-observe data-observe-once>
                            ${escapeHtml(header.title || 'Đội ngũ')}
                        </h1>
                        <div class="hero__picture">
                            <div class="media position-relative wc-t has-video">
                                <div class="media__inner wc-t has-video">
                                    ${header.video ? `<video autoplay preload="auto" playsinline loop muted class="media__video"><source src="${header.video}" type="video/mp4"></video>` : ''}
                            ${getImgUrl(header) ? cmsPictureBlock(getImgUrl(header), 'Đội ngũ', 1920, { loading: 'eager', fetchpriority: 'high', dataParallax: true }) : ''}
                                </div>
                            </div>
                        </div>
                        <div class="hero__video" aria-hidden="true"></div>
                    </div>
                </div>
            </section>

            <!-- DESCRIPTION -->
            <section class="description page__description sp-small">
                <div class="container description__container small">
                    <span class="ta-c fs-xsmall sp-base uppercase lh-base" data-split="line" data-observe data-observe-once>
                        ${escapeHtml(description.title || 'PHÒNG KHÁM CỦA CHÚNG TÔI VẬN HÀNH THEO Y HỌC CHỨNG CỨ')}
                    </span>
                    <div data-observe data-observe-once class="description__inner ta-c ff-serif fs-base lh-base">
                        <p data-split="line" data-observe data-observe-once>${escapeHtml(description.text || '')}</p>
                    </div>
                </div>
            </section>

            <!-- WHEEL SECTION -->
            <section class="sp-medium">
                <div class="wheel-section wc-t position-relative">
                    <div class="wheel-shell" data-observe data-observe-once>
                        <div class="wheel" id="team-wheel" data-cursor>
                            ${wheelCardsHTML}
                        </div>
                    </div>
                </div>
                <div class="wheel-navigation">
                    <button type="button" class="wheel-navigation--left" data-cursor id="wheel-prev" aria-label="Thành viên trước">
                        <div>${WHEEL_NAV_SVG_LEFT}</div>
                        <div class="wheel-navigation-ghost">${WHEEL_NAV_SVG_LEFT}</div>
                    </button>
                    <button type="button" class="wheel-navigation--right" data-cursor id="wheel-next" aria-label="Thành viên tiếp theo">
                        <div>${WHEEL_NAV_SVG_RIGHT}</div>
                        <div class="wheel-navigation-ghost">${WHEEL_NAV_SVG_RIGHT}</div>
                    </button>
                </div>
            </section>

            <!-- CONTENT CARDS -->
            <section class="page__cards sp-large">
                ${contentCardsHTML}
            </section>

            <!-- FOOTER (production: footer > section.description.sp-medium + div.footer__container) -->
            <footer class="footer sp-xlarge">
                <section class="description sp-medium">
                    <div class="container description__container small">
                        <span data-split="line" data-observe data-observe-once class="ta-c fs-xsmall sp-base uppercase lh-base">
                            ${escapeHtml(footerTitle)}
                        </span>
                        <div data-observe data-observe-once class="description__inner ta-c ff-serif fs-base lh-base">
                            <p data-split="line" data-observe data-observe-once>${escapeHtml(footerTextPlain || '')}</p>
                        </div>
                    </div>
                </section>
                <div class="container footer__container small">
                    <a href="${escapeHtml(footerCtaHref)}" data-cursor data-route="${escapeHtml(footerDataRoute)}">
                        <button type="button" class="button fs-small sp-large" data-cursor="">
                            <div class="button__inner">
                                <span data-label="${escapeHtml(ctaLabel)}" class="button__label">${escapeHtml(ctaLabel)}</span>
                            </div>
                        </button>
                    </a>
                    <div class="footer__data">
                        ${address.trim() ? `<a href="${escapeHtml(addressLink)}" target="_blank" rel="noreferrer" class="lh-base fs-xsmall uppercase" data-link="" data-cursor>
                            <span data-label="${escapeHtml(address)}">${escapeHtml(address)}</span>
                        </a>` : ''}
                        ${phone.trim() ? `<a href="tel:${String(phone).replace(/\s/g, '')}" class="lh-base fs-xsmall uppercase" data-link="" data-cursor>
                            <span data-label="${escapeHtml(phoneDisp)}">${escapeHtml(phoneDisp)}</span>
                        </a>` : ''}
                        ${cell.trim() ? `<a href="tel:${String(cell).replace(/\s/g, '')}" class="lh-base fs-xsmall uppercase" data-link="" data-cursor>
                            <span data-label="${escapeHtml(cellDisp)}">${escapeHtml(cellDisp)}</span>
                        </a>` : ''}
                    </div>
                </div>
            </footer>

            <!-- NEXT SECTION (Nuxt: video + picture under next-section__media__item) -->
            <section class="next-section">
                <a href="#/servizi" data-cursor data-cursor-text="tiếp theo" data-route="servizi">
                    <div class="container next-section__container small">
                        <div class="next-section__data sp-base">
                            <span class="ff-serif slide-in">02</span>
                            <span class="fs-xsmall uppercase ta-c">${escapeHtml(nextSectionLabelRaw)}</span>
                            <span class="ff-serif slide-in">04</span>
                        </div>
                        <div class="next-section__media">
                            <h3 class="next-section__media__title fs-large c-alt ff-light uppercase">
                                <span class="next-section__media__label">Dịch vụ</span>
                                <span class="next-section__media__label">Dịch vụ</span>
                            </h3>
                            <div class="next-section__media__picture">
                                <div data-parallax-offset="10" class="media position-relative wc-t next-section__media__item has-video">
                                    <div data-parallax="true" class="media__inner wc-t has-video">
                                        ${nextVideo ? `<video autoplay preload="auto" playsinline loop muted class="media__video"><source src="${escapeHtml(nextVideo)}" type="video/mp4"></video>` : ''}
                                        ${nextImgUrl ? cmsCardPictureBlock(nextImgUrl, 'Dịch vụ') : ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </section>
        `;
    }

    /**
     * Run after the page enter transition finishes (see PageManager.navigateTo).
     * Keep timing close to production: post-enter hooks only.
     */
    afterPageReveal() {
        this.initHeroAnimation();
        // Hero text should reveal immediately with route enter (avoid observer-delay lag).
        this.initSplitText('.page__hero');
        window.requestAnimationFrame(() => {
            document.querySelectorAll('.page__hero .is-split-pending').forEach((el) => {
                el.classList.add('is-inview');
                el.classList.remove('is-split-pending');
            });
        });
        if (this._observerInitTimer) {
            window.clearTimeout(this._observerInitTimer);
        }
        // Production router plugin binds [data-observe] IntersectionObserver ~200ms after route enter.
        this._observerInitTimer = window.setTimeout(() => {
            this.initObserver();
        }, 200);
        if (this._deferredInitTimer) {
            window.clearTimeout(this._deferredInitTimer);
        }
        // Defer heavy setup until the route-enter animation is already visible.
        this._deferredInitTimer = window.setTimeout(() => {
            this.initWheel();
            this.initDetailOverlay();
            this.initSplitText('#page-container > main');
            this.initSplitText('.teams-detail');
            this.initNextSection();
            // Only spin up ScrollTrigger work when needed (parallax/back button).
            const hasParallax = !!document.querySelector('[data-parallax="true"]');
            const canUseScrollTrigger = typeof ScrollTrigger !== 'undefined';
            if (canUseScrollTrigger && hasParallax) {
                this.initParallax();
            }
            // Back button uses ScrollTrigger; skip when plugin missing.
            if (canUseScrollTrigger) {
                this.initBackButton();
            }
            if (canUseScrollTrigger && (hasParallax || document.getElementById('global-back'))) {
                ScrollTrigger.refresh();
            }
        }, 80);
    }

    // ══════════════════════════════════════════════════
    // INIT — called after DOM is ready
    // ══════════════════════════════════════════════════
    init() {
        // Register GSAP plugins
        if (typeof gsap !== 'undefined') {
            const plugins = [];
            if (typeof ScrollTrigger !== 'undefined') plugins.push(ScrollTrigger);
            if (typeof Draggable !== 'undefined') plugins.push(Draggable);
            if (typeof InertiaPlugin !== 'undefined') plugins.push(InertiaPlugin);
            if (typeof Flip !== 'undefined') plugins.push(Flip);
            if (plugins.length) gsap.registerPlugin(...plugins);
        }

        if (this._overlayMarkup) {
            const tpl = document.createElement('template');
            tpl.innerHTML = this._overlayMarkup.trim();
            const overlayNode = tpl.content.firstElementChild;
            const backWrap = document.getElementById('global-back-wrap');
            const app = document.getElementById('app');
            if (backWrap) {
                backWrap.insertAdjacentElement('afterend', overlayNode);
            } else if (app) {
                app.appendChild(overlayNode);
            }
            this._mountedOverlayRoot = overlayNode;
            this._overlayMarkup = '';
        }

        // Heavy interactions are deferred to afterPageReveal for smoother route transitions.
    }

    // ══════════════════════════════════════════════════
    // WHEEL CAROUSEL — Production-accurate (§9 decompile)
    // Polar coordinates + GSAP Draggable + InertiaPlugin
    // ══════════════════════════════════════════════════
    initWheel() {
        const wheel = document.getElementById('team-wheel');
        if (!wheel) return;

        let cards = Array.from(wheel.querySelectorAll('.wheel__card'));
        const numOriginal = cards.length;
        if (numOriginal === 0) return;

        // Desktop: clone each card once (N → 2N) so the wheel loops smoothly (~22 → 44 in production).
        if (window.innerWidth >= 960) {
            cards.forEach(card => {
                const clone = card.cloneNode(true);
                clone.setAttribute('data-clone', 'true');
                wheel.appendChild(clone);
            });
            cards = Array.from(wheel.querySelectorAll('.wheel__card'));
        }

        const numCards = cards.length;
        const rotationSnap = 360 / numCards;
        let endRotation = 0;
        let isMoving = false;
        let direction = 0;
        const cardMedia = [];

        // Place cards in circle using polar coordinates
        const setCardRotation = () => {
            const r = wheel.offsetWidth / 2;
            const cx = r, cy = r;
            const angleStep = (2 * Math.PI) / numCards;

            cards.forEach((card, i) => {
                const angle = i * angleStep;
                const x = cx + r * Math.sin(angle);
                const y = cy - r * Math.cos(angle);
                gsap.set(card, {
                    rotation: `${angle}_rad`,
                    xPercent: -50,
                    yPercent: -50,
                    x,
                    y
                });
            });
        };

        // Map wheel rotation to card index
        const setCurrentIndex = () => {
            const rot = gsap.getProperty(wheel, "rotation");
            const raw = gsap.utils.mapRange(0, -360, 0, numCards, rot);
            this.currentIndex = gsap.utils.wrap(0, numCards, Math.round(raw));
        };

        const activateCard = () => {
            cards[this.currentIndex]?.classList.add('is-active');
        };
        const deactivateCurrentCard = () => {
            cards[this.currentIndex]?.classList.remove('is-active');
        };
        const deactivateAllCards = () => {
            cards.forEach(c => c.classList.remove('is-active'));
        };

        const snap = (rot) => Math.round(rot / rotationSnap) * rotationSnap;

        // Parallax effect on card images based on drag velocity
        const updateParallax = (velocity) => {
            cardMedia.forEach(m => {
                if (!m) return;
                gsap.to(m, {
                    duration: 1,
                    ease: "expo.out",
                    x: gsap.utils.mapRange(-400, 400, -100, 100, velocity)
                });
            });
        };

        const animateWheel = (targetRotation) => {
            deactivateCurrentCard();
            gsap.to(wheel, {
                duration: 0.75,
                rotation: targetRotation,
                ease: "expo.inOut",
                onComplete: () => {
                    isMoving = false;
                    setCurrentIndex();
                    activateCard();
                }
            });
        };

        const next = () => {
            if (isMoving) return;
            isMoving = true;
            if (direction !== 1) {
                direction = 1;
                endRotation = snap(gsap.getProperty(wheel, "rotation") + rotationSnap);
            } else {
                endRotation += rotationSnap;
            }
            animateWheel(endRotation);
        };

        const prev = () => {
            if (isMoving) return;
            isMoving = true;
            if (direction !== -1) {
                direction = -1;
                endRotation = snap(gsap.getProperty(wheel, "rotation") - rotationSnap);
            } else {
                endRotation -= rotationSnap;
            }
            animateWheel(endRotation);
        };

        // ── Init card positions ──
        setCardRotation();

        // ── Collect card media for parallax ──
        cards.forEach((card, i) => {
            cardMedia[i] = card.querySelector(".media__inner");
        });
        cardMedia.forEach(m => {
            if (!m) return;
            m.style.willChange = "transform";
            gsap.set(m, { scale: 1.2 });
        });

        activateCard();

        // ── Draggable + InertiaPlugin ──
        if (typeof Draggable !== 'undefined') {
            const snapAngle = 360 / numCards;
            this._draggable = Draggable.create(wheel, {
                type: "rotation",
                allowEventDefault: true,
                allowNativeTouchScrolling: true,
                inertia: typeof InertiaPlugin !== 'undefined',
                snap: t => Math.round(t / snapAngle) * snapAngle,
                onDrag: () => {
                    if (typeof InertiaPlugin !== 'undefined' && this._draggable?.[0]) {
                        updateParallax(InertiaPlugin.getVelocity(this._draggable[0].target, "rotation"));
                    }
                },
                onThrowUpdate: () => {
                    if (typeof InertiaPlugin !== 'undefined' && this._draggable?.[0]) {
                        updateParallax(InertiaPlugin.getVelocity(this._draggable[0].target, "rotation"));
                    }
                },
                onPress: () => {
                    direction = 0;
                    deactivateCurrentCard();
                    wheel.classList.add("is-dragging");
                },
                onMove: () => {
                    isMoving = true;
                },
                onRelease: () => {
                    wheel.classList.remove("is-dragging");
                    if (!isMoving) {
                        setCurrentIndex();
                        deactivateAllCards();
                        activateCard();
                    }
                    gsap.to(cardMedia.filter(Boolean), {
                        scale: 1.2, duration: 1, ease: "expo.out", force3D: true
                    });
                },
                onThrowComplete: () => {
                    setCurrentIndex();
                    deactivateAllCards();
                    activateCard();
                    isMoving = false;
                }
            });
        }

        // ── Navigation buttons ──
        document.getElementById('wheel-prev')?.addEventListener('click', () => prev());
        document.getElementById('wheel-next')?.addEventListener('click', () => next());

        // ── Card click: open detail if active, else rotate to card ──
        cards.forEach((card, i) => {
            card.addEventListener('click', (e) => {
                // Only handle click if not dragging
                if (isMoving) return;
                
                // Map cloned index back to original team member index
                const memberIndex = i % numOriginal;
                
                if (i === this.currentIndex) {
                    this.openDetail(memberIndex);
                } else {
                    // Calculate shortest rotation path
                    const currentRot = gsap.getProperty(wheel, "rotation");
                    const targetRot = -(i * rotationSnap);
                    const diff = targetRot - currentRot;
                    const normalizedDiff = ((diff % 360) + 540) % 360 - 180;
                    endRotation = currentRot + normalizedDiff;
                    direction = 0;
                    isMoving = true;
                    animateWheel(endRotation);
                }
            });
        });

        // ── Debounced resize ──
        this._resizeHandler = debounce(() => setCardRotation(), 200);
        window.addEventListener('resize', this._resizeHandler);
    }

    // ══════════════════════════════════════════════════
    // DETAIL OVERLAY
    // ══════════════════════════════════════════════════
    initDetailOverlay() {
        const overlay = document.querySelector('.teams-detail');
        const closeBtn = overlay?.querySelector('.teams-detail__close');

        closeBtn?.addEventListener('click', () => this.closeDetail());
        this._detailSlider?.destroy();
        this._detailSlider = overlay ? new TeamDetailSlider(overlay) : null;
        this._detailSlider?.init();
    }

    openDetail(index) {
        this.isDetailOpen = true;
        document.getElementById('app')?.classList.add('is-team-open');
        this._detailSlider?.navigateTo(index);
        if (window.lenis) window.lenis.stop();
    }

    closeDetail() {
        this.isDetailOpen = false;
        document.getElementById('app')?.classList.remove('is-team-open');
        if (window.lenis) window.lenis.start();
    }

    // ══════════════════════════════════════════════════
    // INTERSECTION OBSERVER — data-observe system
    // ══════════════════════════════════════════════════
    initObserver() {
        if (this.observer) {
            this.observer.disconnect();
            this.observer = null;
        }
        // Production behavior: toggle .is-inview while intersecting, keep it only when data-observe-once is set.
        this.observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const target = entry.target;
                const observeOnce = target.hasAttribute('data-observe-once');
                if (entry.isIntersecting) {
                    target.classList.add('is-inview');
                    if (observeOnce) {
                        this.observer.unobserve(target);
                    }
                } else if (!observeOnce) {
                    target.classList.remove('is-inview');
                }
            });
        }, {
            rootMargin: '0px 0px -20px',
            threshold: 0,
        });

        document.querySelectorAll('[data-observe]').forEach(el => {
            this.observer.observe(el);
        });
    }

    // ══════════════════════════════════════════════════
    // SPLIT TEXT — from production module 462
    // ══════════════════════════════════════════════════
    initSplitText(scope = '#page-container > main') {
        try {
            initSplitText(scope);
        } catch (e) {
            console.warn('[TeamPage] SplitText init failed:', e.message);
        }
    }

    // ══════════════════════════════════════════════════
    // PARALLAX — data-parallax system (§8 decompile)
    // ══════════════════════════════════════════════════
    initParallax() {
        if (typeof ScrollTrigger === 'undefined') return;

        const parallaxEls = document.querySelectorAll('[data-parallax="true"]');
        parallaxEls.forEach(el => {
            const offset =
                parseFloat(el.dataset.parallaxOffset)
                || parseFloat(el.parentElement?.dataset?.parallaxOffset)
                || 15;
            gsap.set(el, { transformOrigin: "50% 50%", scale: 1.2 });
            const setY = gsap.quickSetter(el, "yPercent");

            gsap.timeline({
                scrollTrigger: {
                    trigger: el.parentNode,
                    start: "top bottom",
                    end: "bottom top",
                    scrub: true,
                    onUpdate(st) { setY(st.progress * offset); }
                }
            });
        });
    }

    // ══════════════════════════════════════════════════
    // HERO ANIMATION — page enter (§10 decompile)
    // ══════════════════════════════════════════════════
    initHeroAnimation() {
        // Do not GSAP opacity/transform on .hero__paragraph / .hero__title — clashes with [data-split] .line
        // transforms (text stays inside masks → looks “missing”) and fights the line stagger.
        // Counters use .slide-in and need .is-inview on each span (parent opacity tween is not enough).
        document.querySelectorAll('.hero__counter .slide-in').forEach((el, i) => {
            window.setTimeout(() => el.classList.add('is-inview'), 100 + i * 100);
        });

        document.querySelectorAll('.next-section__data .slide-in').forEach((el, i) => {
            window.setTimeout(() => el.classList.add('is-inview'), 250 + i * 100);
        });

        // Wheel navigation reveal
        gsap.set(".wheel-navigation", { yPercent: 150, opacity: 0 });
        gsap.to(".wheel-navigation", {
            yPercent: 0,
            opacity: 1,
            duration: 1.5,
            delay: 0.6,
            ease: "expo.out"
        });

        // Next section reveal offset
        const nextSection = document.querySelector('.next-section');
        if (nextSection) {
            gsap.set(nextSection, { y: 32 });
        }
    }

    // ══════════════════════════════════════════════════
    // NEXT SECTION FLIP TRANSITION (§10 decompile)
    // ══════════════════════════════════════════════════
    initNextSection() {
        const nextLink = document.querySelector('.next-section > a[href*="servizi"]');
        if (!nextLink) return;

        nextLink.addEventListener('click', () => {
            // Flag that the next routing event should use the custom FLIP transition
            this.isNextTransition = true;
        });
    }

    initBackButton() {
        const back = document.getElementById('global-back');
        const hero = document.querySelector('#page-container > main .page__hero');
        if (!back || !hero || typeof ScrollTrigger === 'undefined') return;

        back.classList.remove('is-visible');

        this._backTrigger?.kill();
        this._backTrigger = ScrollTrigger.create({
            trigger: hero,
            start: 'bottom top+=140',
            invalidateOnRefresh: true,
            toggleClass: { targets: '#global-back', className: 'is-visible' },
        });
    }

    leaveTransition(done) {
        if (!this.isNextTransition || typeof Flip === 'undefined') {
            // Fall back to default leave transition
            const page = document.querySelector('#page-container > main');
            if (page) {
                gsap.to(page, { opacity: 0, duration: 0.5, ease: 'expo.out', onComplete: done });
            } else {
                done();
            }
            return;
        }

        const tl = gsap.timeline();
        const portalHero = document.querySelector('.portal__hero');
        const nextMedia = document.querySelector('.next-section__media__picture .media');

        tl.addLabel("start");
        // Title flies down
        tl.to(".next-section__media__title", { yPercent: 150, duration: 0.5, ease: "power4.inOut" }, "start");
        // All sections slide up and fade
        tl.to(["section:not(.next-section)", "footer"], {
            yPercent: -50, opacity: 0, duration: 0.75, ease: "power4.inOut"
        }, "start");
        tl.to(".next-section__data span", {
            yPercent: -50, opacity: 0, stagger: 0.05, duration: 0.5, ease: "power4.inOut"
        }, "start");

        // Media element morphs into portal hero using FLIP
        tl.add(() => {
            if (nextMedia && portalHero) {
                gsap.set(nextMedia, { translateZ: 1 });
                const state = Flip.getState(nextMedia);
                portalHero.appendChild(nextMedia);
                Flip.from(state, { 
                    duration: 1.2, 
                    ease: "expo.inOut", 
                    absolute: true,
                    onComplete: () => { 
                        portalHero.classList.add("is-active"); 
                        done(); 
                    }
                });
            } else {
                done();
            }
        }, "-=0.25");
    }

    // ══════════════════════════════════════════════════
    // DESTROY — cleanup
    // ══════════════════════════════════════════════════
    destroy() {
        document.getElementById('app')?.classList.remove('is-team-open');

        this._mountedOverlayRoot?.remove();
        this._mountedOverlayRoot = null;

        document.getElementById('global-back')?.classList.remove('is-visible');
        this._backTrigger?.kill();
        this._backTrigger = null;

        if (this.observer) {
            this.observer.disconnect();
            this.observer = null;
        }

        if (this._observerInitTimer) {
            window.clearTimeout(this._observerInitTimer);
            this._observerInitTimer = null;
        }
        if (this._deferredInitTimer) {
            window.clearTimeout(this._deferredInitTimer);
            this._deferredInitTimer = null;
        }

        if (this._draggable?.[0]) {
            this._draggable[0].kill();
            this._draggable = null;
        }

        this._detailSlider?.destroy();
        this._detailSlider = null;

        if (this._resizeHandler) {
            window.removeEventListener('resize', this._resizeHandler);
            this._resizeHandler = null;
        }

        if (typeof ScrollTrigger !== 'undefined') {
            ScrollTrigger.getAll().forEach((st) => st.kill());
        }
    }
}
