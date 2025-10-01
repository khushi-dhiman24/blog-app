<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;


class Controller extends Controller
{
     use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function Index()
    {

        $previous_url = url()->previous();
      //   var_dump($this->isBotDetected2());die;
        $city = $request->city;
        $cu_url = $request->url(); 
        $search = $request->search_content;
        $search = $request->search_content;
        
        if(str_contains($cu_url,'/public/')){
            $cu_url = str_replace("public/","",$cu_url);
          // var_dump($cu_url);die;
            return redirect(strtolower($cu_url), 301);
        }
        //commented by yatin
        if ((preg_match('/[A-Z]/', $cu_url) || preg_match("/'/", $cu_url) || preg_match("/,/", $cu_url) || preg_match("/--/", $cu_url) || preg_match("/&/", $cu_url) ) && !str_contains($request->fullurl(), "?")) {
            
            $cu_url = str_replace("'", "-", $cu_url);
            $cu_url = str_replace(",", "-", $cu_url);
            $cu_url = str_replace("--", "-", $cu_url);
            $cu_url = str_replace("&", "-", $cu_url);
            
            return redirect(strtolower($cu_url), 301);
        }
        if (str_contains($city, " - ")) {
            $city = explode(" - ", $city)[0];
        }
        $id = $request->id;
        $current_lat = 0;
        $current_long = 0;


        $cat_id = substr($id, 0, 3);
        $sub_cat_id = substr($id, 3, 8);

        if (strlen($id) != 8) {

            if (strlen($id) == 7) {
                $cat_id = substr($id, 0, 3);
                $sub_cat_id = substr($id, 3, 7);
                $sub_cat_data = DB::table('subcategories')->select('id','name','category_id','meta_tag','meta_description')->where('id', '=', $sub_cat_id)->first();

                $sub_cat_data->name = str_replace(" ", "-", $sub_cat_data->name);
                $sub_cat_data->name = strtolower($sub_cat_data->name);

                $cat_id = $this->cat_return($sub_cat_data->category_id);
                $sub_cat_id = $this->sub_cat_return($sub_cat_data->id);

                $sub_cat_data->name = str_replace("'", "-", $sub_cat_data->name);
                $sub_cat_data->name = str_replace(",", "-", $sub_cat_data->name);
                $sub_cat_data->name = str_replace("&", "-", $sub_cat_data->name);
                $sub_cat_data->name = str_replace("---", "-", $sub_cat_data->name);
                $sub_cat_data->name = str_replace("--", "-", $sub_cat_data->name);
                $url = url($city . "/" . $sub_cat_data->name . "/lmid-" . $cat_id . $sub_cat_id);
                return redirect($url,301);
            }

            if (strlen($id) == 6) {
                $cat_id = substr($id, 0, 3);
                $sub_cat_id = substr($id, 3, 6);
                $sub_cat_data = DB::table('subcategories')->select('id','name','category_id','meta_tag','meta_description')->where('id', '=', $sub_cat_id)->first();

                $sub_cat_data->name = str_replace(" ", "-", $sub_cat_data->name);
                $sub_cat_data->name = strtolower($sub_cat_data->name);

                $cat_id = $this->cat_return($sub_cat_data->category_id);
                $sub_cat_id = $this->sub_cat_return($sub_cat_data->id);

                $sub_cat_data->name = str_replace("'", "-", $sub_cat_data->name);
                $sub_cat_data->name = str_replace(",", "-", $sub_cat_data->name);
                $sub_cat_data->name = str_replace("&", "-", $sub_cat_data->name);
                $sub_cat_data->name = str_replace("---", "-", $sub_cat_data->name);
                $sub_cat_data->name = str_replace("--", "-", $sub_cat_data->name);
                 $url = url($city . "/" . $sub_cat_data->name . "/lmid-" . $cat_id . $sub_cat_id);
                return redirect($url, 301);
            }

            $search = str_replace("-", " ", $search);
            $search_array = explode(" in ", $search);

            if (isset($search_array[1])) {

                $cat_name = $search_array[1];
                $sub_cat_name = $search_array[0];

                $sub_cat_name = str_replace("-", " ", $sub_cat_name);

                $sub_cat_data = DB::table('subcategories')->select('id','name','category_id','meta_tag','meta_description')->where('name', '=', "$sub_cat_name")->first();

                if (!isset($sub_cat_data->id)) {

                    abort(404);
                }

                
                 $cat_id = $this->cat_return($sub_cat_data->category_id);
                $sub_cat_id = $this->sub_cat_return($sub_cat_data->id);

                $url = url($city . "/" . $request->search_content . "/lmid-" . $cat_id . $sub_cat_id);
                return redirect($url, 301);
             } elseif (isset($search_array[0])) {

                $cat_name = $search_array[0];

                $cat_data = DB::table('categories')->select('name','id','meta_name','meta_title')->where('name', '=', "$cat_name")->first();


                if (!isset($cat_data->id)) {
                    abort(404);
                }

                $cat_id = $this->cat_return($cat_data->id);

                $url = url($city . "/" . $request->search_content . "/lmid-" . $cat_id . "00000");
                return redirect($url, 301);

            } else {

                abort(404);
            }

            } else {
            $cat_data = DB::table('categories')->select('name','id','meta_name','meta_title')->where('id', '=', "$cat_id")->first();
            $sub_cat_data = DB::table('subcategories')->select('name','id','category_id','meta_tag','meta_description','slug')->where('id', '=', "$sub_cat_id")->first();
            if (isset($sub_cat_data)) {
                if ($sub_cat_data->category_id != $cat_id) {

                    $cat_id = $this->cat_return($sub_cat_data->category_id);

                    $sub_cat_data_name = str_replace(" ", "-", $sub_cat_data->slug);

                    $url = url($city . "/" . $request->search_content . "/lmid-" . $cat_id . $sub_cat_id);
                    return redirect($url, 301);
                }
            }
            if (!isset($cat_data->id)) {
                $search = str_replace("-", " ", $search);
                $search_array = explode(" in ", $search);

                if (isset($search_array[1])) {
                    $cat_name = $search_array[1];
                    $sub_cat_name = $search_array[0];
                    $sub_cat_data = DB::table('subcategories')->select('name','id','category_id','meta_tag','meta_description')->where('name', '=', "$sub_cat_name")->first();

                    if (!isset($sub_cat_data->id)) {
                        abort(404);
                    }

                    $cat_id = $this->cat_return($sub_cat_data->category_id);
                    $sub_cat_id = $this->sub_cat_return($sub_cat_data->id);

                    $url = url($city . "/" . $request->search_content . "/lmid-" . $cat_id . $sub_cat_id);
                    return redirect($url, 301);
                } elseif (isset($search_array[0])) {

                    $cat_name = $search_array[0];

                    $cat_data = DB::table('categories')->select('name','id','meta_name','meta_title')->where('name', '=', "$cat_name")->first();


                    if (!isset($cat_data->id)) {
                        abort(404);
                    }

                    $cat_id = $this->cat_return($cat_data->id);

                    $url = url($city . "/" . $request->search_content . "/lmid-" . $cat_id . "00000");
                    return redirect($url, 301);

                } else {
                    abort(404);
                }
            }
        }
        $search = str_replace("&amp;", "&", $search);

        $search_city_array = explode("-in-", $search);

        if (count($search_city_array) == 4) {
            $city = $search_city_array[2];
        }

        $yamunanagar_array = ["Yamunanagar", "YamunaNagar", "Yamuna Nagar", "yamunanagar", "yamuna nagar", "yamuna Nagar"];

        if (in_array($city, $yamunanagar_array)) {
            $city = "Yamunanagar";
        }
        $agent = new Agent();
        if (isset($request->page)) {

            $request->page = $request->page;
            $limit = 4;
            $skip = $request->page * $limit;

        } else {
            if ($agent->isMobile()) {
                $limit = 4;
                $skip = 0;
            } else {
                $limit = 4;
                $skip = 0;
            }

        }
         //  var_dump($city);die;
        $city = str_replace("-", " ", $city);
        $seeking = "";
        if (isset($_COOKIE['latitude']) && !empty($_COOKIE['latitude'])) {

            $lat = $_COOKIE['latitude'];
            $long = $_COOKIE['longitude'];
            $current_lat = $lat;
            $current_long = $long;
        } else {
            $lat = $request->lat;
            $long = $request->long;
            $current_lat = $lat;
            $current_long = $long;

        }
        if (isset($request->search) && !str_contains($request->new_location, '-')) {
            $search_array = explode(" in ", $request->search);
            if (isset($search_array[1])) {
                $search_array = explode(" - ", $search_array[1]);
                if (isset($search_array[0])) {
                    $city = $search_array[0];
                }

            }

        }
        $city = str_replace("pondicherry", "puducherry", $city);
        $lat_long_db = DB::table('newcitylatlong')->where('name', 'LIKE', "$city %")->first();
        if (isset($_COOKIE['CUR_CITY']) && str_contains($_COOKIE['CUR_CITY'], ucfirst($city))) {
            $state = explode(" - ", $_COOKIE['CUR_CITY'])[1];

            $ssas = $_COOKIE['CUR_CITY'];
            $lat_long_db = DB::table('newcitylatlong')->where('name', 'LIKE', "$ssas%")->first();
        } else if (isset($lat_long_db->name)) {
            $lat_long_db = DB::table('newcitylatlong')->where('name', 'LIKE', "$city %")->first();
            $azx = explode(" - ", $lat_long_db->name);
            $state = $azx[1];

        } else {
            
            $city = $this->findClosestCity($city);
            
            $name = $city->getData()->closest_city;
            $city = explode(" - ",$name)[0];


           // $lat_long_db = DB::table('newcitylatlong')->where('name','LIKE',"$city %")->first();
            if (isset($lat_long_db->name)) {
                $azx = explode(" - ", $lat_long_db->name);
                $state = $azx[1];

            }

        }
       if (isset($lat_long_db->lat)) {
            $selected_city_lat = str_replace(" ", "", $lat_long_db->lat);
            $selected_city_long = str_replace(" ", "", $lat_long_db->longi);
            $selected_city_lat = trim($selected_city_lat);
            $selected_city_long = trim($selected_city_long);
            $selected_city_lat = trim($selected_city_lat);
            
           //   var_dump($lat_long_db);die;
             $dis = $this->distance($current_lat, $current_long, $selected_city_lat, $selected_city_long, "K");

            if ($dis > 10) {
                $lat = $selected_city_lat;
                $long = $selected_city_long;
            } else {
                $lat = $current_lat;
                $long = $current_long;
            }

        }
        if (empty($lat)) {
            $lat = "28.7041";
            $long = "77.1025";

        }
         $customer_name = "";
         $customer_number = "";

        if (isset(Auth::guard('customer')->user()->id)) {
            $customer_name = Auth::guard('customer')->user()->name;
            $customer_number = Auth::guard('customer')->user()->phone;
        }
          $agent = new Agent();
        
        if (!isset($request->page)) {

            $LastSearches = new LastSearches();
            $LastSearches->search = $search;
            $LastSearches->name = $customer_name;
            $LastSearches->phone_number = $customer_number;
            $LastSearches->lat = $lat;
            $LastSearches->longi = $long;
            $LastSearches->city = $city;
            $LastSearches->cat_id = $cat_id;
            $LastSearches->sub_cat_id = $sub_cat_id;
            $LastSearches->state = $state;
            $LastSearches->agent = request()->header('User-Agent');
            $LastSearches->ip = $request->ip();
            $LastSearches->bot_type = $_SERVER['HTTP_USER_AGENT'];
            $LastSearches->bot = $this->isBotDetected();
            $LastSearches->link = $request->url();
            if (!$agent->isMobile()) {
                $LastSearches->device_type = 1;
            }
            $LastSearches->save();
        }
   //          if($this->isBotDetected2()){
        //     die; 
        //  }


        //        var_dump($lat.",".$long); die;
        $lat_long_query = " 111.111 *
             DEGREES(ACOS(LEAST(1.0, COS(RADIANS(SUBSTRING_INDEX(lat_long, ',', 1)))
             * COS(RADIANS($lat))
             * COS(RADIANS(SUBSTRING_INDEX(SUBSTRING_INDEX(lat_long,',', 2), ',',-1) - $long))
             + SIN(RADIANS(SUBSTRING_INDEX(lat_long, ',', 1)))
             * SIN(RADIANS($lat)))))";
             
        
        $lat_long_query_2 = "111.111 *
                            DEGREES(ACOS(LEAST(1.0,
                                COS(RADIANS(latitude)) * COS(RADIANS($lat)) *
                                COS(RADIANS(longitude - $long)) +
                                SIN(RADIANS(latitude)) * SIN(RADIANS($lat))
                            )))";     

        $search_array = explode("-in-", $search);
        $array_length = count($search_array);


        if (isset($sub_cat_data)) {
            $meta_title = $sub_cat_data->meta_tag;
            $meta_tags = $sub_cat_data->meta_description;

        } else {
            $meta_tags = $cat_data->meta_name;
            $meta_title = $cat_data->meta_title;

        }

        $query_no = 0;
        $check_bs = false;
    
        if ((isset($request->search) && str_contains($request->search, ' in ') && !isset($request->page))) {
            $business_by_name = Business::join('cities', 'cities.id', 'new_businesses.city')->select('new_businesses.*', 'new_businesses.city as city_id', 'cities.name as city')->where('new_businesses.shop_name', 'LIKE', "%" . explode(" in ", $request->search)[0] . "%")->where('cities.name', 'LIKE', "%" . explode(" in ", $request->search)[1] . "%")->limit($limit)->skip($skip)->get()->toArray();
            if ($business_by_name) {
                $check_bs = true;

            }
        } elseif (isset($request->search) && !isset($request->page)) {
            $business_by_name = Business::join('cities', 'cities.id', 'new_businesses.city')->select('new_businesses.*', 'new_businesses.city as city_id', 'cities.name as city')->where('new_businesses.shop_name', 'LIKE', "%$request->search%")->where('cities.name', 'LIKE', "%$city%")->limit($limit)->skip($skip)->get()->toArray();
            if ($business_by_name) {
                $check_bs = true;

            }
        }
        if((isset($request->bname) && is_numeric($request->bname) && strlen($request->bname) != 10 && !isset($request->page))){
            abort(404);
        }
        
         if ((isset($request->bname) && is_numeric($request->bname) && strlen($request->bname) == 10 && !isset($request->page))) {
             
              $business_by_name = Business::leftjoin('cities', 'cities.id', 'new_businesses.city')->select('new_businesses.*', 'new_businesses.city as city_id', 'cities.name as city')->where('phone_number', '=', $request->bname)
              ->orwhere('alternate_phone_number', '=', $request->bname)
              ->orwhere('alternate_phone_number_2', '=', $request->bname)->get()->limit($limit)->skip($skip)->toArray();
              
            if ($business_by_name) {
                Session::put('searched_business_id', $business_by_name[0]['id']);

                $check_bs = true;

            }
            
            
         }else if ((isset($request->bname) && str_contains($request->bname, ' in ') && !isset($request->page))) {

            $city_m = explode(" in ", $request->bname)[1];
            $city_id = Cities::where('name', 'LIKE', "$city_m")->first()->id;


            $business_by_name = Business::leftjoin('cities', 'cities.id', 'new_businesses.city')->select('new_businesses.*', 'new_businesses.city as city_id', 'cities.name as city')->where('shop_name', 'LIKE', "%" . explode(" in ", $request->bname)[0] . "%")->where('new_businesses.city', $city_id)->limit($limit)->skip($skip)->get()->toArray();
            if ($business_by_name) {
                Session::put('searched_business_id', $business_by_name[0]['id']);

                $check_bs = true;

            }
        }else if ((isset($request->bname) && !isset($request->page))){
            
            $business_by_name = Business::leftjoin('cities', 'cities.id', 'new_businesses.city')->select('new_businesses.*', 'new_businesses.city as city_id', 'cities.name as city')->where('shop_name', 'LIKE', "%" . $request->bname . "%")->limit($limit)->skip($skip)->get()->toArray();
            if ($business_by_name) {
                Session::put('searched_business_id', $business_by_name[0]['id']);

                $check_bs = true;

            }
        }
        if (isset($request->page)) {
            $skip = ($request->page) * $limit;
        } else {
            $skip = 0;
        }

        if (isset($request->page) && $agent->isMobile()) {
            if ($request->page == 0) {
                $skip = 0;
            } else {
                $skip = ($request->page) * $limit;
            }
        }

        $new_queries_cat_id = [51, 113, 118, 161, 156, 141, 130, 129, 123, 49, 7, 19];
        $categories = explode(",", ltrim($cat_id, '0'));
        $subCategories = explode(",", ltrim($sub_cat_id, '0'));

        $searched_cat_id = ltrim($cat_id, '0');
        $searched_sub_cat_id = ltrim($sub_cat_id, '0');

        $city = str_replace("-", " ", $city);
        
        $city_id = Cities::where('name', 'LIKE', "$city")->first()->id;
        $state_id = States::where('name', 'LIKE', "%$state%")->first()->id;

    
        $is_in_child_category = SubSubCategory::where('new_sub',$sub_cat_id)->first();
        
        if($is_in_child_category){
            $child_categories = SubSubCategory::where('sub_category_id',$is_in_child_category->sub_category_id)->pluck('new_sub')->toArray();
        }else{
            $child_categories = SubSubCategory::where('sub_category_id',$sub_cat_id)->pluck('new_sub')->toArray();
        }
        
        $subCategories = array_merge($subCategories,$child_categories);
        
        if($subCategories[0] == ""){
         unset($subCategories[0]);   
        }
        
        //var_dump($subCategories);die;
        $business = array();
        
        
        if (in_array(ltrim($cat_id, '0'), $new_queries_cat_id) && $limit != 0) {

            $business = Business::select('new_businesses.id','new_businesses.plan_id','new_businesses.owner_name','new_businesses.shop_name',
            'new_businesses.owner_email','new_businesses.address','new_businesses.area','new_businesses.lat_long','new_businesses.landmark',
            'new_businesses.pincode','new_businesses.city','new_businesses.state','new_businesses.business_type','new_businesses.established',
            'new_businesses.photo1','new_businesses.photo2','new_businesses.phone_number','new_businesses.whatsapp_no','new_businesses.rating_count',
            'new_businesses.subcategories','new_businesses.category_id','new_businesses.whatsapp_no','new_businesses.rating_value',
            'cities.name as city', 'states.name as state')
                ->selectRaw("$lat_long_query AS distance")
                ->join('cities', 'cities.id', 'new_businesses.city')
                ->join('states', 'states.id', 'new_businesses.state')
                ->where(function ($query) use ($city_id, $state_id) {
                    $query->where(function ($query) use ($city_id) {
                        $query->where('plan_id', 8) // Gold: States
                            ->where('city', $city_id);
                    }) // Platinum: All India
                        ->orWhere(function ($query) use ($city_id) {
                            $query->where('plan_id', 7) // Gold: States
                                ->where('city', $city_id);
                        })
                        ->orWhere(function ($query) use ($city_id) {
                            $query->where('plan_id', 6) // Silver: Cities
                                ->where('city', $city_id);
                        })
                        ->orWhere(function ($query) use ($city_id) {
                            $query->where('plan_id', 5) // Standard: Current City
                                ->where('city', $city_id);
                        })
                        ->orWhere('plan_id', 8)
                        ->orWhere(function ($query) use ($state_id) {
                            $query->where('plan_id', 7) // Gold: States
                                ->where('state', $state_id);
                        })
                        ->orWhere(function ($query) use ($state_id) {
                            $query->where('plan_id', 13);
                        });
                })
                ->where(function ($query) use ($searched_cat_id, $searched_sub_cat_id) {
                    $query->whereRaw("FIND_IN_SET(?, category_id)", [$searched_cat_id])
                        ->orWhereRaw("FIND_IN_SET(?, subcategories)", [$searched_sub_cat_id]);
                })
                ->orderByRaw("FIELD(plan_id, 8, 7, 6, 5, 13)"); // Plan priority
            if ($searched_sub_cat_id != 0) {
                $business = $business->orderByRaw("CASE 
                                WHEN plan_id = 13 THEN 
                                  CASE 
                                    WHEN FIND_IN_SET(?, subcategories) AND distance < 5 THEN 1 
                                    ELSE 2 
                                  END
                              END ASC", [$searched_sub_cat_id]);
            }// Subcategory priority for plan_id 13
            $business = $business->orderByRaw("CASE WHEN plan_id = 13 THEN distance END ASC") // Distance priority for plan_id 13
                ->orderBy('distance', 'asc') // General distance ordering
                ->skip($skip)
                ->limit($limit);

            if (Session::has('searched_business_id')) {
                $business = $business->where('new_businesses.id', '!=', Session::get('searched_business_id'));
            } 

            $business = $business->get()->toArray();

        } elseif ($limit != 0) {
        $business = Business::select('new_businesses.id','new_businesses.plan_id','new_businesses.owner_name','new_businesses.shop_name',
            'new_businesses.owner_email','new_businesses.address','new_businesses.area','new_businesses.lat_long','new_businesses.landmark',
            'new_businesses.pincode','new_businesses.city','new_businesses.state','new_businesses.business_type','new_businesses.established',
            'new_businesses.photo1','new_businesses.photo2','new_businesses.phone_number','new_businesses.whatsapp_no','new_businesses.rating_count',
            'new_businesses.subcategories','new_businesses.category_id','new_businesses.whatsapp_no','new_businesses.rating_value',
            'cities.name as city', 'states.name as state')
                ->selectRaw("$lat_long_query AS distance")
                ->join('cities', 'cities.id', 'new_businesses.city')
                ->join('states', 'states.id', 'new_businesses.state')
                ->where(function ($query) use ($city_id, $state_id) {
                    $query->where(function ($query) use ($city_id) {
                        $query->where('plan_id', 8) // Gold: States
                            ->where('city', $city_id);
                    }) // Platinum: All India
                        ->orWhere(function ($query) use ($city_id) {
                            $query->where('plan_id', 7) // Gold: States
                                ->where('city', $city_id);
                        })
                        ->orWhere(function ($query) use ($city_id) {
                            $query->where('plan_id', 6) // Silver: Cities
                                ->where('city', $city_id);
                        })
                        ->orWhere(function ($query) use ($city_id) {
                            $query->where('plan_id', 5) // Standard: Current City
                                ->where('city', $city_id);
                        })
                        ->orWhere('plan_id', 8)
                        ->orWhere(function ($query) use ($state_id) {
                            $query->where('plan_id', 7) // Gold: States
                                ->where('state', $state_id);
                        })
                        ->orWhere(function ($query) use ($state_id) {
                            $query->where('plan_id', 13);
                        });
                })
                ->where(function ($query) use ($searched_cat_id, $searched_sub_cat_id) {
                    $query->whereRaw("FIND_IN_SET(?, category_id)", [$searched_cat_id])
                        ->orWhereRaw("FIND_IN_SET(?, subcategories)", [$searched_sub_cat_id]);
                })
                ->orderByRaw("FIELD(plan_id, 8, 7, 6, 5, 13)"); // Plan priority
            if ($searched_sub_cat_id != 0) {
                $business = $business->orderByRaw("CASE 
                                WHEN plan_id = 13 THEN 
                                  CASE 
                                    WHEN FIND_IN_SET(?, subcategories) AND distance < 5 THEN 1 
                                    ELSE 2 
                                  END
                              END ASC", [$searched_sub_cat_id]);
            }// Subcategory priority for plan_id 13
            $business = $business->orderByRaw("CASE WHEN plan_id = 13 THEN distance END ASC") // Distance priority for plan_id 13
                ->orderBy('distance', 'asc') // General distance ordering
                ->skip($skip)
                ->limit($limit);

            if (Session::has('searched_business_id')) {
                $business = $business->where('new_businesses.id', '!=', Session::get('searched_business_id'));
            } 

            $business = $business->get()->toArray();
        }
       
          // echo(1);die;
        $bus_id_array = array();
        $plan_ids = [5, 6, 7, 8, 13];
        $fetch_all_plans = Plan::wherein('id', $plan_ids)->get();
        $plan13Businesses = [];
        $otherBusinesses = [];

        foreach ($business as $item) {
            if ($item['plan_id'] == 13) {
                $plan13Businesses[] = $item;
            } else {
                $otherBusinesses[] = $item;
            }
        }
        shuffle($plan13Businesses);
        $business = array_merge($otherBusinesses, $plan13Businesses);

        if ($check_bs) {
            $business = array_merge($business_by_name, $business);
        }
        foreach ($business as $key => $bus) {

            $golden_star = '<span class="star-3">';
            for ($i = 0; $i < round($bus['rating_value']); $i++) {
                $golden_star = $golden_star . '';
            }

            $golden_star = $golden_star . '</span>';

            $silver_star = '<span class="star-2">';
            for ($i = 0; $i < 5 - round($bus['rating_value']); $i++) {
                $silver_star = $silver_star . '★';
            }

            $silver_star = $silver_star . '</span>';

            $rating_stars = '<div class="d-block review-div">
                              <span id="rating_id" class="text-muted fs-13">' . round($bus['rating_value'], 1) . '</span>
                              
                              
                                 ' . $golden_star . '' . $silver_star . '
                              <span class="text-muted fs-13">' . $bus['rating_count'] . '</span> <span class="text-muted">reviews</span> </div>';
            $business[$key]['rating_stars'] = $rating_stars;
            $business_times = DB::table('business_times')->where('business_id', $bus['id'])->first();

            $subcategoriesArray = (explode(",", $bus['subcategories']));
            
            if (count($subcategoriesArray) >= 3) {
                
                $randomSubcategories = array_rand(array_flip($subcategoriesArray), 3);
            } else {
                $randomSubcategories = $subcategoriesArray;
            }

            $randomSubcategories = array_slice($randomSubcategories, 0, 3);

            $randomSubCategories = SubCategory::whereIn('id', $randomSubcategories)->select('id','name')->get();
            $average_rating = 0;
            $category_id_array = explode(",", $bus['category_id']);

            if ($bus['business_type'] == 1) {
                $text_title = "Deals In : ";
                $get_best_price = "Get Best Price";
            } else if ($bus['business_type'] == 2) {
                $text_title = "Services : ";
                $get_best_price = "Get Best Deal";
            } else if ($bus['business_type'] == 3) {
                $text_title = "Deals In : ";
                $get_best_price = "Get Best Price";
            }

            if (in_array(6, $category_id_array)) {
                $text_title = "Specialist In : ";
            }

            if (in_array(6, $category_id_array) || in_array(11, $category_id_array) || in_array(124, $category_id_array) || in_array(138, $category_id_array)) {
                $get_best_price = "Book Appointment";
            }

            $business[$key]['text_title'] = $text_title;
            $business[$key]['get_best_price'] = $get_best_price;

            $business_reviews = array();
            
            $business[$key]['review_count'] = $bus['rating_count'];
            $business[$key]['average_rating'] = $bus['rating_value'];
            $business[$key]['randomSubCategories'] = $randomSubCategories;

           
            if ($business_times) {
                $today = now()->format('l');
                $today = strtolower($today);
                if ($business_times->$today == 0) {
                    $time = "<span class='close-red'>Closed Today</span>";
                } else {
                    $current_time = date('H:i');
                    
                    if($business_times->from_time == "" ){
                        $business_times->from_time = "10:00"; 
                    }
                    
                    if($business_times->to_time == "" ){
                        $business_times->to_time = "20:00"; 
                    }

                    $from_time = $business_times->from_time;
                    $to_time = $business_times->to_time;
                    $current_time = new DateTime();

                    $from_time_obj = DateTime::createFromFormat('H:i', $from_time);
                    $to_time_obj = DateTime::createFromFormat('H:i', $to_time);

                    $from_time_am_pm = $from_time_obj->format('h:i A');
                    $to_time_am_pm = $to_time_obj->format('h:i A');

                    if ($current_time >= $from_time_obj && $current_time <= $to_time_obj) {
                        $time = "<span  class='open-green'>Open :  </span> Closes " . $to_time_am_pm;
                    } else {
                        $nextDay = now()->addDays()->format('l');
                        $lowernextDay = strtolower($nextDay);
                        if ($business_times->$lowernextDay == 1) {
                            $time = "<span class='close-red'>Close :  </span> Open " . $from_time_am_pm;
                        } else {
                            $nextDay = now()->addDays(2)->format('l');
                            $lowernextDay = strtolower($nextDay);
                            if ($business_times->$lowernextDay == 1) {
                                $time = "<span class='close-red'>Close :  </span> Open $nextDay at " . $from_time_am_pm;
                            } else {
                                $nextDay = now()->addDays(3)->format('l');
                                $lowernextDay = strtolower($nextDay);
                                $time = "<span class='close-red'>Close :  </span> Open $nextDay at " . $from_time_am_pm;
                            }

                        }
                    }
                }
         } else {
                $time = now()->format('H');
                if ($time > 20) {
                    $time = "<span class='close-red'>Close :  </span> Open 09:00 am";
                } else {
                    $time = "<span  class='open-green'>Open :  </span> Closes 08:00 pm";
                }
            }
            $business[$key]['time'] = $time;

            $in = array_search($bus['plan_id'], $plan_ids);
            $thumb = $fetch_all_plans[$in]['thumb_icon'];
            $lm_trust = $fetch_all_plans[$in]['stamp_icon'];

            $business[$key]['thumb'] = $thumb;
            $business[$key]['lm_trust'] = $lm_trust;
                    if (!isset($request->page)) {
                Session::put('business_ids_array', $bus_id_array);
            }

            $lat_long_array = explode(",", $bus['lat_long']);
            $age = new Agent();

            if ($age->isMobile()) {
                if (Session::has('near_location')) {
                    $bus['distance'] = $this->distance(($current_lat), ($current_long), ($lat_long_array[0]), ($lat_long_array[1]), "K");
                    $bus['distance'] = number_format($bus['distance'], 1);
                } else {
                    $bus['distance'] = "";
                }

            } else {
                $bus['distance'] = $this->distance(($current_lat), ($current_long), ($lat_long_array[0]), ($lat_long_array[1]), "K");
                $bus['distance'] = number_format($bus['distance'], 1);
            }


            array_push($bus_id_array, $bus['id']);
            if (empty($bus['photo1'])) {
                $banner_photo = Business_banner::where('business_id', '=', $bus['id'])->whereNotNull('photo')->limit(1)->first();
                if (isset($banner_photo->photo)) {
                    $business[$key]['photo1'] = str_replace("public", "storage", $banner_photo->photo);
                    $img = $bus['photo1'];
                    $business[$key]['photo1'] = url("$img");
                } else {
                    $business[$key]['photo1'] = url('');
                }
            } else {
                $bus['photo1'] = str_replace("public", "storage", $bus['photo1']);
                $img = $bus['photo1'];
                $business[$key]['photo1'] = url("$img");
            }
            $bscity = str_replace(" ", "-", $bus['city']);
            $shop_name = str_replace(" ", "-", $bus['shop_name']);
            $address = str_replace(" ", "-", $bus['address']);


            $bscity = str_replace(",", "", $bscity);
            $shop_name = str_replace(",", "", $shop_name);
            $address = str_replace(",", "", $address);

            $bscity = str_replace(",", "-", $bscity);
            $shop_name = str_replace(",", "-", $shop_name);
            $address = str_replace(",", "-", $address);


            $bscity = str_replace("/", "-", $bscity);
            $shop_name = str_replace("/", "-", $shop_name);
            $address = str_replace("/", "-", $address);

            $bscity = str_replace("*", "-", $bscity);
            $shop_name = str_replace("*", "-", $shop_name);
            $address = str_replace("*", "-", $address);

            $bscity = str_replace(".", "-", $bscity);
            $shop_name = str_replace(".", "-", $shop_name);
            $address = str_replace(".", "-", $address);

            $bscity = str_replace("---", "-", $bscity);
            $shop_name = str_replace("---", "-", $shop_name);
            $address = str_replace("---", "-", $address);

            $bscity = str_replace("--", "-", $bscity);
            $shop_name = str_replace("--", "-", $shop_name);
            $address = str_replace("--", "-", $address);
            $address = str_replace("/", "-", $address);
            $webpage_link = strtolower(url($bscity . '/' . $shop_name . '/' . $address . '/' . $this->generate_bus_id($bus['id'])));
            $business[$key]['webpage_link'] = $webpage_link;

            $business[$key]['show_address_loding'] = 0;
            if (!str_contains(strtolower($bus['city']), strtolower($city)) && $bus['plan_id'] != 13) {
                if ($bus['business_type'] == 1 || $bus['business_type'] == 3) {
                    $city = ucfirst($city);
                    $business[$key]['address'] = "Also Served in $city";
                } else {
                    $city = ucfirst($city);
                    $business[$key]['address'] = "Also Deals in $city";
                }
                $business[$key]['show_address_loding'] = 1;

            }
             $random_subcategory_div = "<div class='container'><div class='row stop__row'><ul class='list-unstyled d-flex align-items-center gap-2 flex-wrap mb-0 dfddfdf'><li class='fw-bold'>$text_title</li>";
            foreach ($randomSubCategories as $random_sub_category_data) {
                $random_subcategory_div = $random_subcategory_div . "<li><a href='" . $webpage_link . "' class='btn btn-light btn-sm'>" . $random_sub_category_data->name . "</a></li>";
            }

            $random_subcategory_div = $random_subcategory_div . "</ul></div></div>";

            $business[$key]['random_subcategory_div'] = $random_subcategory_div;

            $verified = '<span class="badge bg-success mx-3">Verified</span>';

            $otp_check = Otp::where('phone_number', $bus['phone_number'])->count();

            if (!$otp_check) {
                $verified = "";
            }
            $business[$key]['verified'] = $verified;
            $business[$key]['distance'] = str_replace(",", "", $bus['distance']);
            
            if (((int) $bus['distance']) > 20) {
                $business[$key]['distance'] = "";
            }
         $search_content = str_replace("-", " ", $request->search_content);

            $search_content_in_array = explode(" in ", $search_content);

            if (count($search_content_in_array) == 4) {
                $search_content = $search_content_in_array[0] . ' in ' . $search_content_in_array[1] . ' in ' . $search_content_in_array[2];
            }

            if (isset($request->bname)) {
                $search_content = $request->bname;
            }
            }
         if (!isset($search_content)) {
            $search_content = "";
            }

        $ar = Session::get('business_ids_array');
        if (isset($request->business_link)) {
            $ar = explode(",", $request->business_link);
        }
        Session::put('bus_cat_id', $cat_id);
        Session::put('bus_sub_cat_id', $sub_cat_id);
        Session::put('search_city', $city);
        Session::put('search_content', $search_content);
        Session::put('search_state', $state);

        if (isset($cat_id)) {
            $subcategory_array = SubCategory::where('category_id', '=', $cat_id)->with('category')->get();
            $category = Category::where('id', '=', $cat_id)->get();
        } else {
            $category = array();
            $subcategory_array = array();
        }
        if (isset($request->page)) {

            if (isset($request->business_link)) {
                $view = view('frontend.webpage.show_more_business_link', ['businesses' => $business]);
                echo ($view);
                die;
            }

            if ($agent->isMobile()) {
                foreach ($business as $array) {
                    $verified = $array['verified'];
                    $golden_star = '<span class="star-3">';
                    for ($i = 0; $i < round($array['average_rating']); $i++) {
                        $golden_star = $golden_star . '';
                    }

                    $golden_star = $golden_star . '</span>';

                    $silver_star = '<span class="star-2">';
                    for ($i = 0; $i < 5 - round($array['average_rating']); $i++) {
                        $silver_star = $silver_star . '';
                    }

                    $silver_star = $silver_star . '</span>';

                    $rating_stars = '<div class="d-block review-div">
                              <span id="rating_id" class="text-muted fs-13">' . round($array['average_rating'], 1) . '</span>
                              
                              
                                 ' . $golden_star . '' . $silver_star . '
                              <span class="text-muted fs-13">' . $array['review_count'] . '</span> <span class="text-muted">reviews</span> ' . $verified . ' </div>';
                    if (isset($array->likes)) {
                        $likes = $array->likes;
                    } else {
                        $likes = 0;
                    }
                    if (Session::has('user_login')) {
                        $login = true;
                    } else {
                        $login = false;
                    }

                    $login = Auth::guard('customer')->check();
                    $time = now()->format('H');
                    if ($time > 20) {
                        $t = ("<span class='close-red'>Close :  </span> Open 09:00 am");
                    } else {
                        $t = ("<span class='open-green'>Open :  </span> Closes 08:00 pm");
                    }

                    $random_subcategory_div = $array['random_subcategory_div'];

                    $t = $array['time'];

                    $icons = "";
                    if ($array['thumb'] == 1) {
                        $icons = $icons . '<div class="imag ms-2"><img src="' . asset('/webpage/images/Likeme-thumb.png') . '" width="25" height="25" alt="Likeme-trust" class="certified"></div>';
                    }

                    if ($array['lm_trust'] == 1) {
                        $icons = $icons . '<div class="imag ms-2"><img src="' . asset('/webpage/images/Likeme-trust.png') . '"  width="25" height="25" alt="Likeme-trust" class="certified"></div>';
                    }

                    if ($login) {

                        $number = (substr($array['phone_number'], 0, 2) . "******" . substr($array['phone_number'], 8, 10));
                        $check_eye_number = $number;

                        $call_div = ' <div onclick="send_lead(' . $array['id'] . ')">
                              <a href="tel:' . $array['phone_number'] . '" class="btn btn-sm btn-success text-white d-flex align-items-center gap-1 spacer Call" aria-hidden="true" ><i class="bi bi-telephone"></i> Call</a>
                            </div>';
                        $photo1 = url(str_replace('public', 'storage', $array['photo1']));
                        $photo1 = "'" . $photo1 . "'";

                        $enquiry_div = ' <div>
                              <button type="button" class="btn btn-sm bt-2 d-flex align-items-center gap-1 spacer"  data-bs-toggle="modal" onclick="changename(' . $array['id'] . ',' . $array['phone_number'] . ',' . $photo1 . ')" data-bs-target="#enquireModal";><i class="bi bi-info-circle"></i> Enquire</button>
                            </div>';

                        $whatsapp_div = '<div>
                              <a href="https://wa.me/' . $array['phone_number'] . '"  class="btn btn-sm bt-3 d-flex gap-1 spacer whataspp"><i class="bi bi-whatsapp"></i> Whatsapp</a>
                            </div>';

                        $address_div = '<div>
                              <a href="http://maps.google.com/?q=' . $array['address'] . '" class="btn btn-sm bt-4 d-flex align-items-center gap-1 spacer"><i class="bi bi-signpost"></i> Direction</a>
                            </div>';

                        $tiny_url = "'" . url("tiny-" . $array['id']) . "'";
                        $share_div = '<div>
                              <a href="javascript:save_value(' . $array['id'] . ',' . $array['phone_number'] . ',' . $tiny_url . ')" class="btn btn-sm bt-5 d-flex align-items-center  gap-1 spacer"><i class="bi bi-share"></i> Share</a>
                            </div>';


                    } else {
                        $number = (substr($array['phone_number'], 0, 2) . "******" . substr($array['phone_number'], 8, 10));
                        $call_div = '<div onclick="send_lead(' . $array['id'] . ')">
                              <a href="' . url("mlogin") . '" class="btn btn-sm btn-success text-white d-flex align-items-center gap-1 spacer Call" aria-hidden="true" ><i class="bi bi-telephone"></i> Call</a>
                            </div>';
                        $check_eye_number = ' <a href="/mlogin">' . $number . '<i class="bi bi-eye-slash"></i></a>';

                        $enquiry_div = ' <div>
                              <a type="button" class="btn btn-sm bt-2 d-flex align-items-center gap-1 spacer" href="/mlogin"><i class="bi bi-info-circle"></i> Enquire</a>
                            </div>';

                        $whatsapp_div = '<div>
                              <a href="/mlogin"  class="col-2 btn btn-sm p-1 flex-fill bt-3 buscard__btn whataspp spacer"><i class="bi bi-whatsapp"></i> Whatsapp</a>
                            </div>';

                        $address_div = '<div>
                              <a href="/mlogin" class="btn btn-sm bt-4 d-flex align-items-center gap-1 spacer"><i class="bi bi-signpost"></i> Direction</a>
                            </div>';

                        $share_div = '<div>
                              <a href="/mlogin" class="btn btn-sm bt-5 d-flex align-items-center  gap-1 spacer"><i class="bi bi-share"></i> Share</a>
                            </div>';
                    }

                    if ($array['phone_number'] == "9191919191" || substr($array['phone_number'], 0, 1) == "1") {
                        $call_div = "";
                    }

                    if (isset($array['established'])) {
                        $established = "<li class='lm-mob'> Estb: " . $array['established'] . "</li>";
                    } else {
                        $established = '';
                    }
                    if (isset($array['distance']) && !empty($array['distance'])) {
                        $distance = '<li class=" lm-mob"> ' . ($array['distance'] . "kms") . '</li>';
                    } else {
                        $distance = '';
                    }
                    $busines__id = $array['id'];
                    $webpage_link = url("mwebpage?id=$busines__id");
                    echo ('<section class="bus_card_wrap">
                    <div class="container">
                    <div class="row mt-2">
				  
					<div class="col-12 col-sm-12 col-md-12 openwebpage position-relative">
					   
					<div class="row">
					
						<div class="col-3 col-sm-12 col-md-3 opweb tm">
                                  <a href="' . $webpage_link . '" aria-label="bus image" >
                                <img src="' . $array['photo1'] . '" class="d-block w-100 img-fluid mslidimg" alt="Likeme"> 
                                </a>

						
						</div>
						
					
					<div class="col col-sm-12 col-md-7">
					    
					    <div class="col-12">
                    <div class="wrape d-flex justify-content-between">
                        <div class="heading">
                            <h2 class="line-clamp-head1 ctrlwith fw-bold">' . $array['shop_name'] . '</h2>
                        </div>
                     
                    </div>
                </div>
                
                
                
                 ' . $rating_stars . '
    			
    					<div class="col-1 col-sm-1 icon_php09 position-absolute pl-fix">
					            
					            
					        </div>
    					 
                     <a href="' . $webpage_link . '" >
                    <ul class="list-group list-group-flush d-flex flex-row gap-5 ms-0 ps-0 align-items-center">
                        <li class="d-flex gap-2 line-clamp-2 align-items-start"><i class="bi bi-geo-alt"></i><p class="line-clamp-2">' . $array['area'] . ' ' . $array['city'] . '</p></li>
                    </ul>
                    <ul class="list-group list-group-flush d-flex ms-0 ps-0 mob-list flex-column">
                        <li class="list-a-fix lm-mob">
                            ' . $t . '</li>
                            
                          
                                ' . $established . '
                           
                                     ' . $distance . '
                                
                       
                    </ul>
			
					</div>
			
                    </a>
                    
                    ' . $random_subcategory_div . '
                    
                     <section class="px-0">
                      <div class="container">
                        <div class="row">
                          <div class="overflow-x-auto d-flex hidescroller gap-1">
                           ' . $call_div . '
                            <div>
                              <a href="/maddchat?id=' . $array['id'] . '" class="btn btn-sm bt-1 d-flex align-items-center gap-1 spacer chat"></i> Chat</a>
                            </div>
                             ' . $whatsapp_div . '
                            ' . $enquiry_div . '
                           
                           
                            ' . $address_div . '
                           ' . $share_div . '
                          </div>
                        </div>
                      </div>
                    </section>
					<div class="col-4 col-sm-4 col-md-4 addweblnk">
					<div class="web022" >
				
					</div>
					</div>
					<div class="col-4 col-sm-4 col-md-4 addweblink">
						<div class="web022" >
					
					</div>
					</div>
					  
					</div>
			        </div>
			
			    </div>
			    </div>
			     </div>
                </section>	');
                }
                } else {
  
                foreach ($business as $key => $result) {
                    $category_id_array = (explode(",", $result['category_id']));
                    $randomSubCategories = $business[$key]['randomSubCategories'];

                    if (isset(Auth::guard('customer')->user()->id)) {

                        $enmodel = 'data-bs-target="#enquireModal"';

                    } else {

                        $enmodel = 'data-bs-target="#staticBackdropza"';

                    }
                    $text_title = $result['text_title'];
                    $get_best_price = $result['get_best_price'];
                     $login = Auth::guard('customer')->check();

                    $lat_long_array = explode(",", $result['lat_long']);
                    $result['distance'] = $this->distance($current_lat, $current_long, $lat_long_array[0], $lat_long_array[1], "K");
                    $bus_id = $result['id'];
                    $phone_number = $result['phone_number'];
                    $address = $result['address'];
                    $chat_link = url("/maddchat?id=$bus_id");


                    if (isset($result['distance'])) {
                        $s = $result['distance'] . "KM Away";
                    } else {
                        $s = "";
                    }
                    $m = substr($result['phone_number'], 0, 2) . "******" . substr($result['phone_number'], 8, 10);

                    if (Auth::guard('customer')->check()) {
                        $v = "'" . $result['shop_name'] . "'";
                        $v2 = "'" . $result['phone_number'] . "'";
                        $v3 = "'" . $result['id'] . "'";
                        $m_modal = ' <a href="" class="showabove" data-bs-toggle="modal" data-bs-target="#exampleModal"  onclick="examplemodalchange(' . $v . ',' . $v2 . ')">
                            <i class="bi bi-eye-slash"> </i>
                        </a>';
                        $review_modal = 'data-bs-toggle="modal" data-bs-target="#exammmpleModal"';
                    } else {
                        $m_modal = ' <a href="#" class="showabove" data-bs-toggle="modal" data-bs-target="#staticBackdropza">
                            <i class="bi bi-eye-slash"> </i>
                        </a>';
                        $v3 = "";
                        $v2 = "";
                        $v = "";

                        $review_modal = 'data-bs-toggle="modal" data-bs-target="#staticBackdropza"';
                    }
                    if (isset($result['likes'])) {
                        $like = "(" . $result['likes'] . ")";
                    } else {
                        $like = "";
                    }


                    if (isset($result['distance']) && isset($_COOKIE['NEW_CUR_CITY'])) {
                        $distance_array = explode(".", $result['distance']);
                        $distance = $distance_array[0] . "." . substr($distance_array[1], 0, 1);
                        $distance = "<li class=''>$distance kms </li>";
                    } else {
                        $distance = "";
                    }
                    $icon = "";

                    if ($result['thumb'] == 1) {
                        $icon = $icon . '<img src="' . asset('/webpage/images/Likeme-thumb.png') . '" alt="Likeme-trust" class="certified">';
                    }

                    if ($result['lm_trust'] == 1) {
                        $icon = $icon . '<img src="' . asset('/webpage/images/Likeme-trust.png') . '" alt="Likeme-trust" class="certified">';
                    }

                   

                    $result['distance'] = round($result['distance'], 1);

                    $z = "'" . $result['shop_name'] . "'";
                    $zp = "'" . $result['photo1'] . "'";
                    $shop_name = "'" . $result['shop_name'] . "'";

                    $tiny_url = "'" . url('/tiny-' . $result['id']) . "'";


                    $golden_star = '<span class="star-3">';
                    for ($i = 0; $i < round($result['average_rating']); $i++) {
                        $golden_star = $golden_star . '';
                    }

                    $golden_star = $golden_star . '</span>';

                    $silver_star = '<span class="star-2">';
                    for ($i = 0; $i < 5 - round($result['average_rating']); $i++) {
                        $silver_star = $silver_star . '';
                    }

                    $silver_star = $silver_star . '</span>';

                    $rating_stars = '<a ' . $review_modal . ' onclick="set_review_business_id(' . $result['id'] . ',' . $shop_name . ')" class="showabove" style="width: 200px;display: inline-block;"><div class="d-block review-div">
                              <span id="rating_id" class="text-muted fs-13">' . round($result['average_rating'], 1) . '</span>
                              
                              
                                 ' . $golden_star . '' . $silver_star . '
                              <span class="text-muted fs-13 ">' . $result['review_count'] . '</span> <span class="text-muted">reviews</span> </div></a>';

                    if (round($result['average_rating']) == 0) {
                        $rating_stars = "";
                    }


                    $show_address_loading = $result['show_address_loding'] == 1 ? 'loading' : '';

                    $last_word_start = strrpos($result['area'], " ") + 1;
                    $last_word_end = strlen($result['area']) - 1;
                    $last_word = substr($result['area'], $last_word_start, $last_word_end);

                    if ($last_word == $result['city']) {
                        $business[$key]['address'] = $result['show_address_loding'] == 1 ? $result['address'] : $result['area'];
                    } else {
                        $business[$key]['address'] = $result['show_address_loding'] == 1 ? $result['address'] : $result['area'] . " " . $result['city'];
                    }



                    if (isset(Auth::guard('customer')->user()->id)) {

                        $zcv = 'data-bs-target="#enquireModal"';
                        $call_s = `onClick="alert('You Can't Call from desktop!!!!')"`;
                        $chat_s = 'onclick="openchat(' . $result['id'] . ',' . $z . ',' . $zp . ')" ';
                        $whatsapp_link = " href='https://api.whatsapp.com/send?phone=$phone_number&text=hi'";
                        $direction_link = "href='http://maps.google.com/?q=$address'";
                        $share_s = 'href="javascript:save_value(' . $v3 . ',' . $v2 . ',' . $tiny_url . ')"';
                    } else {


                        $zcv = 'data-bs-target="#staticBackdropza"';
                        $call_s = ' data-bs-toggle="modal" data-bs-target="#staticBackdropza" ';
                        $chat_s = ' data-bs-toggle="modal" data-bs-target="#staticBackdropza" ';
                        $whatsapp_link = ' data-bs-toggle="modal" data-bs-target="#staticBackdropza" ';
                        $direction_link = ' data-bs-toggle="modal" data-bs-target="#staticBackdropza" ';
                        $share_s = ' data-bs-toggle="modal" data-bs-target="#staticBackdropza" ';
                    }

                    if ($result['phone_number'] == "9191919191") {
                        $whatsapp_link = "";
                    }
                    if (substr($result['phone_number'], 0, 1) == "1") {
                        $whatsapp_link = "";
                    }
                    $shop_name = "'" . $result['shop_name'] . "'";
                    $id = "'" . $result['id'] . "'";
                    $photo1 = "'" . $result['photo1'] . "'";

                    $business[$key]['icon'] = $icon;
                    $business[$key]['rating_stars'] = $rating_stars;
                    $business[$key]['m_modal'] = $m_modal;
                    $business[$key]['m'] = $m;
                    $business[$key]['photo1'] = $photo1;
                    $business[$key]['zcv'] = $zcv;
                    $business[$key]['call_s'] = $call_s;
                    $business[$key]['chat_s'] = $chat_s;
                    $business[$key]['whatsapp_link'] = $whatsapp_link;
                    $business[$key]['direction_link'] = $direction_link;
                    $business[$key]['share_s'] = $share_s;
                    $business[$key]['get_best_price'] = $get_best_price;


                }
              $formatted_business = [];

        foreach ($business as $key => $bus) {
         $formatted_business[] = [
        'id' => $bus['id'],
        'shop_name' => $bus['shop_name'],
        'photo1' => $bus['photo1'],
        'thumb_icon' => $bus['thumb'],
        'trust_icon' => $bus['lm_trust'],
        'verified' => $bus['verified'],
        'average_rating' => round($bus['average_rating'], 1),
        'review_count' => $bus['review_count'],
        'rating_stars' => $bus['rating_stars'],
        'distance' => $bus['distance'],
        'address' => $bus['address'],
        'area' => $bus['area'],
        'city' => $bus['city'],
        'state' => $bus['state'],
        'time_status' => $bus['time'],
        'category_id' => $bus['category_id'] ?? null,
        'sub_category_id' => $bus['sub_category_id'] ?? null,
        'random_subcategory_div' => $bus['random_subcategory_div'],
        'cta' => [
            'call' => $bus['call_s'] ?? null,
            'chat' => $bus['chat_s'] ?? null,
            'whatsapp' => $bus['whatsapp_link'] ?? null,
            'enquiry' => $bus['zcv'] ?? null,
            'direction' => $bus['direction_link'] ?? null,
            'share' => $bus['share_s'] ?? null
        ],
        'webpage_link' => $bus['webpage_link'],
        'tiny_url' => url('/tiny-' . $bus['id']),
        'best_price' => $bus['get_best_price'] ?? null,
        'modal_data' => [
            'm_modal' => $bus['m_modal'] ?? null,
            'masked_phone' => $bus['m'] ?? null
        ]
    ];
}

if(isset($request->page)) {
    return response()->json($business);
}
else {

            $xzcv = explode("-in-", $search);
            if (isset($xzcv[1])) {
                $area_name = str_replace("-", " ", $xzcv[1]);
                $area_name = str_replace($city, " ", $area_name);
                $meta_tags = str_replace('{{$cityname}}', ucfirst($area_name) . " " . ucfirst($city), $meta_tags);
                $meta_title = str_replace('{{$cityname}}', ucfirst($area_name) . " " . ucfirst($city), $meta_title);

            } else {
                // var_dump();die;
                // if(isset($_COOKIE['CUR_CITY'])){
                //     $nmcity = $city;
                // }else{
                //     $nmcity = $request->city;
                // }
                $meta_tags = str_replace('{{$cityname}}', ucfirst($request->city), $meta_tags);
                $meta_title = str_replace('{{$cityname}}', ucfirst($request->city), $meta_title);


            }
            if ($agent->isMobile()) {

                $subcategories_1 = SubCategory::where('category_id', $cat_id)->inRandomOrder()->limit(10)->get();
                $subcategories_2 = SubCategory::where('category_id', $cat_id)->inRandomOrder()->limit(10)->get();
                $category = Category::find($cat_id);

                return view('mobile.webpage_listing', ["data" => $business, "meta_tags" => $meta_tags, "meta_title" => $meta_title, 'subcategories_1' => $subcategories_1, 'subcategories_2' => $subcategories_2, 'category_d' => $category]);
            }
            $content = $request->search_content;
            $d = explode("-in-", $content);
            $seeking = $d[0];
            $seeking = str_replace("-", " ", $seeking);

            $n = "";

            //   var_dump($business);die;

            $cat_id_array = explode(",", $cat_id);
            $cat_id = $cat_id_array[0];

            $cat = DB::table('categories')->where('id', '=', $cat_id)->first();
            if (!isset($cat->name) && isset($cat_id_array[1])) {
                $cat_id = $cat_id_array[1];
                $cat = DB::table('categories')->where('id', '=', $cat_id)->first();
                $n = $cat->name;
            } else if (!isset($cat_id_array[1])) {
                $n = "";
            } else {
                $n = $cat->name;
            }


            //  var_dump($query_no);die;


            $bus_ids = implode(",", $bus_id_array);

            $bread_crumb_array = array();

            $cat_d = Category::find($cat_id);
            $sub_cat_d = SubCategory::find($sub_cat_id);

            $bread_crumb_array["https://www.likeme.co.in/"] = ucfirst($city);

            $search_word = str_replace("-", " ", $search);



            //  $n_cat_id = $this->cat_return($cat_id);
            //  $n_sub_cat_id = $this->sub_cat_return("00");

            //   $sn = str_replace(" ","-",$cat_d->name);
            //   $sn = str_replace(",","-",$sn);
            //   $sn = str_replace("(","-",$sn);
            //                           $sn = str_replace(")","-",$sn);
            //                           $sn = str_replace("&","-",$sn);
            //                           $sn = str_replace("/","-",$sn);
            //                             $sn = str_replace("---","-",$sn);
            //                           $sn = str_replace("--","-",$sn);



            // $cat_url = url($city.'/'.$sn.'/lmid-'.$n_cat_id.$n_sub_cat_id); 
            // $cat_url = strtolower(str_replace(" ","-",$cat_url));



            // $bread_crumb_array[$cat_url]= $cat_d->name;


            // $n_cat_id = $this->cat_return($cat_id);
            //  $n_sub_cat_id = $this->sub_cat_return($sub_cat_id);
            //  if(isset($sub_cat_d->id) && !isset($request->bname)){


            //       $sn = str_replace(" ","-",$sub_cat_d->name);
            //              $sn = str_replace(",","-",$sn);
            //       $sn = str_replace("(","-",$sn);
            //                           $sn = str_replace(")","-",$sn);
            //                           $sn = str_replace("&","-",$sn);
            //                           $sn = str_replace("/","-",$sn);
            //                             $sn = str_replace("---","-",$sn);
            //                           $sn = str_replace("--","-",$sn);

            //     $sub_cat_url = url($city.'/'.$sn.'/lmid-'.$n_cat_id.$n_sub_cat_id); 
            //      $sub_cat_url = strtolower(str_replace(" ","-",$sub_cat_url));


            //     $bread_crumb_array[$sub_cat_url]= $sub_cat_d->name;
            //  }

            if (isset($request->bname)) {
                // $sub_cat_url = url($city.'/'.$sub_cat_d->name.'/lmid-'.$n_cat_id.$n_sub_cat_id); 
                //  $sub_cat_url = strtolower(str_replace(" ","-",$sub_cat_url));


                $bread_crumb_array[url()->full()] = ucwords($request->bname);
            } else {
                $bread_crumb_array[url()->full()] = ucwords($search_word) . " in " . ucfirst($city);
            }


            // echo(23);die;
            //  echo($city);die;
            $searched_city = strtolower(str_replace("-", " ", $city));
            //var_dump($searched_city);die;

            $za = "Top " . ucfirst(str_replace("-", " ", $request->search_content)) . " in " . $city;

            $advertismentbanner = AdvertismentBanner::leftjoin('businesses', 'businesses.id', 'advertisement_banner.business_id')
                                    ->where("location", 'LIKE', '%India%')->where('category', '=', '0')->get()->toArray();

            // $business_cat_banner = AdvertismentBanner::leftjoin('businesses', 'businesses.id', 'advertisement_banner.business_id')
            //     ->whereRaw("FIND_IN_SET($cat_id, businesses.category_id)")
            //     ->where("location", 'LIKE', '%India%')
            //     ->where('category', '=', '1') 
            //     ->get()->toArray();

            // $own_city_all_cat_banner = AdvertismentBanner::where("location", 'LIKE', "%$city%")
            //     ->where('category', '=', '0')
            //     ->where('location', 'LIKE', "%$state%")
            //     ->get()->toArray();

            // $own_city_business_cat_banner = AdvertismentBanner::leftjoin('businesses', 'businesses.id', 'advertisement_banner.business_id')
            //     ->whereRaw("FIND_IN_SET($cat_id, businesses.category_id)")
            //     ->where("location", 'LIKE', "%$city%")
            //     ->where('location', 'LIKE', "%$state%")
            //     ->where('category', '=', '1')
            //     ->get()->toArray();

            // $own_state_all_cat_banner = AdvertismentBanner::where("location", 'NOT LIKE', "%$city%")
            //     ->where('category', '=', '0')
            //     ->where('location', 'LIKE', "%$state%")
            //     ->get()->toArray();

            // $own_state_business_cat_banner = AdvertismentBanner::leftjoin('businesses', 'businesses.id', 'advertisement_banner.business_id')
            //     ->whereRaw("FIND_IN_SET($cat_id, businesses.category_id)")
            //     ->where("location", 'NOT LIKE', "%$city%")
            //     ->where('location', 'LIKE', "%$state%")
            //     ->where('category', '=', '1')
            //     ->get()->toArray();
            // $advertismentbanner = array_merge($all_india_all_cat_banner, $business_cat_banner, $own_city_all_cat_banner, $own_city_business_cat_banner, $own_state_all_cat_banner, $own_state_business_cat_banner);
         //$advertismentbanner = AdvertismentBanner::all();
            $ran = array(4, 4.5, 5);
            $rating = $ran[array_rand($ran, 1)];
            $rating_value = $rating;
            $rating_count = rand(100, 200);

            $id = $request->id;
            

            return view('frontend.new_business_list', ["lmid" => $id, "rating_value" => $rating_value, "rating_count" => $rating_count, "lm_page" => true, "advertismentbanner" => $advertismentbanner, "za" => $za, "category" => $cat_d, "cat_id" => $cat_id, "sub_cat_id" => $sub_cat_id, "bread_crumb_array" => $bread_crumb_array, "searched_city" => $searched_city, "meta_tags" => $meta_tags, "meta_title" => $meta_title, "cat_name" => $n, "lat" => $lat, "long" => $long, "search_content" => $search_content, "city" => $city, "search_results" => $business, "title_name" => $xzcv[0], "subcategory_array" => $subcategory_array, "business_subcategory" => $subcategory_array, "categories" => $category, "seeking" => $seeking, "cat_id" => $cat_id, "bus_ids" => $bus_ids]);
      
            }
        } 

    }
}
}