<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>予約のキャンセルメール</title>
</head>

<body>
    <p>{{ $reservation->first_name }} {{ $reservation->last_name }}様</p>
    <p>予約のキャンセルメールを送らせていただきます。</p>
    <p>以下、宿泊内容となります。</p>
    <h2>宿泊内容</h2>
    <h3>予約日時</h3>
    <p>{{ $reservation->start_day }}　〜　{{ $reservation->end_day }}</p>
    <h3>予約人数</h3>
    <p>{{ $reservation->number_of_people }}</p>
</body>

</html>
