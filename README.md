**File:** `README.md`
```markdown
# ticketry.

A Laravel-based event ticketing platform connecting organizers and visitors.

---

## Features

### Organizer
- Create event proposals with multiple ticket types
- Upload venue permits and event plans
- Upload event banner images
- Real-time location availability checking
- Sales dashboard with revenue breakdown
- Monthly income reports
- Banking information management (bank code, account number)
- Profile with logo, Instagram, LinkedIn, and category
- Pay admin fee to activate event (Rp 25.000)

### Visitor
- Browse events with search and filters
- Filter by category, city, and Offline/Online
- Discover organizers and view their profiles
- Purchase tickets (max 4 per order)
- Free tickets skip payment, paid tickets via virtual account
- Download PDF tickets with QR codes
- Order history with status tracking (Pending, Paid, Expired, Cancelled)
- Edit profile with photo upload

### Admin
- Review proposals with 6-item checklist system
- Approve/reject with reviewer tracking
- Monthly reports with PDF download
- User management with ban/unban system
- View organizer logos and visitor photos
- Location management (CRUD)
- Admin management (create/delete other admins)
- Event banner review in proposals
- Duplicate prevention for locations and admins
- RBAC via Spatie Laravel Permission

---

## Tech Stack

- **Backend:** Laravel 13, PHP 8.3
- **Database:** PostgreSQL
- **Frontend:** Bootstrap 5, JavaScript
- **PDF:** barryvdh/laravel-dompdf
- **RBAC:** spatie/laravel-permission

---

## Installation

1. Clone the repository
```bash
git clone https://github.com/sakh9/ticketry.git
cd ticketry
```

2. Install dependencies
```bash
composer install
```

3. Copy environment file
```bash
cp .env.example .env
```

4. Configure your database in `.env`
```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=ticketryDB
DB_USERNAME=postgres
DB_PASSWORD=your_password
```

5. Generate application key
```bash
php artisan key:generate
```

6. Run migrations and seeders
```bash
php artisan migrate --seed
```

7. Assign roles to users
```bash
php artisan ticketry:assign-roles
```

8. Create storage link
```bash
php artisan storage:link
```

9. Start the server
```bash
php artisan serve
```

10. Access at `http://127.0.0.1:8000`

---

## Database Triggers

Run these in your PostgreSQL tool (pgAdmin, Supabase SQL Editor):

### Trigger 1: Auto-update order on payment
```sql
CREATE OR REPLACE FUNCTION update_order_on_payment()
RETURNS TRIGGER AS $$
DECLARE
    item_record RECORD;
BEGIN
    IF NEW.status = 'paid' AND OLD.status = 'pending' THEN
        NEW.transaction_date = NOW();
        NEW.reserved_at = NULL;
        NEW.reservation_expires_at = NULL;
        
        FOR item_record IN 
            SELECT id_ticket_type, COUNT(*) as qty
            FROM order_items 
            WHERE id_order = NEW.id_order 
            GROUP BY id_ticket_type
        LOOP
            UPDATE ticket_types 
            SET reserved_count = GREATEST(reserved_count - item_record.qty, 0),
                sold_count = sold_count + item_record.qty,
                version = version + 1
            WHERE id_ticket_type = item_record.id_ticket_type;
        END LOOP;
        
        UPDATE order_items 
        SET qr_code_data = CONCAT(
            'TICKET:', ticket_code,
            '|ORDER:', NEW.id_order::text,
            '|DATE:', TO_CHAR(NOW(), 'YYYYMMDDHH24MISS')
        )
        WHERE id_order = NEW.id_order;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_order_payment
    BEFORE UPDATE OF status ON orders
    FOR EACH ROW
    EXECUTE FUNCTION update_order_on_payment();
```

### Trigger 2: Update event on review
```sql
CREATE OR REPLACE FUNCTION update_event_on_review()
RETURNS TRIGGER AS $$
BEGIN
    IF NEW.status = 'approved' AND OLD.status = 'pending' THEN
        NEW.rejection_reason = NULL;
        NEW.fee_status = 'unpaid';
        NEW.admin_fee = 25000;
    END IF;
    IF NEW.status = 'rejected' AND OLD.status = 'pending' THEN
        NEW.ticket_access = FALSE;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_event_review
    BEFORE UPDATE OF status ON events
    FOR EACH ROW
    EXECUTE FUNCTION update_event_on_review();
```

### Trigger 3: Auto-expire pending orders
```sql
CREATE OR REPLACE FUNCTION expire_pending_orders()
RETURNS TRIGGER AS $$
DECLARE
    item_record RECORD;
BEGIN
    IF NEW.status = 'expired' AND OLD.status = 'pending' THEN
        FOR item_record IN 
            SELECT id_ticket_type, COUNT(*) as qty
            FROM order_items 
            WHERE id_order = NEW.id_order 
            GROUP BY id_ticket_type
        LOOP
            UPDATE ticket_types 
            SET reserved_count = GREATEST(reserved_count - item_record.qty, 0),
                sold_count = GREATEST(sold_count - item_record.qty, 0),
                version = version + 1
            WHERE id_ticket_type = item_record.id_ticket_type;
        END LOOP;
        NEW.reserved_at = NULL;
        NEW.reservation_expires_at = NULL;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_order_expire
    BEFORE UPDATE OF status ON orders
    FOR EACH ROW
    WHEN (NEW.status = 'expired' AND OLD.status = 'pending')
    EXECUTE FUNCTION expire_pending_orders();
```

### Trigger 4: Cancel order (release tickets)
```sql
CREATE OR REPLACE FUNCTION cancel_order_release_tickets()
RETURNS TRIGGER AS $$
DECLARE
    item_record RECORD;
BEGIN
    IF NEW.status = 'cancelled' AND OLD.status = 'pending' THEN
        FOR item_record IN 
            SELECT id_ticket_type, COUNT(*) as qty
            FROM order_items 
            WHERE id_order = NEW.id_order 
            GROUP BY id_ticket_type
        LOOP
            UPDATE ticket_types 
            SET reserved_count = GREATEST(reserved_count - item_record.qty, 0),
                sold_count = GREATEST(sold_count - item_record.qty, 0),
                version = version + 1
            WHERE id_ticket_type = item_record.id_ticket_type;
        END LOOP;
        NEW.reserved_at = NULL;
        NEW.reservation_expires_at = NULL;
    END IF;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER trigger_order_cancel
    BEFORE UPDATE OF status ON orders
    FOR EACH ROW
    WHEN (NEW.status = 'cancelled' AND OLD.status = 'pending')
    EXECUTE FUNCTION cancel_order_release_tickets();
```

---

## Scheduled Tasks

Run the scheduler for auto-closing past events:
```bash
php artisan schedule:run
```

Or add to crontab:
```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

---

## Commands

| Command | Description |
|---------|-------------|
| `php artisan events:close-past` | Close events past end time |
| `php artisan tickets:release-expired` | Release expired reservations |
| `php artisan ticketry:assign-roles` | Assign roles to all users |
| `php artisan ticketry:create-admin` | Create new admin via CLI |

---

## Deployment

Deployed on Railway: [ticketry-production.up.railway.app](https://ticketry-production.up.railway.app)

---

## Future Plans

- Event Cancellation
- Xendit Payment Integration
- Refund System
- NIK Detection (OCR)
- File/Permit Detection Scanner

---

## License

This project is for educational purposes.
```
