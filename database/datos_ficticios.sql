USE tienda_tecnologia;

SET FOREIGN_KEY_CHECKS = 0;

-- =========================
-- BRANDS
-- =========================

INSERT INTO brands (id, name, country, website, created_at, updated_at) VALUES
(5, 'ASUS', 'Taiwán', 'https://asus.com', NOW(), NOW()),
(6, 'HP', 'Estados Unidos', 'https://hp.com', NOW(), NOW()),
(7, 'Apple', 'Estados Unidos', 'https://apple.com', NOW(), NOW()),
(8, 'Corsair', 'Estados Unidos', 'https://corsair.com', NOW(), NOW());

-- =========================
-- CATEGORIES
-- =========================

INSERT INTO categories (id, name, description, created_at, updated_at) VALUES
(5, 'Monitores', 'Monitores para trabajo, estudio y gaming', NOW(), NOW()),
(6, 'Accesorios', 'Accesorios y periféricos para computadores', NOW(), NOW());

-- =========================
-- PRODUCTS
-- =========================

INSERT INTO products
(id, name, description, price, stock, image, active, brand_id, category_id, created_at, updated_at)
VALUES
(5, 'ASUS ROG Strix G16',
 'Laptop gaming de alto rendimiento con pantalla de 16 pulgadas.',
 5200000.00, 8, NULL, 1, 5, 1, NOW(), NOW()),

(6, 'HP Pavilion 15',
 'Laptop para productividad, estudio y trabajo diario.',
 2800000.00, 12, NULL, 1, 6, 1, NOW(), NOW()),

(7, 'MacBook Air M3',
 'Portátil Apple con chip M3 y diseño ultradelgado.',
 6200000.00, 6, NULL, 1, 7, 1, NOW(), NOW()),

(8, 'ASUS ZenScreen 24',
 'Monitor Full HD de 24 pulgadas para trabajo y entretenimiento.',
 950000.00, 10, NULL, 1, 5, 5, NOW(), NOW()),

(9, 'HP E24 Monitor',
 'Monitor empresarial de 24 pulgadas con resolución Full HD.',
 850000.00, 14, NULL, 1, 6, 5, NOW(), NOW()),

(10, 'Apple Studio Display',
 'Monitor Retina 5K de 27 pulgadas.',
 7500000.00, 4, NULL, 1, 7, 5, NOW(), NOW()),

(11, 'Corsair K70 RGB',
 'Teclado mecánico RGB para gaming y productividad.',
 650000.00, 18, NULL, 1, 8, 6, NOW(), NOW()),

(12, 'Corsair Harpoon RGB',
 'Mouse gaming ergonómico con iluminación RGB.',
 220000.00, 25, NULL, 1, 8, 6, NOW(), NOW()),

(13, 'AirPods Pro 2',
 'Audífonos inalámbricos con cancelación activa de ruido.',
 1200000.00, 20, NULL, 1, 7, 3, NOW(), NOW()),

(14, 'ASUS ROG Swift',
 'Monitor gaming de alta frecuencia de actualización.',
 3200000.00, 7, NULL, 1, 5, 5, NOW(), NOW()),

(15, 'HP Wireless Keyboard',
 'Teclado inalámbrico compacto para oficina.',
 180000.00, 30, NULL, 1, 6, 6, NOW(), NOW()),

(16, 'Corsair Vengeance 32GB',
 'Memoria RAM DDR5 de 32 GB para computadores de alto rendimiento.',
 750000.00, 16, NULL, 1, 8, 4, NOW(), NOW()),

(17, 'ASUS RTX Gaming PC',
 'Tarjeta gráfica dedicada para videojuegos y aplicaciones profesionales.',
 4200000.00, 5, NULL, 1, 5, 4, NOW(), NOW()),

(18, 'Apple Magic Mouse',
 'Mouse inalámbrico con superficie multitáctil.',
 450000.00, 22, NULL, 1, 7, 6, NOW(), NOW()),

(19, 'HP USB-C Dock',
 'Estación de conexión USB-C para computadores portátiles.',
 600000.00, 15, NULL, 1, 6, 6, NOW(), NOW()),

(20, 'Corsair 4000D',
 'Gabinete ATX para computadores de alto rendimiento.',
 550000.00, 9, NULL, 1, 8, 4, NOW(), NOW());

-- =========================
-- USERS
-- =========================

INSERT INTO users
(id, name, email, email_verified_at, password, role, remember_token, created_at, updated_at)
VALUES
(7, 'Carlos Rodríguez', 'carlos.rodriguez@example.com', NOW(),
 '$2y$12$TK344jlKvjttT8zrZRHsGeBiWXsddVe.IT7ty8Mc4KOJbi97hrRS2',
 'cliente', NULL, NOW(), NOW()),

(8, 'Laura Martínez', 'laura.martinez@example.com', NOW(),
 '$2y$12$TK344jlKvjttT8zrZRHsGeBiWXsddVe.IT7ty8Mc4KOJbi97hrRS2',
 'cliente', NULL, NOW(), NOW()),

(9, 'Andrés Gómez', 'andres.gomez@example.com', NOW(),
 '$2y$12$TK344jlKvjttT8zrZRHsGeBiWXsddVe.IT7ty8Mc4KOJbi97hrRS2',
 'cliente', NULL, NOW(), NOW()),

(10, 'Sofía Hernández', 'sofia.hernandez@example.com', NOW(),
 '$2y$12$TK344jlKvjttT8zrZRHsGeBiWXsddVe.IT7ty8Mc4KOJbi97hrRS2',
 'cliente', NULL, NOW(), NOW()),

(11, 'Mateo Torres', 'mateo.torres@example.com', NOW(),
 '$2y$12$TK344jlKvjttT8zrZRHsGeBiWXsddVe.IT7ty8Mc4KOJbi97hrRS2',
 'cliente', NULL, NOW(), NOW()),

