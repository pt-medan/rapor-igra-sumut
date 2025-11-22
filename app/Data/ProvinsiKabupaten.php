<?php

namespace App\Data;

class ProvinsiKabupaten
{
    /**
     * Data Provinsi dan Kabupaten/Kota di Indonesia
     * Sumber: Data Resmi Wilayah Administratif Indonesia
     */
    public static function getProvinsi()
    {
        return [
            ['id' => 1, 'name' => 'Aceh'],
            ['id' => 2, 'name' => 'Sumatera Utara'],
            ['id' => 3, 'name' => 'Sumatera Barat'],
            ['id' => 4, 'name' => 'Riau'],
            ['id' => 5, 'name' => 'Jambi'],
            ['id' => 6, 'name' => 'Sumatera Selatan'],
            ['id' => 7, 'name' => 'Bengkulu'],
            ['id' => 8, 'name' => 'Lampung'],
            ['id' => 9, 'name' => 'Kepulauan Bangka Belitung'],
            ['id' => 10, 'name' => 'Kepulauan Riau'],
            ['id' => 11, 'name' => 'Jawa Barat'],
            ['id' => 12, 'name' => 'Jawa Tengah'],
            ['id' => 13, 'name' => 'Daerah Istimewa Yogyakarta'],
            ['id' => 14, 'name' => 'Jawa Timur'],
            ['id' => 15, 'name' => 'Banten'],
            ['id' => 16, 'name' => 'Bali'],
            ['id' => 17, 'name' => 'Nusa Tenggara Barat'],
            ['id' => 18, 'name' => 'Nusa Tenggara Timur'],
            ['id' => 19, 'name' => 'Kalimantan Barat'],
            ['id' => 20, 'name' => 'Kalimantan Tengah'],
            ['id' => 21, 'name' => 'Kalimantan Selatan'],
            ['id' => 22, 'name' => 'Kalimantan Timur'],
            ['id' => 23, 'name' => 'Kalimantan Utara'],
            ['id' => 24, 'name' => 'Sulawesi Utara'],
            ['id' => 25, 'name' => 'Sulawesi Tengah'],
            ['id' => 26, 'name' => 'Sulawesi Selatan'],
            ['id' => 27, 'name' => 'Sulawesi Tenggara'],
            ['id' => 28, 'name' => 'Gorontalo'],
            ['id' => 29, 'name' => 'Sulawesi Barat'],
            ['id' => 30, 'name' => 'Maluku'],
            ['id' => 31, 'name' => 'Maluku Utara'],
            ['id' => 32, 'name' => 'Papua'],
            ['id' => 33, 'name' => 'Papua Barat'],
            ['id' => 34, 'name' => 'Jakarta'],
        ];
    }

