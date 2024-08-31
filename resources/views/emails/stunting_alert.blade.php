<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
        }
        .content {
            margin: 20px;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .header {
            background-color: #FF5722;
            color: white;
            padding: 10px;
            border-radius: 5px 5px 0 0;
        }
        .footer {
            margin-top: 20px;
            padding: 10px;
            background-color: #FF5722;
            color: white;
            text-align: center;
            border-radius: 0 0 5px 5px;
        }
        ul {
            padding-left: 20px;
        }
    </style>
</head>
<body>
    <div class="content">
        <div class="header">
            <h2>Peringatan Tingkat Stunting Tinggi di Beberapa Kelurahan</h2>
        </div>
        <p>Yth. Bapak/Ibu,</p>
        <p>Kami ingin memberitahukan bahwa jumlah pasien dengan status stunting telah mencapai tingkat yang tinggi di beberapa kelurahan. Berikut adalah daftar kelurahan yang memiliki status stunting tinggi:</p>
        <ul>
            @foreach ($stuntingLocations as $location)
                <li>{{ $location }}</li>
            @endforeach
        </ul>
        <p>Kami sangat mengkhawatirkan kondisi ini dan berharap dapat segera mengambil tindakan yang diperlukan untuk menanggulangi masalah stunting di wilayah ini.</p>
        <p>Terima kasih atas perhatian dan kerjasamanya.</p>
        <p>Salam,</p>
        <p>Tim Kesehatan</p>
        <div class="footer">
            &copy; 2024 Tim Kesehatan. All rights reserved.
        </div>
    </div>
</body>
</html>
