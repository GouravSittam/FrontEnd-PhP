<nav class="bg-white dark:bg-gray-800 shadow-lg fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="fas fa-bars text-gray-600 dark:text-gray-200 text-xl"></i>
                </button>
                <a href="/Rudra/ecommerce/index.php" class="text-2xl font-bold text-indigo-600 dark:text-white hover:text-indigo-800 dark:hover:text-indigo-400 transition duration-300 ml-2 md:ml-0">
                    QuickCart
                </a>
            </div>

            <!-- Navigation Links - Desktop -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="/Rudra/ecommerce/index.php" class="nav-link dark:text-gray-200">Home</a>
                <a href="/Rudra/ecommerce/products.php" class="nav-link dark:text-gray-200">Products</a>
                <a href="/Rudra/ecommerce/cart.php" class="nav-link dark:text-gray-200 flex items-center">
                    <span>Cart</span>
                    <span id="cart-count" class="ml-2 bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">0</span>
                </a>

                <!-- Theme Toggle -->
                <button onclick="toggleTheme()" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-300">
                    <i id="themeIcon" class="fas fa-moon text-gray-600 dark:text-gray-200 text-xl"></i>
                </button>

                <!-- Auth Links -->
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/Rudra/ecommerce/account.php" class="nav-link dark:text-gray-200">Account</a>
                    <a href="/Rudra/ecommerce/auth/logout.php" class="auth-button">Logout</a>
                <?php else: ?>
                    <a href="/Rudra/ecommerce/auth/login.php" class="nav-link dark:text-gray-200">Login</a>
                    <a href="/Rudra/ecommerce/auth/register.php" class="auth-button">Register</a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="md:hidden hidden">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/Rudra/ecommerce/index.php" class="mobile-nav-link block py-2">Home</a>
                <a href="/Rudra/ecommerce/products.php" class="mobile-nav-link block py-2">Products</a>
                <a href="/Rudra/ecommerce/cart.php" class="mobile-nav-link block py-2 flex items-center justify-between">
                    <span>Cart</span>
                    <span id="mobile-cart-count" class="bg-indigo-600 text-white text-xs px-2 py-1 rounded-full">0</span>
                </a>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <a href="/Rudra/ecommerce/account.php" class="mobile-nav-link block py-2">Account</a>
                    <a href="/Rudra/ecommerce/auth/logout.php" class="mobile-auth-button mt-2">Logout</a>
                <?php else: ?>
                    <a href="/Rudra/ecommerce/auth/login.php" class="mobile-nav-link block py-2">Login</a>
                    <a href="/Rudra/ecommerce/auth/register.php" class="mobile-auth-button mt-2">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<!-- Add margin to main content to prevent header overlap -->
<div class="h-16"></div>

<style>
.nav-link {
    @apply text-gray-600 hover:text-indigo-600 dark:text-gray-200 dark:hover:text-white font-medium transition duration-300;
}

.auth-button {
    @apply bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition duration-300 font-medium;
}

.mobile-nav-link {
    @apply text-gray-600 dark:text-gray-200 hover:text-indigo-600 dark:hover:text-white font-medium transition duration-300 px-2;
}

.mobile-auth-button {
    @apply bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition duration-300 font-medium text-center block;
}
</style>

<script>
// Mobile menu toggle
document.getElementById('mobile-menu-button').addEventListener('click', function() {
    document.getElementById('mobile-menu').classList.toggle('hidden');
});

// Close mobile menu when clicking outside
document.addEventListener('click', function(event) {
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    
    if (!mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
        mobileMenu.classList.add('hidden');
    }
});

// Update both desktop and mobile cart counts
function updateCartCount(count) {
    document.getElementById('cart-count').textContent = count;
    document.getElementById('mobile-cart-count').textContent = count;
}
</script>

<script src="/Rudra/ecommerce/assets/js/theme.js"></script>
<script src="/Rudra/ecommerce/assets/js/cart.js"></script>