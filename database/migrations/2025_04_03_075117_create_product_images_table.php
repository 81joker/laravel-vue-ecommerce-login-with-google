<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('product_images')) {

        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('path', 255);
            $table->string('url', 255);
            $table->string('mime', 55);
            $table->integer('size');
            $table->integer('position')->nullable();
            $table->timestamps();
        });
    }

    DB::table('products')
    ->chunkById(100, function ($products) {
        $mapped = $products->map(function ($p) {
            return [
                'product_id' => $p->id,
                'path' => '',
                'url' => $p->image,
                'mime' => $p->image_mime ?:  $p->image,
                'size' => $p->image_size? $p->image_size : 0,
                'position' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        });

        // Insert into product_images table
        DB::table('product_images')->insert($mapped->toArray());
    });


        // Schema::table('products', function (Blueprint $table) {
        //     $table->dropColumn('image');
        //     $table->dropColumn('image_mime');
        //     $table->dropColumn('image_size');
        // });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('image', 2000)->nullable()->after('slug');
            $table->string('image_mime')->nullable()->after('image');
            $table->integer('image_size')->nullable()->after('image_mime');
        });

        DB::table('products')
            ->select('id')
            ->chunkById(100, function (Collection $products) {
                foreach ($products as $product) {
                    $image = DB::table('product_images')
                        ->select(['product_id', 'url', 'mime', 'size'])
                        ->where('product_id', $product->id)
                        ->first();
                    if ($image) {
                        DB::table('products')
                            ->where('id', $image->product_id)
                            ->update([
                                'image' => $image->url,
                                'image_mime' => $image->mime,
                                'image_size' => $image->size
                            ]);
                    }
                }
            });

        Schema::dropIfExists('product_images');
    }
};
