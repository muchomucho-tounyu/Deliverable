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
            background: #f8fafc;
            margin: 0;
            padding: 0;
            height: 100vh;
            overflow: hidden;
        }

        .search-header {
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
        }

        .map-container {
            position: fixed;
            top: 80px;
            left: 0;
            right: 0;
            bottom: 0;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        .search-form {
            display: flex;
            gap: 15px;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .search-input {
            flex: 1;
            max-width: 300px;
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .search-select {
            padding: 10px 15px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 14px;
            background: white;
            transition: all 0.3s ease;
        }

        .search-select:focus {
            outline: none;
            border-color: #667eea;
        }

        .btn-primary {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: #5a67d8;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #48bb78;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: #38a169;
            transform: translateY(-1px);
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

        @media (max-width: 768px) {
            .search-form {
                flex-direction: column;
                gap: 10px;
            }

            .search-input,
            .search-select {
                max-width: none;
                width: 100%;
            }

            .search-header {
                padding: 10px 15px;
            }

            .map-container {
                top: 120px;
            }
        }

        .back-to-search-btn {
            position: fixed;
            top: 18px;
            left: 18px;
            z-index: 1100;
            background: #fff;
            color: #667eea;
            font-weight: bold;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.10);
            padding: 7px 18px 7px 12px;
            text-decoration: none;
            transition: background 0.2s, color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .back-to-search-btn:hover {
            background: #e0e7ff;
            color: #764ba2;
        }
    </style>
</head>

<body>
    <!-- 検索に戻るボタン -->
    <a href="{{ url()->previous() }}" class="back-to-search-btn" title="検索に戻る">
        <span style="font-size:1.3em;">←</span> 検索に戻る
    </a>
    <!-- 検索ヘッダー -->
    <div class="search-header">
        <form id="searchForm" class="search-form">
            <input type="text" name="keyword" id="keyword" placeholder="🔍 キーワード検索"
                class="search-input">

            <select name="category" id="category" class="search-select">
                <option value="">📂 すべて</option>
                <option value="places">🏛️ 場所</option>
                <option value="people">👥 人物</option>
                <option value="works">🎬 作品</option>
                <option value="songs">🎵 楽曲</option>
            </select>

            <button type="button" id="currentLocation" class="btn-secondary">
                📍 現在地
            </button>

            <button type="submit" class="btn-primary">
                🔍 検索
            </button>
        </form>
    </div>

    <!-- マップコンテナ -->
    <div class="map-container">
        <div id="map"></div>
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

                    // クリックで投稿詳細ページに遷移
                    marker.addListener('click', function() {
                        window.location.href = `/posts/${post.id}`;
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
                })
                .catch(function(error) {
                    console.error('検索エラー:', error);
                });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapsApiKey }}&callback=initMap" async defer></script>
</body>

</html>