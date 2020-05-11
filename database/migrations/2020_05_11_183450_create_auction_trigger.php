<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER `change_status` BEFORE UPDATE ON `auctions`
            FOR EACH ROW BEGIN
                IF NEW.finished_at IS NOT NULL THEN
                    SET NEW.status = "dismissed";
                ELSE
                    SET NEW.status = "active";
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `change_status`');
    }
}
