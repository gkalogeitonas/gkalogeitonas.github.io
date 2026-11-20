// Renders every page listed in dist/sitemap.xml to dist/cv-<lang>.pdf with headless Chromium.
// Requests to the site URL are answered from dist/, so this works before anything is deployed.
//
//   node scripts/pdf.mjs            (after `composer export`)
//   SITE_URL=https://example.test node scripts/pdf.mjs
import { chromium } from 'playwright';
import { readFile } from 'node:fs/promises';
import path from 'node:path';

const dist = path.resolve('dist');
const site = new URL(process.env.SITE_URL ?? 'https://gkalogeitonas.github.io');

const types = {
    '.html': 'text/html; charset=utf-8',
    '.css': 'text/css',
    '.js': 'text/javascript',
    '.json': 'application/json',
    '.xml': 'application/xml',
    '.svg': 'image/svg+xml',
    '.png': 'image/png',
    '.jpg': 'image/jpeg',
    '.jpeg': 'image/jpeg',
    '.woff2': 'font/woff2',
    '.woff': 'font/woff',
};

const sitemap = await readFile(path.join(dist, 'sitemap.xml'), 'utf8');
const pages = [...sitemap.matchAll(/<loc>([^<]+)<\/loc>/g)].map((match) => match[1]);

if (pages.length === 0) {
    throw new Error('No pages found in dist/sitemap.xml');
}

const problems = [];
const browser = await chromium.launch();
const context = await browser.newContext({ colorScheme: 'light' });

await context.route('**/*', async (route) => {
    const url = new URL(route.request().url());

    if (url.origin !== site.origin) {
        problems.push(`blocked external request: ${url}`);
        return route.abort();
    }

    let file = path.join(dist, decodeURIComponent(url.pathname));
    if (url.pathname.endsWith('/')) file = path.join(file, 'index.html');

    try {
        if (!file.startsWith(dist + path.sep)) throw new Error('outside dist');
        const body = await readFile(file);
        return route.fulfill({ body, contentType: types[path.extname(file)] ?? 'application/octet-stream' });
    } catch {
        problems.push(`missing in dist: ${url.pathname}`);
        return route.fulfill({ status: 404 });
    }
});

for (const url of pages) {
    if (new URL(url).origin !== site.origin) {
        throw new Error(`Sitemap URL ${url} is not under ${site.origin}; export with the same SITE_URL.`);
    }

    const page = await context.newPage();
    page.on('pageerror', (error) => problems.push(`${url}: ${error.message}`));

    await page.goto(url, { waitUntil: 'networkidle' });
    await page.evaluate(async () => {
        await document.fonts.ready;
        window.preparePrint();
    });

    const lang = await page.getAttribute('html', 'lang');
    const out = path.join(dist, `cv-${lang}.pdf`);
    await page.pdf({ path: out, printBackground: true, preferCSSPageSize: true });
    console.log(`✓ ${url} → ${path.relative(process.cwd(), out)}`);
    await page.close();
}

await browser.close();

if (problems.length > 0) {
    console.error(problems.map((problem) => `✗ ${problem}`).join('\n'));
    process.exit(1);
}
