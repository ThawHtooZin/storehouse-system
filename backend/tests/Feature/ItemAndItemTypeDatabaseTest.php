<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemAndItemTypeDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_item_type_and_linked_item_can_be_created(): void
    {
        $itemType = ItemType::create([
            'name' => 'Electronics',
            'description' => 'Electronic components and devices',
        ]);

        $item = Item::create([
            'item_type_id' => $itemType->id,
            'sku' => 'ELEC-001',
            'name' => 'USB-C Cable',
            'current_quantity' => 50,
            'min_stock_level' => 10,
        ]);

        $this->assertDatabaseHas('item_types', [
            'id' => $itemType->id,
            'name' => 'Electronics',
            'description' => 'Electronic components and devices',
        ]);

        $this->assertDatabaseHas('items', [
            'id' => $item->id,
            'item_type_id' => $itemType->id,
            'sku' => 'ELEC-001',
            'name' => 'USB-C Cable',
            'current_quantity' => 50,
            'min_stock_level' => 10,
        ]);

        $this->assertTrue($item->itemType->is($itemType));
        $this->assertTrue($itemType->items->contains($item));
    }

    public function test_duplicate_sku_is_rejected(): void
    {
        $itemType = ItemType::create([
            'name' => 'Hardware',
            'description' => null,
        ]);

        Item::create([
            'item_type_id' => $itemType->id,
            'sku' => 'HW-100',
            'name' => 'Hammer',
        ]);

        $this->expectException(QueryException::class);

        Item::create([
            'item_type_id' => $itemType->id,
            'sku' => 'HW-100',
            'name' => 'Duplicate Hammer',
        ]);
    }

    public function test_item_type_with_items_cannot_be_deleted(): void
    {
        $itemType = ItemType::create([
            'name' => 'Office Supplies',
            'description' => 'Stationery and consumables',
        ]);

        Item::create([
            'item_type_id' => $itemType->id,
            'sku' => 'OFF-001',
            'name' => 'A4 Paper Ream',
        ]);

        $this->expectException(QueryException::class);

        $itemType->delete();
    }

    public function test_item_type_without_items_can_be_deleted(): void
    {
        $itemType = ItemType::create([
            'name' => 'Empty Category',
            'description' => null,
        ]);

        $itemType->delete();

        $this->assertDatabaseMissing('item_types', [
            'id' => $itemType->id,
        ]);
    }
}
