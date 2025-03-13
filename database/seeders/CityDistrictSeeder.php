<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\District;



class CityDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            'Jakarta' => ['Gambir', 'Menteng', 'Tebet', 'Cilandak', 'Kebayoran Baru', 'Kebayoran Lama', 'Pasar Minggu', 'Setiabudi', 'Johar Baru', 'Cempaka Putih'],
            'Bandung' => ['Cidadap', 'Lengkong', 'Cicendo', 'Antapani', 'Sukajadi', 'Astana Anyar', 'Cibeunying Kaler', 'Coblong', 'Kiaracondong', 'Ujung Berung'],
            'Surabaya' => ['Gubeng', 'Tegalsari', 'Sawahan', 'Genteng', 'Rungkut', 'Sukolilo', 'Pabean Cantikan', 'Sambikerep', 'Simokerto', 'Benowo'],
            'Medan' => ['Medan Kota', 'Medan Barat', 'Medan Timur', 'Medan Marelan', 'Medan Tuntungan', 'Medan Amplas', 'Medan Belawan', 'Medan Helvetia', 'Medan Petisah', 'Medan Sunggal'],
            'Semarang' => ['Banyumanik', 'Candisari', 'Gajahmungkur', 'Pedurungan', 'Tembalang', 'Semarang Tengah', 'Semarang Barat', 'Semarang Utara', 'Gunungpati', 'Ngaliyan'],
            'Makassar' => ['Biringkanaya', 'Tamalanrea', 'Rappocini', 'Ujung Pandang', 'Panakkukang', 'Makassar', 'Mamajang', 'Mariso', 'Tallo', 'Wajo'],
            'Yogyakarta' => ['Kotagede', 'Danurejan', 'Gondokusuman', 'Mantrijeron', 'Mergangsan', 'Ngampilan', 'Pakualaman', 'Tegalrejo', 'Umbulharjo', 'Wirobrajan'],
            'Denpasar' => ['Denpasar Barat', 'Denpasar Selatan', 'Denpasar Timur', 'Denpasar Utara', 'Kuta', 'Kuta Selatan', 'Kuta Utara', 'Mengwi', 'Tabanan', 'Gianyar'],
            'Palembang' => ['Ilir Timur', 'Ilir Barat', 'Seberang Ulu', 'Sukarami', 'Plaju', 'Bukit Kecil', 'Kertapati', 'Kemuning', 'Sako', 'Kalidoni'],
            'Balikpapan' => ['Balikpapan Kota', 'Balikpapan Selatan', 'Balikpapan Barat', 'Balikpapan Utara', 'Balikpapan Timur', 'Balikpapan Tengah', 'Samboja', 'Sepinggan', 'Gunung Bahagia', 'Karang Joang'],
            'Banjarmasin' => ['Banjarmasin Barat', 'Banjarmasin Selatan', 'Banjarmasin Tengah', 'Banjarmasin Timur', 'Banjarmasin Utara'],
            'Pekanbaru' => ['Sail', 'Tenayan Raya', 'Tampan', 'Senapelan', 'Rumbai', 'Marpoyan Damai', 'Bukit Raya', 'Lima Puluh'],
            'Bogor' => ['Bogor Barat', 'Bogor Selatan', 'Bogor Tengah', 'Bogor Timur', 'Bogor Utara', 'Tanah Sareal'],
            'Tangerang' => ['Batuceper', 'Benda', 'Cibodas', 'Cipondoh', 'Jatiuwung', 'Karang Tengah', 'Karawaci', 'Larangan', 'Periuk', 'Pinang'],
            'Depok' => ['Beji', 'Bojongsari', 'Cilodong', 'Cimanggis', 'Cinere', 'Cipayung', 'Limo', 'Pancoran Mas', 'Sawangan', 'Sukmajaya', 'Tapos'],
            'Malang' => ['Klojen', 'Blimbing', 'Kedungkandang', 'Lowokwaru', 'Sukun'],
            'Batam' => ['Batu Aji', 'Batu Ampar', 'Belakang Padang', 'Bengkong', 'Bulang', 'Galang', 'Lubuk Baja', 'Nongsa', 'Sagulung', 'Sei Beduk', 'Sekupang'],
            'Padang' => ['Padang Barat', 'Padang Timur', 'Padang Selatan', 'Padang Utara', 'Koto Tangah', 'Lubuk Begalung', 'Nanggalo', 'Pauh'],
            'Manado' => ['Bunaken', 'Malalayang', 'Mapanget', 'Paal Dua', 'Sario', 'Singkil', 'Tikala', 'Tuminting', 'Wanea', 'Wenang'],
            'Pontianak' => ['Pontianak Barat', 'Pontianak Kota', 'Pontianak Selatan', 'Pontianak Tenggara', 'Pontianak Timur', 'Pontianak Utara'],
            'Samarinda' => ['Samarinda Ilir', 'Samarinda Kota', 'Samarinda Seberang', 'Samarinda Ulu', 'Samarinda Utara', 'Sungai Kunjang', 'Sungai Pinang'],
            'Mataram' => ['Ampenan', 'Cakranegara', 'Mataram', 'Sekarbela', 'Selaparang', 'Sandubaya'],
            'Palangkaraya' => ['Jekan Raya', 'Pahandut', 'Sabangau', 'Sebangau', 'Bukit Batu'],
            'Ambon' => ['Baguala', 'Leitimur Selatan', 'Nusaniwe', 'Sirimau', 'Teluk Ambon'],
            'Jayapura' => ['Abepura', 'Heram', 'Jayapura Selatan', 'Jayapura Utara', 'Muara Tami'],
        ];

        foreach ($cities as $cityName => $districts) {
            $city = City::create(['name' => $cityName]);

            foreach ($districts as $districtName) {
                District::create([
                    'city_id' => $city->id,
                    'name' => $districtName
                ]);
            }
        }
    }
}
