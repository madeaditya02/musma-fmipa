<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->createMany([
            ["nim" => "2208511021", "nama" => "Ni Putu Wulan Kusuma Dewi", "angkatan" => 2022],
            ["nim" => "2308551049", "nama" => "Kadek Bintang Arya Mahardika", "angkatan" => 2023],
            ["nim" => "2308511034", "nama" => "Nur Rifatul Ifadah", "angkatan" => 2023],
            ["nim" => "2208551079", "nama" => "Ni Wayan Nanda Nirmala Sari", "angkatan" => 2022],
            ["nim" => "2408551063", "nama" => "I Gusti Ayu Adhelia Mona Prayumita", "angkatan" => 2024],
            ["nim" => "2408521029", "nama" => "I Putu Kenny Bayu Adi Putra", "angkatan" => 2024],
            ["nim" => "2408521004", "nama" => "Dewa Ayu Dwi Anjani", "angkatan" => 2024],
            ["nim" => "2408541022", "nama" => "Putu Ayu Mas Ariesty Paramasuari", "angkatan" => 2024],
            ["nim" => "2408531033", "nama" => "I Gusti Ayu Komang Eriyani Maheswari", "angkatan" => 2024],
            ["nim" => "2408551049", "nama" => "Ni Made Yulita Prabawati", "angkatan" => 2024],
            ["nim" => "2408541004", "nama" => "Devina Putri Indraswari", "angkatan" => 2024],
            ["nim" => "2408561149", "nama" => "Cindy Rodenni Siringoringo", "angkatan" => 2024],
            ["nim" => "2408551005", "nama" => "Nyoman Dania Sri Manika", "angkatan" => 2024],
            ["nim" => "2408541077", "nama" => "Ni Putu Ayu Diah Wulandari", "angkatan" => 2024],
            ["nim" => "2408551106", "nama" => "Asa Attalya Amazia Sembiring", "angkatan" => 2024],
            ["nim" => "2308551042", "nama" => "I Putu Rakha Teja Wistara", "angkatan" => 2023],
            ["nim" => "2408561048", "nama" => "I Gede Arya Kesha Narendra Subirman", "angkatan" => 2024],
            ["nim" => "2408561078", "nama" => "Ni Kadek Evy Wiramitha", "angkatan" => 2024],
            ["nim" => "2408511040", "nama" => "Shafa Magista Puspaningrum", "angkatan" => 2024],
            ["nim" => "2408541036", "nama" => "Ni Putu Ananda Artasari Cahyani", "angkatan" => 2024],
            ["nim" => "2408521018", "nama" => "Ni Ketut Sri Kawari", "angkatan" => 2024],
            ["nim" => "2408521013", "nama" => "I Made Widnyana", "angkatan" => 2024],
            ["nim" => "2408561090", "nama" => "Mochammad Riky Hidayat", "angkatan" => 2024],
            ["nim" => "2408541084", "nama" => "Kadek Aby Nugraha Kusuma", "angkatan" => 2024],
            ["nim" => "2408561096", "nama" => "I Made Galang Mahessa Mahutama", "angkatan" => 2024],
            ["nim" => "2308541013", "nama" => "Ni Komang Leonyta Agustiya", "angkatan" => 2023],
            ["nim" => "2408541021", "nama" => "Anak Agung Ayu Shanty Mahesuari Gayatri", "angkatan" => 2024],
            ["nim" => "2308511022", "nama" => "Ni Ketut Widhi Widanty Tirthaningsih", "angkatan" => 2023]
        ]);
    }
}
