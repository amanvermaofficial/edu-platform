import React from 'react';

function Footer() {
  return (
    <footer className="bg-gray-100 py-6 ">
      <div className="max-w-6xl mx-auto px-4 flex flex-col sm:flex-row justify-between items-center text-gray-600 text-sm">
        {/* Left: Copyright */}
        <div className="mb-4 sm:mb-0">
          © {new Date().getFullYear()} EduPlatform. All rights reserved.
        </div>

        {/* Right: Footer Links */}
        <div className="flex space-x-4">
          <a href="/about" className="hover:text-blue-600 transition">About</a>
          <a
            href="https://www.youtube.com/@Itipapers"
            target="_blank"
            rel="noopener noreferrer"
            className="hover:text-blue-600 transition"
          >
            YouTube
          </a>
          <a
            href="https://t.me/Itipapers"
            target="_blank"
            rel="noopener noreferrer"
            className="hover:text-blue-600 transition"
          >
            Telegram
          </a>
        </div>
      </div>
    </footer>
  );
}

export default Footer;
