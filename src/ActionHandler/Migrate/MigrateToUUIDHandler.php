<?php
namespace inklabs\kommerce\ActionHandler\Migrate;

use Doctrine\DBAL\Connection;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use inklabs\kommerce\Entity\AbstractCartPriceRuleItem;
use inklabs\kommerce\Entity\AbstractPayment;
use inklabs\kommerce\Entity\Attribute;
use inklabs\kommerce\Entity\AttributeValue;
use inklabs\kommerce\Entity\CartPriceRule;
use inklabs\kommerce\Entity\CartPriceRuleDiscount;
use inklabs\kommerce\Entity\CartPriceRuleProductItem;
use inklabs\kommerce\Entity\CartPriceRuleTagItem;
use inklabs\kommerce\Entity\CatalogPromotion;
use inklabs\kommerce\Entity\Coupon;
use inklabs\kommerce\Entity\Image;
use inklabs\kommerce\Entity\InventoryLocation;
use inklabs\kommerce\Entity\InventoryTransaction;
use inklabs\kommerce\Entity\Option;
use inklabs\kommerce\Entity\OptionProduct;
use inklabs\kommerce\Entity\OptionValue;
use inklabs\kommerce\Entity\Order;
use inklabs\kommerce\Entity\OrderItem;
use inklabs\kommerce\Entity\OrderItemOptionProduct;
use inklabs\kommerce\Entity\OrderItemOptionValue;
use inklabs\kommerce\Entity\OrderItemTextOptionValue;
use inklabs\kommerce\Entity\Product;
use inklabs\kommerce\Entity\ProductAttribute;
use inklabs\kommerce\Entity\ProductQuantityDiscount;
use inklabs\kommerce\Entity\Shipment;
use inklabs\kommerce\Entity\ShipmentComment;
use inklabs\kommerce\Entity\ShipmentItem;
use inklabs\kommerce\Entity\ShipmentTracker;
use inklabs\kommerce\Entity\Tag;
use inklabs\kommerce\Entity\TaxRate;
use inklabs\kommerce\Entity\TempUuidTrait;
use inklabs\kommerce\Entity\TextOption;
use inklabs\kommerce\Entity\User;
use inklabs\kommerce\Entity\UserLogin;
use inklabs\kommerce\Entity\UserRole;
use inklabs\kommerce\Entity\UserToken;
use inklabs\kommerce\Entity\Warehouse;
use PDO;

