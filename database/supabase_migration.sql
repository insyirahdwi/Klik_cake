-- ==========================================================
-- Supabase (PostgreSQL) Migration & Seed Script for Klik.Cake
-- Generated automatically
-- ==========================================================

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;

-- Table: users
CREATE TABLE IF NOT EXISTS users (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    role VARCHAR(50) DEFAULT 'customer' NOT NULL,
    phone VARCHAR(50) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: password_reset_tokens
CREATE TABLE IF NOT EXISTS password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL
);

-- Table: sessions
CREATE TABLE IF NOT EXISTS sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INT NOT NULL
);
CREATE INDEX IF NOT EXISTS sessions_user_id_index ON sessions (user_id);
CREATE INDEX IF NOT EXISTS sessions_last_activity_index ON sessions (last_activity);

-- Table: cache
CREATE TABLE IF NOT EXISTS cache (
    key VARCHAR(255) PRIMARY KEY,
    value TEXT NOT NULL,
    expiration INT NOT NULL
);

-- Table: cache_locks
CREATE TABLE IF NOT EXISTS cache_locks (
    key VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
);

-- Table: jobs
CREATE TABLE IF NOT EXISTS jobs (
    id BIGSERIAL PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload TEXT NOT NULL,
    attempts SMALLINT NOT NULL,
    reserved_at INT NULL,
    available_at INT NOT NULL,
    created_at INT NOT NULL
);
CREATE INDEX IF NOT EXISTS jobs_queue_index ON jobs (queue);

-- Table: job_batches
CREATE TABLE IF NOT EXISTS job_batches (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids TEXT NOT NULL,
    options TEXT NULL,
    cancelled_at INT NULL,
    created_at INT NOT NULL,
    finished_at INT NULL
);

-- Table: failed_jobs
CREATE TABLE IF NOT EXISTS failed_jobs (
    id BIGSERIAL PRIMARY KEY,
    uuid VARCHAR(255) UNIQUE NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload TEXT NOT NULL,
    exception TEXT NOT NULL,
    failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL
);

