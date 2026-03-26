<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu; // <--- WAJIB ADA INI biar file ini kenal Model Menu

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            // BAKSO
    ['nama_menu' => 'Bakso Mercon', 'kategori' => 'Bakso', 'harga' => 17000, 'deskripsi' => 'Bakso dengan isian sambal rawit melimpah yang siap "meledakkan" lidah para pecinta pedas.', 'gambar' => 'Bakso_mercon.jpeg'],
    ['nama_menu' => 'Bakso Tumpeng', 'kategori' => 'Bakso', 'harga' => 20000, 'deskripsi' => 'Bakso unik berbentuk kerucut menyerupai tumpeng, biasanya disajikan dengan porsi besar dan saus spesial.', 'gambar' => 'Bakso_tumpeng.jpeg'],
    ['nama_menu' => 'Bakso Beranak', 'kategori' => 'Bakso', 'harga' => 18000, 'deskripsi' => 'Bakso berukuran jumbo yang saat dibelah berisi butiran bakso kecil dan telur di dalamnya.', 'gambar' => 'Bakso_beranak.jpeg'],
    ['nama_menu' => 'Bakso Telur', 'kategori' => 'Bakso', 'harga' => 19000, 'deskripsi' => 'Bakso klasik dengan isian satu butir telur utuh yang menambah rasa gurih dan tekstur lembut.', 'gambar' => 'Bakso_telur.jpeg'],
    ['nama_menu' => 'Bakso Daging', 'kategori' => 'Bakso', 'harga' => 23000, 'deskripsi' => 'Bakso urat atau halus yang kaya akan serat daging sapi murni, disajikan dengan kuah kaldu bening yang segar.', 'gambar' => 'Bakso_daging.jpeg'],

    // DIMSUM
    ['nama_menu' => 'Dimsum Mentai', 'kategori' => 'Dimsum', 'harga' => 16000, 'deskripsi' => 'Dimsum ayam udang yang dipanggang dengan baluran saus mentai creamy dan smoky.', 'gambar' => '1774513512_dimsum_mentai.jpeg'],
    ['nama_menu' => 'Dimsum Keju', 'kategori' => 'Dimsum', 'harga' => 13000, 'deskripsi' => ' Perpaduan tekstur kenyal dimsum dengan lelehan keju gurih di dalam atau topping di atasnya.', 'gambar' => '1774513536_dimsum_keju.jpeg'],
    ['nama_menu' => 'Dimsum Ori', 'kategori' => 'Dimsum', 'harga' => 10000, 'deskripsi' => 'Siomay kukus klasik yang menonjolkan rasa asli daging ayam dan udang yang segar.', 'gambar' => '1774513549_dimsum_ori.jpeg'],
    ['nama_menu' => 'Dimsum Goreng', 'kategori' => 'Dimsum', 'harga' => 12000, 'deskripsi' => 'Dimsum yang digoreng hingga garing kecokelatan, memberikan sensasi crunchy di setiap gigitan.', 'gambar' => '1774513563_dimsum_goreng.jpeg'],
    ['nama_menu' => 'Dimsum Matcha', 'kategori' => 'Dimsum', 'harga' => 15000, 'deskripsi' => 'Inovasi unik dimsum dengan sentuhan rasa teh hijau (biasanya sebagai kulit atau saus manis) untuk rasa yang berbeda.', 'gambar' => '1774513580_dimsum_matcha.jpeg'],

    // SPAGETI
    ['nama_menu' => 'Spaghetti Bolognese', 'kategori' => 'Spageti', 'harga' => 23000, 'deskripsi' => 'Pasta dengan saus tomat klasik yang dimasak bersama daging cincang dan taburan keju.', 'gambar' => 'bolognese.jpeg'],
    ['nama_menu' => 'Spaghetti Carbonara', 'kategori' => 'Spageti', 'harga' => 21000, 'deskripsi' => 'Pasta super lembut dengan saus kental dari campuran telur, keju, dan potongan daging asap.', 'gambar' => 'carbonara.jpeg'],
    ['nama_menu' => 'Spaghetti Aglio e Olio', 'kategori' => 'Spageti', 'harga' => 24000, 'deskripsi' => 'Menu simpel namun elegan dengan tumisan bawang putih, minyak zaitun, dan taburan cabai kering', 'gambar' => 'aglio_olio.jpeg'],
    ['nama_menu' => 'Spaghetti Pesto', 'kategori' => 'Spageti', 'harga' => 22000, 'deskripsi' => 'Pasta dengan saus hijau aromatik yang terbuat dari basil, kacang-kacangan, dan minyak zaitun.', 'gambar' => 'presto.jpeg'],
    ['nama_menu' => 'Spaghetti Marinara', 'kategori' => 'Spageti', 'harga' => 20000, 'deskripsi' => 'Sajian pasta dengan saus tomat segar yang dipadukan dengan berbagai macam seafood.', 'gambar' => 'marinara.jpeg'],

    // SATE
    ['nama_menu' => 'Sate Padang', 'kategori' => 'Sate', 'harga' => 23000, 'deskripsi' => 'Sate daging sapi dengan kuah kuning kental kaya rempah yang disajikan bersama ketupat.', 'gambar' => 'Sate_padang.jpeg'],
    ['nama_menu' => 'Sate Ayam', 'kategori' => 'Sate', 'harga' => 20000, 'deskripsi' => 'Potongan daging ayam panggang yang dilumuri bumbu kacang manis gurih yang autentik.', 'gambar' => 'Sate_ayam.jpeg'],
    ['nama_menu' => 'Sate Kambing', 'kategori' => 'Sate', 'harga' => 25000, 'deskripsi' => 'Sate daging kambing muda yang empuk, biasanya disajikan dengan kecap pedas dan potongan bawang merah.', 'gambar' => 'Sate_kambing.jpeg'],
    ['nama_menu' => 'Sate Taichan', 'kategori' => 'Sate', 'harga' => 22000, 'deskripsi' => 'Sate ayam polos tanpa bumbu kacang, dibakar putih dan disajikan dengan sambal rawit yang super pedas dan perasan jeruk nipis.', 'gambar' => 'Sate_taichan.jpeg'],
    ['nama_menu' => 'Sate Maranggi', 'kategori' => 'Sate', 'harga' => 19000, 'deskripsi' => 'Sate khas Purwakarta dengan bumbu rendaman ketumbar dan kecap yang meresap hingga ke dalam daging.', 'gambar' => 'Sate_maranggi.jpeg'],

    // MIE
    ['nama_menu' => 'Mie Ayam', 'kategori' => 'Mie', 'harga' => 20000, 'deskripsi' => 'Mie kuning lembut dengan topping potongan ayam bumbu kecap, sawi hijau, dan kuah kaldu terpisah.', 'gambar' => 'mie_ayam.jpeg'],
    ['nama_menu' => 'Mie Goreng', 'kategori' => 'Mie', 'harga' => 17000, 'deskripsi' => 'Mie yang ditumis dengan bumbu kecap manis, telur, sayuran, dan berbagai pilihan topping.', 'gambar' => 'mie_goreng.jpeg'],
    ['nama_menu' => 'Mie Tumis', 'kategori' => 'Mie', 'harga' => 16000, 'deskripsi' => 'Mie dengan sedikit kuah nyemek (becek) yang kaya akan bumbu rempah dan sayuran segar.', 'gambar' => 'mie_tumis.jpeg'],
    ['nama_menu' => 'Mie Celor', 'kategori' => 'Mie', 'harga' => 18000, 'deskripsi' => 'Kuliner khas Palembang berupa mie dalam kuah santan kental kaldu udang yang gurih.', 'gambar' => 'mie_celor.jpeg'],
    ['nama_menu' => 'Mie Tek Tek', 'kategori' => 'Mie', 'harga' => 15000, 'deskripsi' => 'Mie gerobakan khas malam hari yang dimasak dengan bumbu bawang putih dan kemiri yang aromatik.', 'gambar' => 'mie_tektek.jpeg'],

    // NASI
    ['nama_menu' => 'Nasi Goreng Seafood', 'kategori' => 'Nasi', 'harga' => 25000, 'deskripsi' => 'Nasi goreng gurih dengan isian udang, cumi, dan bakso ikan yang segar.', 'gambar' => 'nasi_goreng_seafood.jpeg'],
    ['nama_menu' => 'Nasi Ayam Bakar', 'kategori' => 'Nasi', 'harga' => 20000, 'deskripsi' => 'ANasi hangat dengan ayam yang dibakar madu atau bumbu rujak, lengkap dengan sambal dan lalapan.', 'gambar' => 'nasi_ayam_bakar.jpeg'],
    ['nama_menu' => 'Nasi Ikan Nila Bakar', 'kategori' => 'Nasi', 'harga' => 25000, 'deskripsi' => 'Ikan nila segar yang dibakar dengan olesan kecap rempah, memberikan rasa manis dan gurih.', 'gambar' => 'nasi_ikan_nila_bakar.jpeg'],
    ['nama_menu' => 'Nasi Ayam Goreng', 'kategori' => 'Nasi', 'harga' => 18000, 'deskripsi' => 'Menu favorit sejuta umat; ayam goreng renyah yang disajikan dengan nasi putih dan sambal korek.', 'gambar' => 'nasi_ayam_goreng.jpeg'],
    ['nama_menu' => 'Nasi Ikan Nila Goreng', 'kategori' => 'Nasi', 'harga' => 22000, 'deskripsi' => 'Ikan nila yang digoreng garing hingga renyah di luar namun tetap lembut di dalam.', 'gambar' => 'nasi_ikan_nila_goreng.jpg'],
        ];

        foreach ($menus as $menu) {
            \App\Models\Menu::create($menu);
        }
    }
}