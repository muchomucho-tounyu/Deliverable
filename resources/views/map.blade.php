<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>聖地巡礼マップ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #map {
            width: 100%;
            height: 600px;
        }

        .search-overlay {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 1000;
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
        }

        .marker-info {
            background: white;
            padding: 10px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            max-width: 200px;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold text-center mb-6">聖地巡礼マップ</h1>

        <!-- 検索フォーム -->
        <div class="mb-6 bg-white rounded-lg shadow-md p-6">
            <form id="searchForm" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">キーワード検索</label>
                    <input type="text" name="keyword" id="keyword" placeholder="タイトル、場所、人物名など"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">カテゴリ</label>
                    <select name="category" id="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">すべて</option>
                        <option value="places">場所</option>
                        <option value="people">人物</option>
                        <option value="works">作品</option>
                        <option value="songs">楽曲</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">現在地から検索</label>
                    <button type="button" id="currentLocation" class="w-full px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                        現在地を取得
                    </button>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        検索
                    </button>
                </div>
            </form>
        </div>

        <!-- 検索結果統計 -->
        <div id="searchStats" class="mb-4 bg-white rounded-lg shadow-md p-4">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
                <div>
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['total'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">総投稿数</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-green-600">{{ $stats['places'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">場所</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['people'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">人物</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-orange-600">{{ $stats['works'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">作品</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-red-600">{{ $stats['songs'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600">楽曲</div>
                </div>
            </div>
        </div>

        <!-- マップ -->
        <div class="relative">
            <div id="map" class="rounded-lg shadow-lg"></div>
        </div>

        <!-- 検索結果リスト -->
        <div id="searchResults" class="mt-6 bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold mb-4">検索結果</h2>
            <div id="resultsList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($posts as $post)
                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
                    <h3 class="font-bold text-lg mb-2">{{ $post->title }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($post->content, 100) }}</p>
                    <div class="text-xs text-gray-500 mb-2">
                        <span class="font-medium">投稿者:</span> {{ $post->user->name }}
                    </div>
                    @if($post->places->count() > 0)
                    <div class="text-xs text-gray-500 mb-1">
                        <span class="font-medium">場所:</span> {{ $post->places->pluck('name')->implode(', ') }}
                    </div>
                    @endif
                    @if($post->people->count() > 0)
                    <div class="text-xs text-gray-500 mb-1">
                        <span class="font-medium">人物:</span> {{ $post->people->pluck('name')->implode(', ') }}
                    </div>
                    @endif
                    <a href="{{ route('posts.show', $post->id) }}" class="text-blue-500 hover:text-blue-700 text-sm">詳細を見る</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        let map;
        let markers = [];
        let currentLocationMarker;
        const posts = @json($posts);

        function initMap() {
            // 最初の投稿があればその位置を中心に、なければ日本の中心
            const center = posts.length > 0 ? {
                lat: parseFloat(posts[0].latitude),
                lng: parseFloat(posts[0].longitude)
            } : {
                lat: 35.681236,
                lng: 139.767125
            };

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: center
            });

            // 初期マーカーを表示
            displayMarkers(posts);
        }

        function displayMarkers(posts) {
            // 既存のマーカーを削除
            markers.forEach(marker => marker.setMap(null));
            markers = [];

            posts.forEach(post => {
                if (post.latitude && post.longitude) {
                    const marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(post.latitude),
                            lng: parseFloat(post.longitude)
                        },
                        map: map,
                        title: post.title || ''
                    });

                    // 情報ウィンドウを作成
                    const infoWindow = new google.maps.InfoWindow({
                        content: `
                            <div class="marker-info">
                                <h3 class="font-bold">${post.title || 'タイトルなし'}</h3>
                                <p class="text-sm text-gray-600">${post.content ? post.content.substring(0, 100) + '...' : ''}</p>
                                <p class="text-xs text-gray-500">投稿者: ${post.user ? post.user.name : '不明'}</p>
                                <a href="/posts/${post.id}" class="text-blue-500 hover:text-blue-700 text-sm">詳細を見る</a>
                            </div>
                        `
                    });

                    marker.addListener('click', function() {
                        infoWindow.open(map, marker);
                    });

                    markers.push(marker);
                }
            });
        }

        // 検索フォームの処理
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            performSearch();
        });

        // 現在地取得
        document.getElementById('currentLocation').addEventListener('click', function() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;

                    // 現在地マーカーを表示
                    if (currentLocationMarker) {
                        currentLocationMarker.setMap(null);
                    }

                    currentLocationMarker = new google.maps.Marker({
                        position: {
                            lat: lat,
                            lng: lng
                        },
                        map: map,
                        title: '現在地',
                        icon: {
                            url: 'http://maps.google.com/mapfiles/ms/icons/blue-dot.png'
                        }
                    });

                    // マップを現在地に移動
                    map.setCenter({
                        lat: lat,
                        lng: lng
                    });
                    map.setZoom(12);

                    // 現在地周辺を検索
                    performSearch(lat, lng, 5); // 5km範囲
                });
            } else {
                alert('位置情報を取得できませんでした。');
            }
        });

        function performSearch(lat, lng, radius) {
            var formData = new FormData(document.getElementById('searchForm'));
            var params = new URLSearchParams();

            // フォームデータをパラメータに追加
            for (var i = 0; i < formData.entries().length; i++) {
                var entry = formData.entries()[i];
                if (entry[1]) params.append(entry[0], entry[1]);
            }

            // 位置情報がある場合は追加
            if (lat && lng && radius) {
                params.append('lat', lat);
                params.append('lng', lng);
                params.append('radius', radius);
            }

            // AJAXで検索実行
            fetch('/map/search?' + params.toString())
                .then(function(response) {
                    return response.json();
                })
                .then(function(data) {
                    displayMarkers(data.posts);
                    updateSearchResults(data.posts);
                    updateStats(data.posts);
                })
                .catch(function(error) {
                    console.error('検索エラー:', error);
                });
        }

        function updateSearchResults(posts) {
            const resultsList = document.getElementById('resultsList');
            resultsList.innerHTML = '';

            posts.forEach(post => {
                const postElement = document.createElement('div');
                postElement.className = 'border rounded-lg p-4 hover:shadow-md transition-shadow';
                postElement.innerHTML = `
                    <h3 class="font-bold text-lg mb-2">${post.title || 'タイトルなし'}</h3>
                    <p class="text-gray-600 text-sm mb-2">${post.content ? post.content.substring(0, 100) + '...' : ''}</p>
                    <div class="text-xs text-gray-500 mb-2">
                        <span class="font-medium">投稿者:</span> ${post.user || '不明'}
                    </div>
                    ${post.places && post.places.length > 0 ? `
                        <div class="text-xs text-gray-500 mb-1">
                            <span class="font-medium">場所:</span> ${post.places.join(', ')}
                        </div>
                    ` : ''}
                    ${post.people && post.people.length > 0 ? `
                        <div class="text-xs text-gray-500 mb-1">
                            <span class="font-medium">人物:</span> ${post.people.join(', ')}
                        </div>
                    ` : ''}
                    <a href="${post.url}" class="text-blue-500 hover:text-blue-700 text-sm">詳細を見る</a>
                `;
                resultsList.appendChild(postElement);
            });
        }

        function updateStats(posts) {
            const stats = {
                total: posts.length,
                places: posts.filter(p => p.places && p.places.length > 0).length,
                people: posts.filter(p => p.people && p.people.length > 0).length,
                works: posts.filter(p => p.works && p.works.length > 0).length,
                songs: posts.filter(p => p.songs && p.songs.length > 0).length
            };

            const statsElement = document.getElementById('searchStats');
            statsElement.innerHTML = `
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-blue-600">${stats.total}</div>
                        <div class="text-sm text-gray-600">総投稿数</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-600">${stats.places}</div>
                        <div class="text-sm text-gray-600">場所</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-purple-600">${stats.people}</div>
                        <div class="text-sm text-gray-600">人物</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-orange-600">${stats.works}</div>
                        <div class="text-sm text-gray-600">作品</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-red-600">${stats.songs}</div>
                        <div class="text-sm text-gray-600">楽曲</div>
                    </div>
                </div>
            `;
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapsApiKey }}&callback=initMap" async defer></script>
</body>

</html>