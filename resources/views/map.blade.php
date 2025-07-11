<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>聖地巡礼マップ</title>
    <style>
        #map {
            width: 100%;
            height: 600px;
        }
    </style>
</head>

<body>
    <h1>聖地巡礼マップ</h1>
    <div id="map"></div>
    <script>
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
            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 8,
                center: center
            });
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
                    marker.addListener('click', function() {
                        window.location.href = `/posts/${post.id}`;
                    });
                }
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key={{ $googleMapsApiKey }}&callback=initMap" async defer></script>
</body>

</html>