class MigrateToUUIDHandler
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var Connection */
    private $connection;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->connection = $this->entityManager->getConnection();
    }

    public function handle()
    {
        $this->migrateSchema();
        $this->migrateAllEntities();
        $this->migrateAttributes();
        $this->migrateCartPriceRules();
        $this->migrateImages();
        $this->migrateOptions();
        $this->migrateProducts();
        $this->migrateShipments();
        $this->migrateUsers();
        $this->migrateCatalogPromotions();
        $this->migrateOrders();
        $this->migrateInventoryLocations();
        $this->migrateJoinTables();

        $this->removeForeignKeys();

        $this->sqlMigration();
        $this->addPrimaryKeys();
    }

    private function migrateSchema()
    {
        if ($this->connection->getDriver() instanceof \Doctrine\DBAL\Driver\PDOSqlite\Driver) {
            return;
        }

        $this->removeForeignKeys();
        $this->clearCart();

        $this->updateSchema();
    }

    private function removeForeignKeys()
    {
        error_log(__METHOD__);
        $result = $this->connection->query("
            SELECT concat('ALTER TABLE ', TABLE_NAME, ' DROP FOREIGN KEY ', CONSTRAINT_NAME, ';')
            FROM information_schema.key_column_usage
            WHERE CONSTRAINT_SCHEMA = 'birdiesperch' AND referenced_table_name IS NOT NULL;"
        )->fetchAll(PDO::FETCH_NUM);

        foreach ($result as $sql) {
            $this->connection->exec($sql[0]);
        }
    }

    private function addPrimaryKeys()
    {
        error_log(__METHOD__);
        $result = $this->connection->query("
            SELECT concat('ALTER TABLE ', TABLE_NAME, ' ADD PRIMARY KEY (id);')
            FROM information_schema.tables WHERE table_name LIKE 'zk_%';"
        )->fetchAll(PDO::FETCH_NUM);

        foreach ($result as $sql) {
            try {
                $this->connection->exec($sql[0]);
            } catch (Exception $e) {
            }
        }
    }

    private function clearCart()
    {
        error_log(__METHOD__);
        $this->connection->exec('DELETE FROM `zk_CartItem`');
        $this->connection->exec('DELETE FROM `zk_Cart`');
        $this->connection->exec('DELETE FROM `zk_cart_coupon`');
    }

    private function migrateAllEntities()
    {
        error_log(__METHOD__);
        $this->migrateEntities([
            AbstractCartPriceRuleItem::class,
            AbstractPayment::class,
            Attribute::class,
            AttributeValue::class,
            CatalogPromotion::class,
            CartPriceRule::class,
            CartPriceRuleDiscount::class,
            Coupon::class,
            Image::class,
            InventoryTransaction::class,
            InventoryLocation::class,
            Option::class,
            OptionProduct::class,
            OptionValue::class,
            Order::class,
            OrderItem::class,
            OrderItemOptionProduct::class,
            OrderItemOptionValue::class,
            OrderItemTextOptionValue::class,
            Product::class,
            ProductAttribute::class,
            ProductQuantityDiscount::class,
            Shipment::class,
            ShipmentComment::class,
            ShipmentItem::class,
            ShipmentTracker::class,
            Tag::class,
            TaxRate::class,
            TextOption::class,
            User::class,
            UserLogin::class,
            UserRole::class,
            UserToken::class,
            Warehouse::class
        ]);
    }

    private function migrateEntities(array $entityClassNames)
    {
        foreach ($entityClassNames as $entityClassName) {
            $entityQuery = $this->getEntityQuery($entityClassName);
            $this->setUUIDAndFlush($entityQuery);
        }
    }

    private function migrateAttributes()
    {
        $entityQuery = $this->getEntityQuery(Attribute::class);

        foreach ($this->iterate($entityQuery) as $attribute) {
            $this->migrateAttributeValues($attribute);
            $this->migrateAttribute2ProductAttributes($attribute);
        }

        $this->entityManager->flush();
    }

    private function migrateAttributeValues(Attribute $attribute)
    {
        foreach ($attribute->getAttributeValues() as $attributeValue) {
            $attributeValue->setAttributeUuid($attribute->getUuid());
            $this->migrateAttributeValue2ProductAttributes($attributeValue);
        }
    }

    private function migrateAttribute2ProductAttributes(Attribute $attribute)
    {
        foreach ($attribute->getProductAttributes() as $productAttribute) {
            $productAttribute->setAttributeUuid($attribute->getUuid());
        }
    }

    private function migrateAttributeValue2ProductAttributes(AttributeValue $attributeValue)
    {
        foreach ($attributeValue->getProductAttributes() as $productAttribute) {
            $productAttribute->setAttributeValueUuid($attributeValue->getUuid());
        }
    }

    private function migrateCartPriceRules()
    {
        $entityQuery = $this->getEntityQuery(CartPriceRule::class);

        foreach ($this->iterate($entityQuery) as $cartPriceRule) {
            $this->migrateCartPriceRuleChildren($cartPriceRule);
        }

        $this->entityManager->flush();
    }

    private function migrateCartPriceRuleChildren(CartPriceRule $cartPriceRule)
    {
        foreach ($cartPriceRule->getCartPriceRuleDiscounts() as $cartPriceRuleDiscount) {
            $cartPriceRuleDiscount->setCartPriceRuleUuid($cartPriceRule->getUuid());
            $cartPriceRuleDiscount->setProductUuid($cartPriceRuleDiscount->getProduct()->getUuid());
        }

        foreach ($cartPriceRule->getCartPriceRuleItems() as $cartPriceRuleItem) {
            $cartPriceRuleItem->setCartPriceRuleUuid($cartPriceRule->getUuid());

            if ($cartPriceRuleItem instanceof CartPriceRuleProductItem) {
                $cartPriceRuleItem->setProductUuid($cartPriceRuleItem->getProduct()->getUuid());
            }

            if ($cartPriceRuleItem instanceof CartPriceRuleTagItem) {
                $cartPriceRuleItem->setTagUuid($cartPriceRuleItem->getTag()->getUuid());
            }
        }
    }

    private function migrateImages()
    {
        $entityQuery = $this->getEntityQuery(Image::class);

        foreach ($this->iterate($entityQuery) as $image) {
            /** @var Image $image */

            $product = $image->getProduct();
            if ($product !== null) {
                $image->setProductUuid($product->getUuid());
            }

            $tag = $image->getTag();
            if ($tag !== null) {
                $image->setTagUuid($tag->getUuid());
            }
        }

        $this->entityManager->flush();
    }

    private function migrateOptions()
    {
        $entityQuery = $this->getEntityQuery(Option::class);

        foreach ($this->iterate($entityQuery) as $option) {
            $this->migrateOptionProducts($option);
            $this->migrateOptionValues($option);
        }

        $this->entityManager->flush();
    }

    private function migrateOptionProducts(Option $option)
    {
        foreach ($option->getOptionProducts() as $optionProduct) {
            $optionProduct->setOptionUuid($option->getUuid());
            $optionProduct->setProductUuid($optionProduct->getProduct()->getUuid());
        }
    }

    private function migrateOptionValues(Option $option)
    {
        foreach ($option->getOptionValues() as $optionProduct) {
            $optionProduct->setOptionUuid($option->getUuid());
        }
    }

    private function migrateProducts()
    {
        $entityQuery = $this->getEntityQuery(Product::class);

        foreach ($this->iterate($entityQuery) as $product) {
            $this->migrateProductQuantityDiscounts($product);
            $this->migrateProductAttributes($product);
        }

        $this->entityManager->flush();
    }

    private function migrateProductQuantityDiscounts(Product $product)
    {
        foreach ($product->getProductQuantityDiscounts() as $productQuantityDiscount) {
            $productQuantityDiscount->setProductUuid($product->getUuid());
        }
    }

    private function migrateProductAttributes(Product $product)
    {
        foreach ($product->getProductAttributes() as $productAttribute) {
            $productAttribute->setProductUuid($product->getUuid());
        }
    }

    private function migrateShipments()
    {
        $entityQuery = $this->getEntityQuery(Shipment::class);

        foreach ($this->iterate($entityQuery) as $shipment) {
            $this->migrateShipmentComments($shipment);
            $this->migrateShipmentItems($shipment);
            $this->migrateShipmentTrackers($shipment);
        }

        $this->entityManager->flush();
    }

    private function migrateShipmentComments(Shipment $shipment)
    {
        foreach ($shipment->getShipmentComments() as $shipmentComment) {
            $shipmentComment->setShipmentUuid($shipment->getUuid());
        }
    }

    private function migrateShipmentItems(Shipment $shipment)
    {
        foreach ($shipment->getShipmentItems() as $shipmentItem) {
            $shipmentItem->setShipmentUuid($shipment->getUuid());
            $shipmentItem->setOrderItemUuid($shipmentItem->getOrderItem()->getUuid());
        }
    }

    private function migrateShipmentTrackers(Shipment $shipment)
    {
        foreach ($shipment->getShipmentTrackers() as $shipmentTracker) {
            $shipmentTracker->setShipmentUuid($shipment->getUuid());
        }
    }

    private function migrateUsers()
    {
        $entityQuery = $this->getEntityQuery(User::class);

        foreach ($this->iterate($entityQuery) as $user) {
            $this->migrateUserLogins($user);
            $this->migrateUserTokens($user);
            $this->migrateUserOrders($user);
        }

        $this->entityManager->flush();
    }

    private function migrateUserLogins(User $user)
    {
        foreach ($user->getUserLogins() as $userLogin) {
            $userLogin->setUserUuid($user->getUuid());

            $userToken = $userLogin->getUserToken();
            if ($userToken !== null) {
                $userLogin->setUserTokenUuid($userToken->getUuid());
            }
        }
    }

    private function migrateUserTokens(User $user)
    {
        foreach ($user->getUserTokens() as $userToken) {
            $userToken->setUserUuid($user->getUuid());
        }
    }

    private function migrateUserOrders(User $user)
    {
        foreach ($user->getOrders() as $order) {
            $order->setUserUuid($user->getUuid());
        }
    }

    private function migrateCatalogPromotions()
    {
        $entityQuery = $this->getEntityQuery(CatalogPromotion::class);

        foreach ($this->iterate($entityQuery) as $catalogPromotion) {
            /** @var CatalogPromotion $catalogPromotion */
            $tag = $catalogPromotion->getTag();

            if ($tag !== null) {
                $catalogPromotion->setTagUuid($tag->getUuid());
            }
        }
        $this->entityManager->flush();
    }

    private function migrateOrders()
    {
        $entityQuery = $this->getEntityQuery(Order::class);

        foreach ($this->iterate($entityQuery) as $order) {
            /** @var Order $order */
            $this->migrateOrderItems($order);
            $this->migratePayments($order);

            $taxRate = $order->getTaxRate();
            if ($taxRate !== null) {
                $order->setTaxRateUuid($order->getTaxRate()->getUuid());
            }

            foreach ($order->getShipments() as $shipment) {
                $shipment->setOrderUuid($order->getUuid());
            }
        }

        $this->entityManager->flush();
    }

    private function migrateOrderItems(Order $order)
    {
        foreach ($order->getOrderItems() as $orderItem) {
            $orderItem->setOrderUuid($order->getUuid());

            $product = $orderItem->getProduct();
            if ($product !== null) {
                $orderItem->setProductUuid($product->getUuid());
            }

            $this->migrateOrderItemOptionProducts($orderItem);
            $this->migrateOrderItemOptionValues($orderItem);
            $this->migrateOrderItemTextOptionValues($orderItem);
        }
    }

    private function migrateOrderItemOptionProducts(OrderItem $orderItem)
    {
        foreach ($orderItem->getOrderItemOptionProducts() as $orderItemOptionProduct) {
            $orderItemOptionProduct->setOrderItemUuid($orderItem->getUuid());
            $orderItemOptionProduct->setOptionProductUuid($orderItemOptionProduct->getOptionProduct()->getUuid());
        }
    }

    private function migrateOrderItemOptionValues(OrderItem $orderItem)
    {
        foreach ($orderItem->getOrderItemOptionValues() as $orderItemOptionValue) {
            $orderItemOptionValue->setOrderItemUuid($orderItem->getUuid());
            $orderItemOptionValue->setOptionValueUuid($orderItemOptionValue->getOptionValue()->getUuid());
        }
    }

    private function migrateOrderItemTextOptionValues(OrderItem $orderItem)
    {
        foreach ($orderItem->getOrderItemTextOptionValues() as $orderItemTextOptionValue) {
            $orderItemTextOptionValue->setOrderItemUuid($orderItem->getUuid());
            $orderItemTextOptionValue->setTextOptionUuid($orderItemTextOptionValue->getTextOption()->getUuid());
        }
    }

    private function migratePayments(Order $order)
    {
        foreach ($order->getPayments() as $payment) {
            $payment->setOrderUuid($order->getUuid());
        }
    }

    private function migrateInventoryLocations()
    {
        $entityQuery = $this->getEntityQuery(InventoryLocation::class);

        foreach ($this->iterate($entityQuery) as $inventoryLocation) {
            /** @var InventoryLocation $inventoryLocation */

            $inventoryLocation->setWarehouseUuid($inventoryLocation->getWarehouse()->getUuid());
        }

        $this->entityManager->flush();
    }

    /**
     * @param $entityClass
     * @return \Doctrine\ORM\Query
     */
    private function getEntityQuery($entityClass)
    {
        return $this->entityManager->createQueryBuilder()
            ->select('table')
            ->from($entityClass, 'table')
            ->getQuery();
    }

    /**
     * @param $entityQuery
     */
    private function setUUIDAndFlush(\Doctrine\ORM\Query $entityQuery)
    {
        foreach ($this->iterate($entityQuery) as $entity) {
            $entity->setUuid();
        }

        $this->entityManager->flush();
    }

    /**
     * @param \Doctrine\ORM\Query $entityQuery
     * @return \Generator | TempUuidTrait[]
     */
    private function iterate(\Doctrine\ORM\Query $entityQuery)
    {
        foreach ($entityQuery->iterate() as $row) {
            yield $row[0];
        }
    }

    private function migrateJoinTables()
    {
        error_log(__METHOD__);
        if ($this->connection->getDriver() instanceof \Doctrine\DBAL\Driver\PDOSqlite\Driver) {
            return;
        }

        try {
            $this->connection->exec('
                ALTER TABLE zk_product_tag
                  ADD COLUMN product_uuid BINARY(16) NOT NULL COMMENT "(DC2Type:uuid_binary)",
                  ADD COLUMN tag_uuid BINARY(16) NOT NULL COMMENT "(DC2Type:uuid_binary)";
            ');

            $this->connection->exec('
                ALTER TABLE zk_orderitem_catalogpromotion
                  ADD COLUMN orderitem_uuid BINARY(16) NOT NULL COMMENT "(DC2Type:uuid_binary)",
                  ADD COLUMN catalogpromotion_uuid BINARY(16) NOT NULL COMMENT "(DC2Type:uuid_binary)";
            ');

            $this->connection->exec('
                ALTER TABLE zk_user_userrole
                  ADD COLUMN user_uuid BINARY(16) NOT NULL COMMENT "(DC2Type:uuid_binary)",
                  ADD COLUMN userrole_uuid BINARY(16) NOT NULL COMMENT "(DC2Type:uuid_binary)";
            ');

            $this->connection->exec('
                ALTER TABLE zk_order_coupon
                  ADD COLUMN order_uuid BINARY(16) NOT NULL COMMENT "(DC2Type:uuid_binary)",
                  ADD COLUMN coupon_uuid BINARY(16) NOT NULL COMMENT "(DC2Type:uuid_binary)";
            ');
        } catch (Exception $e) {
        }

        $this->connection->exec('
            UPDATE zk_product_tag AS pt
            INNER JOIN zk_Product AS p ON p.id = pt.product_id
            INNER JOIN zk_Tag AS t ON t.id = pt.tag_id
            SET pt.product_uuid = p.uuid, pt.tag_uuid = t.uuid;
         ');

        $this->connection->exec('
            UPDATE zk_orderitem_catalogpromotion AS oc
            INNER JOIN zk_OrderItem AS o ON o.id = oc.orderitem_id
            INNER JOIN zk_CatalogPromotion AS c ON c.id = oc.catalogpromotion_id
            SET oc.orderitem_uuid = o.uuid, oc.catalogpromotion_uuid = c.uuid;
         ');

        $this->connection->exec('
            UPDATE zk_user_userrole AS uu
            INNER JOIN zk_User AS u ON u.id = uu.user_id
            INNER JOIN zk_UserRole AS r ON r.id = uu.userrole_id
            SET uu.user_uuid = u.uuid, uu.userrole_uuid = r.uuid;
         ');

        $this->connection->exec('
            UPDATE zk_order_coupon AS oc
            INNER JOIN zk_Order AS o ON o.id = oc.order_id
            INNER JOIN zk_Coupon AS c ON c.id = oc.coupon_id
            SET oc.order_uuid = o.uuid, oc.coupon_uuid = c.uuid;
         ');
    }

    private function sqlMigration()
    {
        error_log(__METHOD__);
        $this->connection->exec("
            ALTER TABLE zk_Attribute
            DROP id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST;
        ");

        $this->connection->exec("
            ALTER TABLE zk_AttributeValue
            DROP id,
            DROP attribute_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN attribute_uuid attribute_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_Cart
            MODIFY COLUMN user_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            MODIFY COLUMN `created` INT(10) UNSIGNED NOT NULL AFTER `ip4`,
            MODIFY COLUMN `updated` INT(10) UNSIGNED NOT NULL AFTER `created`;
        ");

        $this->connection->exec("
            ALTER TABLE zk_cart_coupon
            CHANGE COLUMN coupon_id coupon_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)';
        ");

        $this->connection->exec("
            ALTER TABLE zk_cart_taxrate
            CHANGE COLUMN cart_id cart_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)',
            CHANGE COLUMN taxrate_id taxrate_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)';
        ");

        $this->connection->exec("
            ALTER TABLE zk_CartItem
            CHANGE COLUMN product_id product_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER cart_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_CartItemOptionProduct
            CHANGE COLUMN cartItem_id cartItem_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN optionProduct_id optionProduct_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER cartItem_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_CartItemOptionValue
            CHANGE COLUMN cartItem_id cartItem_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN optionValue_id optionValue_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER cartItem_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_CartItemTextOptionValue
            CHANGE COLUMN cartItem_id cartItem_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN textOption_id textOption_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER cartItem_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_CartPriceRule
            DROP id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST;
        ");

        $this->connection->exec("
            ALTER TABLE zk_CartPriceRuleDiscount
            DROP id,
            DROP product_id,
            DROP cartPriceRule_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN cartPriceRule_uuid cartPriceRule_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN product_uuid product_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER cartPriceRule_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_CartPriceRuleItem
            DROP id,
            DROP product_id,
            DROP tag_id,
            DROP cartPriceRule_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN cartPriceRule_uuid cartPriceRule_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN product_uuid product_id BINARY(16) COMMENT '(DC2Type:uuid_binary)' AFTER cartPriceRule_id,
            CHANGE COLUMN tag_uuid tag_id BINARY(16) COMMENT '(DC2Type:uuid_binary)' AFTER product_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_CatalogPromotion
            DROP id,
            DROP tag_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN tag_uuid tag_id BINARY(16) COMMENT '(DC2Type:uuid_binary)' AFTER id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_Coupon
            DROP id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST;
        ");

        $this->connection->exec("
            ALTER TABLE zk_Image
            DROP id,
            DROP product_id,
            DROP tag_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN product_uuid product_id BINARY(16) COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN tag_uuid tag_id BINARY(16) COMMENT '(DC2Type:uuid_binary)' AFTER product_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_InventoryLocation
            DROP id,
            DROP warehouse_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN warehouse_uuid warehouse_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_InventoryTransaction
            DROP id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN inventoryLocation_id inventoryLocation_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN product_id product_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER inventoryLocation_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_Option
            DROP id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST;
        ");

        $this->connection->exec("
            ALTER TABLE zk_OptionProduct
            DROP id,
            DROP option_id,
            DROP product_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN option_uuid option_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN product_uuid product_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER option_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_OptionValue
            DROP id,
            DROP option_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN option_uuid option_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_Order
            DROP id,
            DROP user_id,
            DROP taxRate_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN user_uuid user_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN taxRate_uuid taxRate_id BINARY(16) COMMENT '(DC2Type:uuid_binary)' AFTER user_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_order_coupon
            DROP order_id,
            DROP coupon_id,
            CHANGE COLUMN order_uuid order_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)',
            CHANGE COLUMN coupon_uuid coupon_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)';
        ");

        $this->connection->exec("
            ALTER TABLE zk_OrderItem
            DROP id,
            DROP product_id,
            DROP order_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN order_uuid order_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN product_uuid product_id BINARY(16) COMMENT '(DC2Type:uuid_binary)' AFTER order_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_orderitem_attachment
            CHANGE COLUMN orderitem_id orderitem_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)';
        ");

        $this->connection->exec("
            ALTER TABLE zk_orderitem_catalogpromotion
            DROP orderitem_id,
            DROP catalogpromotion_id,
            CHANGE COLUMN orderitem_uuid orderitem_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)',
            CHANGE COLUMN catalogpromotion_uuid catalogpromotion_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)';
        ");

        $this->connection->exec("
            ALTER TABLE zk_orderitem_productquantitydiscount
            CHANGE COLUMN orderitem_id orderitem_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)',
            CHANGE COLUMN productquantitydiscount_id productquantitydiscount_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)';
        ");

        $this->connection->exec("
            ALTER TABLE zk_OrderItemOptionProduct
            DROP id,
            DROP orderItem_id,
            DROP optionProduct_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN orderItem_uuid orderItem_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN optionProduct_uuid optionProduct_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER orderItem_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_OrderItemOptionValue
            DROP id,
            DROP orderItem_id,
            DROP optionValue_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN orderItem_uuid orderItem_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN optionValue_uuid optionValue_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER orderItem_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_OrderItemTextOptionValue
            DROP id,
            DROP orderItem_id,
            DROP textOption_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN orderItem_uuid orderItem_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN textOption_uuid textOption_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER orderItem_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_Payment
            DROP id,
            DROP order_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN order_uuid order_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_Product
            DROP id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST;
        ");

        $this->connection->exec("
            ALTER TABLE zk_product_tag
            DROP product_id,
            DROP tag_id,
            CHANGE COLUMN product_uuid product_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)',
            CHANGE COLUMN tag_uuid tag_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)';
        ");

        $this->connection->exec("
            ALTER TABLE zk_ProductAttribute
            DROP id,
            DROP product_id,
            DROP attribute_id,
            DROP attributeValue_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN product_uuid product_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN attribute_uuid attribute_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER product_id,
            CHANGE COLUMN attributeValue_uuid attributeValue_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER attribute_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_ProductQuantityDiscount
            DROP id,
            DROP product_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN product_uuid product_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            MODIFY COLUMN `flagApplyCatalogPromotions` TINYINT(1) NOT NULL AFTER `reducesTaxSubtotal`,
            MODIFY COLUMN `quantity` SMALLINT(5) UNSIGNED NOT NULL AFTER `name`,
            MODIFY COLUMN `created` INT(10) UNSIGNED NOT NULL AFTER `quantity`,
            MODIFY COLUMN `updated` INT(10) UNSIGNED NOT NULL AFTER `created`;
        ");

        $this->connection->exec("
            ALTER TABLE zk_Shipment
            DROP id,
            DROP order_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN order_uuid order_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_ShipmentComment
            DROP id,
            DROP shipment_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN shipment_uuid shipment_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_ShipmentItem
            DROP id,
            DROP shipment_id,
            DROP orderItem_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN shipment_uuid shipment_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN orderItem_uuid orderItem_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER shipment_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_ShipmentTracker
            DROP id,
            DROP shipment_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN shipment_uuid shipment_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            MODIFY COLUMN `created` INT(10) UNSIGNED NOT NULL AFTER `shipmentRate_deliveryMethod`,
            MODIFY COLUMN `updated` INT(10) UNSIGNED NOT NULL AFTER `created`;
        ");

        $this->connection->exec("
            ALTER TABLE zk_Tag
            DROP id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST;
        ");

        $this->connection->exec("
            ALTER TABLE zk_tag_option
            MODIFY COLUMN tag_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)',
            MODIFY COLUMN option_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)';
        ");

        $this->connection->exec("
            ALTER TABLE zk_tag_textoption
            MODIFY COLUMN tag_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)',
            MODIFY COLUMN textoption_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)';
        ");

        $this->connection->exec("
            ALTER TABLE zk_TaxRate
            DROP id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST;
        ");

        $this->connection->exec("
            ALTER TABLE zk_TextOption
            DROP id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST;
        ");

        $this->connection->exec("
            ALTER TABLE zk_User
            DROP id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST;
        ");

        $this->connection->exec("
            ALTER TABLE zk_user_userrole
            DROP user_id,
            DROP userrole_id,
            CHANGE COLUMN user_uuid user_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)',
            CHANGE COLUMN userrole_uuid userrole_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)';
        ");

        $this->connection->exec("
            ALTER TABLE zk_UserLogin
            DROP id,
            DROP user_id,
            DROP userToken_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN user_uuid user_id BINARY(16) COMMENT '(DC2Type:uuid_binary)' AFTER id,
            CHANGE COLUMN userToken_uuid userToken_id BINARY(16) COMMENT '(DC2Type:uuid_binary)' AFTER user_id;
        ");

        $this->connection->exec("
            ALTER TABLE zk_UserRole
            DROP id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST;
        ");

        $this->connection->exec("
            ALTER TABLE zk_UserToken
            DROP id,
            DROP user_id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST,
            CHANGE COLUMN user_uuid user_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' AFTER id,
            MODIFY COLUMN `created` INT(10) UNSIGNED NOT NULL AFTER `ip4`,
            MODIFY COLUMN `updated` INT(10) UNSIGNED NOT NULL AFTER `created`;
        ");

        $this->connection->exec("
            ALTER TABLE zk_Warehouse
            DROP id,
            CHANGE COLUMN uuid id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid_binary)' FIRST;
        ");
    }

    private function updateSchema()
    {
        error_log(__METHOD__);
        $cmd = 'cd ' . realpath(__DIR__ . '/../../..') . '; vendor/bin/doctrine orm:schema-tool:update --dump-sql --force';
        shell_exec($cmd);

//        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->entityManager);
//        $tool->updateSchema($this->entityManager->getMetaDataFactory()->getAllMetaData());
    }
}
