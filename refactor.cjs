const fs = require('fs');
const path = require('path');

const srcDir = path.join(__dirname, 'resources', 'views', 'Pengunjung');
const destDir = path.join(__dirname, 'resources', 'views', 'pages', 'pengunjung');

if (!fs.existsSync(destDir)) {
    fs.mkdirSync(destDir, { recursive: true });
}

const files = fs.readdirSync(srcDir).filter(f => f.endsWith('.php'));

files.forEach(file => {
    const filePath = path.join(srcDir, file);
    let content = fs.readFileSync(filePath, 'utf8');

    // Extract title
    let title = 'Eventiket';
    const titleMatch = content.match(/<title>(.*?)<\/title>/i);
    if (titleMatch) {
        title = titleMatch[1];
    }

    // Extract body class
    let bodyClass = '';
    const bodyMatch = content.match(/<body[^>]*class=["']([^"']*)["'][^>]*>/i);
    if (bodyMatch) {
        bodyClass = bodyMatch[1];
    }

    // Extract styles inside <head>
    let styles = '';
    const styleMatch = content.match(/<style>([\s\S]*?)<\/style>/i);
    if (styleMatch) {
        styles = styleMatch[0];
    }

    // Identify the content between Navbar and ending tags.
    // The navbar usually ends at </div></div></div> or </header> and the content starts.
    // A more reliable way: find everything inside <body>, remove Navbar, remove scripts, then we have content.
    const bodyContentMatch = content.match(/<body[^>]*>([\s\S]*?)<\/body>/i);
    let bodyContent = '';
    if (bodyContentMatch) {
        bodyContent = bodyContentMatch[1];
    }

    // Remove Navbar (heuristic: find <div class="sticky... atau <header class="sticky...)
    // and remove it up to the end of its div/header.
    // Since it's hard to parse HTML with regex perfectly, let's remove the common navbar block.
    // We'll look for <!-- NAVBAR --> and the next major element like <!-- CONTENT -->, <!-- KONTEN HALAMAN -->, <!-- HERO SECTION -->
    let mainContent = bodyContent;
    mainContent = mainContent.replace(/<!-- NAVBAR -->[\s\S]*?(?=<!-- CONTENT -->|<!-- KONTEN HALAMAN -->|<!-- HERO SECTION -->|<!-- KONTEN -->|<div class="flex-grow|<main>|<div class="relative z-10)/i, '');
    
    // Sometimes it might not have the comment. If so, let's just use regex to remove sticky top-0
    mainContent = mainContent.replace(/<div class="sticky top-0 z-50[^>]*>[\s\S]*?<\/div>\s*<\/div>\s*<\/div>/i, '');
    mainContent = mainContent.replace(/<header class="sticky top-0 z-50[^>]*>[\s\S]*?<\/header>/i, '');

    // Extract scripts
    let scripts = '';
    const scriptRegex = /<script(?! src)[^>]*>([\s\S]*?)<\/script>/gi;
    let match;
    while ((match = scriptRegex.exec(mainContent)) !== null) {
        // Exclude tailwind config
        if (!match[1].includes('tailwind.config')) {
            scripts += match[0] + '\n';
        }
    }
    
    // Remove scripts from main content
    mainContent = mainContent.replace(/<script(?! src)[^>]*>[\s\S]*?<\/script>/gi, '');
    
    // Construct new file content
    let newContent = `@extends('layouts.pengunjung')\n\n`;
    newContent += `@section('title', '${title}')\n\n`;
    if (bodyClass) {
        newContent += `@section('body_class', '${bodyClass}')\n\n`;
    }
    
    if (styles && !styles.includes("body { font-family: 'Poppins', sans-serif; }") || (styles.length > 50)) {
        // only add if it's not the generic one
        newContent += `@push('styles')\n${styles}\n@endpush\n\n`;
    }

    newContent += `@section('content')\n${mainContent.trim()}\n@endsection\n\n`;

    if (scripts.trim()) {
        newContent += `@push('scripts')\n${scripts.trim()}\n@endpush\n`;
    }

    const destPath = path.join(destDir, file);
    fs.writeFileSync(destPath, newContent, 'utf8');
    console.log(`Refactored ${file}`);
});
