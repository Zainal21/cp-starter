<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->foreignUuid('category_id')->constrained('categories')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignUuid('author')->constrained('users')->onUpdate('restrict')->onDelete('restrict');
            $table->string('thumbnail');
            $table->text('content');
            $table->string('slug');
            $table->string('tags');
            $table->enum('status', ['draft', 'publish', 'archive'])->default('draft');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
