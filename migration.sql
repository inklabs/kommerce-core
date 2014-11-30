-- Migrate product
INSERT INTO zk_product (name, sku, description, default_image, is_inventory_required, is_price_visible, is_active, is_visible, is_taxable, is_shippable, unit_price, quantity, shipping_weight, rating, created, updated, id)
SELECT p.name, p.sku, p.description, p.default_image, p.require_inventory, 1, p.active, p.visible, p.taxable, p.shipping, p.price, p.quantity, p.shipping_weight, p.rating, p.created, p.updated, p.id FROM product p;

UPDATE zk_product SET description = null where description = '';

-- Migrate tag
INSERT INTO zk_tag (name, description, default_image, is_active, is_visible, sort_order, created, updated, id)
SELECT t.name, t.description, t.default_image, 1, t.visible, t.sort_order, t.created, t.updated, t.id FROM tag t;

UPDATE zk_tag SET description = null where description = '';

-- Migrate product_tag
INSERT INTO zk_product_tag (product_id, tag_id)
SELECT pt.product_id, pt.tag_id FROM product_tag pt;

-- Migrate image
INSERT INTO zk_image (path, width, height, sort_order, created, updated, id, product_id, tag_id)
SELECT i.path, i.width, i.height, i.sort_order, i.created, i.updated, i.id, i.product_id, i.tag_id FROM image i;

-- Migrate catalog_promotion
INSERT INTO zk_catalog_promotion (name, type, value, redemptions, start, end, reduces_tax_subtotal, max_redemptions, code, created, updated, id, tag_id)
SELECT cp.name, cp.discount_type, cp.discount_value, cp.redemptions, cp.start, cp.end, 1, cp.max_redemptions, null, cp.created, cp.updated, cp.id, cp.tag_id FROM catalog_promotion cp;

-- Migrate coupon
INSERT INTO zk_coupon (name, type, value, redemptions, start, end, reduces_tax_subtotal, max_redemptions, code, can_combine, flag_free_shipping, min_order_value, max_order_value, created, updated, id, tag_id)
SELECT c.name, c.discount_type, c.discount_value, c.redemptions, c.start, c.end, 1, c.max_redemptions, c.code, c.can_combine, c.free_shipping, c.min_order_value, c.max_order_value, c.created, c.updated, c.id, c.tag_id FROM coupon c;

-- Migrate product_quantity_discount
INSERT INTO zk_product_quantity_discount (name, type, value, redemptions, start, end, reduces_tax_subtotal, max_redemptions, apply_catalog_promotions, quantity, created, updated, id, product_id)
SELECT null, p.discount_type, p.discount_value, 0, p.start, p.end, 1, null, p.apply_catalog_promotions, p.quantity, p.created, p.updated, p.id, p.product_id FROM product_discount p;

-- Migrate tax_rate
INSERT INTO zk_tax_rate (state, zip5, zip5_from, zip5_to, rate, apply_to_shipping, created, updated, id)
SELECT t.state, t.zip5, t.zip5_from, t.zip5_to, t.rate, t.apply_to_shipping, t.created, t.updated, t.id FROM tax_rate t;

-- Migrate user
INSERT INTO zk_user (first_name, last_name, email, username, password_hash, total_logins, last_login, status, created, updated, id)
SELECT u.first_name, u.last_name, u.email, u.username, u.password, u.logins, u.last_login, 1, u.created, u.updated, u.id FROM user u;
