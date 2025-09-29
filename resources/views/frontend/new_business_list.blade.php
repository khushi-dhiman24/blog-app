<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $meta_title ?? 'Business Listings' }}</title>
    <meta name="description" content="{{ $meta_tags ?? '' }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        .breadcrumb {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }
        .breadcrumb a {
            color: #3498db;
            text-decoration: none;
        }
        .breadcrumb a:hover {
            text-decoration: underline;
        }
        .filters {
            background: white;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .business-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .business-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .business-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .business-image {
            width: 100%;
            height: 200px;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #999;
        }
        .business-info {
            padding: 15px;
        }
        .business-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #2c3e50;
        }
        .business-address {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .business-phone {
            color: #3498db;
            font-size: 14px;
            text-decoration: none;
        }
        .rating {
            margin: 10px 0;
            color: #f39c12;
        }
        .categories {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            margin-top: 10px;
        }
        .category-tag {
            background: #ecf0f1;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: #7f8c8d;
        }
        .no-results {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 8px;
            color: #666;
        }
        .load-more {
            text-align: center;
            margin-top: 30px;
        }
        .load-more button {
            background: #3498db;
            color: white;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .load-more button:hover {
            background: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="breadcrumb">
                @if(isset($bread_crumb_array))
                    @foreach($bread_crumb_array as $url => $name)
                        @if($loop->last)
                            {{ $name }}
                        @else
                            <a href="{{ $url }}">{{ $name }}</a> /
                        @endif
                    @endforeach
                @endif
            </div>
            <h1>{{ $za ?? 'Business Listings' }}</h1>
            <p>Found {{ count($search_results ?? []) }} businesses in {{ ucfirst($city ?? 'your area') }}</p>
        </div>

        @if(isset($subcategory_array) && count($subcategory_array) > 0)
        <div class="filters">
            <strong>Related Categories:</strong>
            @foreach($subcategory_array->take(10) as $subcat)
                <span class="category-tag">{{ $subcat->name }}</span>
            @endforeach
        </div>
        @endif

        @if(isset($search_results) && count($search_results) > 0)
            <div class="business-grid">
                @foreach($search_results as $business)
                <div class="business-card">
                    @if(!empty($business['photo1']))
                        <img src="{{ $business['photo1'] }}" alt="{{ $business['shop_name'] }}" class="business-image" style="object-fit: cover;">
                    @else
                        <div class="business-image">
                            <span>No Image Available</span>
                        </div>
                    @endif
                    
                    <div class="business-info">
                        <div class="business-name">{{ $business['shop_name'] ?? 'Business Name' }}</div>
                        
                        @if(!empty($business['address']))
                            <div class="business-address">📍 {{ $business['address'] }}, {{ $business['area'] ?? '' }}</div>
                        @endif
                        
                        @if(!empty($business['phone_number']))
                            <a href="tel:{{ $business['phone_number'] }}" class="business-phone">📞 {{ $business['phone_number'] }}</a>
                        @endif
                        
                        @if(isset($business['rating_stars']))
                            <div class="rating">{!! $business['rating_stars'] !!}</div>
                        @endif
                        
                        @if(!empty($business['distance']))
                            <div style="color: #666; font-size: 14px;">📏 {{ $business['distance'] }} km away</div>
                        @endif
                        
                        @if(isset($business['time']))
                            <div style="margin-top: 10px; font-size: 14px;">{!! $business['time'] !!}</div>
                        @endif
                        
                        @if(isset($business['randomSubCategories']) && count($business['randomSubCategories']) > 0)
                            <div class="categories">
                                @foreach($business['randomSubCategories'] as $subcat)
                                    @if($subcat)
                                        <span class="category-tag">{{ $subcat->name ?? '' }}</span>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        
                        @if(!empty($business['verified']))
                            {!! $business['verified'] !!}
                        @endif
                        
                        @if(!empty($business['webpage_link']))
                            <div style="margin-top: 10px;">
                                <a href="{{ $business['webpage_link'] }}" style="color: #3498db; text-decoration: none;">View Details →</a>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="load-more">
                <button onclick="loadMore()">Load More</button>
            </div>
        @else
            <div class="no-results">
                <h2>No businesses found</h2>
                <p>Try adjusting your search criteria or browse different categories.</p>
            </div>
        @endif
    </div>

    <script>
        let currentPage = 0;
        
        function loadMore() {
            currentPage++;
            fetch(window.location.href + '?page=' + currentPage, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if(data && data.length > 0) {
                    // Append new results
                    console.log('Loaded more results:', data);
                } else {
                    document.querySelector('.load-more').style.display = 'none';
                }
            })
            .catch(error => console.error('Error loading more:', error));
        }
    </script>

    <style>
        .star-3 { color: #ffc107; }
        .star-2 { color: #ddd; }
        .open-green { color: #28a745; font-weight: bold; }
        .close-red { color: #dc3545; font-weight: bold; }
        .badge { 
            display: inline-block;
            padding: 4px 8px;
            font-size: 12px;
            border-radius: 4px;
        }
        .bg-success { 
            background-color: #28a745;
            color: white;
        }
        .mx-3 { margin: 0 10px; }
    </style>
</body>
</html>
