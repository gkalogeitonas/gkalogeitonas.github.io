// Theme toggle. The initial theme is applied inline in the layout <head> to avoid a flash.
document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const dark = document.documentElement.classList.toggle('dark');
        localStorage.setItem('theme', dark ? 'dark' : 'light');
    });
});

// Email links carry the address reversed so it never appears verbatim in the HTML.
document.querySelectorAll('[data-email]').forEach((link) => {
    link.href = `mailto:${[...link.dataset.email].reverse().join('')}`;
});
