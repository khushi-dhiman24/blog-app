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
        Schema::create('new_businesses', function (Blueprint $table) {
            $table->id();
            $table->integer('plan_id')->nullable();
            $table->integer('sales_id')->nullable();
            $table->integer('admin_id')->nullable();
            $table->string('designation')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('shop_name');
            $table->string('owner_email')->nullable();
            $table->text('address')->nullable();
            $table->string('area')->nullable();
            $table->string('alternate_phone_number')->nullable();
            $table->string('alternate_phone_number_2')->nullable();
            $table->string('alternate_email')->nullable();
            $table->string('alternate_email_2')->nullable();
            $table->string('ownership')->nullable();
            $table->string('google_business_url')->nullable();
            $table->string('lat_long')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->boolean('show_likeme_questions')->default(false);
            $table->string('pinterest')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('youtube')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->text('embed_map')->nullable();
            $table->string('landmark')->nullable();
            $table->string('pincode')->nullable();
            $table->unsignedBigInteger('city')->nullable();
            $table->unsignedBigInteger('state')->nullable();
            $table->text('multiple_state')->nullable();
            $table->text('multiple_city')->nullable();
            $table->string('business_type')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('established')->nullable();
            $table->string('photo1')->nullable();
            $table->string('photo2')->nullable();
            $table->text('gallery')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('landline')->nullable();
            $table->string('whatsapp_no')->nullable();
            $table->string('land_line_number')->nullable();
            $table->string('gst_number')->nullable();
            $table->string('google_review_link')->nullable();
            $table->text('product_details')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->date('date_renewal')->nullable();
            $table->string('status_payment')->nullable();
            $table->string('status')->nullable();
            $table->string('video_link')->nullable();
            $table->boolean('banner_status')->default(false);
            $table->string('theme')->nullable();
            $table->string('theme_color')->nullable();
            $table->text('subcategories')->nullable();
            $table->text('category_id')->nullable();
            $table->string('website_link')->nullable();
            $table->boolean('free_listing')->default(false);
            $table->string('emergency_1')->nullable();
            $table->string('emergency_2')->nullable();
            $table->string('api_token')->nullable();
            $table->integer('likes')->default(0);
            $table->string('webpage_link')->nullable();
            $table->string('news_topic')->nullable();
            $table->string('password')->nullable();
            $table->string('remember_token')->nullable();
            $table->boolean('app_installed')->default(false);
            $table->string('pan')->nullable();
            $table->string('cin')->nullable();
            $table->string('tan')->nullable();
            $table->string('iec')->nullable();
            $table->text('keyword')->nullable();
            $table->string('annual_turnover')->nullable();
            $table->string('no_of_employee')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->decimal('rating_value', 3, 2)->nullable();
            $table->integer('rating_count')->default(0);
            $table->boolean('claimed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('new_businesses');
    }
};