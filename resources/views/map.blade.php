<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>聖地巡礼マップ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Noto Sans JP', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .card-shadow {
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        #map {
            width: 100%;
            height: 600px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
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
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            max-width: 250px;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        .marker-label {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: 500;
            white-space: nowrap;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
        }

        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #4ade80 0%, #22c55e 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-secondary:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 20px rgba(74, 222, 128, 0.3);
        }

        .input-field {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(102, 126, 234, 0.2);
            border-radius: 8px;
            padding: 12px 16px;
            transition: all 0.3s ease;
            font-size: 14px;
        }

        .input-field:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
        }

        .stats-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .post-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .post-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            border-color: rgba(102, 126, 234, 0.2);
        }

        .nav-link {
            color: #4b5563;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
        }

        .nav-link.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        @media (max-width: 768px) {
            .container {
                padding: 10px;
            }

            #map {
                height: 400px;
            }

            .search-form {
                grid-template-columns: 1fr;
                gap: 15px;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-400 to-purple-600 min-h-screen">
    <div class="container mx-auto px-4 py-6">
        <!-- ヘッダー -->
        <div class="text-center mb-8">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 drop-shadow-lg">
                聖地巡礼マップ
            </h1>
            <p class="text-white/80 text-lg max-w-2xl mx-auto">
                アニメ・映画・ドラマの聖地を地図上で発見し、あなたの思い出を共有しましょう
            </p>
        </div>

        <!-- 検索フォーム -->
        <div class="glass-effect card-shadow rounded-2xl p-6 mb-8">
            <form id="searchForm" class="search-form grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">🔍 キーワード検索</label>
                    <input type="text" name="keyword" id="keyword" placeholder="タイトル、場所、人物名など"
                        class="input-field w-full">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">📂 カテゴリ</label>
                    <select name="category" id="category" class="input-field w-full">
                        <option value="">すべて</option>
                        <option value="places">🏛️ 場所</option>
                        <option value="people">👥 人物</option>
                        <option value="works">🎬 作品</option>
                        <option value="songs">🎵 楽曲</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">📍 現在地から検索</label>
                    <button type="button" id="currentLocation" class="btn-secondary w-full">
                        📍 現在地を取得
                    </button>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="btn-primary w-full">
                        🔍 検索
                    </button>
                </div>
            </form>
        </div>

        <!-- 検索結果統計 -->
        <div id="searchStats" class="stats-card mb-6">
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
                <div class="hover-lift">
                    <div class="text-3xl font-bold gradient-text">{{ $stats['total'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600 font-medium">総投稿数</div>
                </div>
                <div class="hover-lift">
                    <div class="text-3xl font-bold text-green-600">{{ $stats['places'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600 font-medium">🏛️ 場所</div>
                </div>
                <div class="hover-lift">
                    <div class="text-3xl font-bold text-purple-600">{{ $stats['people'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600 font-medium">👥 人物</div>
                </div>
                <div class="hover-lift">
                    <div class="text-3xl font-bold text-orange-600">{{ $stats['works'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600 font-medium">🎬 作品</div>
                </div>
                <div class="hover-lift">
                    <div class="text-3xl font-bold text-red-600">{{ $stats['songs'] ?? 0 }}</div>
                    <div class="text-sm text-gray-600 font-medium">🎵 楽曲</div>
                </div>
            </div>
        </div>

        <!-- マップ -->
        <div class="relative mb-8">
            <div id="map" class="card-shadow"></div>
        </div>

        <!-- 検索結果リスト -->
        <div id="searchResults" class="glass-effect card-shadow rounded-2xl p-6">
            <h2 class="text-2xl font-bold mb-6 gradient-text">📋 検索結果</h2>
            <div id="resultsList" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                <div class="post-card hover-lift">
                    <h3 class="font-bold text-xl mb-3 text-gray-800">{{ $post->title }}</h3>
                    <p class="text-gray-600 text-sm mb-3 leading-relaxed">{{ Str::limit($post->content, 120) }}</p>
                    <div class="text-xs text-gray-500 mb-3">
                        <span class="font-medium">👤 投稿者:</span> {{ $post->user->name }}
                    </div>
                    @if($post->places->count() > 0)
                    <div class="text-xs text-gray-500 mb-2">
                        <span class="font-medium">🏛️ 場所:</span> {{ $post->places->pluck('name')->implode(', ') }}
                    </div>
                    @endif
                    @if($post->people->count() > 0)
                    <div class="text-xs text-gray-500 mb-3">
                        <span class="font-medium">👥 人物:</span> {{ $post->people->pluck('name')->implode(', ') }}
                    </div>
                    @endif
                    <a href="{{ route('posts.show', $post->id) }}" class="inline-block bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:shadow-lg transition-all duration-300">
                        📖 詳細を見る
                    </a>
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
                zoom: 10,
                center: center,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: [{
                    featureType: 'poi',
                    elementType: 'labels',
                    stylers: [{
                        visibility: 'off'
                    }]
                }]
            });

            // 初期マーカーを表示
            displayMarkers(posts);
        }

        function displayMarkers(posts) {
            // 既存のマーカーを削除
            markers.forEach(function(marker) {
                marker.setMap(null);
            });
            markers = [];

            posts.forEach(function(post) {
                if (post.latitude && post.longitude) {
                    // カスタムマーカーアイコン（iPhone風のピン）
                    const markerIcon = {
                        path: google.maps.SymbolPath.CIRCLE,
                        scale: 8,
                        fillColor: '#667eea',
                        fillOpacity: 0.9,
                        strokeColor: '#FFFFFF',
                        strokeWeight: 2
                    };

                    const marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(post.latitude),
                            lng: parseFloat(post.longitude)
                        },
                        map: map,
                        title: post.title || '',
                        icon: markerIcon,
                        label: {
                            text: post.title || '投稿',
                            className: 'marker-label',
                            color: '#333333'
                        }
                    });

                    // 情報ウィンドウを作成
                    const infoWindow = new google.maps.InfoWindow({
                        content: `
                            <div class="marker-info">
                                <h3 class="font-bold text-lg mb-2 text-gray-800">${post.title || 'タイトルなし'}</h3>
                                <p class="text-sm text-gray-600 mb-2">${post.content ? post.content.substring(0, 100) + '...' : ''}</p>
                                <p class="text-xs text-gray-500 mb-2">👤 投稿者: ${post.user ? post.user.name : '不明'}</p>
                                <div class="flex justify-between items-center">
                                    <a href="/posts/${post.id}" class="text-blue-500 hover:text-blue-700 text-sm font-medium">📖 詳細を見る</a>
                                    <span class="text-xs text-gray-400">${post.places ? post.places.join(', ') : ''}</span>
                                </div>
                            </div>
                        `
                    });

                    // クリックで情報ウィンドウを表示
                    marker.addListener('click', function() {
                        infoWindow.open(map, marker);
                    });

                    // ズームレベルに応じてラベルを表示/非表示
                    google.maps.event.addListener(map, 'zoom_changed', function() {
                        const zoom = map.getZoom();
                        if (zoom >= 12) {
                            marker.setLabel({
                                text: post.title || '投稿',
                                className: 'marker-label',
                                color: '#333333'
                            });
                        } else {
                            marker.setLabel(null);
                        }
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
            var resultsList = document.getElementById('resultsList');
            resultsList.innerHTML = '';

            posts.forEach(function(post) {
                const postElement = document.createElement('div');
                postElement.className = 'post-card hover-lift';
                postElement.innerHTML = `
                    <h3 class="font-bold text-xl mb-3 text-gray-800">${post.title || 'タイトルなし'}</h3>
                    <p class="text-gray-600 text-sm mb-3 leading-relaxed">${post.content ? post.content.substring(0, 120) + '...' : ''}</p>
                    <div class="text-xs text-gray-500 mb-3">
                        <span class="font-medium">👤 投稿者:</span> ${post.user || '不明'}
                    </div>
                    ${post.places && post.places.length > 0 ? `
                        <div class="text-xs text-gray-500 mb-2">
                            <span class="font-medium">🏛️ 場所:</span> ${post.places.join(', ')}
                        </div>
                    ` : ''}
                    ${post.people && post.people.length > 0 ? `
                        <div class="text-xs text-gray-500 mb-3">
                            <span class="font-medium">👥 人物:</span> ${post.people.join(', ')}
                        </div>
                    ` : ''}
                    <a href="${post.url}" class="inline-block bg-gradient-to-r from-blue-500 to-purple-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:shadow-lg transition-all duration-300">
                        📖 詳細を見る
                    </a>
                `;
                resultsList.appendChild(postElement);
            });
        }

        function updateStats(posts) {
            var stats = {
                total: posts.length,
                places: posts.filter(function(p) {
                    return p.places && p.places.length > 0;
                }).length,
                people: posts.filter(function(p) {
                    return p.people && p.people.length > 0;
                }).length,
                works: posts.filter(function(p) {
                    return p.works && p.works.length > 0;
                }).length,
                songs: posts.filter(function(p) {
                    return p.songs && p.songs.length > 0;
                }).length
            };

            const statsElement = document.getElementById('searchStats');
            statsElement.innerHTML = `
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
                    <div class="hover-lift">
                        <div class="text-3xl font-bold gradient-text">${stats.total}</div>
                        <div class="text-sm text-gray-600 font-medium">総投稿数</div>
                    </div>
                    <div class="hover-lift">
                        <div class="text-3xl font-bold text-green-600">${stats.places}</div>
                        <div class="text-sm text-gray-600 font-medium">🏛️ 場所</div>
                    </div>
                    <div class="hover-lift">
                        <div class="text-3xl font-bold text-purple-600">${stats.people}</div>
                        <div class="text-sm text-gray-600 font-medium">👥 人物</div>
                    </div>
                    <div class="hover-lift">
                        <div class="text-3xl font-bold text-orange-600">${stats.works}</div>
                        <div class="text-sm text-gray-600 font-medium">🎬 作品</div>
                    </div>
                    <div class="hover-lift">
                        <div class="text-3xl font-bold text-red-600">${stats.songs}</div>
                        <div class="text-sm text-gray-600 font-medium">🎵 楽曲</div>
                    </div>
                </div>
            `;
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapsApiKey }}&callback=initMap" async defer></script>
</body>

</html>