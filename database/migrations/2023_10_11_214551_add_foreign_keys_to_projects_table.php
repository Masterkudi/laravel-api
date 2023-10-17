<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // prima key: user_id
            // creo una colonna di tipo unsignedBigInteger
            $table->unsignedBigInteger('user_id')->nullable();

            // rendo la colonna user_id in una foreign key
            $table->foreign('user_id')
                // che fa riferimento alla colonna id della tabella users
                ->references('id')
                ->on("users")
                // se l'utente viene cancellato, cancella anche i suoi post
                ->onDelete('set null');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            //
        });
    }
};
