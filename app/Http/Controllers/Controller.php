<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use App\Models\Business;
use App\Models\Cities;
use App\Models\States;
use App\Models\SubSubCategory;
use App\Models\SubCategory;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Otp;
use App\Models\Business_banner;
use App\Models\AdvertismentBanner;
use App\Models\LastSearches;
use Jenssegers\Agent\Agent;
use Carbon\Carbon;



abstract class Controller
{
    protected function cat_return($category_id)
    {
        return (string) $category_id;
    }

    protected function sub_cat_return($sub_cat_id)
    {
        return (string) $sub_cat_id;
    }

    protected function isBotDetected()
    {
        return false;
    }

    protected function distance($lat1, $lon1, $lat2, $lon2, $unit = "K")
    {
        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos(min(1, max(-1, $dist)));
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        if ($unit == "K") {
            return ($miles * 1.609344);
        } elseif ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

    protected function sanitizeForUrl($value)
    {
        $value = preg_replace(['/\s+/', '/ \+ /', '/--+/', '/\\/+/', '/\*+/', '/\.+/'], ['-', '-', '-', '-', '-', '-'], $value);
        $value = str_replace(["'"], '-', $value);
        $value = preg_replace('/-+/', '-', $value);
        return strtolower(trim($value, '-'));
    }

    protected function generate_bus_id($id)
    {
        return (string) $id;
    }

    protected function findClosestCity($city)
    {
        return (object)["getData" => function () use ($city) {
            return (object)["closest_city" => $city];
        }];
    }

    public function index(Request $request)
    {
        $agent = new Agent();
        $currentUrl = $request->url();
        $city = $request->city;
        $search = $request->search_content ?? $request->search ?? '';
        $id = $request->id;


        if (str_contains($currentUrl, '/public/')) {
            return redirect(strtolower(str_replace('public/', '', $currentUrl)), 301);
        }

        if ((preg_match('/[A-Z]/', $currentUrl) || str_contains($currentUrl, "'") || str_contains($currentUrl, ',') || str_contains($currentUrl, '--') || str_contains($currentUrl, '&')) && !str_contains($request->fullurl(), '?')) {
            $clean = str_replace(["'", ',', '--', '&'], ['-', '-', '-', '-'], $currentUrl);
            return redirect(strtolower($clean), 301);
        }

        if (str_contains($city, ' - ')) {
            $city = explode(' - ', $city)[0];
        }

        $current_lat = 0;
        $current_long = 0;

        $cat_id = substr($id, 0, 3) ?: '000';
        $sub_cat_id = substr($id, 3) ?: '00000';

        if (strlen($id) !== 8) {
            if (in_array(strlen($id), [6, 7])) {
                $sub_id_len = strlen($id) - 3;
                $sub_cat_id_extracted = substr($id, 3, $sub_id_len);
                $sub_cat_data = SubCategory::select('id','name','category_id','meta_tag','meta_description')->find($sub_cat_id_extracted);
                if (!$sub_cat_data) abort(404);
                $slug = $this->sanitizeForUrl($sub_cat_data->name);
                $cat_id = $this->cat_return($sub_cat_data->category_id);
                $sub_cat_id = $this->sub_cat_return($sub_cat_data->id);
                return redirect(url($city . '/' . $slug . '/lmid-' . $cat_id . $sub_cat_id), 301);
            }


            $search = str_replace('-', ' ', $search);
            $search_array = explode(' in ', $search);

            if (isset($search_array[1])) {
                $sub_cat_name = $search_array[0];
                $sub_cat_data = SubCategory::where('name', $sub_cat_name)->select('id','name','category_id','meta_tag','meta_description')->first();
                if (!$sub_cat_data) abort(404);
                $cat_id = $this->cat_return($sub_cat_data->category_id);
                $sub_cat_id = $this->sub_cat_return($sub_cat_data->id);
                return redirect(url($city . '/' . $request->search_content . '/lmid-' . $cat_id . $sub_cat_id), 301);
            }

            if (isset($search_array[0])) {
                $cat_name = $search_array[0];
                $cat_data = Category::where('name', $cat_name)->select('name','id','meta_name','meta_title')->first();
                if (!$cat_data) abort(404);
                $cat_id = $this->cat_return($cat_data->id);
                return redirect(url($city . '/' . $request->search_content . '/lmid-' . $cat_id . '00000'), 301);
            }

            abort(404);
        }

        $sub_cat_data = SubCategory::with('category')->find($sub_cat_id);
        $cat_data = $sub_cat_data ? $sub_cat_data->category : Category::find($cat_id);

        if ($sub_cat_data && $sub_cat_data->category_id != $cat_data->id) {
            $cat_id = $sub_cat_data->category_id;
            $slug = $this->sanitizeForUrl($sub_cat_data->slug ?? $sub_cat_data->name);
            return redirect(url($city . '/' . $request->search_content . '/lmid-' . $cat_id . $sub_cat_id), 301);
        }

        if (!isset($cat_data->id)) {
            $search = str_replace('-', ' ', $search);
            $search_array = explode(' in ', $search);
            if (isset($search_array[1])) {
                $sub_cat_name = $search_array[0];
                $sub_cat_data = SubCategory::where('name', $sub_cat_name)->select('id','name','category_id','meta_tag','meta_description')->first();
                if (!$sub_cat_data) abort(404);
                $cat_id = $this->cat_return($sub_cat_data->category_id);
                $sub_cat_id = $this->sub_cat_return($sub_cat_data->id);
                return redirect(url($city . '/' . $request->search_content . '/lmid-' . $cat_id . $sub_cat_id), 301);
            } elseif (isset($search_array[0])) {
                $cat_name = $search_array[0];
                $cat_data = Category::where('name', $cat_name)->select('name','id','meta_name','meta_title')->first();
                if (!$cat_data) abort(404);
                $cat_id = $this->cat_return($cat_data->id);
                return redirect(url($city . '/' . $request->search_content . '/lmid-' . $cat_id . '00000'), 301);
            }
            abort(404);
        }

        $search = str_replace('&amp;', '&', $search);
        $search_city_array = explode('-in-', $search);
        if (count($search_city_array) == 4) $city = $search_city_array[2];

        $yamunanagar_array = ["Yamunanagar", "YamunaNagar", "Yamuna Nagar", 'yamunanagar', 'yamuna nagar', 'yamuna Nagar'];
        if (in_array($city, $yamunanagar_array)) $city = 'Yamunanagar';

        $page = $request->page ?? 0;
        $limit = 4; 
        $skip = max(0, $page * $limit);

        if (!empty($_COOKIE['latitude'])) {
            $current_lat = $_COOKIE['latitude'];
            $current_long = $_COOKIE['longitude'];
        } else {
            $current_lat = $request->lat ?? 0;
            $current_long = $request->long ?? 0;
        }

        $cityKey = 'city_by_name_' . strtolower($city);
        $lat_long_db = Cache::remember($cityKey, 60 * 60, function () use ($city) {
            return Cities::where('name', 'LIKE', "$city %")->first();
        });

        $state = null;
        if (isset($_COOKIE['CUR_CITY']) && str_contains($_COOKIE['CUR_CITY'], ucfirst($city))) {
            $ssas = $_COOKIE['CUR_CITY'];
            $lat_long_db = Cities::where('name', 'LIKE', "$ssas%")->first();
            $state = explode(' - ', $ssas)[1] ?? null;
        } elseif ($lat_long_db) {
            $azx = explode(' - ', $lat_long_db->name);
            $state = $azx[1] ?? null;
        } else {
            $cityObj = $this->findClosestCity($city);
            $name = $cityObj->getData()->closest_city;
            $city = explode(' - ', $name)[0];
            $lat_long_db = Cities::where('name', 'LIKE', "$city %")->first();
            if ($lat_long_db) $state = explode(' - ', $lat_long_db->name)[1] ?? null;
        }

        if ($lat_long_db && isset($lat_long_db->lat)) {
            $selected_city_lat = trim(str_replace(' ', '', $lat_long_db->lat));
            $selected_city_long = trim(str_replace(' ', '', $lat_long_db->longi));
            $dis = $this->distance($current_lat, $current_long, $selected_city_lat, $selected_city_long, 'K');
            if ($dis > 10) {
                $lat = $selected_city_lat;
                $long = $selected_city_long;
            } else {
                $lat = $current_lat;
                $long = $current_long;
            }
        }

        $lat = $lat ?? '28.7041';
        $long = $long ?? '77.1025';
        $customer_name = Auth::guard('customer')->check() ? Auth::guard('customer')->user()->name : '';
        $customer_number = Auth::guard('customer')->check() ? Auth::guard('customer')->user()->phone : '';

        if (!isset($request->page)) {
            LastSearches::create([
                'search' => $search,
                'name' => $customer_name,
                'phone_number' => $customer_number,
                'lat' => $lat,
                'longi' => $long,
                'city' => $city,
                'cat_id' => $cat_id,
                'sub_cat_id' => $sub_cat_id,
                'state' => $state,
                'agent' => request()->header('User-Agent'),
                'ip' => $request->ip(),
                'bot_type' => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'bot' => $this->isBotDetected(),
                'link' => $request->url(),
                'device_type' => $agent->isMobile() ? 0 : 1,
            ]);
        }

        $lat_long_query = "111.111 * DEGREES(ACOS(LEAST(1.0, COS(RADIANS(SUBSTRING_INDEX(lat_long, ',', 1))) * COS(RADIANS($lat)) * COS(RADIANS(SUBSTRING_INDEX(SUBSTRING_INDEX(lat_long,',', 2), ',',-1) - $long)) + SIN(RADIANS(SUBSTRING_INDEX(lat_long, ',', 1))) * SIN(RADIANS($lat)))))";

        if (isset($sub_cat_data)) {
            $meta_title = $sub_cat_data->meta_tag;
            $meta_tags = $sub_cat_data->meta_description;
        } else {
            $meta_tags = $cat_data->meta_name ?? '';
            $meta_title = $cat_data->meta_title ?? '';
        }

        $check_bs = false;
        $business_by_name = collect();
        if ((isset($request->search) && str_contains($request->search, ' in ') && !isset($request->page)) || (isset($request->search) && !isset($request->page))) {
            $business_by_name = Business::with('city')
                ->where('shop_name', 'LIKE', "%$request->search%")
                ->skip($skip)->take($limit)
                ->get();
            if ($business_by_name->isNotEmpty()) $check_bs = true;
        }

        if ((isset($request->bname) && is_numeric($request->bname) && strlen($request->bname) != 10 && !isset($request->page))) {
            abort(404);
        }

        if (isset($request->bname) && is_numeric($request->bname) && strlen($request->bname) == 10 && !isset($request->page)) {
            $business_by_name = Business::leftJoin('cities', 'cities.id', 'new_businesses.city')
                ->select('new_businesses.*', 'cities.name as city')
                ->where('phone_number', $request->bname)
                ->orWhere('alternate_phone_number', $request->bname)
                ->orWhere('alternate_phone_number_2', $request->bname)
                ->skip($skip)->take($limit)
                ->get();
            if ($business_by_name->isNotEmpty()) {
                Session::put('searched_business_id', $business_by_name->first()->id);
                $check_bs = true;
            }
        } elseif (isset($request->bname) && str_contains($request->bname, ' in ') && !isset($request->page)) {
            $parts = explode(' in ', $request->bname);
            $city_m = $parts[1] ?? null;
            $cityObj = Cities::where('name', 'LIKE', $city_m)->first();
            if ($cityObj) {
                $business_by_name = Business::leftJoin('cities', 'cities.id', 'new_businesses.city')
                    ->select('new_businesses.*', 'cities.name as city')
                    ->where('shop_name', 'LIKE', "%" . $parts[0] . "%")
                    ->where('new_businesses.city', $cityObj->id)
                    ->skip($skip)->take($limit)
                    ->get();
                if ($business_by_name->isNotEmpty()) {
                    Session::put('searched_business_id', $business_by_name->first()->id);
                    $check_bs = true;
                }
            }
        } elseif (isset($request->bname) && !isset($request->page)) {
            $business_by_name = Business::leftJoin('cities', 'cities.id', 'new_businesses.city')
                ->select('new_businesses.*', 'cities.name as city')
                ->where('shop_name', 'LIKE', "%" . $request->bname . "%")
                ->skip($skip)->take($limit)
                ->get();
            if ($business_by_name->isNotEmpty()) {
                Session::put('searched_business_id', $business_by_name->first()->id);
                $check_bs = true;
            }
        }
        $searched_cat_id = ltrim($this->cat_return($cat_id), '0');
        $searched_sub_cat_id = ltrim($this->sub_cat_return($sub_cat_id), '0');
        $radiusKm = 50;
        $latDiff = $radiusKm / 110.574;
        $lonDiff = $radiusKm / (111.320 * cos(deg2rad($lat)));

        $minLat = $lat - $latDiff; $maxLat = $lat + $latDiff;
        $minLon = $long - $lonDiff; $maxLon = $long + $lonDiff;
        $baseBusinessQuery = Business::select(
    'new_businesses.id','new_businesses.plan_id','new_businesses.owner_name','new_businesses.shop_name',
    'new_businesses.owner_email','new_businesses.address','new_businesses.area','new_businesses.lat_long','new_businesses.landmark',
    'new_businesses.pincode','new_businesses.city','new_businesses.state','new_businesses.business_type','new_businesses.established',
    'new_businesses.photo1','new_businesses.photo2','new_businesses.phone_number','new_businesses.whatsapp_no','new_businesses.rating_count',
    'new_businesses.subcategories','new_businesses.category_id','new_businesses.rating_value','cities.name as city', 'states.name as state'
    )
    ->whereBetween(DB::raw("CAST(SUBSTRING_INDEX(lat_long, ',', 1) AS DECIMAL(10,6))"), [$minLat, $maxLat])
    ->whereBetween(DB::raw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(lat_long, ',', 2), ',', -1) AS DECIMAL(10,6))"), [$minLon, $maxLon])
    ->where(function ($q) use ($searched_cat_id, $searched_sub_cat_id) {
    $q->whereRaw("FIND_IN_SET(?, category_id)", [$searched_cat_id])
      ->orWhereRaw("FIND_IN_SET(?, subcategories)", [$searched_sub_cat_id]);
    })
    ->orderByRaw('FIELD(plan_id, 8, 7, 6, 5, 13)')
    ->orderBy('distance', 'asc');

        if ($searched_sub_cat_id != 0) {
            $baseBusinessQuery->orderByRaw("CASE WHEN plan_id = 13 AND FIND_IN_SET(?, subcategories) AND $lat_long_query < 5 THEN 1 ELSE 2 END ASC", [$searched_sub_cat_id]);
        }

        if (Session::has('searched_business_id')) {
            $baseBusinessQuery->where('new_businesses.id', '!=', Session::get('searched_business_id'));
        }

        $businessCollection = $baseBusinessQuery->skip($skip)->limit($limit)->get()->toArray();

        $plan13Businesses = array_filter($businessCollection, fn($i) => $i['plan_id'] == 13);
        $otherBusinesses = array_filter($businessCollection, fn($i) => $i['plan_id'] != 13);
        if (!empty($plan13Businesses)) shuffle($plan13Businesses);
        $businessFinal = array_merge($otherBusinesses, $plan13Businesses);

        if ($check_bs && $business_by_name->isNotEmpty()) {
            $businessFinal = array_merge($business_by_name->toArray(), $businessFinal);
        }

        $busIds = array_column($businessFinal, 'id');
        $banners = Business_banner::whereIn('business_id', $busIds)->whereNotNull('photo')->get()->groupBy('business_id');
        $otpCounts = Otp::whereIn('phone_number', array_column($businessFinal, 'phone_number'))->select('phone_number', DB::raw('count(*) as cnt'))->groupBy('phone_number')->get()->pluck('cnt', 'phone_number')->toArray();

        $allSubIds = [];
        foreach ($businessFinal as $b) {
            $subcats = array_filter(explode(',', $b['subcategories']));
            foreach ($subcats as $s) $allSubIds[] = $s;
        }
        $allSubIds = array_unique($allSubIds);
        $subcatModels = SubCategory::whereIn('id', $allSubIds)->select('id','name')->get()->keyBy('id');

        $plan_ids = [5,6,7,8,13];
        $fetch_all_plans = Plan::whereIn('id', $plan_ids)->get()->keyBy('id');

        $processed = [];
        foreach ($businessFinal as $bus) {
            $bus['rating_stars'] = $this->buildRatingHtml($bus['rating_value'] ?? 0, $bus['rating_count'] ?? 0);

            $subArray = array_filter(explode(',', $bus['subcategories']));
            if (count($subArray) >= 3) {
                $randKeys = array_rand(array_flip($subArray), 3);
                $randKeys = is_array($randKeys) ? $randKeys : [$randKeys];
                $randomSubCategories = array_map(fn($id) => $subcatModels->get($id), $randKeys);
            } else {
                $randomSubCategories = array_map(fn($id) => $subcatModels->get($id), $subArray);
            }
            $randomSubCategories = array_filter($randomSubCategories);

           $busIds = array_column($businessFinal, 'id');
           $businessTimes = DB::table('business_times')->whereIn('business_id', $busIds)->get()->keyBy('business_id');

           foreach ($businessFinal as $bus) {
            $business_times = $businessTimes[$bus['id']] ?? null;
            $time = $this->buildBusinessTimeString($business_times);
        }

            $thumb = $fetch_all_plans[$bus['plan_id']]['thumb_icon'] ?? null;
            $lm_trust = $fetch_all_plans[$bus['plan_id']]['stamp_icon'] ?? null;

            // photo
            if (empty($bus['photo1'])) {
                $banner_photo = $banners[$bus['id']]->first() ?? null;
                $bus['photo1'] = $banner_photo ? url(str_replace('public', 'storage', $banner_photo->photo)) : url('');
            } else {
                $bus['photo1'] = url(str_replace('public', 'storage', $bus['photo1']));
            }
            $lat_long_array = explode(',', $bus['lat_long']);
            $distance = '';
            if (!empty($lat_long_array[0])) {
                $d = $this->distance($current_lat, $current_long, $lat_long_array[0], $lat_long_array[1] ?? 0, 'K');
                $d = number_format($d, 1);
                if ((int)$d <= 20) $distance = $d;
            }
            $bus['distance'] = $distance;
            $bus['verified'] = isset($otpCounts[$bus['phone_number']]) && $otpCounts[$bus['phone_number']] ? '<span class="badge bg-success mx-3">Verified</span>' : '';
            $bscity = $this->sanitizeForUrl($bus['city'] ?? '');
            $shop_name = $this->sanitizeForUrl($bus['shop_name'] ?? '');
            $address = $this->sanitizeForUrl($bus['address'] ?? '');
            $bus['webpage_link'] = strtolower(url($bscity . '/' . $shop_name . '/' . $address . '/' . $this->generate_bus_id($bus['id'])));
            $bus['randomSubCategories'] = $randomSubCategories;
            $bus['time'] = $time;
            $bus['thumb'] = $thumb;
            $bus['lm_trust'] = $lm_trust;

            $processed[] = $bus;
        }

        Session::put('bus_cat_id', $cat_id);
        Session::put('bus_sub_cat_id', $sub_cat_id);
        Session::put('search_city', $city);
        Session::put('search_content', $search);
        Session::put('search_state', $state);

        $subcategory_array = SubCategory::where('category_id', $cat_id)->with('category')->get();
        $category = Category::find($cat_id);

        if (isset($request->page)) {
            if (isset($request->business_link)) {
                $view = view('frontend.webpage.show_more_business_link', ['businesses' => $processed]);
                echo $view; die;
            }

            if ($agent->isMobile()) {
                foreach ($processed as $array) {
                    echo view('mobile.partials.business_card', ['array' => $array]);
                }
            } else {
                return response()->json($processed);
            }
            return null;
        }

        $advertismentbanner = AdvertismentBanner::leftJoin('businesses', 'businesses.id', 'advertisement_banner.business_id')
                                ->where('location', 'LIKE', '%India%')->where('category', 0)->get()->toArray();

        $za = "Top " . ucfirst(str_replace('-', ' ', $request->search_content ?? '')) . " in " . $city;
        if ($agent->isMobile()) {
            $subcategories_1 = SubCategory::where('category_id', $cat_id)->inRandomOrder()->limit(10)->get();
            $subcategories_2 = SubCategory::where('category_id', $cat_id)->inRandomOrder()->limit(10)->get();
            $categoryModel = Category::find($cat_id);
            return view('mobile.webpage_listing', [
                'data' => $processed,
                'meta_tags' => $meta_tags,
                'meta_title' => $meta_title,
                'subcategories_1' => $subcategories_1,
                'subcategories_2' => $subcategories_2,
                'category_d' => $categoryModel,
            ]);
        }

        $content = $request->search_content;
        $d = explode('-in-', $content);
        $seeking = $d[0] ?? '';
        $seeking = str_replace('-', ' ', $seeking);

        $bus_ids = implode(',', array_column($processed, 'id'));

        $cat_d = Category::find($cat_id);
        $sub_cat_d = SubCategory::find($sub_cat_id);

        $bread_crumb_array = ["https://www.likeme.co.in/" => ucfirst($city)];
        $search_word = str_replace('-', ' ', $search);
        $bread_crumb_array[url()->full()] = isset($request->bname) ? ucwords($request->bname) : ucwords($search_word) . ' in ' . ucfirst($city);

      
        return view('frontend.new_business_list', [
            'lmid' => $id,
            'rating_value' => rand(4,5),
            'rating_count' => rand(100,200),
            'lm_page' => true,
            'advertismentbanner' => $advertismentbanner,
            'za' => $za,
            'category' => $cat_d,
            'cat_id' => $cat_id,
            'sub_cat_id' => $sub_cat_id,
            'bread_crumb_array' => $bread_crumb_array,
            'searched_city' => strtolower(str_replace('-', ' ', $city)),
            'meta_tags' => $meta_tags,
            'meta_title' => $meta_title,
            'cat_name' => $cat_d->name ?? '',
            'lat' => $lat,
            'long' => $long,
            'search_content' => $search,
            'city' => $city,
            'search_results' => $processed,
            'title_name' => $d[0] ?? '',
            'subcategory_array' => $subcategory_array,
            'business_subcategory' => $subcategory_array,
            'categories' => $category,
            'seeking' => $seeking,
            'cat_id' => $cat_id,
            'bus_ids' => $bus_ids,
        ]);
    }

   
    protected function buildRatingHtml($value, $count)
    {
        $gold = '<span class="star-3">' . str_repeat('★', round($value)) . '</span>';
        $silver = '<span class="star-2">' . str_repeat('★', 5 - round($value)) . '</span>';
        return '<div class="d-block review-div"><span class="text-muted fs-13">' . round($value, 1) . '</span>' . $gold . $silver . '<span class="text-muted fs-13">' . ($count ?? 0) . '</span> <span class="text-muted">reviews</span></div>';
    }

