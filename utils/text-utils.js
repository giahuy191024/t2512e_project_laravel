/**
 * Text Split Animation System
 * From production decompile: module 462 (team/studiobrusco_team_decompile.md §7)
 *
 * data-split="line" → .line-mask > .line per *visual* line (SplitText lines),
 * not per-word wrappers (those break line-height and stagger vs production).
 */

/**
 * @param {HTMLElement} el  Clone source for typography / box model
 * @param {string} plainText
 * @param {number} widthPx  Layout width (capture before clearing el.innerHTML)
 * @returns {string[]} One string per rendered line at that width
 */
function measureVisualLineStrings(el, plainText, widthPx) {
    const words = plainText.replace(/\s+/g, ' ').trim().split(' ').filter(Boolean);
    if (!words.length) return [];

    const width = widthPx >= 8 ? widthPx : el.offsetWidth || el.getBoundingClientRect().width;
    if (width < 8) {
        return [words.join(' ')];
    }

    const host = el.cloneNode(false);
    host.className = el.className;
    host.removeAttribute('id');
    ['data-split', 'data-observe', 'data-observe-once'].forEach((a) =>
        host.removeAttribute(a));
    host.setAttribute('aria-hidden', 'true');

    const cs = getComputedStyle(el);

    host.style.cssText =
        `position:absolute;left:-99999px;top:0;visibility:hidden;pointer-events:none;opacity:0;` +
        `width:${width}px;box-sizing:${cs.boxSizing};` +
        `font-family:${cs.fontFamily};font-size:${cs.fontSize};font-weight:${cs.fontWeight};` +
        `font-style:${cs.fontStyle};line-height:${cs.lineHeight};letter-spacing:${cs.letterSpacing};` +
        `text-transform:${cs.textTransform};text-align:${cs.textAlign};` +
        `padding:${cs.padding};margin:0;background:transparent;`;

    (el.parentElement || document.body).appendChild(host);

    const spans = words.map((w, i) => {
        const s = document.createElement('span');
        s.textContent = w + (i < words.length - 1 ? ' ' : '');
        s.style.display = 'inline';
        host.appendChild(s);
        return s;
    });

    let lastTop = null;
    const groups = [];
    spans.forEach((span) => {
        const top = span.offsetTop;
        if (lastTop === null || Math.abs(top - lastTop) > 1) {
            groups.push([]);
            lastTop = top;
        }
        groups[groups.length - 1].push(span);
    });

    const lines = groups.map((g) =>
        g.map((s) => s.textContent).join('').replace(/\s+/g, ' ').trim());

    host.remove();
    return lines;
}


export function initSplitText(scope) {
    const wordEls = gsap.utils.toArray(`${scope || ''} [data-split="word"]`);
    const lineEls = gsap.utils.toArray(`${scope || ''} [data-split="line"]`);

    // --- CASE 1: GSAP SplitText is available (PRO) ---
    // Matches team/_nuxt/9c5a40e.js module 462 (see studiobrusco_team_decompile.md §7).
    if (typeof SplitText !== 'undefined') {
        wordEls.forEach((el) => {
            if (el.dataset.splitReady === '1') return;
            new SplitText(el, { type: 'words', wordsClass: 'word-mask ' });
            const split = new SplitText(el, { type: 'words', wordsClass: 'word' });
            split.words.forEach((word, i) => {
                word.style.setProperty('--index', String(i));
            });
            el.dataset.splitReady = '1';
        });

        lineEls.forEach((el) => {
            if (el.dataset.splitReady === '1') return;
            const split = new SplitText(el, { type: 'lines', linesClass: 'line' });
            new SplitText(el, { type: 'lines', linesClass: 'line-mask' });
            split.lines.forEach((line, i) => {
                line.style.setProperty('--index', String(i));
            });
            el.dataset.splitReady = '1';
        });
        return;
    }

    // --- CASE 2: Fallback (Manual splitting) ---
    console.log('[text-utils] SplitText not found, using manual fallback');

    wordEls.forEach((el) => {
        if (el.dataset.splitReady === '1') return;
        const text = el.textContent.trim();
        const words = text.split(/\s+/).filter(Boolean);
        el.innerHTML = '';
        words.forEach((word, i) => {
            const mask = document.createElement('span');
            mask.className = 'word-mask';
            mask.style.display = 'inline-block';
            mask.style.overflow = 'hidden';
            mask.style.verticalAlign = 'top';

            const inner = document.createElement('span');
            inner.className = 'word';
            inner.textContent = word + (i < words.length - 1 ? '\u00A0' : '');
            inner.style.display = 'inline-block';
            inner.style.setProperty('--index', i);

            mask.appendChild(inner);
            el.appendChild(mask);
        });
        el.dataset.splitReady = '1';
    });

    lineEls.forEach((el) => {
        if (el.dataset.splitReady === '1') return;
        const raw = el.textContent.replace(/\r\n/g, '\n').trim();
        if (!raw) {
            el.innerHTML = '';
            el.dataset.splitReady = '1';
            return;
        }

        /* offsetWidth = layout width; getBoundingClientRect shrinks during parent scale enter transition */
        const layoutWidth = el.offsetWidth || el.getBoundingClientRect().width;

        const segments = raw.split('\n').map((s) => s.trim()).filter(Boolean);
        const toMeasure = segments.length ? segments : [raw.replace(/\s+/g, ' ').trim()];

        el.innerHTML = '';
        let lineIndex = 0;
        toMeasure.forEach((segment) => {
            const visualLines = measureVisualLineStrings(el, segment, layoutWidth);
            visualLines.forEach((lineText) => {
                const lineMask = document.createElement('span');
                lineMask.className = 'line-mask';

                const line = document.createElement('span');
                line.className = 'line';
                line.style.setProperty('--index', lineIndex);
                line.textContent = lineText;

                lineMask.appendChild(line);
                el.appendChild(lineMask);
                lineIndex += 1;
            });
        });
        el.dataset.splitReady = '1';
    });
}

/**
 * Debounce utility
 */
export function debounce(fn, delay = 200) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => fn(...args), delay);
    };
}
