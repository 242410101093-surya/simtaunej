<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DosenFasilkomSeeder extends Seeder
{
    public function run()
    {
        $dosens = [
            // --- SISTEM INFORMASI ---
            ['name' => 'Fahrobby Adnan, S.Kom., M.MSI.', 'nim_nip' => '198706192014041001', 'email' => 'fahrobby.adnan@unej.ac.id'],
            ['name' => 'Katarina Leba, S.Ag., M.Th.', 'nim_nip' => '197904292008122002', 'email' => 'katarina.leba@unej.ac.id'],
            ['name' => 'Oktalia Juwita, S.Kom., M.MT.', 'nim_nip' => '198110202014042001', 'email' => 'oktalia.juwita@unej.ac.id'],
            ['name' => 'Fajrin Nurman Arifin, ST., M.Eng.', 'nim_nip' => '198511282015041002', 'email' => 'fajrin.nurman@unej.ac.id'],
            ['name' => 'Beny Prasetyo, S.Kom., M.Kom.', 'nim_nip' => '199110172020121002', 'email' => 'beny.prasetyo@unej.ac.id'],
            ['name' => 'Karina Nine Amalia, S.Kom., M.Kom.', 'nim_nip' => '199512092022032023', 'email' => 'karina.nine@unej.ac.id'],
            ['name' => 'Tri Agustina Nugrahani, S.Kom., M.Kom.', 'nim_nip' => '199208222022032014', 'email' => 'tri.agustina@unej.ac.id'],
            ['name' => 'Maliatul Fitriyasari, M.Sc.', 'nim_nip' => '199503152023212038', 'email' => 'maliatul.fitri@unej.ac.id'],
            ['name' => 'Harry Soepandi, S.Kom., M.Kom.', 'nim_nip' => '197604252023211002', 'email' => 'harry.soepandi@unej.ac.id'],
            ['name' => 'Khoirunnisa’ Afandi, M.Kom.', 'nim_nip' => '199412282024062001', 'email' => 'khoirunnisa.afandi@unej.ac.id'],
            ['name' => 'Martiana Kholila Fadhil, M.Kom.', 'nim_nip' => '199907192024062001', 'email' => 'martiana.kholila@unej.ac.id'],
            ['name' => 'M. Habibullah Arief, M.Kom.', 'nim_nip' => '199202112024061001', 'email' => 'habibullah.arief@unej.ac.id'],
            ['name' => 'Ifrina Nuritha, S.Kom., M.Kom.', 'nim_nip' => '199008292025062003', 'email' => 'ifrina.nuritha@unej.ac.id'],
            ['name' => 'Vina Dewi Ramadhanty, S.Kom., M.Kom.', 'nim_nip' => '200001162025062013', 'email' => 'vina.dewi@unej.ac.id'],
            ['name' => 'Shynta Ayu Dwi Darmawan, S.Kom., MMSI.', 'nim_nip' => '199809192025062010', 'email' => 'shynta.ayu@unej.ac.id'],

            // --- TEKNOLOGI INFORMASI ---
            ['name' => 'Achmad Maududie, ST., M.Sc.', 'nim_nip' => '197004221995121001', 'email' => 'achmad.maududie@unej.ac.id'],
            ['name' => 'Diah Ayu Retnani Wulandari, ST., M.Eng.', 'nim_nip' => '198603052014042001', 'email' => 'diah.ayu@unej.ac.id'],
            ['name' => 'Prof. Dr. Saiful Bukhori, ST., M.Kom.', 'nim_nip' => '196811131994121001', 'email' => 'saiful.bukhori@unej.ac.id'],
            ['name' => 'Anang Andrianto, S.T., M.T.', 'nim_nip' => '196906151997021002', 'email' => 'anang.andrianto@unej.ac.id'],
            ['name' => 'Yanuar Nurdiansyah, ST., M.Cs.', 'nim_nip' => '198201012010121004', 'email' => 'yanuar.nurdiansyah@unej.ac.id'],
            ['name' => 'Dr. Dwiretno Istiyadi S, ST., M.Kom.', 'nim_nip' => '197803302003121003', 'email' => 'dwiretno.istiyadi@unej.ac.id'],
            ['name' => 'Windi Eka Yulia Retnani, S.Kom., MT.', 'nim_nip' => '198403052010122002', 'email' => 'windi.eka@unej.ac.id'],
            ['name' => 'Priza Pandunata, S.Kom., M.Sc.', 'nim_nip' => '198301312015041001', 'email' => 'priza.pandunata@unej.ac.id'],
            ['name' => 'Nova El Maidah, S.Si., M.Cs.', 'nim_nip' => '198411012015042001', 'email' => 'nova.el@unej.ac.id'],
            ['name' => 'Mohammad Zarkasi, S.Kom., M.Kom.', 'nim_nip' => '199011112019031018', 'email' => 'mohammad.zarkasi@unej.ac.id'],
            ['name' => 'Yudha Alif Auliya, S.Kom., M.Kom.', 'nim_nip' => '199206302022031009', 'email' => 'yudha.alif@unej.ac.id'],
            ['name' => 'Diksy Media Firmansyah, S.Kom., M.Kom.', 'nim_nip' => '199112132023211015', 'email' => 'diksy.media@unej.ac.id'],
            ['name' => 'Dwi Wijonarko, M.Kom.', 'nim_nip' => '198511272023211013', 'email' => 'dwi.wijonarko@unej.ac.id'],
            ['name' => 'Akbar Pandu Segara, M.Kom.', 'nim_nip' => '199508242024061001', 'email' => 'akbar.pandu@unej.ac.id'],
            ['name' => 'Narandha Arya Ranggianto, S.Kom., M.Kom.', 'nim_nip' => '199803082024061001', 'email' => 'narandha.arya@unej.ac.id'],
            ['name' => 'Abbi Nizar Muhammad, S.Kom., M.T.I', 'nim_nip' => '199609092025061007', 'email' => 'abbi.nizar@unej.ac.id'],

            // --- INFORMATIKA ---
            ['name' => 'Prof. Drs. Antonius Cahya Prihandoko, M.App.Sc., Ph.D.', 'nim_nip' => '196909281993021001', 'email' => 'antonius.cahya@unej.ac.id'],
            ['name' => 'Prof. Drs. Slamin, M.Comp.Sc., Ph.D.', 'nim_nip' => '196704201992011001', 'email' => 'slamin@unej.ac.id'],
            ['name' => 'Nelly Oktavia Adiwijaya, S.Si., MT.', 'nim_nip' => '198410242009122008', 'email' => 'nelly.oktavia@unej.ac.id'],
            ['name' => 'M. Arief Hidayat, S.Kom., M.Kom.', 'nim_nip' => '198101232010121003', 'email' => 'arief.hidayat@unej.ac.id'],
            ['name' => 'Muhammad ‘Ariful Furqon, S.Pd., M.Kom.', 'nim_nip' => '199407262020121005', 'email' => 'ariful.furqon@unej.ac.id'],
            ['name' => 'Tio Dharmawan, S.Kom., M.Kom.', 'nim_nip' => '199111122022031011', 'email' => 'tio.dharmawan@unej.ac.id'],
            ['name' => 'Januar Adi Putra, S.Kom., M.Kom.', 'nim_nip' => '199301312022031005', 'email' => 'januar.adi@unej.ac.id'],
            ['name' => 'Gama Wisnu Fajarianto, S.Kom., M.Kom.', 'nim_nip' => '198811132024061001', 'email' => 'gama.wisnu@unej.ac.id'],
            ['name' => 'Gayatri Dwi Santika, S.SI., M.Kom.', 'nim_nip' => '199201162023212044', 'email' => 'gayatri.dwi@unej.ac.id'],
            ['name' => 'Qurrota A’yuni Ar Ruhimat, S.Pd., M.Sc.', 'nim_nip' => '760018029', 'email' => 'qurrota.ayuni@unej.ac.id'],
            ['name' => 'Brian Rizqi Paradisiaca Darnoto, S.Kom., M.Kom.', 'nim_nip' => '199804272024061001', 'email' => 'brian.rizqi@unej.ac.id'],
            ['name' => 'Damar Novtahaning, M.Sc.', 'nim_nip' => '199711132024062005', 'email' => 'damar.novtahaning@unej.ac.id'],
            ['name' => 'Dony Bahtera Firmawan, S.Kom., M.Kom.', 'nim_nip' => '199711202024061001', 'email' => 'dony.bahtera@unej.ac.id'],
            ['name' => 'Erik Yohan Kartiko, S.Pd., M.Kom.', 'nim_nip' => '199512292024061001', 'email' => 'erik.yohan@unej.ac.id'],
            ['name' => 'Muhammad Andryan Wahyu Saputra, M.Kom.', 'nim_nip' => '200109062024061001', 'email' => 'andryan.wahyu@unej.ac.id'],
            ['name' => 'Rizky Alfanio Atmoko, S.Si., M.Sc.', 'nim_nip' => '199205112024061001', 'email' => 'rizky.alfanio@unej.ac.id'],
            ['name' => 'Stanislaus Jiwandana Pinasthika, S.Kom., M.Cs.', 'nim_nip' => '199705232025061006', 'email' => 'stanislaus.jiwandana@unej.ac.id'],
            ['name' => 'Fadhel Akhmad Hizham, S.Kom., M.Kom.', 'nim_nip' => '199705212025061007', 'email' => 'fadhel.akhmad@unej.ac.id'],
            ['name' => 'Annisa Fitri Maghfiroh Harvyant, S.Si., M.Si.', 'nim_nip' => '199801292025062009', 'email' => 'annisa.fitri@unej.ac.id'],
        ];

        foreach ($dosens as $dsn) {
            User::updateOrCreate(
                ['nim_nip' => $dsn['nim_nip']], // Supaya tidak duplikat kalau dijalankan ulang
                [
                    'name' => $dsn['name'],
                    'email' => $dsn['email'],
                    'role' => 'dosen',
                    'password' => Hash::make($dsn['nim_nip']), // Password awal pake NIP masing-masing
                ]
            );
        }
    }
}