<?php
// footer.php
?>
<footer class="bg-gray-900 py-5 text-center text-gray-300">
    <div class="max-w-6xl mx-auto flex flex-col items-center justify-center">
        <div class="mb-2 text-center">
            <p class="mt-1 text-sm">hey@disasterprep.org</p>
            <div class="mt-1 flex justify-center space-x-1">
                <a href="https://twitter.com" target="_blank" aria-label="Twitter">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-2.717 0-4.92 2.203-4.92 4.917 0 .386.045.762.127 1.124C7.691 8.094 4.066 6.13 1.64 3.161c-.427.732-.666 1.585-.666 2.475 0 1.71.87 3.213 2.188 4.096-.807-.026-1.566-.248-2.228-.616v.062c0 2.385 1.693 4.374 3.946 4.827-.413.112-.849.171-1.296.171-.314 0-.615-.03-.916-.086.631 1.953 2.445 3.377 4.604 3.417-1.68 1.319-3.809 2.105-6.102 2.105-.396 0-.788-.023-1.175-.068 2.187 1.405 4.788 2.224 7.582 2.224 9.055 0 14.012-7.503 14.012-14.012 0-.213-.005-.426-.014-.637.962-.695 1.797-1.562 2.457-2.549z"/>
                    </svg>
                </a>
                <a href="https://facebook.com" target="_blank" aria-label="Facebook">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.477 2 2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.879V14.89h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.989C18.343 21.129 22 16.991 22 12c0-5.523-4.477-10-10-10z"/>
                    </svg>
                </a>
            </div>
        </div>
        <div class="text-center">
            <p class="text-sm">© <?php echo date('Y'); ?> DisasterPrep. All rights reserved</p>
            <p class="mt-1 text-sm">
                <a href="/DisasterPrep/includes/privacypolicy.php" onclick="console.log('Privacy Policy clicked');" class="text-green-400 hover:underline">Privacy Policy</a> | 
                <a href="/DisasterPrep/includes/tndc.php" onclick="console.log('Terms clicked');" class="text-green-400 hover:underline">Terms of Service</a> | 
                <a href="/DisasterPrep/includes/cookie.php" onclick="console.log('Cookie Policy clicked');" class="text-green-400 hover:underline">Cookie Policy</a>
            </p>
        </div>
    </div>
</footer>

<style>
    footer {
        background-color: rgba(17, 24, 39, 0.95);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        margin-top: auto;
        padding: 1rem;
        color: #d1d5db;
        min-height: 80px;
    }
    footer a { color: #10b981; text-decoration: none; position: relative; z-index: 10; }
    footer a:hover { color: #059669; }
    @media (max-width: 640px) { footer { padding: 0.5rem; } footer p { font-size: 0.7rem; } footer svg { width: 12px; height: 12px; } }
</style>