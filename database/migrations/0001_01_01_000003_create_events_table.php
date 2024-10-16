<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id()->autoIncrement()->unique();
            $table->string('name');
            $table->longText('description')->nullable();
            $table->integer('qty');
            $table->integer('available_qty');
            $table->datetime('date_from');
            $table->datetime('date_until')->nullable();
            $table->timestamps();
        });

        DB::table('events')->insert(
            array(
                [
                    'name' => 'Test Event',
                    'description' => 'Test Event Description',
                    'qty' => 10,
                    'available_qty' => 10,
                    'date_from' => Carbon::create(2024,10,10),
                    'date_until' => Carbon::create(2024,10,23),
                ]
            )
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