(12, 'Valentina Pérez', 'valentina.perez@example.com', NOW(),
 '$2y$12$TK344jlKvjttT8zrZRHsGeBiWXsddVe.IT7ty8Mc4KOJbi97hrRS2',
 'cliente', NULL, NOW(), NOW()),

(13, 'Daniel Castro', 'daniel.castro@example.com', NOW(),
 '$2y$12$TK344jlKvjttT8zrZRHsGeBiWXsddVe.IT7ty8Mc4KOJbi97hrRS2',
 'cliente', NULL, NOW(), NOW()),

(14, 'Mariana López', 'mariana.lopez@example.com', NOW(),
 '$2y$12$TK344jlKvjttT8zrZRHsGeBiWXsddVe.IT7ty8Mc4KOJbi97hrRS2',
 'cliente', NULL, NOW(), NOW());

-- =========================
-- ORDERS
-- =========================

INSERT INTO orders
(id, order_date, status, total_amount, user_id, created_at, updated_at)
VALUES
(2, '2026-09-10 10:30:00', 'pagado', 10400000.00, 7, NOW(), NOW()),
(3, '2026-09-11 14:20:00', 'enviado', 2800000.00, 8, NOW(), NOW()),
(4, '2026-09-12 09:15:00', 'pagado', 4050000.00, 9, NOW(), NOW()),
(5, '2026-09-12 16:45:00', 'enviado', 8700000.00, 10, NOW(), NOW()),
(6, '2026-09-13 11:10:00', 'pendiente', 1310000.00, 11, NOW(), NOW()),
(7, '2026-09-14 13:40:00', 'pagado', 3200000.00, 12, NOW(), NOW()),
(8, '2026-09-14 18:30:00', 'enviado', 7050000.00, 13, NOW(), NOW()),
(9, '2026-09-15 10:00:00', 'pagado', 1170000.00, 14, NOW(), NOW()),
(10, '2026-09-15 15:25:00', 'pendiente', 4800000.00, 7, NOW(), NOW());

-- =========================
-- ORDER ITEMS
-- =========================

INSERT INTO order_items
(id, quantity, unit_price, subtotal, order_id, product_id, created_at, updated_at)
VALUES
(2, 2, 5200000.00, 10400000.00, 2, 5, NOW(), NOW()),

(3, 1, 2800000.00, 2800000.00, 3, 6, NOW(), NOW()),

(4, 1, 3200000.00, 3200000.00, 4, 14, NOW(), NOW()),
(5, 1, 850000.00, 850000.00, 4, 9, NOW(), NOW()),

(6, 1, 7500000.00, 7500000.00, 5, 10, NOW(), NOW()),
(7, 1, 1200000.00, 1200000.00, 5, 13, NOW(), NOW()),

(8, 1, 750000.00, 750000.00, 6, 16, NOW(), NOW()),
(9, 1, 550000.00, 550000.00, 6, 20, NOW(), NOW()),
(10, 1, 10000.00, 10000.00, 6, 12, NOW(), NOW()),

(11, 1, 3200000.00, 3200000.00, 7, 14, NOW(), NOW()),

(12, 1, 6200000.00, 6200000.00, 8, 7, NOW(), NOW()),
(13, 1, 850000.00, 850000.00, 8, 9, NOW(), NOW()),

(14, 2, 220000.00, 440000.00, 9, 12, NOW(), NOW()),
(15, 1, 750000.00, 750000.00, 9, 16, NOW(), NOW()),

(16, 1, 4200000.00, 4200000.00, 10, 17, NOW(), NOW()),
(17, 1, 600000.00, 600000.00, 10, 19, NOW(), NOW());

-- =========================
-- REVIEWS
-- =========================

INSERT INTO reviews
(id, rating, comment, created_at_review, user_id, product_id, created_at, updated_at)
VALUES
(9, 5, 'Excelente laptop, muy rápida y con buenos acabados.', NOW(), 7, 5, NOW(), NOW()),
(10, 4, 'Buen rendimiento para trabajar y estudiar.', NOW(), 8, 6, NOW(), NOW()),
(11, 5, 'La pantalla tiene una calidad excelente.', NOW(), 9, 7, NOW(), NOW()),
(12, 4, 'Buen monitor para trabajar desde casa.', NOW(), 10, 8, NOW(), NOW()),
(13, 5, 'Muy buena relación entre calidad y precio.', NOW(), 11, 9, NOW(), NOW()),
(14, 5, 'La calidad de imagen es excelente.', NOW(), 12, 10, NOW(), NOW()),
(15, 4, 'El teclado se siente muy bien al escribir.', NOW(), 13, 11, NOW(), NOW()),
(16, 5, 'Muy cómodo para jugar y trabajar.', NOW(), 14, 12, NOW(), NOW()),
(17, 5, 'Excelente cancelación de ruido.', NOW(), 7, 13, NOW(), NOW()),
(18, 4, 'Muy buena experiencia para gaming.', NOW(), 8, 14, NOW(), NOW()),
(19, 4, 'Cumple perfectamente para oficina.', NOW(), 9, 15, NOW(), NOW()),
(20, 5, 'La memoria funciona muy bien.', NOW(), 10, 16, NOW(), NOW()),
(21, 5, 'Excelente rendimiento gráfico.', NOW(), 11, 17, NOW(), NOW()),
(22, 4, 'Muy cómodo y fácil de usar.', NOW(), 12, 18, NOW(), NOW()),
(23, 4, 'Práctico para conectar varios dispositivos.', NOW(), 13, 19, NOW(), NOW()),
(24, 5, 'Muy buen gabinete, amplio y bien construido.', NOW(), 14, 20, NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;