    protected function buildBusinessTimeString($business_times)
    {
        if (!$business_times) {
            $hour = now()->format('H');
            return $hour > 20 ? "<span class='close-red'>Close :  </span> Open 09:00 am" : "<span class='open-green'>Open :  </span> Closes 08:00 pm";
        }

        $today = strtolower(now()->format('l'));
        if ($business_times->$today == 0) {
            return "<span class='close-red'>Closed Today</span>";
        }

        $from = $business_times->from_time ?: '10:00';
        $to = $business_times->to_time ?: '20:00';
        $current = Carbon::now();
        $fromObj = Carbon::createFromFormat('H:i', $from);
        $toObj = Carbon::createFromFormat('H:i', $to);
        $from_am = $fromObj->format('h:i A');
        $to_am = $toObj->format('h:i A');

        if ($current->between($fromObj, $toObj)) {
            return "<span  class='open-green'>Open :  </span> Closes $to_am";
        }

        
        for ($i = 1; $i <= 3; $i++) {
            $nextDay = strtolower(now()->addDays($i)->format('l'));
            if (isset($business_times->$nextDay) && $business_times->$nextDay == 1) {
                $dayName = now()->addDays($i)->format('l');
                return "<span class='close-red'>Close :  </span> Open $dayName at $from_am";
            }
        }

        return "<span class='close-red'>Close :  </span> Open soon";
    }
}