    /**
     * Data Kabupaten/Kota untuk setiap Provinsi
     */
    public static function getKabupaten($provinsiId = null)
    {
        $kabupatenByProv = [
            1 => [ // Aceh
                'Kabupaten Aceh Selatan', 'Kabupaten Aceh Tenggara', 'Kabupaten Aceh Timur', 'Kabupaten Aceh Jaya',
                'Kabupaten Aceh Barat', 'Kabupaten Aceh Besar', 'Kabupaten Pidie', 'Kabupaten Pidie Jaya',
                'Kabupaten Bireuen', 'Kabupaten Simeulue', 'Kabupaten Gayo Lues', 'Kabupaten Alas',
                'Kota Banda Aceh', 'Kota Sabang', 'Kota Lhokseumawe', 'Kota Langsa'
            ],
            2 => [ // Sumatera Utara
                'Kabupaten Nias', 'Kabupaten Mandailing Natal', 'Kabupaten Tapanuli Selatan', 'Kabupaten Tapanuli Tengah',
                'Kabupaten Tapanuli Utara', 'Kabupaten Toba', 'Kabupaten Labuhanbatu', 'Kabupaten Labuhanbatu Utara',
                'Kabupaten Labuhanbatu Selatan', 'Kabupaten Asahan', 'Kabupaten Simalungun', 'Kabupaten Dairi',
                'Kabupaten Karo', 'Kabupaten Deli Serdang', 'Kabupaten Langkat', 'Kabupaten Nias Utara',
                'Kabupaten Nias Barat', 'Kota Sibolga', 'Kota Tanjung Balai', 'Kota Pematang Siantar',
                'Kota Tebing Tinggi', 'Kota Medan', 'Kota Binjai', 'Kota Padang Sidimpuan',
                'Kabupaten Pakpak Bharat', 'Kota Gunungsitoli'
            ],
            3 => [ // Sumatera Barat
                'Kabupaten Pesisir Selatan', 'Kabupaten Solok', 'Kabupaten Sijunjung', 'Kabupaten Tanah Datar',
                'Kabupaten Padang Pariaman', 'Kabupaten Agam', 'Kabupaten Lima Puluh Kota', 'Kabupaten Pasaman',
                'Kabupaten Solok Selatan', 'Kabupaten Pasaman Barat', 'Kota Padang', 'Kota Solok',
                'Kota Sawahlunto', 'Kota Padang Panjang', 'Kota Bukittinggi'
            ],
            4 => [ // Riau
                'Kabupaten Kuantan Singingi', 'Kabupaten Indragiri Hulu', 'Kabupaten Indragiri Hilir', 'Kabupaten Pelalawan',
                'Kabupaten Rokan Hulu', 'Kabupaten Bengkalis', 'Kabupaten Rokan Hilir', 'Kabupaten Kampar',
                'Kabupaten Siak', 'Kabupaten Kepulauan Meranti', 'Kota Pekanbaru', 'Kota Dumai'
            ],
            5 => [ // Jambi
                'Kabupaten Kerinci', 'Kabupaten Merangin', 'Kabupaten Sarolangun', 'Kabupaten Batanghari',
                'Kabupaten Muaro Jambi', 'Kabupaten Tanjung Jabung Timur', 'Kabupaten Tanjung Jabung Barat', 'Kabupaten Tebo',
                'Kota Jambi', 'Kota Sungai Penuh'
            ],
            6 => [ // Sumatera Selatan
                'Kabupaten Ogan Komering Ulu', 'Kabupaten Ogan Komering Ilir', 'Kabupaten Muara Enim', 'Kabupaten Lahat',
                'Kabupaten Musi Rawas', 'Kabupaten Musi Banyuasin', 'Kabupaten Banyu Asin', 'Kabupaten Ogan Komering Ulu Selatan',
                'Kabupaten Ogan Komering Ulu Timur', 'Kabupaten Musi Rawas Utara', 'Kota Palembang', 'Kota Prabumulih',
                'Kota Lubuk Linggau'
            ],
            7 => [ // Bengkulu
                'Kabupaten Seluma', 'Kabupaten Rejang Lebong', 'Kabupaten Bengkulu Utara', 'Kabupaten Bengkulu Tengah',
                'Kabupaten Kaur', 'Kabupaten Lebong', 'Kota Bengkulu'
            ],
            8 => [ // Lampung
                'Kabupaten Lampung Barat', 'Kabupaten Lampung Utara', 'Kabupaten Lampung Tengah', 'Kabupaten Lampung Timur',
                'Kabupaten Lampung Selatan', 'Kabupaten Tulang Bawang', 'Kabupaten Pesawaran', 'Kabupaten Pringsewu',
                'Kabupaten Mesuji', 'Kabupaten Tulang Bawang Barat', 'Kabupaten Way Kanan', 'Kota Bandar Lampung',
                'Kota Metro'
            ],
            9 => [ // Kepulauan Bangka Belitung
                'Kabupaten Bangka', 'Kabupaten Belitung', 'Kabupaten Bangka Barat', 'Kabupaten Bangka Tengah',
                'Kabupaten Bangka Selatan', 'Kabupaten Belitung Timur', 'Kota Pangkal Pinang'
            ],
            10 => [ // Kepulauan Riau
                'Kabupaten Karimun', 'Kabupaten Bintan', 'Kabupaten Natuna', 'Kabupaten Anambas',
                'Kota Batam', 'Kota Tanjung Pinang'
            ],
            11 => [ // Jawa Barat
                'Kabupaten Bogor', 'Kabupaten Sukabumi', 'Kabupaten Cianjur', 'Kabupaten Bandung',
                'Kabupaten Garut', 'Kabupaten Tasikmalaya', 'Kabupaten Ciamis', 'Kabupaten Kuningan',
                'Kabupaten Cirebon', 'Kabupaten Indramayu', 'Kabupaten Majalengka', 'Kabupaten Sumedang',
                'Kabupaten Subang', 'Kabupaten Purwakarta', 'Kabupaten Karawang', 'Kabupaten Bekasi',
                'Kabupaten Bandung Barat', 'Kota Bogor', 'Kota Sukabumi', 'Kota Bandung',
                'Kota Garut', 'Kota Tasikmalaya', 'Kota Cirebon', 'Kota Bekasi',
                'Kota Depok', 'Kota Cimahi', 'Kabupaten Pangandaran'
            ],
            12 => [ // Jawa Tengah
                'Kabupaten Cilacap', 'Kabupaten Banyumas', 'Kabupaten Purbalingga', 'Kabupaten Banjarnegara',
                'Kabupaten Kebumen', 'Kabupaten Purworejo', 'Kabupaten Wonosobo', 'Kabupaten Magelang',
                'Kabupaten Boyolali', 'Kabupaten Klaten', 'Kabupaten Sukoharjo', 'Kabupaten Wonogiri',
                'Kabupaten Karanganyar', 'Kabupaten Sragen', 'Kabupaten Grobogan', 'Kabupaten Blora',
                'Kabupaten Rembang', 'Kabupaten Pati', 'Kabupaten Kudus', 'Kabupaten Jepara',
                'Kabupaten Demak', 'Kabupaten Semarang', 'Kabupaten Temanggung', 'Kabupaten Kendal',
                'Kabupaten Batang', 'Kabupaten Pekalongan', 'Kabupaten Pemalang', 'Kabupaten Tegal',
                'Kabupaten Brebes', 'Kota Magelang', 'Kota Surakarta', 'Kota Salatiga',
                'Kota Semarang', 'Kota Pekalongan', 'Kota Tegal'
            ],
            13 => [ // Daerah Istimewa Yogyakarta
                'Kabupaten Kulon Progo', 'Kabupaten Bantul', 'Kabupaten Gunung Kidul', 'Kabupaten Sleman',
                'Kota Yogyakarta'
            ],
            14 => [ // Jawa Timur
                'Kabupaten Pacitan', 'Kabupaten Ponorogo', 'Kabupaten Trenggalek', 'Kabupaten Tulungagung',
                'Kabupaten Blitar', 'Kabupaten Kediri', 'Kabupaten Malang', 'Kabupaten Lumajang',
                'Kabupaten Jember', 'Kabupaten Banyuwangi', 'Kabupaten Bondowoso', 'Kabupaten Situbondo',
                'Kabupaten Probolinggo', 'Kabupaten Pasuruan', 'Kabupaten Sidoarjo', 'Kabupaten Mojokerto',
                'Kabupaten Jombang', 'Kabupaten Nganjuk', 'Kabupaten Madiun', 'Kabupaten Magetan',
                'Kabupaten Ngawi', 'Kabupaten Bojonegoro', 'Kabupaten Tuban', 'Kabupaten Lamongan',
                'Kabupaten Gresik', 'Kabupaten Bangkalan', 'Kabupaten Sampang', 'Kabupaten Pamekasan',
                'Kabupaten Sumenep', 'Kota Kediri', 'Kota Blitar', 'Kota Malang',
                'Kota Probolinggo', 'Kota Pasuruan', 'Kota Mojokerto', 'Kota Madiun',
                'Kota Surabaya', 'Kota Batu'
            ],
            15 => [ // Banten
                'Kabupaten Pandeglang', 'Kabupaten Lebak', 'Kabupaten Tangerang', 'Kabupaten Serang',
                'Kota Tangerang', 'Kota Cilegon', 'Kota Serang', 'Kota Tangerang Selatan'
            ],
            16 => [ // Bali
                'Kabupaten Jembrana', 'Kabupaten Tabanan', 'Kabupaten Badung', 'Kabupaten Gianyar',
                'Kabupaten Klungkung', 'Kabupaten Bangli', 'Kota Denpasar'
            ],
            17 => [ // Nusa Tenggara Barat
                'Kabupaten Lombok Utara', 'Kabupaten Lombok Barat', 'Kabupaten Lombok Tengah', 'Kabupaten Lombok Timur',
                'Kabupaten Sumbawa', 'Kabupaten Sumbawa Barat', 'Kota Mataram', 'Kota Bima'
            ],
            18 => [ // Nusa Tenggara Timur
                'Kabupaten Kupang', 'Kabupaten Timor Tengah Utara', 'Kabupaten Timor Tengah Selatan', 'Kabupaten Timor Timur',
                'Kabupaten Belu', 'Kabupaten Alor', 'Kabupaten Flores Timur', 'Kabupaten Sikka',
                'Kabupaten Ende', 'Kabupaten Ngada', 'Kabupaten Manggarai', 'Kabupaten Rote Ndao',
                'Kabupaten Manggarai Barat', 'Kabupaten Sumba Timur', 'Kabupaten Sumba Barat', 'Kabupaten Sumba Barat Daya',
                'Kabupaten Sumba Tengah', 'Kota Kupang'
            ],
            19 => [ // Kalimantan Barat
                'Kabupaten Mempawah', 'Kabupaten Sanggau', 'Kabupaten Kubu Raya', 'Kabupaten Bengkayang',
                'Kabupaten Landak', 'Kabupaten Polman', 'Kabupaten Sekadau', 'Kabupaten Melawi',
                'Kabupaten Ketapang', 'Kota Pontianak', 'Kota Singkawang'
            ],
            20 => [ // Kalimantan Tengah
                'Kabupaten Kotawaringin Barat', 'Kabupaten Kotawaringin Timur', 'Kabupaten Kapuas', 'Kabupaten Barito Utara',
                'Kabupaten Barito Timur', 'Kabupaten Barito Selatan', 'Kabupaten Murung Raya', 'Kabupaten Lamandau',
                'Kota Palangka Raya'
            ],
            21 => [ // Kalimantan Selatan
                'Kabupaten Tanah Laut', 'Kabupaten Kota Baru', 'Kabupaten Banjar', 'Kabupaten Barito Kuala',
                'Kabupaten Tapin', 'Kabupaten Hulu Sungai Utama', 'Kabupaten Hulu Sungai Tengah', 'Kabupaten Hulu Sungai Selatan',
                'Kabupaten Tabalong', 'Kabupaten Balangan', 'Kota Banjarmasin', 'Kota Banjar Baru'
            ],
            22 => [ // Kalimantan Timur
                'Kabupaten Paser', 'Kabupaten Kutai Barat', 'Kabupaten Kutai Kartanegara', 'Kabupaten Kutai Timur',
                'Kabupaten Berau', 'Kabupaten Penajam Paser Utara', 'Kota Balikpapan', 'Kota Samarinda',
                'Kota Tarakan', 'Kota Bontang'
            ],
            23 => [ // Kalimantan Utara
                'Kabupaten Malinau', 'Kabupaten Nunukan', 'Kabupaten Tana Tidung', 'Kota Tarakan'
            ],
            24 => [ // Sulawesi Utara
                'Kabupaten Bolaang Mongondow', 'Kabupaten Minahasa', 'Kabupaten Kepulauan Sangihe', 'Kabupaten Kepulauan Talaud',
                'Kabupaten Minahasa Utara', 'Kabupaten Bolaang Mongondow Utara', 'Kabupaten Siau Tagulandang Biaro', 'Kota Manado',
                'Kota Bitung', 'Kota Tomohon', 'Kota Kotamobagu', 'Kabupaten Minahasa Tenggara', 'Kabupaten Bolaang Mongondow Selatan',
                'Kabupaten Bolaang Mongondow Timur'
            ],
            25 => [ // Sulawesi Tengah
                'Kabupaten Banggai', 'Kabupaten Banggai Kepulauan', 'Kabupaten Banggai Laut', 'Kabupaten Morowali',
                'Kabupaten Donggala', 'Kabupaten Palu', 'Kabupaten Toli-toli', 'Kabupaten Buol',
                'Kabupaten Parigi Moutong', 'Kabupaten Tojo Una-una', 'Kabupaten Sigi', 'Kota Palu',
                'Kabupaten Morowali Utara'
            ],
            26 => [ // Sulawesi Selatan
                'Kabupaten Selayar', 'Kabupaten Bulukumba', 'Kabupaten Bantaeng', 'Kabupaten Barru',
                'Kabupaten Bone', 'Kabupaten Soppeng', 'Kabupaten Wajo', 'Kabupaten Sidenreng Rappang',
                'Kabupaten Pinrang', 'Kabupaten Enrekang', 'Kabupaten Luwu', 'Kabupaten Luwu Utara',
                'Kabupaten Luwu Timur', 'Kabupaten Toraja Utara', 'Kabupaten Toraja', 'Kota Makassar',
                'Kota Palopo', 'Kota Parepare'
            ],
            27 => [ // Sulawesi Tenggara
                'Kabupaten Muna', 'Kabupaten Buton', 'Kabupaten Kolaka', 'Kabupaten Konawe',
                'Kabupaten Bombana', 'Kabupaten Wakatobi', 'Kabupaten Kolaka Utara', 'Kabupaten Konawe Utara',
                'Kabupaten Buton Utara', 'Kabupaten Konawe Kepulauan', 'Kabupaten Muna Barat', 'Kabupaten Buton Selatan',
                'Kabupaten Buton Tengah', 'Kota Kendari', 'Kota Bau-bau'
            ],
            28 => [ // Gorontalo
                'Kabupaten Gorontalo', 'Kabupaten Boalemo', 'Kabupaten Bone Bolango', 'Kabupaten Pohuwato',
                'Kabupaten Gorontalo Utara', 'Kota Gorontalo'
            ],
            29 => [ // Sulawesi Barat
                'Kabupaten Manado', 'Kabupaten Majene', 'Kabupaten Polewali Mandar', 'Kabupaten Mamasa',
                'Kabupaten Mamuju Utara'
            ],
            30 => [ // Maluku
                'Kabupaten Maluku Tengah', 'Kabupaten Maluku Tenggara', 'Kabupaten Maluku Tenggara Barat', 'Kabupaten Buru',
                'Kabupaten Buru Selatan', 'Kabupaten Seram Bagian Barat', 'Kabupaten Seram Bagian Timur', 'Kabupaten Pulau Morotai',
                'Kota Ambon', 'Kota Tual'
            ],
            31 => [ // Maluku Utara
                'Kabupaten Halmahera Barat', 'Kabupaten Halmahera Tengah', 'Kabupaten Halmahera Utara', 'Kabupaten Halmahera Selatan',
                'Kabupaten Kepulauan Sula', 'Kabupaten Pulau Morotai', 'Kota Ternate', 'Kota Tidore Kepulauan'
            ],
            32 => [ // Papua
                'Kabupaten Fakfak', 'Kabupaten Kaimana', 'Kabupaten Teluk Wondama', 'Kabupaten Teluk Bintuni',
                'Kabupaten Manokwari', 'Kabupaten Sorong Selatan', 'Kabupaten Sorong', 'Kabupaten Raja Ampat',
                'Kabupaten Manokwari Selatan', 'Kabupaten Pegunungan Arfak', 'Kota Sorong', 'Kabupaten Tambrauw',
                'Kabupaten Maybrat', 'Kabupaten Kuala Pembuang'
            ],
            33 => [ // Papua Barat
                'Kabupaten Maybrat', 'Kabupaten Sorong Selatan', 'Kabupaten Manokwari', 'Kabupaten Fakfak',
                'Kabupaten Kaimana', 'Kota Sorong'
            ],
            34 => [ // Jakarta
                'Jakarta Selatan', 'Jakarta Utara', 'Jakarta Timur', 'Jakarta Barat',
                'Jakarta Pusat'
            ]
        ];

        if ($provinsiId !== null) {
            return $kabupatenByProv[$provinsiId] ?? [];
        }

        return $kabupatenByProv;
    }
}
