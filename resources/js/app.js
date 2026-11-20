// Theme toggle. The initial theme is applied inline in the layout <head> to avoid a flash.
document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const dark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', dark ? 'dark' : 'light');
    });
});

// The address is reversed in the markup so it never appears verbatim in the HTML.
const email = document.querySelector('[data-email]')?.dataset.email.split('').reverse().join('');

if (email) {
    document.querySelectorAll('[data-email]').forEach((link) => (link.href = `mailto:${email}`));
    document.querySelectorAll('[data-email-text]').forEach((el) => {
        el.innerHTML = '';
        const link = Object.assign(document.createElement('a'), { href: `mailto:${email}`, textContent: email });
        el.append(link);
    });
}

// Paper is always light and shows every collapsed section. Exposed for the PDF generator.
let restore = () => {};

window.preparePrint = () => {
    const wasDark = document.documentElement.classList.contains('dark');
    const closed = [...document.querySelectorAll('details:not([open])')];
    document.documentElement.classList.remove('dark');
    closed.forEach((details) => (details.open = true));

    restore = () => {
        document.documentElement.classList.toggle('dark', wasDark);
        closed.forEach((details) => (details.open = false));
    };
};

window.addEventListener('beforeprint', () => window.preparePrint());
window.addEventListener('afterprint', () => restore());
