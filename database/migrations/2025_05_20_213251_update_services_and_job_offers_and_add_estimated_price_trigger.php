<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->decimal('price', 10, 2)->after('description')->nullable();
        });

        DB::statement('ALTER TABLE job_offers ALTER COLUMN offer_price TYPE NUMERIC(10,2) USING offer_price::NUMERIC');

        DB::unprepared('
            CREATE OR REPLACE FUNCTION calculate_estimated_price()
            RETURNS TRIGGER AS $$
            BEGIN
                IF NEW.area IS NOT NULL THEN
                    SELECT s.price INTO STRICT NEW.estimated_price
                    FROM services s
                    WHERE s.id = NEW.service_id;

                    NEW.estimated_price := NEW.area * COALESCE(NEW.estimated_price, 0);
                END IF;
                RETURN NEW;
            END;
            $$ LANGUAGE plpgsql;
        ');

        DB::unprepared('
            CREATE TRIGGER trigger_estimate_price
            BEFORE INSERT OR UPDATE ON service_requests
            FOR EACH ROW
            EXECUTE FUNCTION calculate_estimated_price();
        ');
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('price');
        });

        DB::statement('ALTER TABLE job_offers ALTER COLUMN offer_price TYPE VARCHAR(255)');

        DB::unprepared('DROP TRIGGER IF EXISTS trigger_estimate_price ON service_requests');
        DB::unprepared('DROP FUNCTION IF EXISTS calculate_estimated_price');
    }
};
