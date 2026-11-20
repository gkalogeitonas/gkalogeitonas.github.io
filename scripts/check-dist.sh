#!/usr/bin/env bash
# Sanity checks on the exported site before it is published.
set -euo pipefail
cd "$(dirname "$0")/../dist"

fail() { echo "✗ $*" >&2; exit 1; }

for file in index.html el/index.html sitemap.xml robots.txt favicon.svg images/og.png images/profile.jpeg cv-en.pdf cv-el.pdf; do
    [[ -e "$file" ]] || fail "missing dist/$file"
done

# Local-only tooling and URLs must never ship.
if grep -rlE 'browser-logs|_boost|ddev\.site|localhost|_og-image' --include='*.html' --include='*.xml' --include='*.js' . ; then
    fail "dev-only references found in the files above"
fi
find . -name '*.php' | grep -q . && fail "PHP files in dist"

grep -q 'gkalog2@gmail.com' index.html el/index.html && fail "plain email address in HTML"

echo "✓ dist looks good ($(find . -type f | wc -l) files)"
