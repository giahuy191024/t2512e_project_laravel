/**
 * Minimal CMS/markdown-lite → HTML for Strapi text fields (trusted editorial content).
 * Supports: paragraphs (double newline), [label](url), ![alt](/uploads/...).
 */

const DEFAULT_CMS = 'https://www.studiobrusco.com/cms';

export function escapeHtml(raw) {
    if (raw == null || typeof raw !== 'string') return '';
    return raw
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

export function sanitizeUrl(url, cmsBase = DEFAULT_CMS) {
    const u = String(url).trim();
    if (!u) return '';
    if (/^tel:/i.test(u)) {
        const digits = u.replace(/^tel:/i, '').replace(/\s+/g, '');
        return digits ? `tel:${digits}` : '';
    }
    if (/^mailto:/i.test(u)) {
        try {
            return encodeURI(u);
        } catch {
            return '';
        }
    }
    if (/^https?:\/\//i.test(u)) return u;
    if (u.startsWith('//')) return `https:${u}`;
    if (u.startsWith('/uploads/')) return `${cmsBase}${u}`;
    if (u.startsWith('/') && u.length > 1) return `${cmsBase}${u}`;
    return '';
}

/**
 * Markdown-style inline fragments → safe HTML pieces.
 */
function inlineMarkdownToHtml(str, cmsBase) {
    let remaining = String(str || '');
    const out = [];

    while (remaining.length > 0) {
        const img = remaining.match(/^!\[([^\]]*)\]\(([^)]*)\)/);
        if (img) {
            const href = sanitizeUrl(img[2], cmsBase);
            if (href) out.push(`<img src="${escapeHtml(href)}" alt="${escapeHtml(img[1])}" loading="lazy">`);
            remaining = remaining.slice(img[0].length);
            continue;
        }

        const link = remaining.match(/^\[([^\]]+)\]\(([^)]*)\)/);
        if (link) {
            const href = sanitizeUrl(link[2], cmsBase);
            if (href) {
                const isExternal = /^https?:\/\//i.test(href) || href.startsWith('//');
                const rel = isExternal ? 'noopener noreferrer' : '';
                const target = isExternal ? ' target="_blank"' : '';
                out.push(`<a href="${escapeHtml(href)}"${rel ? ` rel="${rel}"` : ''}${target}>${escapeHtml(link[1])}</a>`);
            } else out.push(escapeHtml(link[0]));
            remaining = remaining.slice(link[0].length);
            continue;
        }

        const nextSpecial = remaining.search(/!\[/);
        const linkBrack = remaining.indexOf('[', nextSpecial === 0 ? 1 : 0);
        let cutoff = remaining.length;
        if (nextSpecial >= 0) cutoff = Math.min(cutoff, nextSpecial);
        if (linkBrack >= 0) cutoff = Math.min(cutoff, linkBrack);

        const chunk = cutoff === remaining.length ? remaining : remaining.slice(0, cutoff);
        out.push(escapeHtml(chunk));
        remaining = remaining.slice(chunk.length);
    }

    return out.join('');
}

/**
 * Plain / markdown-lite block text → paragraphs for .description__inner
 */
export function renderCmsRichText(text, cmsBase = DEFAULT_CMS) {
    if (!text || typeof text !== 'string') return '';
    const normalized = text.replace(/\r\n/g, '\n').trim();
    if (!normalized) return '';

    const blocks = normalized.split(/\n\n+/).map((b) => b.trim()).filter(Boolean);
    if (blocks.length === 0) return '';

    return blocks.map((block) => `<p>${inlineMarkdownToHtml(block, cmsBase)}</p>`).join('');
}

/**
 * Bio / long plain text → HTML with preserved line breaks (member detail overlay).
 */
export function formatPlainBio(text) {
    if (!text || typeof text !== 'string') return '';
    return escapeHtml(text).replace(/\n/g, '<br>\n');
}
