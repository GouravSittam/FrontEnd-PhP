<?php
session_start();
require_once 'config/database.php';

// Fetch featured products
$stmt = $pdo->query("SELECT p.*, c.name as category_name 
                     FROM products p 
                     LEFT JOIN categories c ON p.category_id = c.id 
                     WHERE p.is_featured = 1 
                     LIMIT 8");
$featured_products = $stmt->fetchAll();

// Fetch all categories
$stmt = $pdo->query("SELECT * FROM categories");
$categories = $stmt->fetchAll();

// Fetch latest products
$stmt = $pdo->query("SELECT p.*, c.name as category_name 
                     FROM products p 
                     LEFT JOIN categories c ON p.category_id = c.id 
                     ORDER BY p.created_at DESC LIMIT 4");
$latest_products = $stmt->fetchAll();

// Fetch sale products
$stmt = $pdo->query("SELECT p.*, c.name as category_name 
                     FROM products p 
                     LEFT JOIN categories c ON p.category_id = c.id 
                     WHERE p.sale_price IS NOT NULL 
                     LIMIT 4");
$sale_products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to QuickCart</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script>
        // Check for saved dark mode preference
        if (localStorage.getItem('darkMode') === 'true' || 
            (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.remove('light');
            document.documentElement.classList.add('dark');
        }
    </script>
    <style>
        .dark body { background-color: #1a1a1a; color: #ffffff; }
        .dark .bg-white { background-color: #2d2d2d; }
        .dark .text-gray-700 { color: #e5e5e5; }
        .dark .bg-gray-50 { background-color: #1a1a1a; }
        .dark .shadow-lg { box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5); }
        .dark .text-gray-600 { color: #d1d1d1; }
        .dark .text-gray-500 { color: #a3a3a3; }
        .dark .text-gray-400 { color: #737373; }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-50 transition-colors duration-200">
    <?php include 'templates/header.php'; ?>

    <main class="flex-grow">
        <!-- Hero Section with Slider -->
        <div class="relative bg-indigo-600 text-white py-32">
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 to-purple-600"></div>
            <div class="relative max-w-7xl mx-auto px-4">
                <h1 class="text-6xl font-bold mb-6 animate-fade-in">Welcome to RudraShop</h1>
                <p class="text-2xl mb-8 max-w-2xl">Discover amazing products at great prices. Shop the latest trends in fashion, electronics, and more.</p>
                <div class="flex gap-4">
                    <a href="/Rudra/ecommerce/products.php" 
                       class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition transform hover:scale-105">
                        Shop Now
                    </a>
                    <a href="/Rudra/ecommerce/categories.php" 
                       class="border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-indigo-600 transition transform hover:scale-105">
                        Browse Categories
                    </a>
                </div>
            </div>
        </div>

        <!-- Categories Section with Grid -->
        <section class="max-w-7xl mx-auto px-4 py-20">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-4xl font-bold">Shop by Category</h2>
                <a href="/Rudra/ecommerce/categories.php" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    View All Categories <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <?php foreach ($categories as $category): ?>
                    <a href="/Rudra/ecommerce/products.php?category=<?php echo $category['id']; ?>" 
                       class="group relative overflow-hidden rounded-xl shadow-lg hover:shadow-2xl transition duration-300">
                        <img src="<?php echo $category['image_url']; ?>" 
                             alt="<?php echo $category['name']; ?>" 
                             class="w-full h-64 object-cover group-hover:scale-110 transition duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex items-end">
                            <div class="p-6 w-full">
                                <h3 class="text-white text-2xl font-bold mb-2">
                                    <?php echo $category['name']; ?>
                                </h3>
                                <p class="text-gray-200 text-sm opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <?php echo $category['description']; ?>
                                </p>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Featured Products Section -->
        <section class="bg-white py-20">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-4xl font-bold mb-12 text-center">Featured Products</h2>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <?php foreach ($featured_products as $product): ?>
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-2xl transition duration-300">
                            <div class="relative">
                                <img src="<?php echo $product['image_url']; ?>" 
                                     alt="<?php echo $product['name']; ?>" 
                                     class="w-full h-64 object-cover group-hover:scale-105 transition duration-500">
                                <?php if ($product['sale_price']): ?>
                                    <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                        Sale!
                                    </div>
                                <?php endif; ?>
                                <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                    <button onclick="addToCart(<?php echo $product['id']; ?>)" 
                                            class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                                        Add to Cart
                                    </button>
                                </div>
                            </div>
                            <div class="p-6">
                                <p class="text-sm text-indigo-600 font-semibold mb-2"><?php echo $product['category_name']; ?></p>
                                <h3 class="text-xl font-bold mb-2"><?php echo $product['name']; ?></h3>
                                <div class="flex items-center justify-between">
                                    <?php if ($product['sale_price']): ?>
                                        <div class="flex items-center gap-2">
                                            <span class="text-2xl font-bold text-indigo-600">
                                                $<?php echo number_format($product['sale_price'], 2); ?>
                                            </span>
                                            <span class="text-sm text-gray-400 line-through">
                                                $<?php echo number_format($product['price'], 2); ?>
                                            </span>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-2xl font-bold text-indigo-600">
                                            $<?php echo number_format($product['price'], 2); ?>
                                        </span>
                                    <?php endif; ?>
                                    <span class="text-sm text-gray-500">
                                        <?php echo $product['stock']; ?> in stock
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Latest Products Section -->
        <section class="max-w-7xl mx-auto px-4 py-20">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-4xl font-bold">Latest Arrivals</h2>
                <a href="/Rudra/ecommerce/products.php?sort=newest" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                    View All <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <?php foreach ($latest_products as $product): ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden group hover:shadow-2xl transition duration-300">
                        <div class="relative">
                            <img src="<?php echo $product['image_url']; ?>" 
                                 alt="<?php echo $product['name']; ?>" 
                                 class="w-full h-64 object-cover group-hover:scale-105 transition duration-500">
                            <?php if ($product['sale_price']): ?>
                                <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    Sale!
                                </div>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <button onclick="addToCart(<?php echo $product['id']; ?>)" 
                                        class="bg-white text-indigo-600 px-6 py-3 rounded-lg font-semibold transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                        <div class="p-6">
                            <p class="text-sm text-indigo-600 font-semibold mb-2"><?php echo $product['category_name']; ?></p>
                            <h3 class="text-xl font-bold mb-2"><?php echo $product['name']; ?></h3>
                            <div class="flex items-center justify-between">
                                <?php if ($product['sale_price']): ?>
                                    <div class="flex items-center gap-2">
                                        <span class="text-2xl font-bold text-indigo-600">
                                            $<?php echo number_format($product['sale_price'], 2); ?>
                                        </span>
                                        <span class="text-sm text-gray-400 line-through">
                                            $<?php echo number_format($product['price'], 2); ?>
                                        </span>
                                    </div>
                                <?php else: ?>
                                    <span class="text-2xl font-bold text-indigo-600">
                                        $<?php echo number_format($product['price'], 2); ?>
                                    </span>
                                <?php endif; ?>
                                <span class="text-sm text-gray-500">
                                    <?php echo $product['stock']; ?> in stock
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>

        <!-- Newsletter Section -->
        <section class="bg-indigo-600 py-20">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h2 class="text-4xl font-bold text-white mb-4">Stay Updated</h2>
                <p class="text-xl text-white/80 mb-8">Subscribe to our newsletter for the latest updates and exclusive offers.</p>
                <form class="max-w-xl mx-auto flex gap-4">
                    <input type="email" placeholder="Enter your email" 
                           class="flex-1 px-6 py-4 rounded-lg focus:outline-none focus:ring-2 focus:ring-white">
                    <button type="submit" 
                            class="bg-white text-indigo-600 px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Subscribe
                    </button>
                </form>
            </div>
        </section>
    </main>

    <?php include 'templates/footer.php'; ?>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="/Rudra/ecommerce/assets/js/cart.js"></script>
    <script src="/Rudra/ecommerce/assets/js/darkMode.js"></script>
</body>
</html>