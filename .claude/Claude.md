# System Context: Storehouse Management System

## Tech Stack Architecture

- **Monorepo Root**: `/`
- **Backend Service**: Laravel 11 API (`/backend`)
- **Frontend Application**: React via Vite (`/frontend`)
- **Database Engine**: MySQL (Relational)

## Core Database Entities & Schema Rules

You must strictly maintain the integrity of these 6 core entities:

1. **ItemType**: `id`, `name`, `description`, `timestamps`
2. **Item**: `id`, `item_type_id` (FK), `sku`, `name`, `current_quantity`, `min_stock_level`, `timestamps`
3. **Client**: `id`, `company_name`, `contact_name`, `email`, `phone`, `type` (Enum: Vendor/Buyer), `timestamps`
4. **Staff**: `id`, `name`, `email`, `role` (Enum: Admin, Manager, Warehouse), `timestamps`
5. **InboundLog**: `id`, `item_id` (FK), `client_id` (FK: Vendor), `quantity_received`, `received_by_staff_id` (FK), `received_at`
6. **OutboundLog**: `id`, `item_id` (FK), `client_id` (FK: Buyer), `quantity_shipped`, `shipped_by_staff_id` (FK), `shipped_at`

## Architectural Constraints (Senior Guardrails)

- **Database Logic**: Follow legacy relational structures. Write raw SQL or clean Eloquent operations; do NOT use complex dynamic abstract extensions unless explicitly asked.
- **API Standards**: All responses from Laravel must return unified JSON structures: `{ "success": boolean, "data": array|object, "message": string }`.
- **UI Architecture**: React components must be functional components utilizing standard hooks. Keep UI layouts completely isolated from API logic.
- [cite_start]**Communication Style**: Always respond in simple English, short and to the point.
