<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class new_businesses extends Model
{
    
    protected $table ='new_businesses';

    protected $primaryKey='id';
    protected $timestamped = true;
    protected $increment='true';
   
    protected $fillable =[
        'plan_id',
        'sales_id',
        'admin_id',
        'designation',
        'owner_name',
        'shop_name',
        'owner_email',
        'address',
        'area',
        'alternate_phone_number',
        'alternate_email',
        'alternate_email_2',
        'alternate_phone_number',
        'ownership',
        'google_business_url',
        'lat_long',
        'latitude',
        'longitude',
        'show_likeme_questions',
        'pinterest',
        'linkedin',
        'twitter',
        'youtube',
        'facebook',
        'instagram',
        'embed_map',
        'landmark',
        'pincode',
        'city',
        'state',
        'multiple_state',
        'multiple_city',
        'business_type',
        'payment_mode',
        'established',
        'photo1',
        'photo2',
        'gallery',
        'phone_number',
        'landline',
        'whatsapp_no',
        'land_line_number',
        'gst_number',
        'google_review_link',
        'product_details',
        'description',
        'price',
        'date_renewal',
        'status_payment',
        'status',
        'video_link',
        'banner_status',
        'theme',
        'theme_color',
        'subcategories',
        'category_id',
        'website_link',
        'free_listing',
        'emergency_2',
        'emergency_1',
        'api_token',
        'likes',
        'webpage_link',
        'news_topic',
        'password',
        'remember_token',
        'app_installed',
        'pan',
        'cin',
        'tan',
        'iec',
        'keyword',
        'annual_turnover',
        'no_of_employee',
        'meta_title',
        'meta_description',
        'rating_value',
        'rating_count',
        'claimed',



    ];
}