-- Table: collections
CREATE TABLE IF NOT EXISTS collections (
    id BIGSERIAL PRIMARY KEY,
    parent_id BIGINT NULL REFERENCES collections(id) ON DELETE SET NULL,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    image_url VARCHAR(255) NULL,
    sort_order INT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
CREATE INDEX IF NOT EXISTS collections_parent_id_index ON collections (parent_id);

-- Table: products
CREATE TABLE IF NOT EXISTS products (
    id BIGSERIAL PRIMARY KEY,
    collection_id BIGINT NOT NULL REFERENCES collections(id) ON DELETE CASCADE,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    portion_info VARCHAR(255) NULL,
    ingredients TEXT NULL,
    allergens VARCHAR(255) NULL,
    shelf_life VARCHAR(255) NULL,
    lead_time_days INT DEFAULT 1 NOT NULL,
    availability_type VARCHAR(50) DEFAULT 'preorder' NOT NULL,
    is_featured BOOLEAN DEFAULT FALSE NOT NULL,
    is_fresh_bake BOOLEAN DEFAULT TRUE NOT NULL,
    rating NUMERIC(3, 2) DEFAULT 5.00 NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
CREATE INDEX IF NOT EXISTS products_collection_id_index ON products (collection_id);
CREATE INDEX IF NOT EXISTS products_is_fresh_bake_index ON products (is_fresh_bake);
CREATE INDEX IF NOT EXISTS products_is_featured_index ON products (is_featured);
CREATE INDEX IF NOT EXISTS products_availability_type_index ON products (availability_type);

-- Table: variants
CREATE TABLE IF NOT EXISTS variants (
    id BIGSERIAL PRIMARY KEY,
    product_id BIGINT NOT NULL REFERENCES products(id) ON DELETE CASCADE,
    name VARCHAR(255) NOT NULL,
    sku VARCHAR(255) NOT NULL,
    price INT NOT NULL,
    stock INT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
CREATE INDEX IF NOT EXISTS variants_product_id_index ON variants (product_id);

-- Table: slot_quotas
CREATE TABLE IF NOT EXISTS slot_quotas (
    id BIGSERIAL PRIMARY KEY,
    date DATE NOT NULL,
    time_slot VARCHAR(50) NOT NULL,
    max_orders INT DEFAULT 10 NOT NULL,
    booked_orders INT DEFAULT 0 NOT NULL,
    is_active BOOLEAN DEFAULT TRUE NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    CONSTRAINT slot_quotas_date_time_slot_unique UNIQUE (date, time_slot)
);

-- Table: delivery_zones
CREATE TABLE IF NOT EXISTS delivery_zones (
    id BIGSERIAL PRIMARY KEY,
    kecamatan VARCHAR(255) NOT NULL,
    delivery_fee INT NOT NULL,
    is_active BOOLEAN DEFAULT TRUE NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: promo_codes
CREATE TABLE IF NOT EXISTS promo_codes (
    id BIGSERIAL PRIMARY KEY,
    code VARCHAR(100) UNIQUE NOT NULL,
    type VARCHAR(50) NOT NULL,
    value INT NOT NULL,
    min_order_amount INT DEFAULT 0 NOT NULL,
    max_discount_amount INT NULL,
    usage_limit INT NULL,
    used_count INT DEFAULT 0 NOT NULL,
    starts_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: orders
CREATE TABLE IF NOT EXISTS orders (
    id BIGSERIAL PRIMARY KEY,
    order_number VARCHAR(100) UNIQUE NOT NULL,
    user_id BIGINT NULL REFERENCES users(id) ON DELETE SET NULL,
    customer_name VARCHAR(255) NOT NULL,
    customer_phone VARCHAR(50) NOT NULL,
    customer_email VARCHAR(255) NULL,
    fulfillment_type VARCHAR(50) NOT NULL,
    delivery_date DATE NOT NULL,
    delivery_time_slot VARCHAR(50) NOT NULL,
    delivery_address TEXT NULL,
    delivery_kecamatan VARCHAR(255) NULL,
    delivery_notes TEXT NULL,
    subtotal INT NOT NULL,
    delivery_fee INT DEFAULT 0 NOT NULL,
    discount_amount INT DEFAULT 0 NOT NULL,
    promo_code VARCHAR(100) NULL,
    total_amount INT NOT NULL,
    status VARCHAR(50) DEFAULT 'pending' NOT NULL,
    cake_writing VARCHAR(255) NULL,
    greeting_card_text TEXT NULL,
    general_notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
CREATE INDEX IF NOT EXISTS orders_order_number_index ON orders (order_number);
CREATE INDEX IF NOT EXISTS orders_user_id_index ON orders (user_id);
CREATE INDEX IF NOT EXISTS orders_status_index ON orders (status);
CREATE INDEX IF NOT EXISTS orders_delivery_date_index ON orders (delivery_date);

-- Table: order_items
CREATE TABLE IF NOT EXISTS order_items (
    id BIGSERIAL PRIMARY KEY,
    order_id BIGINT NOT NULL REFERENCES orders(id) ON DELETE CASCADE,
    product_id BIGINT NOT NULL REFERENCES products(id),
    variant_id BIGINT NULL REFERENCES variants(id),
    product_name VARCHAR(255) NOT NULL,
    variant_name VARCHAR(255) NULL,
    price INT NOT NULL,
    quantity INT NOT NULL,
    subtotal INT NOT NULL,
    notes TEXT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
CREATE INDEX IF NOT EXISTS order_items_order_id_index ON order_items (order_id);

-- Table: payments
CREATE TABLE IF NOT EXISTS payments (
    id BIGSERIAL PRIMARY KEY,
    order_id BIGINT NOT NULL REFERENCES orders(id) ON DELETE CASCADE,
    payment_method VARCHAR(50) NOT NULL,
    status VARCHAR(50) DEFAULT 'pending' NOT NULL,
    amount INT NOT NULL,
    external_id VARCHAR(255) NULL,
    payment_url TEXT NULL,
    payload JSONB NULL,
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
CREATE INDEX IF NOT EXISTS payments_order_id_index ON payments (order_id);
CREATE INDEX IF NOT EXISTS payments_external_id_index ON payments (external_id);

-- Table: order_status_logs
CREATE TABLE IF NOT EXISTS order_status_logs (
    id BIGSERIAL PRIMARY KEY,
    order_id BIGINT NOT NULL REFERENCES orders(id) ON DELETE CASCADE,
    from_status VARCHAR(50) NULL,
    to_status VARCHAR(50) NOT NULL,
    notes VARCHAR(255) NULL,
    changed_by VARCHAR(255) NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
CREATE INDEX IF NOT EXISTS order_status_logs_order_id_index ON order_status_logs (order_id);

-- Table: article_categories
CREATE TABLE IF NOT EXISTS article_categories (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NULL,
    is_active BOOLEAN DEFAULT TRUE NOT NULL,
    sort_order INT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: articles
CREATE TABLE IF NOT EXISTS articles (
    id BIGSERIAL PRIMARY KEY,
    category_id BIGINT NULL REFERENCES article_categories(id) ON DELETE SET NULL,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    excerpt TEXT NULL,
    content TEXT NOT NULL,
    featured_image VARCHAR(255) NULL,
    author_name VARCHAR(255) DEFAULT 'Dapur Pinky Cake' NOT NULL,
    is_published BOOLEAN DEFAULT TRUE NOT NULL,
    published_at TIMESTAMP NULL,
    view_count INT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: pages
CREATE TABLE IF NOT EXISTS pages (
    id BIGSERIAL PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    content TEXT NOT NULL,
    meta_description TEXT NULL,
    is_published BOOLEAN DEFAULT TRUE NOT NULL,
    show_in_header BOOLEAN DEFAULT FALSE NOT NULL,
    show_in_footer BOOLEAN DEFAULT TRUE NOT NULL,
    sort_order INT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: hero_sections
CREATE TABLE IF NOT EXISTS hero_sections (
    id BIGSERIAL PRIMARY KEY,
    badge_text VARCHAR(255) DEFAULT 'Fresh Bake hari ini' NOT NULL,
    title VARCHAR(255) DEFAULT 'Klik, dipanggang, sampai.' NOT NULL,
    subtitle TEXT NULL,
    button_text VARCHAR(255) DEFAULT 'Pesan Sekarang' NOT NULL,
    button_link VARCHAR(255) DEFAULT '/katalog' NOT NULL,
    secondary_button_text VARCHAR(255) DEFAULT 'Lihat Menu' NULL,
    secondary_button_link VARCHAR(255) DEFAULT '#kategori' NULL,
    image_url VARCHAR(255) NULL,
    featured_product_id BIGINT NULL REFERENCES products(id) ON DELETE SET NULL,
    is_active BOOLEAN DEFAULT TRUE NOT NULL,
    sort_order INT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: web_settings
CREATE TABLE IF NOT EXISTS web_settings (
    id BIGSERIAL PRIMARY KEY,
    key VARCHAR(255) UNIQUE NOT NULL,
    value TEXT NULL,
    "group" VARCHAR(100) DEFAULT 'general' NOT NULL,
    label VARCHAR(255) NULL,
    type VARCHAR(50) DEFAULT 'text' NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- Table: networkings
CREATE TABLE IF NOT EXISTS networkings (
    id BIGSERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    type VARCHAR(50) DEFAULT 'social_media' NOT NULL,
    platform VARCHAR(100) NULL,
    url VARCHAR(255) NULL,
    address TEXT NULL,
    phone VARCHAR(50) NULL,
    icon VARCHAR(100) NULL,
    is_active BOOLEAN DEFAULT TRUE NOT NULL,
    sort_order INT DEFAULT 0 NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);

-- ==========================================================
-- SEED DATA
-- ==========================================================

-- Data for: collections (13 rows)
INSERT INTO "collections" (id, parent_id, name, slug, description, image_url, sort_order, created_at, updated_at) VALUES (1, NULL, 'Roti', 'roti', 'Pilihan roti hangat, lembut, dan harum dipanggang setiap hari.', NULL, 1, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "collections" (id, parent_id, name, slug, description, image_url, sort_order, created_at, updated_at) VALUES (2, 1, 'Roti Manis', 'roti-manis', 'Roti manis dengan aneka isian lembut dan lezat.', NULL, 1, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "collections" (id, parent_id, name, slug, description, image_url, sort_order, created_at, updated_at) VALUES (3, 1, 'Roti Tawar & Gurih', 'roti-tawar-gurih', 'Roti tawar bergizi dan roti gurih dengan topping lezat.', NULL, 2, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "collections" (id, parent_id, name, slug, description, image_url, sort_order, created_at, updated_at) VALUES (4, NULL, 'Cake', 'cake', 'Kue tart lembut untuk momen spesial dan perayaan istimewa.', NULL, 2, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "collections" (id, parent_id, name, slug, description, image_url, sort_order, created_at, updated_at) VALUES (5, 4, 'Whole Cake', 'whole-cake', 'Kue utuh aneka ukuran untuk ulang tahun dan pesta.', NULL, 1, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "collections" (id, parent_id, name, slug, description, image_url, sort_order, created_at, updated_at) VALUES (6, 4, 'Slice / Cup Cake', 'slice-cup-cake', 'Potongan cake satuan atau cup cake cantik nikmat.', NULL, 2, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "collections" (id, parent_id, name, slug, description, image_url, sort_order, created_at, updated_at) VALUES (7, 4, 'Custom & Ulang Tahun', 'custom-ulang-tahun', 'Pesanan kue custom tema khusus dengan lead time H-3.', NULL, 3, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "collections" (id, parent_id, name, slug, description, image_url, sort_order, created_at, updated_at) VALUES (8, NULL, 'Pastry', 'pastry', 'Pastry renyah berlapis dengan mentega premium pilihan.', NULL, 3, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "collections" (id, parent_id, name, slug, description, image_url, sort_order, created_at, updated_at) VALUES (9, 8, 'Croissant & Danish', 'croissant-danish', 'Croissant renyah berlapis danish harum mentega.', NULL, 1, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "collections" (id, parent_id, name, slug, description, image_url, sort_order, created_at, updated_at) VALUES (10, 8, 'Cookies & Pie', 'cookies-pie', 'Kue kering renyah dan pie lezat aneka isian manis.', NULL, 2, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "collections" (id, parent_id, name, slug, description, image_url, sort_order, created_at, updated_at) VALUES (11, NULL, 'Snackbox', 'snackbox', 'Paket hantaran dan snackbox lengkap untuk segala macam kegiatan.', NULL, 4, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "collections" (id, parent_id, name, slug, description, image_url, sort_order, created_at, updated_at) VALUES (12, 11, 'Paket Acara', 'paket-acara', 'Snackbox lengkap untuk arisan, tasyakuran, dan reuni.', NULL, 1, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "collections" (id, parent_id, name, slug, description, image_url, sort_order, created_at, updated_at) VALUES (13, 11, 'Paket Kantor', 'paket-kantor', 'Snackbox praktis dan elegan untuk rapat dan seminar kantor.', NULL, 2, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
SELECT setval(pg_get_serial_sequence('collections', 'id'), COALESCE((SELECT MAX(id) + 1 FROM "collections"), 1), false);

-- Data for: products (13 rows)
INSERT INTO "products" (id, collection_id, name, slug, description, portion_info, ingredients, allergens, shelf_life, lead_time_days, availability_type, is_featured, is_fresh_bake, rating, created_at, updated_at) VALUES (1, 5, 'Strawberry Cream Cake', 'strawberry-cream-cake', 'Sponge cake vanila lembut berpadu krim segar ringan dan buah stroberi manis segar pilihan khas Pinky Cake.', 'Porsi 6–8 orang (16 cm) / 10–12 orang (20 cm)', 'Tepung terigu protein rendah, gula kastor, telur ayam segar, mentega wisman, ekstrak vanila murni, whipped cream nabati, buah stroberi segar.', 'susu, telur, gluten', 'Simpan 2 hari di kulkas', 1, 'preorder', 1, 1, 4.9, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "products" (id, collection_id, name, slug, description, portion_info, ingredients, allergens, shelf_life, lead_time_days, availability_type, is_featured, is_fresh_bake, rating, created_at, updated_at) VALUES (2, 5, '[CONTOH] Double Chocolate Fudge Cake', 'contoh-double-chocolate-fudge-cake', 'Kue cokelat pekat berlapis ganache dark chocolate Belgia premium dengan lelehan lembut di lidah.', 'Porsi 6–8 orang', 'Dark chocolate 70%, cocoa butter, tepung gandum, telur, mentega, susu segar.', 'susu, telur, gluten', 'Simpan 3 hari di kulkas', 1, 'preorder', 1, 1, 4.8, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "products" (id, collection_id, name, slug, description, portion_info, ingredients, allergens, shelf_life, lead_time_days, availability_type, is_featured, is_fresh_bake, rating, created_at, updated_at) VALUES (3, 5, '[CONTOH] Basque Burnt Cheesecake', 'contoh-basque-burnt-cheesecake', 'Cheesecake panggang khas Basque dengan permukaan karamel gelap yang harum dan bagian tengah yang lembut lumer.', 'Porsi 6–8 orang', 'Cream cheese Australia, heavy cream, gula, telur, tepung maizena.', 'susu, telur', 'Simpan 4 hari di kulkas', 1, 'preorder', 1, 1, 4.9, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "products" (id, collection_id, name, slug, description, portion_info, ingredients, allergens, shelf_life, lead_time_days, availability_type, is_featured, is_fresh_bake, rating, created_at, updated_at) VALUES (4, 7, '[CONTOH] Custom Birthday Cake Tema Floral Pastel', 'contoh-custom-birthday-cake-floral', 'Kue ulang tahun dekorasi custom bunga buttercream pastel elegan dengan ucapan nama khusus.', 'Porsi 10–12 orang', 'Sponge cake vanilla / cokelat, swiss meringue buttercream, edible flower.', 'susu, telur, gluten', 'Simpan 2 hari di suhu sejuk', 3, 'preorder', 0, 0, 5, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "products" (id, collection_id, name, slug, description, portion_info, ingredients, allergens, shelf_life, lead_time_days, availability_type, is_featured, is_fresh_bake, rating, created_at, updated_at) VALUES (5, 6, '[CONTOH] Red Velvet Slice Cake', 'contoh-red-velvet-slice-cake', 'Satu potong red velvet lembut beraroma buttermilk dengan lapisan cream cheese frosting segar gurih.', 'Porsi 1 orang', 'Tepung terigu, cokelat bubuk, buttermilk, cream cheese frosting.', 'susu, telur, gluten', 'Simpan 2 hari di kulkas', 1, 'ready_today', 0, 1, 4.7, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "products" (id, collection_id, name, slug, description, portion_info, ingredients, allergens, shelf_life, lead_time_days, availability_type, is_featured, is_fresh_bake, rating, created_at, updated_at) VALUES (6, 2, '[CONTOH] Roti Sisir Mentega Wisman', 'contoh-roti-sisir-mentega-wisman', 'Roti sisir tradisional yang super lembut dengan polesan mentega Wisman wangi gurih dan gula halus.', 'Porsi 3–4 orang', 'Tepung terigu cakra, mentega Wisman, susu murni, gula, kuning telur.', 'susu, telur, gluten', '3 hari suhu ruang', 1, 'ready_today', 1, 1, 4.9, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "products" (id, collection_id, name, slug, description, portion_info, ingredients, allergens, shelf_life, lead_time_days, availability_type, is_featured, is_fresh_bake, rating, created_at, updated_at) VALUES (7, 2, '[CONTOH] Signature Pandan Roll Cheese', 'contoh-signature-pandan-roll-cheese', 'Bolu gulung aroma pandan daun suji asli berisi krim keju dan taburan keju cheddar melimpah.', 'Porsi 6–8 potong', 'Ekstrak pandan suji, keju cheddar parut, tepung terigu, telur, mentega.', 'susu, telur, gluten', '3 hari suhu ruang', 1, 'ready_today', 0, 1, 4.8, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "products" (id, collection_id, name, slug, description, portion_info, ingredients, allergens, shelf_life, lead_time_days, availability_type, is_featured, is_fresh_bake, rating, created_at, updated_at) VALUES (8, 3, '[CONTOH] Roti Daging Bakso Sapi Makassar', 'contoh-roti-daging-bakso-sapi', 'Roti empuk gurih dengan isian daging sapi cincang bumbu rempah khas Makassar yang manis gurih sedap.', 'Porsi 1 orang', 'Daging sapi segar cincang, bawang merah, rempah, tepung terigu, wijen sangrai.', 'gluten, wijen', '2 hari suhu ruang', 1, 'ready_today', 1, 1, 4.9, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "products" (id, collection_id, name, slug, description, portion_info, ingredients, allergens, shelf_life, lead_time_days, availability_type, is_featured, is_fresh_bake, rating, created_at, updated_at) VALUES (9, 9, '[CONTOH] Classic French Butter Croissant', 'contoh-classic-french-butter-croissant', 'Croissant berlapis renyah di luar, sarang lebah lembut di dalam dengan aroma mentega Prancis yang semerbak.', 'Porsi 1 orang', 'Mentega elle & vire, tepung gandum Prancis, ragi alami, susu cair.', 'susu, gluten', '1 hari renyah maksimal (dapat dipanaskan ulang)', 1, 'ready_today', 1, 1, 4.9, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "products" (id, collection_id, name, slug, description, portion_info, ingredients, allergens, shelf_life, lead_time_days, availability_type, is_featured, is_fresh_bake, rating, created_at, updated_at) VALUES (10, 9, '[CONTOH] Pain Au Chocolat', 'contoh-pain-au-chocolat', 'Pastry mentega berlapis renyah dengan isian dua batang cokelat dark batangan Belgia yang lumer saat dihangatkan.', 'Porsi 1 orang', 'Baton dark chocolate, mentega Prancis, tepung gandum, ragi.', 'susu, gluten, kedelai', '1–2 hari', 1, 'ready_today', 0, 1, 4.8, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "products" (id, collection_id, name, slug, description, portion_info, ingredients, allergens, shelf_life, lead_time_days, availability_type, is_featured, is_fresh_bake, rating, created_at, updated_at) VALUES (11, 10, '[CONTOH] Fudgy Brownies Bites Crust', 'contoh-fudgy-brownies-bites', 'Brownies potong gigitan sekali santap dengan lapisan atas shiny crust renyah dan bagian dalam padat lumer.', 'Isi 16 potong bite size', 'Dark chocolate, cocoa powder, telur, butter, gula tebu, sea salt.', 'susu, telur, gluten', '7 hari suhu ruang / 14 hari di kulkas', 1, 'ready_today', 0, 0, 4.9, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "products" (id, collection_id, name, slug, description, portion_info, ingredients, allergens, shelf_life, lead_time_days, availability_type, is_featured, is_fresh_bake, rating, created_at, updated_at) VALUES (12, 12, '[CONTOH] Snackbox Acara Melati', 'contoh-snackbox-acara-melati', 'Paket kotak snack ekonomis lengkap: Roti Manis Cokelat, Lemper Bakar Ayam, dan Bolu Gulung Mini plus air mineral.', 'Paket untuk 1 orang', 'Kombinasi 3 varian kue segar manis dan gurih pilihan.', 'susu, telur, gluten', 'Konsumsi di hari yang sama', 1, 'preorder', 0, 1, 4.7, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "products" (id, collection_id, name, slug, description, portion_info, ingredients, allergens, shelf_life, lead_time_days, availability_type, is_featured, is_fresh_bake, rating, created_at, updated_at) VALUES (13, 13, '[CONTOH] Snackbox Eksekutif Pertemuan Kantor', 'contoh-snackbox-eksekutif-kantor', 'Paket hantaran snack premium box elegan: Mini Croissant Butter, Pastel Ayam Spesial, Red Velvet Slice, dan jus kemasan.', 'Paket untuk 1 orang', 'Kombinasi 3 pastry & cake premium Pinky Cake.', 'susu, telur, gluten', 'Konsumsi di hari yang sama', 1, 'preorder', 1, 1, 5, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
SELECT setval(pg_get_serial_sequence('products', 'id'), COALESCE((SELECT MAX(id) + 1 FROM "products"), 1), false);

-- Data for: variants (21 rows)
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (1, 1, '16 cm', 'SCC-16CM', 185000, 20, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (2, 1, '20 cm', 'SCC-20CM', 245000, 15, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (3, 2, '16 cm', 'DCFC-16', 195000, 15, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (4, 2, '20 cm', 'DCFC-20', 260000, 10, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (5, 3, '16 cm', 'BBC-16', 175000, 20, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (6, 3, '20 cm', 'BBC-20', 235000, 12, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (7, 4, 'Diameter 18 cm', 'CUST-FLORAL-18', 350000, 5, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (8, 4, 'Diameter 22 cm', 'CUST-FLORAL-22', 475000, 5, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (9, 5, '1 Slice', 'RV-SLICE-1', 32000, 30, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (10, 5, 'Kotak Isi 4', 'RV-SLICE-4', 120000, 15, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (11, 6, '1 Loyang (8 Sisir)', 'RSM-8', 45000, 25, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (12, 7, '1 Gulung (22 cm)', 'PRC-22', 75000, 20, '2026-11-23 02:00:52', '2026-11-23 02:00:52') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (13, 8, '1 Pcs', 'RDBS-1', 18000, 40, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (14, 8, 'Paket Isi 5', 'RDBS-5', 85000, 15, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (15, 9, '1 Pcs', 'CFBC-1', 22000, 35, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (16, 9, 'Box Isi 4', 'CFBC-4', 82000, 15, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (17, 10, '1 Pcs', 'PAC-1', 25000, 30, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (18, 11, 'Box 250 gram', 'FBB-250', 65000, 25, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (19, 11, 'Box 500 gram', 'FBB-500', 120000, 15, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (20, 12, '1 Box (3 Kue + Air)', 'SNACK-MELATI-1', 24000, 100, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "variants" (id, product_id, name, sku, price, stock, created_at, updated_at) VALUES (21, 13, '1 Box Premium', 'SNACK-EKS-1', 38000, 80, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
SELECT setval(pg_get_serial_sequence('variants', 'id'), COALESCE((SELECT MAX(id) + 1 FROM "variants"), 1), false);

-- Data for: slot_quotas (42 rows)
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (1, '2026-11-23 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (2, '2026-11-23 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (3, '2026-11-23 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (4, '2026-11-24 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (5, '2026-11-24 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (6, '2026-11-24 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (7, '2026-11-25 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (8, '2026-11-25 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (9, '2026-11-25 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (10, '2026-11-26 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (11, '2026-11-26 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (12, '2026-11-26 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (13, '2026-11-27 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (14, '2026-11-27 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (15, '2026-11-27 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (16, '2026-11-28 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (17, '2026-11-28 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (18, '2026-11-28 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (19, '2026-11-29 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (20, '2026-11-29 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (21, '2026-11-29 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (22, '2026-11-30 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (23, '2026-11-30 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (24, '2026-11-30 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (25, '2026-12-01 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (26, '2026-12-01 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (27, '2026-12-01 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (28, '2026-12-02 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (29, '2026-12-02 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (30, '2026-12-02 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (31, '2026-12-03 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (32, '2026-12-03 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (33, '2026-12-03 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (34, '2026-12-04 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (35, '2026-12-04 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (36, '2026-12-04 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (37, '2026-12-05 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (38, '2026-12-05 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (39, '2026-12-05 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (40, '2026-12-06 00:00:00', '10:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (41, '2026-12-06 00:00:00', '13:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "slot_quotas" (id, date, time_slot, capacity, booked, created_at, updated_at) VALUES (42, '2026-12-06 00:00:00', '16:00', 5, 0, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
SELECT setval(pg_get_serial_sequence('slot_quotas', 'id'), COALESCE((SELECT MAX(id) + 1 FROM "slot_quotas"), 1), false);

-- Data for: delivery_zones (3 rows)
INSERT INTO "delivery_zones" (id, name, fee, estimated_delivery_time, is_active, created_at, updated_at) VALUES (1, 'Makassar Kota & Panakkukang', 15000, '30 – 45 menit', 1, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "delivery_zones" (id, name, fee, estimated_delivery_time, is_active, created_at, updated_at) VALUES (2, 'Tamalanrea & Biringkanaya', 25000, '45 – 60 menit', 1, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "delivery_zones" (id, name, fee, estimated_delivery_time, is_active, created_at, updated_at) VALUES (3, 'Somba Opu & Gowa Perbatasan', 30000, '60 – 90 menit', 1, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
SELECT setval(pg_get_serial_sequence('delivery_zones', 'id'), COALESCE((SELECT MAX(id) + 1 FROM "delivery_zones"), 1), false);

-- Data for: promo_codes (2 rows)
INSERT INTO "promo_codes" (id, code, type, value, min_order_amount, max_discount, expires_at, is_active, created_at, updated_at) VALUES (1, 'KLIKMANIS', 'percentage', 10, 100000, 25000, '2027-02-23 02:00:53', 1, '2026-11-23 02:00:53', '2026-11-23 02:00:53') ON CONFLICT DO NOTHING;
INSERT INTO "promo_codes" (id, code, type, value, min_order_amount, max_discount, expires_at, is_active, created_at, updated_at) VALUES (2, 'FRESHBAKE', 'fixed', 20000, 150000, NULL, '2027-02-23 02:00:53', 1, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
SELECT setval(pg_get_serial_sequence('promo_codes', 'id'), COALESCE((SELECT MAX(id) + 1 FROM "promo_codes"), 1), false);

-- Data for: article_categories (3 rows)
INSERT INTO "article_categories" (id, name, slug, description, is_active, sort_order, created_at, updated_at) VALUES (1, 'Tips & Panduan Kue', 'tips-dan-resep', 'Tips menyimpan kue, memilih ukuran tart, dan panduan memilih hidangan pesta.', 1, 1, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "article_categories" (id, name, slug, description, is_active, sort_order, created_at, updated_at) VALUES (2, 'Cerita Dapur Pinky', 'cerita-dapur-pinky', 'Kisah di balik layar pembuatan roti dan kue segar di dapur Makassar kami.', 1, 2, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "article_categories" (id, name, slug, description, is_active, sort_order, created_at, updated_at) VALUES (3, 'Acara & Hampers Makassar', 'acara-dan-hampers', 'Inspirasi snackbox kantor, aqiqah, arisan, hingga hampers hari raya khas Makassar.', 1, 3, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
SELECT setval(pg_get_serial_sequence('article_categories', 'id'), COALESCE((SELECT MAX(id) + 1 FROM "article_categories"), 1), false);

-- Data for: articles (2 rows)
INSERT INTO "articles" (id, category_id, title, slug, excerpt, content, featured_image, author_name, is_published, published_at, view_count, created_at, updated_at) VALUES (1, 2, 'Rahasia Kelembutan Strawberry Cream Cake Khas Pinky Cake', 'rahasia-kelembutan-strawberry-cream-cake-khas-pinky-cake', 'Mengapa bolu chiffon kami begitu lembut dan krim segarnya tidak bikin enek? Simak proses pemanggangan hari-H langsung dari dapur Panakkukang.', '<p>Setiap pagi sebelum fajar menyingsing di kota Makassar, oven dapur <strong>Pinky Cake & Bakery</strong> sudah mulai memancarkan aroma wangi mentega premium dan vanila murni. Salah satu menu paling digemari pelanggan kami sejak hari pertama adalah <em>Strawberry Cream Cake</em>.</p><h3>1. Dipanggang Sesuai Jadwal (Bake to Order)</h3><p>Kami tidak pernah membekukan atau menyimpan bolu berminggu-minggu. Setiap pesanan yang masuk melalui <strong>Klik.Cake</strong> dipanggang khusus H-1 sesuai slot waktu pengambilan atau pengiriman yang Anda pilih (pukul 10.00, 13.00, atau 16.00 WITA).</p><h3>2. Buah Strawberry Segar & Whipped Cream Lembut</h3><p>Kombinasi asam manis strawberry segar berpadu sempurna dengan krim kocok dingin yang ringan. Kue ini sangat cocok disajikan pada suhu dingin untuk menemani momen spesial ulang tahun keluarga tercinta.</p>', NULL, 'Chef Pastry Pinky Cake', 1, '2026-11-20 02:00:54', 124, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "articles" (id, category_id, title, slug, excerpt, content, featured_image, author_name, is_published, published_at, view_count, created_at, updated_at) VALUES (2, 1, 'Panduan Memilih Ukuran Cake Sesuai Jumlah Tamu Acara Anda', 'panduan-memilih-ukuran-cake-sesuai-jumlah-tamu', 'Bingung memilih ukuran kue 16cm, 20cm, atau 24cm? Simak perkiraan jumlah porsi agar acara Anda berjalan sempurna tanpa kekurangan kue.', '<p>Memilih ukuran kue tart ulang tahun atau perayaan sering kali membingungkan. Apakah diameter 16 cm sudah cukup untuk arisan keluarga, ataukah butuh ukuran 24 cm?</p><ul><li><strong>Diameter 16 cm:</strong> Cocok untuk 4–6 porsi keluarga inti atau perayaan santai berdua.</li><li><strong>Diameter 20 cm:</strong> Pilihan paling populer untuk 8–12 porsi perayaan ulang tahun anak atau kumpul kerabat.</li><li><strong>Diameter 24 cm:</strong> Ideal untuk 16–20 porsi acara kantor, perayaan wisuda, atau syukuran keluarga besar.</li></ul><p>Semua cake kami dilengkapi dengan lilin angka/batang, pisau pemotong higienis, dan kartu ucapan gratis yang dapat Anda isi langsung di website Klik.Cake.</p>', NULL, 'Tim Klik.Cake', 1, '2026-11-22 02:00:54', 88, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
SELECT setval(pg_get_serial_sequence('articles', 'id'), COALESCE((SELECT MAX(id) + 1 FROM "articles"), 1), false);

-- Data for: pages (5 rows)
INSERT INTO "pages" (id, title, slug, content, meta_description, is_published, show_in_header, show_in_footer, sort_order, created_at, updated_at) VALUES (1, 'Tentang Kami', 'tentang-kami', '<h2>Hangat Dari Dapur Makassar</h2><p><strong>Klik.Cake</strong> adalah platform pemesanan online resmi dari <strong>Pinky Cake & Bakery</strong> di Makassar. Kami hadir untuk menghadirkan pengalaman menikmati roti, cake, dan pastry segar tanpa khawatir kehabisan kuota atau kue mengendap lama di etalase toko.</p><h3>Filosofi Fresh Bake Kami</h3><p>Kami percaya kue terbaik adalah kue yang baru selesai dipanggang. Dengan sistem kuota slot harian, kami menjamin setiap kue dipanggang khusus menjelang jam pengiriman atau pengambilan yang Anda tentukan.</p>', 'Mengenal Pinky Cake & Bakery Makassar dan sistem pemesanan online Klik.Cake.', 1, 0, 1, 1, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "pages" (id, title, slug, content, meta_description, is_published, show_in_header, show_in_footer, sort_order, created_at, updated_at) VALUES (2, 'Cara Pesan', 'cara-pesan', '<h2>3 Langkah Mudah Pesan di Klik.Cake</h2><ol><li><strong>Pilih Menu & Varian:</strong> Tentukan kue favorit Anda, tentukan ukuran/rasa, dan tambahkan ucapan kartu jika untuk kado.</li><li><strong>Tentukan Tanggal & Slot:</strong> Pilih tanggal pengiriman (minimal H-1) dan slot waktu yang tersedia (10.00, 13.00, atau 16.00 WITA).</li><li><strong>Bayar & Lacak:</strong> Selesaikan pembayaran via QRIS/Transfer, dan pantau status pemanggangan kue Anda secara real-time.</li></ol>', 'Panduan mudah memesan roti dan kue di Klik.Cake Makassar.', 1, 1, 1, 2, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "pages" (id, title, slug, content, meta_description, is_published, show_in_header, show_in_footer, sort_order, created_at, updated_at) VALUES (3, 'Kebijakan Privasi', 'kebijakan-privasi', '<h2>Perlindungan Data Anda</h2><p>Klik.Cake menghormati dan menjaga kerahasiaan data pribadi seluruh pelanggan. Data seperti nama, nomor WhatsApp, dan alamat pengiriman hanya digunakan untuk keperluan pemrosesan dan pengantaran pesanan Anda di area Makassar.</p>', 'Kebijakan privasi dan perlindungan data pelanggan Klik.Cake.', 1, 0, 1, 3, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "pages" (id, title, slug, content, meta_description, is_published, show_in_header, show_in_footer, sort_order, created_at, updated_at) VALUES (4, 'Syarat & Ketentuan', 'syarat-ketentuan', '<h2>Ketentuan Pemesanan</h2><p>1. Pemesanan cake standar dilakukan minimal H-1 sebelum pukul 18.00 WITA.<br>2. Pembayaran terverifikasi otomatis dalam batas waktu 1 jam setelah checkout.<br>3. Pengantaran dilakukan oleh kurir khusus bakery area Makassar.</p>', 'Syarat dan ketentuan pemesanan dan pengiriman di Klik.Cake.', 1, 0, 1, 4, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "pages" (id, title, slug, content, meta_description, is_published, show_in_header, show_in_footer, sort_order, created_at, updated_at) VALUES (5, 'Pertanyaan Umum (FAQ)', 'faq', '<h2>Pertanyaan yang Sering Diajukan</h2><p><strong>Q: Apakah bisa pesan untuk hari yang sama?</strong><br>A: Untuk menjaga kesegaran Fresh Bake, pemesanan minimal dilakukan H-1 sebelum cut-off jam 18.00 WITA.</p><p><strong>Q: Di mana lokasi pengambilan langsung?</strong><br>A: Dapur pusat kami berlokasi di area Panakkukang / Boulevard, Makassar.</p>', 'Jawaban atas pertanyaan seputar pemesanan roti dan cake di Klik.Cake.', 1, 0, 1, 5, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
SELECT setval(pg_get_serial_sequence('pages', 'id'), COALESCE((SELECT MAX(id) + 1 FROM "pages"), 1), false);

-- Data for: hero_sections (1 rows)
INSERT INTO "hero_sections" (id, badge_text, title, subtitle, button_text, button_link, secondary_button_text, secondary_button_link, image_url, featured_product_id, is_active, sort_order, created_at, updated_at) VALUES (1, 'Fresh Bake hari ini', 'Klik, dipanggang, sampai.', 'Pesan roti & kue segar dari Makassar, pilih jadwal, bayar, pantau sampai matang. Dibuat fresh setiap hari langsung dari dapur kami.', 'Pesan Sekarang', '/katalog', 'Lihat Menu', '#kategori', 'products/hero-makassar.jpg', 1, 1, 1, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
SELECT setval(pg_get_serial_sequence('hero_sections', 'id'), COALESCE((SELECT MAX(id) + 1 FROM "hero_sections"), 1), false);

-- Data for: web_settings (9 rows)
INSERT INTO "web_settings" (id, "key", value, "group", label, type, created_at, updated_at) VALUES (1, 'site_name', 'Klik.Cake', 'general', 'Nama Website / Brand', 'text', '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "web_settings" (id, "key", value, "group", label, type, created_at, updated_at) VALUES (2, 'site_tagline', 'by Pinky Cake & Bakery Makassar', 'general', 'Tagline Brand', 'text', '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "web_settings" (id, "key", value, "group", label, type, created_at, updated_at) VALUES (3, 'meta_description', 'Pesan roti & kue segar dari Makassar, pilih jadwal, bayar, pantau sampai matang. Dibuat fresh setiap hari.', 'general', 'Deskripsi Meta SEO', 'textarea', '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "web_settings" (id, "key", value, "group", label, type, created_at, updated_at) VALUES (4, 'announcement_enabled', 1, 'announcement', 'Aktifkan Announcement Bar', 'boolean', '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "web_settings" (id, "key", value, "group", label, type, created_at, updated_at) VALUES (5, 'announcement_text', '✨ Fresh Bake Setiap Hari — Pesan Hari Ini untuk Pengiriman Esok Hari di Seluruh Area Makassar!', 'announcement', 'Teks Pengumuman', 'text', '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "web_settings" (id, "key", value, "group", label, type, created_at, updated_at) VALUES (6, 'contact_whatsapp', 6281234567890, 'contact', 'Nomor WhatsApp CS (tanpa tanda +)', 'text', '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "web_settings" (id, "key", value, "group", label, type, created_at, updated_at) VALUES (7, 'contact_email', 'halo@klikcake.local', 'contact', 'Email Layanan Pelanggan', 'text', '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "web_settings" (id, "key", value, "group", label, type, created_at, updated_at) VALUES (8, 'kitchen_address', 'Jl. Boulevard / Panakkukang
Makassar, Sulawesi Selatan', 'contact', 'Alamat Dapur / Lokasi Pick-up', 'textarea', '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "web_settings" (id, "key", value, "group", label, type, created_at, updated_at) VALUES (9, 'operating_hours', 'Buka setiap hari: 08.00 – 20.00 WITA', 'contact', 'Jam Operasional Dapur', 'text', '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
SELECT setval(pg_get_serial_sequence('web_settings', 'id'), COALESCE((SELECT MAX(id) + 1 FROM "web_settings"), 1), false);

-- Data for: networkings (6 rows)
INSERT INTO "networkings" (id, name, type, platform, url, address, phone, icon, is_active, sort_order, created_at, updated_at) VALUES (1, 'Instagram @pinkycakemks', 'social_media', 'instagram', 'https://instagram.com/pinkycakemks', NULL, NULL, NULL, 1, 1, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "networkings" (id, name, type, platform, url, address, phone, icon, is_active, sort_order, created_at, updated_at) VALUES (2, 'TikTok @klik.cake', 'social_media', 'tiktok', 'https://tiktok.com/@klik.cake', NULL, NULL, NULL, 1, 2, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "networkings" (id, name, type, platform, url, address, phone, icon, is_active, sort_order, created_at, updated_at) VALUES (3, 'WhatsApp Channel Pinky Cake', 'social_media', 'whatsapp', 'https://wa.me/6281234567890', NULL, NULL, NULL, 1, 3, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "networkings" (id, name, type, platform, url, address, phone, icon, is_active, sort_order, created_at, updated_at) VALUES (4, 'Dapur Pusat Panakkukang', 'kitchen', 'gmaps', 'https://maps.google.com/?q=Panakkukang+Makassar', 'Jl. Boulevard Ruko Ruby, Panakkukang, Makassar', '0812-3456-7890', NULL, 1, 4, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "networkings" (id, name, type, platform, url, address, phone, icon, is_active, sort_order, created_at, updated_at) VALUES (5, 'Outlet Pick-up Pengayoman', 'outlet', 'gmaps', 'https://maps.google.com/?q=Pengayoman+Makassar', 'Jl. Pengayoman No. 45, Makassar', '0812-9876-5432', NULL, 1, 5, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
INSERT INTO "networkings" (id, name, type, platform, url, address, phone, icon, is_active, sort_order, created_at, updated_at) VALUES (6, 'Mitra Reseller Antang & Tamalanrea', 'reseller', 'whatsapp', 'https://wa.me/6281234567890', 'Titik Distribusi Antang / Perintis, Makassar', '0821-1122-3344', NULL, 1, 6, '2026-11-23 02:00:54', '2026-11-23 02:00:54') ON CONFLICT DO NOTHING;
SELECT setval(pg_get_serial_sequence('networkings', 'id'), COALESCE((SELECT MAX(id) + 1 FROM "networkings"), 1), false);

