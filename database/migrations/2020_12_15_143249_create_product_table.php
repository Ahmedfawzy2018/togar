<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string( 'name' );
            $table->double( 'price' );
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('quantity_available')->default(1);
            $table->enum( 'in_stock', ['0','1'] )->default('1');
            $table->enum( 'status',['active','inactive'] )->default('active');
            $table->timestamps();
            $table->softDeletes();

            } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product');
    }
}
